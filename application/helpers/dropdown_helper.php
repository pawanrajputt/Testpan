<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('get_dropdown_options')) {
    function get_dropdown_options($type)
    {
        $options = [
            'system_processor' => ['7', '8', '10', '11'],
            'ram_size'         => ['4GB', '8GB', '16GB', '32GB'],
        ];

        return isset($options[$type]) ? $options[$type] : [];
    }
}
