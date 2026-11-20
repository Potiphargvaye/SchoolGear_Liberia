<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AfricanPhoneCountries
{
    public const DEFAULT_COUNTRY = 'LR';

    private const CACHE_KEY = 'admissions.african_phone_countries.v1';
    private const STALE_CACHE_KEY = 'admissions.african_phone_countries.stale.v1';

    public function all(): array
    {
        $cachedCountries = Cache::get(self::CACHE_KEY);

        if (is_array($cachedCountries)) {
            return $cachedCountries;
        }

        try {
            $query = '{ countries { code name phone continent { code } } }';
            $response = Http::acceptJson()
                ->timeout(8)
                ->get('https://countries.trevorblades.com/', ['query' => $query])
                ->throw();
            $records = $response->json('data.countries');

            if (! is_array($records) || ! $records) {
                throw new \RuntimeException('Country API returned no country data.');
            }

            $flagUrls = [];

            try {
                $flagsResponse = Http::acceptJson()
                    ->timeout(8)
                    ->get('https://countriesnow.space/api/v0.1/countries/flag/images')
                    ->throw();
                $flagRecords = $flagsResponse->json('data');

                if ($flagsResponse->json('error') !== false || ! is_array($flagRecords)) {
                    throw new \RuntimeException('Flag API returned an invalid response.');
                }

                foreach ($flagRecords as $flagRecord) {
                    $code = strtoupper((string) ($flagRecord['iso2'] ?? ''));
                    $url = $flagRecord['flag'] ?? null;

                    if (preg_match('/^[A-Z]{2}$/', $code) && is_string($url) && str_starts_with($url, 'https://')) {
                        $flagUrls[$code] = $url;
                    }
                }
            } catch (\Throwable $exception) {
                Log::warning('Admission country flag API failed; using the public flag CDN.', [
                    'exception' => $exception->getMessage(),
                ]);
            }

            $countries = [];

            foreach ($records as $record) {
                if (($record['continent']['code'] ?? null) !== 'AF') {
                    continue;
                }

                $code = strtoupper((string) ($record['code'] ?? ''));
                $name = $record['name'] ?? null;
                $dialDigits = preg_replace('/\D+/', '', (string) ($record['phone'] ?? ''));

                if (! preg_match('/^[A-Z]{2}$/', $code) || ! is_string($name) || $name === '' || $dialDigits === '') {
                    continue;
                }

                $countries[] = [
                    'code' => $code,
                    'name' => $name,
                    'dial_code' => '+' . $dialDigits,
                    'flag' => $flagUrls[$code] ?? 'https://flagcdn.com/w80/' . strtolower($code) . '.png',
                ];
            }

            usort($countries, fn (array $left, array $right) => strcasecmp($left['name'], $right['name']));

            if (! $countries) {
                throw new \RuntimeException('Country API returned no usable African countries.');
            }

            Cache::put(self::CACHE_KEY, $countries, now()->addDays(30));
            Cache::put(self::STALE_CACHE_KEY, $countries, now()->addDays(365));

            return $countries;
        } catch (\Throwable $exception) {
            Log::warning('Admission country API failed.', [
                'exception' => $exception->getMessage(),
            ]);

            $staleCountries = Cache::get(self::STALE_CACHE_KEY);

            return is_array($staleCountries) ? $staleCountries : [];
        }
    }

    public function parse(?string $phone): ?array
    {
        if (! $phone || ! preg_match('/^\+(\d+)$/', $phone, $matches)) {
            return null;
        }

        $digits = $matches[1];
        $countries = $this->all();
        usort($countries, fn (array $left, array $right) => strlen($right['dial_code']) <=> strlen($left['dial_code']));

        foreach ($countries as $country) {
            $dialDigits = substr($country['dial_code'], 1);

            if (str_starts_with($digits, $dialDigits)) {
                $nationalNumber = substr($digits, strlen($dialDigits));
                $nationalNumber = ltrim($nationalNumber, '0');

                if ($nationalNumber !== '') {
                    return [
                        'country' => $country,
                        'national_number' => $nationalNumber,
                    ];
                }
            }
        }

        return null;
    }
}
