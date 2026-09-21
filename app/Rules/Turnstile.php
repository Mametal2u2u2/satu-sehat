<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Turnstile implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $secret = config('services.turnstile.secret');

        // If not configured or running in testing environment without secret, skip
        if (empty($secret) || app()->environment('testing')) {
            return;
        }

        if (empty($value)) {
            $fail('Verifikasi keamanan Cloudflare Turnstile diperlukan.');
            return;
        }

        // Support manual fallback token during local development / testing
        if ($value === 'MANUAL-DEV-VERIFIED' && (app()->environment('local', 'testing') || $secret === '1x0000000000000000000000000000000AA')) {
            return;
        }

        try {
            $response = Http::asForm()
                ->timeout(5)
                ->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                    'secret' => $secret,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                ]);

            if (! $response->successful() || ! ($response->json('success') === true)) {
                // Check if using dummy test key and offline
                if ($secret === '1x0000000000000000000000000000000AA' && ! $response->successful()) {
                    return;
                }
                $fail('Verifikasi keamanan Cloudflare Turnstile gagal. Silakan coba lagi.');
            }
        } catch (\Throwable $e) {
            Log::warning('Turnstile verification failed to reach Cloudflare: ' . $e->getMessage());
            // If using official dummy test key in development and network fails, allow pass
            if ($secret === '1x0000000000000000000000000000000AA') {
                return;
            }
            $fail('Layanan verifikasi bot sementara tidak dapat dihubungi. Silakan refresh halaman.');
        }
    }
}
