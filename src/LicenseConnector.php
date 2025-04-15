<?php

namespace Llls\Connector;

class LicenseConnector
{
    protected string $apiUrl;
    protected $httpClient;

    public function __construct(string $apiUrl)
    {
        $this->apiUrl = rtrim($apiUrl, '/');

        if (class_exists(\GuzzleHttp\Client::class)) {
            $this->httpClient = new \GuzzleHttp\Client();
        }
    }

    public function verify(string $licenseKey, string $domain = ''): array
    {
        $url = "{$this->apiUrl}/api/verify";

        $headers = [
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];

        $data = [
            'license_key' => $licenseKey,
        ];

        if (!empty($domain)) {
            $data['domain'] = $domain;
        }

        try {
            if ($this->httpClient) {
                $response = $this->httpClient->post($url, [
                    'headers' => $headers,
                    'json'    => $data,
                ]);
                $body = $response->getBody()->getContents();
            } else {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Accept: application/json',
                    'Content-Type: application/json',
                ]);
                $body = curl_exec($ch);
                if ($body === false) {
                    return [
                        'success' => false,
                        'message' => 'cURL Error: ' . curl_error($ch),
                    ];
                }
                curl_close($ch);
            }

            return json_decode($body, true) ?? [
                'success' => false,
                'message' => 'Invalid JSON response',
            ];
        } catch (\Throwable $e) {
            return [
                'success' => false,
                'message' => 'Request error: ' . $e->getMessage(),
            ];
        }
    }
}
