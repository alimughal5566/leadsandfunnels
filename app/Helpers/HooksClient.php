<?php

namespace App\Helpers;

class HooksClient {

    /**
     * Returns hooks API endpoint base URL
     */
    public static function getBaseUrl(){
        $endpointUrl = getenv('LP_API_ENDPOINT_BASE_URL');
        $endpointUrl = $endpointUrl ? $endpointUrl : config('lp.chargebee.lp_api_endpoint_base_url');
        $endpointUrl = rtrim($endpointUrl, '/');
        return $endpointUrl;
    }

    /**
     * Returns hooks API endpoint authentication key
     */
    public static function getAuthKey(){
        $authKey = getenv('LP_API_ENDPOINT_AUTH_KEY');
        return $authKey ? $authKey : config('lp.chargebee.lp_api_endpoint_auth_key');
    }

    /**
     * Send API call to hooks endpoint
     *
     * @param string $route hooks route 
     * @param array $data dat to send to API
     * @return array response data returned from server
     */
    public static function send(string $route, array $data = []): array {
        $client = new \GuzzleHttp\Client([
            'base_uri' => self::getBaseUrl(),
            'http_errors' => false,
            'headers' => [
                'Authorization' => self::getAuthKey(),
                'Accept'     => 'application/json'
            ]
        ]);

        $response = $client->post($route, [
            'json' => $data
        ]);

        if($response->getStatusCode() != 200){
            return [
                'status' => false,
                'message' => "Hook's route '$route' returned with status code: {$response->getStatusCode()}"
            ];
        }

        $jsonContentString= $response->getBody()->getContents();
        $jsonContent = json_decode($jsonContentString, true);

        if(!isset($jsonContent['status'])){
            return [
                'status' => false,
                'message' => "Hook's route '$route' did not return expected response format"
            ];
        }
        return $jsonContent;
    }
}