<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_email')) {

    function send_email($msg, $sub, $to, $from, $attachment = '')
    {
        $config = array();
        
        $config['protocol']     = 'smtp';
        $config['smtp_host']    = 'in-v3.mailjet.com';
        $config['smtp_port']    = 587;
        $config['smtp_user']    = '9deae25a281139533d9e4f36975dbfcc';
        $config['smtp_pass']    = '026145e8527fc3025b98aa07884d72ae';
        $config['smtp_crypto']  = 'tls';
        $config['mailtype']     = 'html';
        $config['charset']      = 'utf-8';
        $config['newline']      = "\r\n";
        $config['crlf']         = "\r\n";
        $config['smtp_timeout'] = 30;

        $CI =& get_instance();
        $CI->load->library('email');
        $CI->email->initialize($config);

        $CI->email->from($from, 'BookMyTestCenter');
        $CI->email->to($to);
        $CI->email->subject($sub);
        $CI->email->message($msg);

        if ($attachment != '') {
            $CI->email->attach($attachment);
        }

        if ($CI->email->send()) {
            return true;
        } else {
            log_message('error', $CI->email->print_debugger());
            return false;
        }
    }
}