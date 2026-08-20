<?php

namespace App\Services;

use App\Models\MedicalRecord;
use App\Models\Visit;
use Illuminate\Support\Facades\DB;

class MedicalRecordService
{
    public function createMedicalRecord(array $data, array $diagnoses = []): MedicalRecord
    {
        return DB::transaction(function () use ($data, $diagnoses) {
            $record = MedicalRecord::create($data);

            foreach ($diagnoses as $diag) {
                $record->diagnoses()->create([
                    'icd10_code' => $diag['icd10_code'],
                    'description' => $diag['description'],
                    'type' => $diag['type'] ?? 'primary',
                ]);
            }

            if (isset($data['visit_id'])) {
                Visit::where('id', $data['visit_id'])->update(['status' => 'examining']);
            }

            return $record->load('diagnoses', 'visit', 'patient', 'doctor');
        });
    }
}
