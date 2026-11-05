<?php

namespace App\Services;

class GoogleMapsUrlService
{
    public static function makeEmbedUrl(?string $mapsUrl, ?string $locationName = null, ?string $address = null): array
    {
        $openUrl = $mapsUrl;
        $resolvedUrl = $mapsUrl;
        $embedUrl = null;

        if ($mapsUrl) {
            if (
                str_contains($mapsUrl, 'maps.app.goo.gl') ||
                str_contains($mapsUrl, 'goo.gl/maps')
            ) {
                $resolvedUrl = self::resolveRedirectUrl($mapsUrl) ?: $mapsUrl;
            }

            $decodedUrl = urldecode($resolvedUrl);

            $latitude = null;
            $longitude = null;
            $zoom = 17;

            /*
                Format:
                /@-8.0068647,112.6174332,17z/
            */
            if (preg_match('/@(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?),(\d+)z/', $decodedUrl, $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
                $zoom = $matches[3];
            }

            /*
                Format:
                !3d-8.0068647!4d112.6200081
                Biasanya ini lokasi yang paling akurat.
            */
            if (preg_match('/!3d(-?\d+(?:\.\d+)?)!4d(-?\d+(?:\.\d+)?)/', $decodedUrl, $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
            }

            /*
                Format:
                query=-8.0068647,112.6200081
            */
            if (!$latitude && preg_match('/[?&]query=(-?\d+(?:\.\d+)?),(-?\d+(?:\.\d+)?)/', $decodedUrl, $matches)) {
                $latitude = $matches[1];
                $longitude = $matches[2];
            }

            if ($latitude && $longitude) {
                $embedUrl = 'https://maps.google.com/maps?q='
                    . $latitude . ',' . $longitude
                    . '&z=' . $zoom
                    . '&output=embed';
            }
        }

        /*
            Fallback kalau koordinat gagal ditemukan.
            Tetap tampilkan peta berdasarkan alamat / nama lokasi.
        */
        if (!$embedUrl) {
            $query = $address ?: $locationName;

            if ($query) {
                $embedUrl = 'https://maps.google.com/maps?q='
                    . urlencode($query)
                    . '&z=17&output=embed';
            }
        }

        return [
            'open_url' => $openUrl,
            'resolved_url' => $resolvedUrl,
            'embed_url' => $embedUrl,
        ];
    }

    private static function resolveRedirectUrl(string $url): ?string
    {
        try {
            $ch = curl_init($url);

            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_USERAGENT => 'Mozilla/5.0',
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
            ]);

            curl_exec($ch);

            $effectiveUrl = curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

            curl_close($ch);

            return $effectiveUrl ?: null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}
