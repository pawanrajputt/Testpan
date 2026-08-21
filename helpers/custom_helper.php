<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('formatDistance')) {
    function formatDistance($distance)
    {
        if ($distance === null || $distance === '') {
            return 'N/A';
        }

        $distance = floatval($distance);

        if ($distance < 1000) {
            return $distance . ' m';
        } else {
            return number_format($distance / 1000, 2) . ' km';
        }
    }
}