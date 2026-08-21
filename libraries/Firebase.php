<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Google\Client;

class Firebase
{
    protected $CI;
    protected $projectId;
    protected $credentialPath;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->config->load('firebase');
        $this->CI->load->model('FirebaseNotification_model');

        $this->projectId = $this->CI->config->item('firebase_project_id');
        $this->credentialPath = $this->CI->config->item('firebase_credentials');
    }

    /**
     * Generate Firebase Access Token
     */
    private function getAccessToken()
    {
        try {

            $client = new Client();

            $client->setAuthConfig($this->credentialPath);

            $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

            $token = $client->fetchAccessTokenWithAssertion();

            log_message('error', json_encode($token));

            if (isset($token['access_token'])) {
                return $token['access_token'];
            }

            log_message('error', 'Firebase Access Token Error : '.json_encode($token));

            return false;

        } catch (Exception $e) {

            log_message('error', 'Firebase Exception : '.$e->getMessage());

            return false;
        }
    }

    /**
     * Send Push Notification
     */
    public function send($deviceToken, $title, $body, $data = [])
    {
        $accessToken = $this->getAccessToken();

        if (!$accessToken) {
            return [
                'status' => false,
                'message' => 'Unable to generate access token.'
            ];
        }

        $url = "https://fcm.googleapis.com/v1/projects/".$this->projectId."/messages:send";

        $payload = [
            'message' => [
                'token' => $deviceToken,

                'notification' => [
                    'title' => $title,
                    'body'  => $body
                ],

                'data' => array_map('strval', $data),

                'android' => [
                    'priority' => 'high'
                ],

                'apns' => [
                    'headers' => [
                        'apns-priority' => '10'
                    ]
                ]
            ]
        ];

        $headers = [
            "Authorization: Bearer ".$accessToken,
            "Content-Type: application/json"
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);

        $response = curl_exec($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if (curl_errno($ch)) {

            $error = curl_error($ch);

            curl_close($ch);

            log_message('error', 'Firebase CURL Error : '.$error);

            return [
                'status' => false,
                'message' => $error
            ];
        }

        curl_close($ch);

        log_message('info', 'Firebase Response : '.$response);


        $responseArray = json_decode($response, true);

        if ($httpCode == 200) {

            return [
                'status'   => true,
                'response' => $responseArray
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | Invalid Token Cleanup
        |--------------------------------------------------------------------------
        */

        if (
            isset($responseArray['error']['status']) &&
            $responseArray['error']['status'] === 'UNREGISTERED'
        ) {

            log_message(
                'error',
                'Firebase Invalid Token : '.$deviceToken
            );

            $this->CI->Notification_model->deleteToken($deviceToken);
        }

        /*
        |--------------------------------------------------------------------------
        | Firebase Error Log
        |--------------------------------------------------------------------------
        */

        log_message(
            'error',
            'Firebase Send Error : '.json_encode($responseArray)
        );

        return [
            'status'   => false,
            'response' => $responseArray
        ];

    }
}