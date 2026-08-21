<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NotificationService
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();

        $this->CI->load->library('Firebase');
        $this->CI->load->model('FirebaseNotification_model');
    }

    /**
     * Send notification to single device
     *
     * @param string $deviceToken
     * @param string $title
     * @param string $body
     * @param array  $data
     *
     * @return array
     */
    public function sendToDevice($deviceToken, $title, $body, $data = [])
    {
        if (empty($deviceToken)) {

            return [
                'status'  => false,
                'message' => 'Device token is missing.'
            ];
        }

        try {

            return $this->CI->firebase->send(
                $deviceToken,
                $title,
                $body,
                $data
            );

        } catch (Exception $e) {

            log_message(
                'error',
                'NotificationService : '.$e->getMessage()
            );

            return [
                'status'  => false,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * Send notification to multiple devices
     *
     * @param array  $deviceTokens
     * @param string $title
     * @param string $body
     * @param array  $data
     *
     * @return array
     */
    public function sendToMultipleDevices(array $deviceTokens, $title, $body, $data = [])
    {
        $result = [
            'total'     => count($deviceTokens),
            'success'   => 0,
            'failed'    => 0,
            'responses' => []
        ];

        foreach ($deviceTokens as $token) {

            if (empty($token)) {
                continue;
            }

            $response = $this->sendToDevice(
                $token,
                $title,
                $body,
                $data
            );

            $result['responses'][] = $response;

            if (!empty($response['status'])) {
                $result['success']++;
            } else {
                $result['failed']++;
            }
        }


        log_message(
            'info',
            'Notification Summary : '.json_encode([
                'total'   => $result['total'],
                'success' => $result['success'],
                'failed'  => $result['failed']
            ])
        );

        return $result;
    }

    /**
     * Send notification using token objects
     *
     * Example:
     * [
     *   ['device_token'=>'xxxxx'],
     *   ['device_token'=>'yyyyy']
     * ]
     */
    public function sendByRecords(array $records, $title, $body, $data = [])
    {
        $tokens = [];

        foreach ($records as $row) {

            if (is_array($row) && !empty($row['device_token'])) {
                $tokens[] = $row['device_token'];
            }

            if (is_object($row) && !empty($row->device_token)) {
                $tokens[] = $row->device_token;
            }
        }

        return $this->sendToMultipleDevices(
            $tokens,
            $title,
            $body,
            $data
        );
    }
}