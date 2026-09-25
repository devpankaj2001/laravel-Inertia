<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeoIPService
{
    /**
     * Map of common ISO 2-letter codes to Country Names
     */
    protected static array $codeToCountry = [
        'IN' => 'India',
        'US' => 'United States',
        'GB' => 'United Kingdom',
        'CA' => 'Canada',
        'AU' => 'Australia',
        'AE' => 'United Arab Emirates',
        'DE' => 'Germany',
        'FR' => 'France',
        'SG' => 'Singapore',
        'SA' => 'Saudi Arabia',
        'NL' => 'Netherlands',
        'NZ' => 'New Zealand',
        'IE' => 'Ireland',
        'PK' => 'Pakistan',
        'BD' => 'Bangladesh',
        'NP' => 'Nepal',
        'LK' => 'Sri Lanka',
        'MY' => 'Malaysia',
        'ID' => 'Indonesia',
        'PH' => 'Philippines',
        'ZA' => 'South Africa',
        'BR' => 'Brazil',
        'MX' => 'Mexico',
        'ES' => 'Spain',
        'IT' => 'Italy',
        'CH' => 'Switzerland',
        'SE' => 'Sweden',
        'NO' => 'Norway',
        'DK' => 'Denmark',
        'FI' => 'Finland',
        'JP' => 'Japan',
        'KR' => 'South Korea',
        'CN' => 'China',
        'RU' => 'Russia',
    ];

    /**
     * Resolve the country name from client IP / HTTP request.
     */
    public static function getCountry(?string $ip = null, ?Request $request = null): string
    {
        $req = $request ?: request();

        // 1. Cloudflare Country Header check
        if ($req) {
            $cfCountryCode = strtoupper(trim((string) $req->header('CF-IPCountry', '')));
            if (!empty($cfCountryCode) && strlen($cfCountryCode) === 2 && $cfCountryCode !== 'XX' && $cfCountryCode !== 'T1') {
                return self::$codeToCountry[$cfCountryCode] ?? $cfCountryCode;
            }
        }

        // 2. Resolve Client IP
        if (empty($ip) && $req) {
            $ip = self::getClientIp($req);
        }

        if (empty($ip)) {
            return 'India';
        }

        // 3. Check for private / localhost / loopback IP ranges
        if (self::isPrivateOrLocalIp($ip)) {
            return 'India';
        }

        // 4. Cache & Query IP Geolocation API
        try {
            return Cache::remember("geoip_country_{$ip}", 86400 * 7, function () use ($ip) {
                // Primary: ip-api.com (free, reliable, fast)
                try {
                    $response = Http::timeout(2.5)->get("http://ip-api.com/json/{$ip}?fields=status,country,countryCode");
                    if ($response->successful()) {
                        $data = $response->json();
                        if (($data['status'] ?? '') === 'success' && !empty($data['country'])) {
                            return (string) $data['country'];
                        }
                    }
                } catch (\Throwable $e) {
                    // Failover
                }

                // Backup: ipwho.is
                try {
                    $resp2 = Http::timeout(2.5)->get("https://ipwho.is/{$ip}");
                    if ($resp2->successful()) {
                        $d2 = $resp2->json();
                        if (($d2['success'] ?? false) && !empty($d2['country'])) {
                            return (string) $d2['country'];
                        }
                    }
                } catch (\Throwable $e) {
                    // Ignore
                }

                return 'India';
            });
        } catch (\Throwable $e) {
            Log::info("GeoIP lookup failed for IP {$ip}: " . $e->getMessage());
            return 'India';
        }
    }

    /**
     * Get accurate client IP address taking proxies/Cloudflare into account
     */
    public static function getClientIp(?Request $request = null): string
    {
        $req = $request ?: request();
        if (!$req) {
            return '127.0.0.1';
        }

        // Cloudflare real IP
        if ($cfIp = $req->header('CF-Connecting-IP')) {
            return trim(explode(',', $cfIp)[0]);
        }

        // Forwarded For
        if ($forwarded = $req->header('X-Forwarded-For')) {
            $ips = explode(',', $forwarded);
            return trim($ips[0]);
        }

        if ($realIp = $req->header('X-Real-IP')) {
            return trim($realIp);
        }

        return $req->ip() ?: '127.0.0.1';
    }

    /**
     * Check if an IP address is a private, loopback, or development address
     */
    public static function isPrivateOrLocalIp(string $ip): bool
    {
        if (in_array($ip, ['127.0.0.1', '::1', 'localhost', '0.0.0.0'])) {
            return true;
        }

        return filter_var(
            $ip,
            FILTER_VALIDATE_IP,
            FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE
        ) === false;
    }

    /**
     * Return flag emoji for country
     */
    public static function getCountryFlag(?string $country): string
    {
        if (empty($country)) {
            return '🌐';
        }

        $c = strtolower(trim($country));

        $flags = [
            'india' => '🇮🇳',
            'in' => '🇮🇳',
            'united states' => '🇺🇸',
            'usa' => '🇺🇸',
            'us' => '🇺🇸',
            'united kingdom' => '🇬🇧',
            'uk' => '🇬🇧',
            'gb' => '🇬🇧',
            'canada' => '🇨🇦',
            'ca' => '🇨🇦',
            'australia' => '🇦🇺',
            'au' => '🇦🇺',
            'united arab emirates' => '🇦🇪',
            'uae' => '🇦🇪',
            'ae' => '🇦🇪',
            'dubai' => '🇦🇪',
            'germany' => '🇩🇪',
            'de' => '🇩🇪',
            'france' => '🇫🇷',
            'fr' => '🇫🇷',
            'singapore' => '🇸🇬',
            'sg' => '🇸🇬',
            'saudi arabia' => '🇸🇦',
            'sa' => '🇸🇦',
            'pakistan' => '🇵🇰',
            'pk' => '🇵🇰',
            'bangladesh' => '🇧🇩',
            'bd' => '🇧🇩',
            'nepal' => '🇳🇵',
            'np' => '🇳🇵',
            'netherlands' => '🇳🇱',
            'nl' => '🇳🇱',
            'new zealand' => '🇳🇿',
            'nz' => '🇳🇿',
            'ireland' => '🇮🇪',
            'ie' => '🇮🇪',
            'south africa' => '🇿🇦',
            'za' => '🇿🇦',
            'spain' => '🇪🇸',
            'es' => '🇪🇸',
            'italy' => '🇮🇹',
            'it' => '🇮🇹',
            'switzerland' => '🇨🇭',
            'ch' => '🇨🇭',
            'japan' => '🇯🇵',
            'jp' => '🇯🇵',
        ];

        return $flags[$c] ?? '🌍';
    }
}
