<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OwnerAuthController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->model('FirebaseNotification_model');
    }

    // ===========================================
    // SEND SMS Helper
    // ===========================================
    private function sendSms($number, $message)
    {
        // Store the new phone number and OTP in the session
        $sessionData = array();

        $sessionData = [
            'mobile_phone' => $number,
        ];

        $this->session->set_userdata($sessionData);
        $params = [
            'username' => 'testpan',
            'password' => 'testpan',
            'sender' => 'TIPLBM',
            'sendto' => $number,
            'message' => $message,
            'PEID' => '1201159186520284947',
            'templateid' => '1207168821022450810'
        ];

        $url = "https://connect.valueone.ai/api.php?" . http_build_query($params);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // SSL FIX (TEMP - for local testing)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute request
        $response = curl_exec($ch);

        // Capture error if any
        $error = curl_error($ch);

        // HTTP status code (very useful for debugging)
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        // Proper response handling
        if ($response !== false) {
            return [
                'status' => 'success',
                'http_code' => $httpCode,
                'response' => $response
            ];
        } else {
            return [
                'status' => 'error',
                'http_code' => $httpCode,
                'message' => $error ?: 'SMS sending failed'
            ];
        }
    }


    // ===========================================
    // CHECK PHONE EXISTS
    // ===========================================
    public function checkPhoneExists()
    {
        $phone = $this->input->post('mobile_phone');

        if (!$phone) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        $exists = $this->Common_model->check_phone_exists($phone);

        echo json_encode([
            'status' => 'success',
            'exists' => $exists
        ]);
    }


    // ===========================================
    // SEND OTP
    // ===========================================
    public function sendOtp()
    {
        $mobile = $this->input->post('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);

        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Delete old OTPs
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile]);

        // Insert new OTP
        $this->db->insert('otp_verifications', [
            'mobile_phone' => $mobile,
            'otp_hash' => $otpHash,
            'expires_at' => $expiry,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        // Send SMS
        $message = "Your OTP is $otp valid for 10 min only. Testpan India.";
        $this->sendSms($mobile, $message);

        echo json_encode(['status' => 'success', 'message' => 'OTP sent']);
    }


    // ===========================================
    // RESEND OTP
    // ===========================================
    public function resendOtp()
    {
        $mobile = $this->input->post('mobile_phone');

        if (!$mobile) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mobile number required'
            ]);
            return;
        }

        // OPTIONAL: resend rate limit (last 60 sec)
        $lastOtp = $this->db
            ->where('mobile_phone', $mobile)
            ->order_by('created_at', 'DESC')
            ->get('otp_verifications')
            ->row();

        if ($lastOtp && strtotime($lastOtp->created_at) > strtotime('-60 seconds')) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please wait before requesting OTP again'
            ]);
            return;
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);

        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Remove old OTPs
        $this->db->delete('otp_verifications', [
            'mobile_phone' => $mobile
        ]);

        // Insert new OTP
        $this->db->insert('otp_verifications', [
            'mobile_phone' => $mobile,
            'otp_hash'     => $otpHash,
            'expires_at'   => $expiry,
            'attempts'     => 0,
            'is_verified'  => 0,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        // Send SMS
        $message = "Your OTP is $otp valid for 10 min only. Testpan India.";
        $sms = $this->sendSms($mobile, $message);

        if ($sms['status'] === 'success') {
            echo json_encode([
                'status' => 'success',
                'message' => 'OTP resent successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to resend OTP'
            ]);
        }
    }


    // ===========================================
    // VERIFY OTP
    // ===========================================
    public function verifyOtp()
    {
        $mobile = $this->input->post('mobile_phone');
        $otp    = $this->input->post('otp');

        if (!$mobile || !$otp) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile & OTP required']);
            return;
        }

        $row = $this->db
            ->where('mobile_phone', $mobile)
            ->where('is_verified', 0)
            ->get('otp_verifications')
            ->row();

        if (!$row) {
            echo json_encode(['status' => 'error', 'message' => 'OTP not found']);
            return;
        }

        if (strtotime($row->expires_at) < time()) {
            echo json_encode(['status' => 'error', 'message' => 'OTP expired']);
            return;
        }

        if ($row->attempts >= 5) {
            echo json_encode(['status' => 'error', 'message' => 'Too many attempts']);
            return;
        }

        if (!password_verify($otp, $row->otp_hash)) {
            $this->db->set('attempts', 'attempts+1', false)
                ->where('id', $row->id)
                ->update('otp_verifications');

            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            return;
        }

        // Mark verified
        $this->db->update(
            'otp_verifications',
            ['is_verified' => 1],
            ['id' => $row->id]
        );

        echo json_encode(['status' => 'success', 'message' => 'OTP verified']);
    }



    /* =======================================================
     AUTH HELPER
    ======================================================= */
    private function authenticateOwner()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'api_token' => $token,
            'role_id'   => 9
        ]);

        if (!$owner) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $owner;
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    /* =======================================================
     REGISTER OWNER
    ======================================================= */
    public function doRegister()
    {
        $mobile = $this->input->post('mobile_phone');
        $mpin   = $this->input->post('mpin');

        if (!$mobile || !$mpin) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mobile & MPIN required'
            ]);
            return;
        }

        $exists = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 9
        ]);

        if ($exists) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Owner already exists'
            ]);
            return;
        }

        $token = $this->generateToken();
        $now   = date('Y-m-d H:i:s');

        // Full name → first + last
        $name = trim($this->input->post('name'));

        $name_parts = preg_split('/\s+/', $name);

        $first_name = $name_parts[0] ?? '';
        $last_name  = isset($name_parts[1])
            ? $name_parts[1]
            : '';


        /* --------------------------------
        Owner Documents Upload
        -------------------------------- */

        $documentDir = FCPATH . 'uploads/temp_owner_documents/';

        if (!is_dir($documentDir)) {
            mkdir($documentDir, 0755, true);
        }

        $owner_pan_card = '';
        $owner_aadhaar_card = '';

        $this->load->library('upload');


        /* ---------- PAN CARD ---------- */

        if (!empty($_FILES['owner_pan_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name']  = true;
            $config['max_size']      = 5120;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_pan_card')) {

                $uploadData = $this->upload->data();

                $owner_pan_card = $uploadData['file_name'];
            } else {

                echo json_encode([
                    'status' => 'error',
                    'message' => 'PAN Card: ' .
                        strip_tags(
                            $this->upload->display_errors()
                        )
                ]);
                return;
            }
        }


        /* ---------- AADHAAR CARD ---------- */

        if (!empty($_FILES['owner_aadhaar_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['encrypt_name']  = true;
            $config['max_size']      = 5120;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_aadhaar_card')) {

                $uploadData = $this->upload->data();

                $owner_aadhaar_card = $uploadData['file_name'];
            } else {

                // If Aadhaar upload fails, remove PAN uploaded in this request
                if (!empty($owner_pan_card)) {

                    $panFile = $documentDir . $owner_pan_card;

                    if (file_exists($panFile)) {
                        unlink($panFile);
                    }
                }

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Aadhaar Card: ' .
                        strip_tags(
                            $this->upload->display_errors()
                        )
                ]);
                return;
            }
        }


        /* --------------------------------
        Create Owner
        -------------------------------- */

        $ownerId = $this->Common_model->insertData(
            'tt_admin_users',
            [
                'username' => $name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => trim($this->input->post('email')),
                'mobile_phone' => trim($mobile),
                'mobile_country_code' => $this->input->post('country_code'),
                'owner_pan_card' => $owner_pan_card,
                'owner_aadhaar_card' => $owner_aadhaar_card,
                'mpin' => $mpin,
                'role_id' => 9,
                'api_token' => $token,
                'api_token_updated_at' => $now,
                'created' => $now,
                'updated' => $now
            ]
        );


        /* --------------------------------
        Device Token
        -------------------------------- */

        $deviceToken = trim($this->input->post('device_token'));
        $deviceType  = trim($this->input->post('device_type'));
        $appVersion  = trim($this->input->post('app_version'));

        if (!empty($deviceToken)) {

            $this->FirebaseNotification_model->saveDeviceToken([
                'user_id'      => $ownerId,
                'device_token' => $deviceToken,
                'device_type'  => !empty($deviceType)
                    ? strtolower($deviceType)
                    : 'android',
                'app_version'  => $appVersion
            ]);
        }


        /* --------------------------------
        Response
        -------------------------------- */

        echo json_encode([
            'status' => 'success',
            'message' => 'Owner registered successfully',
            'api_token' => $token
        ]);
    }

    /* =======================================================
     LOGIN (TOKEN ROTATION)
    ======================================================= */
    public function login()
    {

        $mobile = trim($this->input->post('mobile_phone'));
        $mpin   = trim($this->input->post('mpin'));
        $deviceToken = trim($this->input->post('device_token'));
        $deviceType = trim($this->input->post('device_type'));
        $appVersion = trim($this->input->post('app_version'));

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 9
        ]);

        if (!$owner || $owner->mpin !== $mpin) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid credentials']);
            return;
        }

        $newToken = $this->generateToken();

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'api_token' => $newToken,
                'api_token_updated_at' => date('Y-m-d H:i:s')
            ],
            ['id' => $owner->id]
        );

        if (!empty($deviceToken)) {

            $this->FirebaseNotification_model->saveDeviceToken([
                'user_id'      => $owner->id,
                'device_token' => $deviceToken,
                'device_type'  => !empty($deviceType) ? strtolower($deviceType) : 'android',
                'app_version'  => $appVersion
            ]);
        }

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'api_token' => $newToken
        ]);
    }


    public function sendForgotMpinOtp()
    {
        $mobile = $this->input->post('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        // Owner must exist
        $owner = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 9
        ]);

        if (!$owner) {
            echo json_encode(['status' => 'error', 'message' => 'Account not found']);
            return;
        }

        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);

        $this->db->delete('otp_verifications', [
            'mobile_phone' => $mobile,
            'purpose' => 'forgot_mpin'
        ]);

        $this->db->insert('otp_verifications', [
            'mobile_phone' => $mobile,
            'otp_hash'     => $otpHash,
            'purpose'      => 'forgot_mpin',
            'attempts'     => 0,
            'is_verified'  => 0,
            'expires_at'   => date('Y-m-d H:i:s', strtotime('+5 minutes')),
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        $this->sendSms($mobile, "Your OTP is $otp valid for 10 min only. Testpan India.");

        echo json_encode(['status' => 'success', 'message' => 'OTP sent']);
    }


    public function verifyForgotMpinOtp()
    {
        $mobile = $this->input->post('mobile_phone');
        $otp    = $this->input->post('otp');

        if (!$mobile || !$otp) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile & OTP required']);
            return;
        }

        $row = $this->db
            ->where([
                'mobile_phone' => $mobile,
                'purpose' => 'forgot_mpin',
                'is_verified' => 0
            ])
            ->get('otp_verifications')
            ->row();

        if (!$row) {
            echo json_encode(['status' => 'error', 'message' => 'OTP not found']);
            return;
        }

        if (strtotime($row->expires_at) < time()) {
            echo json_encode(['status' => 'error', 'message' => 'OTP expired']);
            return;
        }

        if ($row->attempts >= 5) {
            echo json_encode(['status' => 'error', 'message' => 'Too many attempts']);
            return;
        }

        if (!password_verify($otp, $row->otp_hash)) {
            $this->db->set('attempts', 'attempts+1', false)
                ->where('id', $row->id)
                ->update('otp_verifications');

            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            return;
        }

        $this->db->update('otp_verifications', ['is_verified' => 1], ['id' => $row->id]);

        echo json_encode(['status' => 'success', 'message' => 'OTP verified']);
    }


    public function resetForgotMpin()
    {
        $mobile = $this->input->post('mobile_phone');
        $newMpin = trim($this->input->post('mpin'));

        if (!$mobile || !$newMpin) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile & new MPIN required']);
            return;
        }

        $otpRow = $this->db
            ->where([
                'mobile_phone' => $mobile,
                'purpose' => 'forgot_mpin',
                'is_verified' => 1
            ])
            ->get('otp_verifications')
            ->row();

        if (!$otpRow) {
            echo json_encode(['status' => 'error', 'message' => 'OTP verification required']);
            return;
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'mpin' => $newMpin,
                'updated' => date('Y-m-d H:i:s')
            ],
            ['mobile_phone' => $mobile, 'role_id' => 9]
        );

        // Cleanup OTP
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile, 'purpose' => 'forgot_mpin']);

        echo json_encode(['status' => 'success', 'message' => 'MPIN reset successfully']);
    }


    /* =======================================================
     LOGOUT
    ======================================================= */
    public function logout()
    {
        $owner = $this->authenticateOwner();

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            ['api_token' => NULL],
            ['id' => $owner->id]
        );

        echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
    }
}
