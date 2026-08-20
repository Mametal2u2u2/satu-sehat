<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\SatuSehatLog;
use Illuminate\Support\Facades\Http;
use Exception;

class SatuSehatService
{
    protected string $baseUrl;
    protected string $authUrl;
    protected string $clientId;
    protected string $clientSecret;

    public function __construct()
    {
        // Mock configurations for test/dev environment
        $this->baseUrl = env('SATUSEHAT_BASE_URL', 'https://api-satusehat-dev.dto.kemkes.go.id/fhir-r4/v1');
        $this->authUrl = env('SATUSEHAT_AUTH_URL', 'https://api-satusehat-dev.dto.kemkes.go.id/oauth2/v1/accesstoken');
        $this->clientId = env('SATUSEHAT_CLIENT_ID', 'dummy_client_id');
        $this->clientSecret = env('SATUSEHAT_CLIENT_SECRET', 'dummy_client_secret');
    }

    /**
     * Mendapatkan Access Token OAuth2 dari server SatuSehat.
     */
    public function getAccessToken(): string
    {
        $response = Http::asForm()->post($this->authUrl, [
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if ($response->successful()) {
            return $response->json('access_token');
        }

        throw new Exception('Gagal mendapatkan token SatuSehat: ' . $response->body());
    }

    /**
     * Mengirim data Kunjungan (Encounter) dan Diagnosis (Condition) ke SatuSehat.
     */
    public function syncEncounter(MedicalRecord $medicalRecord): array
    {
        $token = $this->getAccessToken();
        
        $payload = $this->buildEncounterPayload($medicalRecord);
        $endpoint = $this->baseUrl . '/Encounter';

        $response = Http::withToken($token)
            ->post($endpoint, $payload);

        // Logging the transaction
        SatuSehatLog::create([
            'medical_record_id' => $medicalRecord->id,
            'endpoint'          => $endpoint,
            'request_payload'   => $payload,
            'response_payload'  => $response->json(),
            'status_code'       => $response->status(),
            'is_success'        => $response->successful(),
            'error_message'     => $response->successful() ? null : $response->body(),
        ]);

        if (!$response->successful()) {
            throw new Exception('SatuSehat Error: ' . $response->body());
        }

        return $response->json();
    }

    /**
     * Memetakan data lokal ke format standar FHIR R4 SatuSehat
     */
    protected function buildEncounterPayload(MedicalRecord $medicalRecord): array
    {
        return [
            'resourceType' => 'Encounter',
            'status'       => 'finished',
            'class'        => [
                'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ActCode',
                'code'    => 'AMB',
                'display' => 'ambulatory'
            ],
            'subject'      => [
                'reference' => 'Patient/100000030009', // Dummy IHS Number
                'display'   => $medicalRecord->visit->patient->name,
            ],
            'participant'  => [
                [
                    'type' => [
                        [
                            'coding' => [
                                [
                                    'system'  => 'http://terminology.hl7.org/CodeSystem/v3-ParticipationType',
                                    'code'    => 'ATND',
                                    'display' => 'attender'
                                ]
                            ]
                        ]
                    ],
                    'individual' => [
                        'reference' => 'Practitioner/N10000001', // Dummy IHS Practitioner
                        'display'   => $medicalRecord->visit->doctor->name,
                    ]
                ]
            ],
            'period'       => [
                'start' => $medicalRecord->created_at->toIso8601String(),
            ],
            // Diagnoses mapping
            'diagnosis'    => $medicalRecord->diagnoses->map(function ($diag) {
                return [
                    'condition' => [
                        'reference' => 'Condition/DUMMY-CONDITION-ID',
                        'display'   => $diag->icd10_code . ' ' . $diag->description
                    ],
                    'use' => [
                        'coding' => [
                            [
                                'system'  => 'http://terminology.hl7.org/CodeSystem/diagnosis-role',
                                'code'    => 'AD',
                                'display' => 'Admission diagnosis'
                            ]
                        ]
                    ]
                ];
            })->toArray()
        ];
    }
    /**
     * Mengirim data Vital Signs (Observation) ke SatuSehat per-parameter.
     */
    public function syncObservation(MedicalRecord $medicalRecord): array
    {
        $token    = $this->getAccessToken();
        $endpoint = $this->baseUrl . '/Observation';
        $results  = [];

        $vitalSigns = $medicalRecord->vital_signs ?? [];

        // Mapping: key lokal → LOINC code + nama
        $loincMap = [
            'systolic'    => ['8480-6', 'Systolic blood pressure'],
            'diastolic'   => ['8462-4', 'Diastolic blood pressure'],
            'heart_rate'  => ['8867-4', 'Heart rate'],
            'temperature' => ['8310-5', 'Body temperature'],
            'spo2'        => ['2708-6', 'Oxygen saturation in Arterial blood'],
        ];

        foreach ($loincMap as $key => [$loincCode, $display]) {
            if (!isset($vitalSigns[$key])) {
                continue;
            }

            $payload = $this->buildObservationPayload(
                $medicalRecord, $loincCode, $display, $vitalSigns[$key]
            );

            $response = Http::withToken($token)->post($endpoint, $payload);

            SatuSehatLog::create([
                'medical_record_id' => $medicalRecord->id,
                'endpoint'          => $endpoint,
                'request_payload'   => $payload,
                'response_payload'  => $response->json(),
                'status_code'       => $response->status(),
                'is_success'        => $response->successful(),
                'error_message'     => $response->successful() ? null : $response->body(),
            ]);

            if (!$response->successful()) {
                throw new Exception("SatuSehat Observation Error ({$key}): " . $response->body());
            }

            $results[$key] = $response->json();
        }

        return $results;
    }

    /**
     * Membangun payload FHIR R4 Observation untuk satu parameter vital sign.
     */
    protected function buildObservationPayload(
        MedicalRecord $medicalRecord,
        string $loincCode,
        string $display,
        mixed $value
    ): array {
        return [
            'resourceType' => 'Observation',
            'status'       => 'final',
            'category'     => [
                [
                    'coding' => [
                        [
                            'system'  => 'http://terminology.hl7.org/CodeSystem/observation-category',
                            'code'    => 'vital-signs',
                            'display' => 'Vital Signs',
                        ],
                    ],
                ],
            ],
            'code'         => [
                'coding' => [
                    [
                        'system'  => 'http://loinc.org',
                        'code'    => $loincCode,
                        'display' => $display,
                    ],
                ],
                'text' => $display,
            ],
            'subject'      => [
                'reference' => 'Patient/100000030009',
                'display'   => $medicalRecord->visit->patient->name,
            ],
            'encounter'    => [
                'reference' => 'Encounter/DUMMY-ENCOUNTER-ID',
            ],
            'effectiveDateTime' => $medicalRecord->created_at->toIso8601String(),
            'valueQuantity'     => [
                'value'  => (float) $value,
                'system' => 'http://unitsofmeasure.org',
            ],
        ];
    }
}
