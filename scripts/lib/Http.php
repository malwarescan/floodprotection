<?php

namespace AuditLib;

class Http
{
    public static function get(string $url, array $cfg): array
    {
        $tries = 0;
        $max = $cfg['retries'] ?? 0;
        $ua = $cfg['user_agent'] ?? 'SEO-AuditBot';
        $timeout = $cfg['timeout'] ?? 20;
        
        start:
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS => 5,
            CURLOPT_CONNECTTIMEOUT => $timeout,
            CURLOPT_TIMEOUT => $timeout,
            CURLOPT_USERAGENT => $ua,
            CURLOPT_HTTPHEADER => ['Accept: text/html,application/xhtml+xml,application/ld+json;q=0.9,*/*;q=0.8'],
            CURLOPT_SSL_VERIFYPEER => false // For local testing
        ]);
        
        $body = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $ctype = curl_getinfo($ch, CURLINFO_CONTENT_TYPE) ?: '';
        $err = curl_error($ch);
        curl_close($ch);
        
        if (($code < 200 || $code >= 400 || !$body) && $tries < $max) {
            $tries++;
            sleep(1);
            goto start;
        }
        
        return [
            'code' => $code,
            'ctype' => $ctype,
            'body' => $body,
            'error' => $err
        ];
    }
}

