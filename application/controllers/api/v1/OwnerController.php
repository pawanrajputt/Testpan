<?php
defined('BASEPATH') or exit('No direct script access allowed');

class OwnerController extends CI_Controller
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


    /* =======================================================
     OWNER MPIN RESET VIA PROFILE
    ======================================================= */
    public function resetMpin()
    {
        $owner = $this->authenticateOwner();

        $current = trim($this->input->post('current_mpin'));
        $new     = trim($this->input->post('new_mpin'));
        $confirm = trim($this->input->post('confirm_mpin'));

        if (!$current || !$new || !$confirm) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'All MPIN fields are required'
            ]);
            return;
        }

        if ($current !== $owner->mpin) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Current MPIN is incorrect'
            ]);
            return;
        }

        if ($new !== $confirm) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'New MPIN and Confirm MPIN do not match'
            ]);
            return;
        }

        if (!ctype_digit($new) || strlen($new) !== 4) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'MPIN must be exactly 4 digits'
            ]);
            return;
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'mpin'    => $new,
                'updated' => date('Y-m-d H:i:s')
            ],
            ['id' => $owner->id]
        );

        echo json_encode([
            'status'  => 'success',
            'message' => 'MPIN reset successfully'
        ]);
    }

    /* =======================================================
     DASHBOARD
    ======================================================= */
    public function dashboard()
    {
        $owner = $this->authenticateOwner();

        // Total centers
        $total = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        // Approved centers
        $approved = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->where('approved', 1)
            ->count_all_results('tt_center');

        // Pending centers
        $pending = $this->db
            ->where('owner_user_id', $owner->id)
            ->where('deleted', 0)
            ->where('approved', 0)
            ->count_all_results('tt_center');

        echo json_encode([
            'status' => 'success',
            'owner' => [
                'id' => (int)$owner->id,
                'name' => $owner->username,
                'mobile' => $owner->mobile_phone
            ],
            'stats' => [
                'total_centers' => (int)$total,
                'approved' => (int)$approved,
                'pending' => (int)$pending
            ]
        ]);
    }


    /* =======================================================
     ALL CENTERS BY OWNER
    ======================================================= */
    public function allCenterListing()
    {
        $owner = $this->authenticateOwner();

        $centers = $this->Common_model->getdata_array(
            'tt_center',
            ['owner_user_id' => $owner->id, 'deleted' => 0]
        );

        foreach ($centers as $key => $center) {

            // If api_token is empty → generate and update
            if (empty($center['api_token'])) {

                $token = bin2hex(random_bytes(32));

                $this->db->where('id', $center['id']);
                $this->db->update('tt_center', [
                    'api_token' => $token
                ]);

                // assign new token
                $centers[$key]['api_token'] = $token;
            }

            // ALWAYS send as center_api_token
            $centers[$key]['center_api_token'] = $centers[$key]['api_token'];

            // OPTIONAL: remove original api_token if you don't want to expose it
            unset($centers[$key]['api_token']);
        }

        // Fetch related data
        $countries = $this->Common_model->getdata_array('tt_countries', '');
        $states = $this->Common_model->getdata_array('tt_states', '');
        $cities = $this->Common_model->getdata_array('tt_city_master', '');

        echo json_encode([
            'status' => 'success',
            'centers' => $centers,
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
        ]);
    }

    /* =======================================================
     OWNER PROFILE
    ======================================================= */
    public function profile()
    {
        $owner = $this->authenticateOwner();

        $profile_pic = '';
        $pan_card = '';
        $aadhaar_card = '';

        if (!empty($owner->profile_pic)) {
            $profile_pic = base_url(
                'uploads/owner_profile/' . $owner->profile_pic
            );
        }

        if (!empty($owner->owner_pan_card)) {
            $pan_card = base_url(
                'uploads/temp_owner_documents/' . $owner->owner_pan_card
            );
        }

        if (!empty($owner->owner_aadhaar_card)) {
            $aadhaar_card = base_url(
                'uploads/temp_owner_documents/' . $owner->owner_aadhaar_card
            );
        }

        echo json_encode([
            'status' => 'success',
            'data' => [
                'name'         => $owner->username,
                'email'        => $owner->email,
                'mobile_phone' => $owner->mobile_phone,
                'profile_pic'  => $profile_pic,
                'pan_card'     => $pan_card,
                'aadhaar_card' => $aadhaar_card
            ]
        ]);
    }

    /* =======================================================
     UPDATE PROFILE
    ======================================================= */
    public function updateProfile()
    {
        $owner = $this->authenticateOwner();

        $name  = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));

        if (!$name) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Name field is required'
            ]);
            return;
        }

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email field is required'
            ]);
            return;
        }

        $name_parts = preg_split('/\s+/', $name);

        $updateData = [
            'username'   => $name,
            'first_name' => $name_parts[0] ?? '',
            'last_name'  => $name_parts[1] ?? '',
            'email'      => $email,
            'updated'    => date('Y-m-d H:i:s')
        ];


        /* --------------------------------
       Profile Pic Upload
    -------------------------------- */

        if (!empty($_FILES['profile_pic']['name'])) {

            $uploadDir = FCPATH . 'uploads/owner_profile/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $config['upload_path']   = $uploadDir;
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name']  = true;
            $config['max_size']      = 2048;

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_pic')) {

                $uploadData = $this->upload->data();

                $updateData['profile_pic'] = $uploadData['file_name'];

                // Delete old image
                if (!empty($owner->profile_pic)) {

                    $oldFile = FCPATH .
                        'uploads/owner_profile/' .
                        $owner->profile_pic;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => strip_tags(
                        $this->upload->display_errors()
                    )
                ]);
                return;
            }
        }


        /* --------------------------------
       Owner Documents Upload
    -------------------------------- */

        $documentDir = FCPATH . 'uploads/temp_owner_documents/';

        if (!is_dir($documentDir)) {
            mkdir($documentDir, 0755, true);
        }

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

                $updateData['owner_pan_card'] =
                    $uploadData['file_name'];

                // Delete old PAN card
                if (!empty($owner->owner_pan_card)) {

                    $oldFile = $documentDir .
                        $owner->owner_pan_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
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

                $updateData['owner_aadhaar_card'] =
                    $uploadData['file_name'];

                // Delete old Aadhaar card
                if (!empty($owner->owner_aadhaar_card)) {

                    $oldFile = $documentDir .
                        $owner->owner_aadhaar_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Aadhaar Card: ' .
                        strip_tags(
                            $this->upload->display_errors()
                        )
                ]);
                return;
            }
        }


        /* --------------------------------
       Update Database
       -------------------------------- */

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $updateData,
            ['id' => $owner->id]
        );


        /* --------------------------------
       Response URLs
       -------------------------------- */

        $profile_pic_url = '';
        $pan_card_url = '';
        $aadhaar_card_url = '';


        if (!empty($updateData['profile_pic'])) {

            $profile_pic_url = base_url(
                'uploads/owner_profile/' .
                    $updateData['profile_pic']
            );
        } elseif (!empty($owner->profile_pic)) {

            $profile_pic_url = base_url(
                'uploads/owner_profile/' .
                    $owner->profile_pic
            );
        }


        if (!empty($updateData['owner_pan_card'])) {

            $pan_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $updateData['owner_pan_card']
            );
        } elseif (!empty($owner->owner_pan_card)) {

            $pan_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $owner->owner_pan_card
            );
        }


        if (!empty($updateData['owner_aadhaar_card'])) {

            $aadhaar_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $updateData['owner_aadhaar_card']
            );
        } elseif (!empty($owner->owner_aadhaar_card)) {

            $aadhaar_card_url = base_url(
                'uploads/temp_owner_documents/' .
                    $owner->owner_aadhaar_card
            );
        }


        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated',
            'data' => [
                'name'         => $updateData['username'],
                'email'        => $updateData['email'],
                'profile_pic'  => $profile_pic_url,
                'pan_card'     => $pan_card_url,
                'aadhaar_card' => $aadhaar_card_url
            ]
        ]);
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


    public function viewCenterDetail($center_id)
    {
        header("Content-Type: application/json");

        // Authenticate owner via token
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        // Fetch center
        $center = $this->Common_model->getdata('tt_center', [
            'id' => $center_id,
            'owner_user_id' => $owner_id
        ]);

        if (!$center) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Center not found or access denied'
            ]);
            return;
        }

        $baseUrl = base_url();

        // Documents
        $documents = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_document')
            ->result();

        foreach ($documents as &$doc) {
            $doc->url = $baseUrl . $doc->url;
        }

        // Images
        $images = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_images')
            ->result();

        foreach ($images as &$img) {
            $img->center_image = $baseUrl . $img->center_image;
        }

        // Videos
        $videos = $this->db
            ->where('center_id', $center_id)
            ->where('deleted', 0)
            ->get('tt_center_video')
            ->result();

        foreach ($videos as &$video) {
            $video->center_video = $baseUrl . $video->center_video;
        }

        // Labs
        $labs = $this->db
            ->where('center_id', $center_id)
            ->get('tt_lab')
            ->result();

        // GST file & Logo
        if (!empty($center->gst_file)) {
            $center->gst_file = $baseUrl . $center->gst_file;
        }

        if (!empty($center->logo)) {
            $center->logo = $baseUrl . $center->logo;
        }

        // Fetch related data
        $where = '';
        $countries = $this->Common_model->getdata_array('tt_countries', $where);
        $states = $this->Common_model->getdata_array('tt_states', $where);
        $cities = $this->Common_model->getdata_array('tt_city_master', $where);

        // Final Response
        echo json_encode([
            'status' => 'success',
            'data' => [
                'center'     => $center,
                'documents'  => $documents,
                'images'     => $images,
                'videos'     => $videos,
                'labs'       => $labs,
                'countries'   => $countries,
                'states'   => $states,
                'cities'   => $cities,
            ]
        ]);
    }


    /* =======================================================
     OWNER ACCOUNT DELETE
    ======================================================= */
    public function deleteOwnerAccountApi()
    {
        $owner = $this->authenticateOwner();

        $owner_user_id = $owner->id;

        $centerExists = $this->db
            ->where('owner_user_id', $owner_user_id)
            ->limit(1)
            ->count_all_results('tt_center') > 0;

        if ($centerExists) {
            echo json_encode([
                'status'  => false,
                'message' => 'Account cannot be deleted because center exist.'
            ]);
            return;
        }

        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $data,
            ['id' => $owner_user_id]
        );

        echo json_encode([
            'status'    => true,
            'message'   => 'Account deleted successfully!',
            'id'        => $owner_user_id
        ]);
    }
}
