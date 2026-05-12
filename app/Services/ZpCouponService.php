<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZpCouponService
{
    private string $baseUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.zp_live.url', ''), '/');
        $this->apiKey  = config('services.zp_live.api_key', '');
    }

    public function validate(string $code): ?array
    {
        if (!$this->baseUrl || !$this->apiKey) {
            return null;
        }

        try {
            $response = Http::withHeaders(['X-Api-Key' => $this->apiKey])
                ->timeout(5)
                ->get($this->baseUrl . '/api/coupons/validate', ['code' => $code]);

            return $response->json();
        } catch (\Exception) {
            return null;
        }
    }

    public function redeem(string $code): bool
    {
        if (!$this->baseUrl || !$this->apiKey) {
            return false;
        }

        try {
            $response = Http::withHeaders(['X-Api-Key' => $this->apiKey])
                ->timeout(5)
                ->post($this->baseUrl . '/api/coupons/redeem', ['code' => $code]);

            return $response->successful();
        } catch (\Exception) {
            return false;
        }
    }
}
