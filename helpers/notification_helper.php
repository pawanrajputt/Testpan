<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_notification'))
{
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
    function send_notification($deviceToken, $title, $body, $data = [])
    {
        $CI =& get_instance();

        $CI->load->library('NotificationService');

        return $CI->notificationservice->sendToDevice(
            $deviceToken,
            $title,
            $body,
            $data
        );
    }
}

if (!function_exists('send_bulk_notification'))
{
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
    function send_bulk_notification(array $deviceTokens, $title, $body, $data = [])
    {
        $CI =& get_instance();

        $CI->load->library('NotificationService');

        return $CI->notificationservice->sendToMultipleDevices(
            $deviceTokens,
            $title,
            $body,
            $data
        );
    }
}

if (!function_exists('send_record_notification'))
{
    /**
     * Send notification using database records
     *
     * @param array  $records
     * @param string $title
     * @param string $body
     * @param array  $data
     *
     * @return array
     */
    function send_record_notification(array $records, $title, $body, $data = [])
    {
        $CI =& get_instance();

        $CI->load->library('NotificationService');

        return $CI->notificationservice->sendByRecords(
            $records,
            $title,
            $body,
            $data
        );
    }
}