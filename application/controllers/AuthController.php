<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

class AuthController extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Booking_model');
        $this->load->library('session');
        $this->load->helper('email');
    }

    public function index()
    {

        // Soft clear signup temp data
        $this->session->unset_userdata([
            'mpin',
            'otp',
            'mobile_phone',
            'email',
            'name',
            'country_code',
            'signup_step'
        ]);

        // ❗ If an incomplete center exists, force login
        if ($this->session->userdata('exam_center_id')) {
            $this->logout();
            exit;
        }

        $data['countries'] = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $data['center_type'] = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $data['bank_name'] = $this->Common_model->getdata_array('tt_bank_name', ['deleted' => 0]);

        $data['privacyPolicy'] = $this->Common_model->getdata('cms', array('slug' => 'privacy-policy', 'status' => 1));
        $data['termsCondition'] = $this->Common_model->getdata('cms', array('slug' => 'terms-condition', 'status' => 1));


        if (!$this->session->userdata('site_settings')) {
            $result = $this->Common_model->getdata_array('custom_settings', '');

            // Convert to key-value array
            $settings = [];
            foreach ($result as $item) {
                $settings[$item['setting_key']] = $item['setting_value'];
            }

            // Session
            $this->session->set_userdata('site_settings', $settings);
        }

        $this->load->view('layouts/auth/header');
        $this->load->view('auth/signup', $data);
        $this->load->view('layouts/auth/footer');
    }

    public function cmsPage($slug)
    {

        $data['cmsData'] = $this->Common_model->getdata('cms', array('slug' => $slug));

        $this->load->view('layouts/auth/header');
        $this->load->view('auth/cms', $data);
        $this->load->view('layouts/auth/footer');
    }


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

    public function checkPhoneExists()
    {
        $phone = $this->input->post('mobile_phone');

        $exists = $this->Common_model->check_phone_exists($phone);
        echo json_encode(['exists' => $exists]);
        exit;
    }


    public function sendOtp()
    {
        $mobile = $this->input->post('mobile_phone');
        $email  = $this->input->post('email');
        $name   = $this->input->post('name');
        $country_code = $this->input->post('country_code');
        $panFile = $_FILES['owner_pan_card'] ?? null;
        $aadhaarFile = $_FILES['owner_aadhaar_card'] ?? null;

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        // At least one document required
        if (
            empty($panFile['name']) &&
            empty($aadhaarFile['name'])
        ) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Please upload PAN Card or Aadhaar Card'
            ]);
            return;
        }


        $panPath = null;
        $aadhaarPath = null;

        if (!empty($panFile['name'])) {

            $panPath = $this->uploadOwnerDocument(
                $panFile,
                'owner_pan_card',
                $mobile
            );

            if ($panPath === false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to upload PAN Card'
                ]);
                return;
            }
        }

        if (!empty($aadhaarFile['name'])) {

            $aadhaarPath = $this->uploadOwnerDocument(
                $aadhaarFile,
                'owner_aadhaar_card',
                $mobile
            );

            if ($aadhaarPath === false) {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to upload Aadhaar Card'
                ]);
                return;
            }
        }

        $check = $this->Common_model->getdata('tt_admin_users', array('mobile_phone' => $mobile, 'role_id' => 12));

        if ($check) {
            echo json_encode(['status' => 'error', 'message' => 'This mobile is already used as client account']);
            return;
        }

        // OTP generate
        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);

        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Purane OTP delete
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile]);

        // Insert OTP
        $this->db->insert('otp_verifications', [
            'mobile_phone' => $mobile,
            'otp_hash'     => $otpHash,
            'expires_at'   => $expiry,
            'attempts'     => 0,
            'is_verified'  => 0,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        // SMS
        $message = "Your OTP is $otp valid for 10 min only. Testpan India.";
        $sms = $this->sendSms($mobile, $message);

        // Session me sirf minimal data
        $this->session->set_userdata([
            'mobile_phone' => $mobile,
            'email' => $email,
            'name' => $name,
            'country_code' => $country_code,
            'owner_pan_card' => $panPath,
            'owner_aadhaar_card' => $aadhaarPath
        ]);

        if ($sms['status'] === 'success') {

            // ================= SEND REQUIRED DOCUMENT EMAIL =================
            $email_subject = "Required Documents for Center Registration";

            $email_content = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        padding: 20px;
                    }

                    .email-container {
                        background: #ffffff;
                        border-radius: 8px;
                        padding: 30px;
                        max-width: 650px;
                        margin: auto;
                        border: 1px solid #e5e5e5;
                    }

                    .header {
                        text-align: center;
                        margin-bottom: 25px;
                    }

                    .header h2 {
                        color: #1f4e79;
                        margin: 0;
                    }

                    .content {
                        color: #333;
                        line-height: 1.7;
                        font-size: 15px;
                    }

                    .doc-list {
                        margin-top: 15px;
                        padding-left: 20px;
                    }

                    .doc-list li {
                        margin-bottom: 10px;
                    }

                    .note-box {
                        background: #fff8e1;
                        border: 1px solid #ffe58f;
                        padding: 15px;
                        border-radius: 6px;
                        margin-top: 20px;
                        color: #8c6d1f;
                    }

                    .footer {
                        margin-top: 30px;
                        font-size: 13px;
                        color: #888;
                        text-align: center;
                    }

                </style>
            </head>

            <body>

                <div class='email-container'>

                    <div class='header'>
                        <h2>BookMyTestCenter Registration</h2>
                    </div>

                    <div class='content'>

                        <p>Dear <strong>{$name}</strong>,</p>

                        <p>
                            Thank you for starting your center registration with 
                            <strong>BookMyTestCenter</strong>.
                        </p>

                        <p>
                            Please keep the following documents ready to complete your registration process:
                        </p>

                        <ul class='doc-list'>
                            <li>✔ Canceled Cheque</li>
                            <li>✔ GST Certificate</li>
                            <li>✔ Udyam Certificate</li>
                            <li>✔ PAN Card</li>
                            <li>✔ UIDAI Number (if available)</li>
                        </ul>

                        <div class='note-box'>
                            ⚠ Please ensure all documents are available before proceeding further in the onboarding process.
                        </div>

                        <p style='margin-top:20px;'>
                            If you need any assistance, feel free to contact our support team.
                        </p>

                        <p>
                            Regards,<br>
                            <strong>BookMyTestCenter Team</strong>
                        </p>

                    </div>

                    <div class='footer'>
                        © " . date('Y') . " BookMyTestCenter. All Rights Reserved.
                    </div>

                </div>

            </body>
            </html>
            ";

            // SEND EMAIL
            try {

                $send_email = send_email(
                    $email_content,
                    $email_subject,
                    $email,
                    "centerbooking@bookmytestcenter.com"
                );

                if (!$send_email) {
                    log_message('error', 'Failed to send required document email to: ' . $email);
                }
            } catch (Exception $e) {

                log_message('error', 'Email sending exception: ' . $e->getMessage());
            }

            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
        }
    }


    private function uploadOwnerDocument($file, $type, $mobile)
    {
        if (empty($file['name'])) {
            return null;
        }

        $upload_path = FCPATH . 'uploads/temp_owner_documents/';

        if (!is_dir($upload_path)) {
            mkdir($upload_path, 0755, true);
        }

        $extension = strtolower(
            pathinfo($file['name'], PATHINFO_EXTENSION)
        );

        $allowed_extensions = ['jpg', 'jpeg', 'png', 'pdf'];

        if (!in_array($extension, $allowed_extensions)) {
            return false;
        }

        $file_name = $type . '_' . $mobile . '_' . time() . '.' . $extension;

        $config['upload_path'] = $upload_path;
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['max_size'] = 5120; // 5 MB
        $config['file_name'] = $file_name;
        $config['overwrite'] = false;

        $this->load->library('upload');

        $this->upload->initialize($config);

        if (!$this->upload->do_upload($type)) {
            log_message(
                'error',
                'Owner document upload failed: ' .
                    $this->upload->display_errors('', '')
            );

            return false;
        }

        $upload_data = $this->upload->data();

        return $upload_data['file_name'];
    }


    public function resendOtp()
    {
        $mobile = $this->session->userdata('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Session expired']);
            return;
        }

        // Rate limit (60 sec)
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

        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Purana OTP delete
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile]);

        // Insert new OTP
        $this->db->insert('otp_verifications', [
            'mobile_phone' => $mobile,
            'otp_hash'     => $otpHash,
            'expires_at'   => $expiry,
            'attempts'     => 0,
            'is_verified'  => 0,
            'created_at'   => date('Y-m-d H:i:s')
        ]);

        $message = "Your OTP is $otp valid for 10 min only. Testpan India.";
        $sms = $this->sendSms($mobile, $message);

        if ($sms['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => 'OTP resent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to resend OTP']);
        }
    }


    public function verifyOtp()
    {
        $otp    = $this->input->post('otp');
        $mobile = $this->session->userdata('mobile_phone');

        if (!$otp || !$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'OTP or session missing']);
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

        // Verified
        $this->db->update(
            'otp_verifications',
            ['is_verified' => 1],
            ['id' => $row->id]
        );

        $check = $this->Common_model->getdata('tt_admin_users', array('mobile_phone' => $mobile));
        $is_already = 0;

        if ($check) {

            $owner_pan_card = $this->session->userdata('owner_pan_card');
            $owner_aadhaar_card = $this->session->userdata('owner_aadhaar_card');

            $updateData = [];

            if (!empty($owner_pan_card)) {
                $updateData['owner_pan_card'] = $owner_pan_card;
            }

            if (!empty($owner_aadhaar_card)) {
                $updateData['owner_aadhaar_card'] = $owner_aadhaar_card;
            }

            if (!empty($updateData)) {

                $this->Common_model->UpdateRecord(
                    'tt_admin_users',
                    $updateData,
                    ['id' => $check->id]
                );
            }

            $is_already = 1;
        }

        echo json_encode(['status' => 'success', 'message' => 'OTP verified successfully', 'is_already' => $is_already]);
    }



    public function storeMpin()
    {
        $mpin = $this->input->post('mpin');
        $mobile_phone = $this->session->userdata('mobile_phone');
        $email = $this->session->userdata('email');
        $name = $this->session->userdata('name');
        $country_code = $this->session->userdata('country_code') ?? '+91';
        $owner_pan_card = $this->session->userdata('owner_pan_card');
        $owner_aadhaar_card = $this->session->userdata('owner_aadhaar_card');

        if (!$mpin || !$mobile_phone) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            return;
        }

        $created_at = date('Y-m-d H:i:s');

        $name_parts = explode(' ', trim($name));
        $first_name = $name_parts[0] ?? '';
        $last_name  = $name_parts[1] ?? '';

        // OWNER CHECK
        $owner = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile_phone,
            'role_id' => 9
        ]);

        if ($owner) {
            // Update mpin only
            $updateData = [
                'mpin' => $mpin,
                'updated' => $created_at
            ];

            if (!empty($owner_pan_card)) {
                $updateData['owner_pan_card'] = $owner_pan_card;
            }

            if (!empty($owner_aadhaar_card)) {
                $updateData['owner_aadhaar_card'] = $owner_aadhaar_card;
            }

            $this->Common_model->UpdateRecord(
                'tt_admin_users',
                $updateData,
                ['id' => $owner->id]
            );

            $ownerId = $owner->id;
        } else {
            // Create OWNER
            $ownerId = $this->Common_model->insertData('tt_admin_users', [
                'username' => $name,
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'mobile_phone' => $mobile_phone,
                'mobile_country_code' => $country_code,
                'owner_pan_card' => $owner_pan_card,
                'owner_aadhaar_card' => $owner_aadhaar_card,
                'mpin' => $mpin,
                'role_id' => 9,
                'created' => $created_at,
                'updated' => $created_at,
                'approved' => 1,
            ]);
        }

        // signup flow session only
        $this->session->set_userdata([
            'owner_id' => $ownerId,
            'is_owner_logged_in' => true
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'MPIN created successfully'
        ]);
    }



    public function login()
    {
        $mpin = trim($this->input->post('mpin'));
        $mobile_phone = trim($this->input->post('mobile_phone'));

        if (!$mpin || !$mobile_phone) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Mobile & MPIN required'
            ]);
            return;
        }

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile_phone,
            'role_id' => 9
        ]);

        if (!$owner) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Account not found'
            ]);
            return;
        }

        // SUPPORT BOTH (plain + hashed)
        $mpinMatched = false;

        if ($owner->mpin === $mpin) {
            $mpinMatched = true;
        } elseif (password_verify($mpin, $owner->mpin)) {
            $mpinMatched = true;
        }

        if (!$mpinMatched) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid MPIN'
            ]);
            return;
        }

        if ($owner->deleted == 1) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Your account is deleted. Please contact support for more information!'
            ]);
            return;
        }

        if ($owner->approved != 1) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Your account is deactived by team. Please contact support for more information!'
            ]);
            return;
        }

        // OWNER SESSION
        $this->session->set_userdata([
            'owner_id' => $owner->id,
            'is_owner_logged_in' => true
        ]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'redirect' => site_url('center-owner-dashboard')
        ]);
    }


    public function centerOwnerDashabord()
    {
        if (!$this->session->userdata('is_owner_logged_in')) {
            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        $this->db->select('
            c.id,
            c.center_id,
            c.center_name,
            c.capacity,
            c.approved,
            c.created_on,
            c.total_no_system,
            c.total_no_lab,

            country.name AS country_name,
            state.title AS state_name,
            city.city_name
        ');

        $this->db->from('tt_center c');
        $this->db->join('tt_countries country', 'country.id = c.country_id', 'left');
        $this->db->join('tt_states state', 'state.id = c.state_id', 'left');
        $this->db->join('tt_city_master city', 'city.city_id = c.city_id', 'left');
        $this->db->where('c.owner_user_id', $owner_id);
        $this->db->where('c.deleted', 0);
        $this->db->order_by('c.created_on', 'DESC');
        $query = $this->db->get();
        $centers = $query->result_array();

        // if (empty($centers)) {
        //     show_error('No centers found for this owner.');
        // }

        $data['centers'] = $centers;

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/dashboard/dashboard', $data);
        $this->load->view('auth/owner/layouts/footer');
    }


    public function selectCenter($center_id)
    {
        if (!$this->session->userdata('is_owner_logged_in')) {
            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        $center = $this->Common_model->getdata('tt_center', [
            'id' => $center_id,
            'owner_user_id' => $owner_id
        ]);

        if (!$center) {
            show_error('Unauthorized access');
        }

        if ((int)$center->approved !== 1) {
            show_error('Center not approved yet');
        }

        $this->session->set_userdata([
            'selected_center_id' => $center->id,
            'exam_center_id' => $center->id,
        ]);

        redirect('dashboard');
    }


    // Owner Logut
    public function logout()
    {
        $this->session->unset_userdata([
            'owner_id',
            'selected_center_id',
            'exam_center_id',
            'is_owner_logged_in'
        ]);

        $this->session->sess_destroy();
        redirect('/');
    }


    private function authOwner()
    {
        if (!$this->session->userdata('is_owner_logged_in')) {
            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'id' => $owner_id,
            'role_id' => 9
        ]);

        if (!$owner) {
            $this->session->sess_destroy();
            redirect('/');
        }

        return $owner;
    }


    public function profile()
    {
        $owner = $this->authOwner();

        $data['owner'] = $owner;

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/dashboard/profile', $data);
        $this->load->view('auth/owner/layouts/footer');
    }


    public function updateProfile()
    {
        $owner = $this->authOwner();

        $name  = trim($this->input->post('name'));
        $email = trim($this->input->post('email'));

        if (!$name) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Name is required'
            ]);
            exit;
        }

        if (!$email) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Email is required'
            ]);
            exit;
        }

        $updateData = [
            'username' => $name,
            'email'    => $email,
            'updated'  => date('Y-m-d H:i:s')
        ];

        $name_parts = preg_split('/\s+/', $name);
        $updateData['first_name'] = $name_parts[0] ?? '';
        $updateData['last_name']  = $name_parts[1] ?? '';

        // Profile Pic Upload
        if (!empty($_FILES['profile_pic']['name'])) {

            $uploadDir = FCPATH . 'uploads/owner_profile/';

            // Folder create if not exists
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $config['upload_path']   = $uploadDir;
            $config['allowed_types'] = 'jpg|jpeg|png|webp';
            $config['encrypt_name']  = true;
            $config['max_size']      = 2048; // 2 MB

            $this->load->library('upload');
            $this->upload->initialize($config);

            if ($this->upload->do_upload('profile_pic')) {

                $uploadData = $this->upload->data();

                $updateData['profile_pic'] = $uploadData['file_name'];

                // Delete old image
                if (!empty($owner->profile_pic)) {

                    $oldFile = FCPATH . 'uploads/owner_profile/' . $owner->profile_pic;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => strip_tags($this->upload->display_errors())
                ]);
                exit;
            }
        }

        /* Owner Documents Upload */

        $documentDir = FCPATH . 'uploads/temp_owner_documents/';

        if (!is_dir($documentDir)) {
            mkdir($documentDir, 0755, true);
        }

        $this->load->library('upload');


        /* PAN CARD */

        if (!empty($_FILES['owner_pan_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = true;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_pan_card')) {

                $uploadData = $this->upload->data();

                $updateData['owner_pan_card'] = $uploadData['file_name'];

                // Delete old PAN document
                if (!empty($owner->owner_pan_card)) {

                    $oldFile = $documentDir . $owner->owner_pan_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'PAN Card: ' .
                        strip_tags($this->upload->display_errors())
                ]);
                exit;
            }
        }


        /* AADHAAR CARD */

        if (!empty($_FILES['owner_aadhaar_card']['name'])) {

            $config = [];

            $config['upload_path']   = $documentDir;
            $config['allowed_types'] = 'jpg|jpeg|png|pdf';
            $config['max_size']      = 5120;
            $config['encrypt_name']  = true;

            $this->upload->initialize($config);

            if ($this->upload->do_upload('owner_aadhaar_card')) {

                $uploadData = $this->upload->data();

                $updateData['owner_aadhaar_card'] = $uploadData['file_name'];

                // Delete old Aadhaar document
                if (!empty($owner->owner_aadhaar_card)) {

                    $oldFile = $documentDir . $owner->owner_aadhaar_card;

                    if (file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            } else {

                echo json_encode([
                    'status'  => 'error',
                    'message' => 'Aadhaar Card: ' .
                        strip_tags($this->upload->display_errors())
                ]);
                exit;
            }
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $updateData,
            ['id' => $owner->id]
        );

        echo json_encode([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'profile_pic_url' => !empty($updateData['profile_pic'])
                ? base_url('uploads/owner_profile/' . $updateData['profile_pic'])
                : ''
        ]);
        exit;
    }


    public function resetMpin()
    {
        $owner = $this->authOwner();

        $current = trim($this->input->post('current_mpin'));
        $new     = trim($this->input->post('new_mpin'));
        $confirm = trim($this->input->post('confirm_mpin'));

        if (!$current || !$new || !$confirm) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All MPIN fields are required'
            ]);
            exit;
        }

        if ($current !== $owner->mpin) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Current MPIN is incorrect'
            ]);
            exit;
        }

        if ($new !== $confirm) {
            echo json_encode([
                'status' => 'error',
                'message' => 'New MPIN and Confirm MPIN do not match'
            ]);
            exit;
        }

        if (!ctype_digit($new) || strlen($new) !== 4) {
            echo json_encode([
                'status' => 'error',
                'message' => 'MPIN must be exactly 4 digits'
            ]);
            exit;
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
        exit;
    }

    public function helpAndSupport()
    {
        $data['result'] = $this->Common_model->getdata_array('custom_settings', '');

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/dashboard/help_and_support', $data);
        $this->load->view('auth/owner/layouts/footer');
    }


    public function fetchStateByCountryId()
    {
        $country_id = $this->input->post('country_id');
        if ($country_id) {
            $states = $this->Common_model->getdata_array('tt_states', ['country_id' => $country_id]);
            echo json_encode($states);
        } else {
            echo json_encode([]);
        }
    }


    public function fetchCityByStateId()
    {
        $state_id = $this->input->post('state_id');
        if ($state_id) {
            $city = $this->Common_model->getdata_array('tt_city_master', ['state_id' => $state_id]);
            echo json_encode($city);
        } else {
            echo json_encode([]);
        }
    }


    public function resetForgotMpin()
    {
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/forgot-mpin');
        $this->load->view('layouts/auth/footer');
    }


    public function sendResetForgotMpinOtp()
    {
        $mobile = trim($this->input->post('mobile_phone'));

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            exit;
        }

        $user = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 9
        ]);

        if (!$user) {
            echo json_encode([
                'status' => 'error',
                'message' => 'No account registered with this mobile number'
            ]);
            exit;
        }

        // Generate OTP (prod me rand use karna)
        $otp = rand(100000, 999999);
        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

        // Remove old OTPs
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile]);

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
            $this->session->set_userdata('mpin_mobile_phone', $mobile);

            echo json_encode([
                'status' => 'success',
                'message' => 'OTP sent successfully'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to send OTP'
            ]);
        }
        exit;
    }



    public function resetForgotMpinOtp()
    {
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/forgot-mpin-otp');
        $this->load->view('layouts/auth/footer');
    }


    public function verifyResetForgotMpinOtp()
    {
        $mobile = $this->session->userdata('mpin_mobile_phone');
        $otp    = trim($this->input->post('otp'));

        if (!$mobile || !$otp) {
            echo json_encode(['status' => 'error', 'message' => 'OTP required']);
            exit;
        }

        $row = $this->db
            ->where('mobile_phone', $mobile)
            ->where('is_verified', 0)
            ->get('otp_verifications')
            ->row();

        if (!$row) {
            echo json_encode(['status' => 'error', 'message' => 'OTP not found']);
            exit;
        }

        if (strtotime($row->expires_at) < time()) {
            echo json_encode(['status' => 'error', 'message' => 'OTP expired']);
            exit;
        }

        if ($row->attempts >= 5) {
            echo json_encode(['status' => 'error', 'message' => 'Too many attempts']);
            exit;
        }

        if (!password_verify($otp, $row->otp_hash)) {
            $this->db->set('attempts', 'attempts+1', false)
                ->where('id', $row->id)
                ->update('otp_verifications');

            echo json_encode(['status' => 'error', 'message' => 'Invalid OTP']);
            exit;
        }

        // Mark verified
        $this->db->update(
            'otp_verifications',
            ['is_verified' => 1],
            ['id' => $row->id]
        );

        echo json_encode([
            'status' => 'success',
            'message' => 'OTP verified successfully'
        ]);
        exit;
    }



    public function newMpinSet()
    {
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/new-mpin');
        $this->load->view('layouts/auth/footer');
    }


    public function updateNewMpinSet()
    {
        $mobile = $this->session->userdata('mpin_mobile_phone');
        $mpin   = trim($this->input->post('mpin'));

        if (!$mobile || !$mpin) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
            exit;
        }

        $verifiedOtp = $this->db
            ->where('mobile_phone', $mobile)
            ->where('is_verified', 1)
            ->get('otp_verifications')
            ->row();

        if (!$verifiedOtp) {
            echo json_encode(['status' => 'error', 'message' => 'OTP not verified']);
            exit;
        }

        // Update MPIN
        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'mpin' => $mpin,
                'updated' => date('Y-m-d H:i:s')
            ],
            ['mobile_phone' => $mobile, 'role_id' => 9]
        );

        // Cleanup
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile]);
        $this->session->unset_userdata('mpin_mobile_phone');

        echo json_encode([
            'status' => 'success',
            'message' => 'M-Pin updated successfully'
        ]);
        exit;
    }


    // ===================================Center========================
    public function centerLogout()
    {
        // Agar owner hi login nahi hai → login page
        if (!$this->session->userdata('is_owner_logged_in')) {
            redirect('/');
        }

        // Sirf center related session clear karo
        $this->session->unset_userdata([
            'active_center_id',
            'is_center_logged_in',
            'exam_center_id',
        ]);

        // Owner abhi bhi login hai
        redirect('center-owner-dashboard');
    }
    // ===================================Center========================


    /* ===============================
       CALENDAR PAGE
    =============================== */
    public function center_calendar()
    {
        $owner_id = $this->session->userdata('owner_id');

        // Get current month and year
        $current_month = date('n');
        $current_year = date('Y');


        $data['all_centers'] = $this->db
            ->where('owner_user_id', $owner_id)
            ->where('deleted', 0)
            ->order_by('center_name', 'ASC')
            ->get('tt_center')
            ->result_array();

        $center_ids = array_column($data['all_centers'], 'id');

        // Get booked dates for current month
        $data['booked_dates'] = $this->Booking_model->get_booked_dates($current_month, $current_year, $center_ids);
        $data['month'] = $current_month;
        $data['year'] = $current_year;

        $summary = $this->Booking_model->get_center_booking_summary($current_month, $current_year, $center_ids);
        $data['summary']      = $summary;

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/dashboard/calendar/center_calendar', $data);
        $this->load->view('auth/owner/layouts/footer');
    }

    public function get_bookings_by_date()
    {
        $date = $this->input->post('date');
        $data['bookings'] = $this->Booking_model->get_bookings_by_date($date);
        $this->load->view('auth/owner/dashboard/calendar/bookings_table', $data);
    }


    public function get_calendar()
    {
        $owner_id = $this->session->userdata('owner_id');

        $month     = $this->input->post('month');
        $year      = $this->input->post('year');
        $center_id = $this->input->post('center_id');

        // Owner ke saare center ids nikalo
        $owner_centers = $this->db
            ->select('id')
            ->where('owner_user_id', $owner_id)
            ->where('deleted', 0)
            ->get('tt_center')
            ->result_array();

        $owner_center_ids = array_column($owner_centers, 'id');

        // Agar search me single center id aayi hai
        if (!empty($center_id)) {
            $center_ids = [$center_id];
        } else {
            // Default owner ke saare centers
            $center_ids = $owner_center_ids;
        }

        // --------------------
        // Get booked dates
        // --------------------
        $booked_dates = $this->Booking_model
            ->get_booked_dates($month, $year, $center_ids);

        // --------------------
        // Get summary
        // --------------------
        $summary = $this->Booking_model
            ->get_center_booking_summary($month, $year, $center_ids);

        // --------------------
        // Render partials
        // --------------------
        $calendar_html = $this->load->view(
            'auth/owner/dashboard/calendar/calendar_partial',
            [
                'month' => $month,
                'year' => $year,
                'booked_dates' => $booked_dates
            ],
            true
        );

        $summary_html = $this->load->view(
            'auth/owner/dashboard/calendar/calendar-summary-partial',
            [
                'summary' => $summary
            ],
            true
        );

        echo json_encode([
            'calendar' => $calendar_html,
            'summary'  => $summary_html
        ]);
    }


    public function ownerAllCentersNotification()
    {
        $owner_id = $this->session->userdata('owner_id');

        $this->load->library('pagination');

        $center_id = $this->input->get('center_id');

        // Base query
        $this->db->from('notifications');
        $this->db->where([
            'admin_user_id' => $owner_id,
            'type'          => 'center',
            'is_remove'     => 0
        ]);

        if (!empty($center_id)) {
            $this->db->where('notifications.center_id', $center_id);
        }

        $config['base_url'] = base_url('owner-all-notifications');
        $config['per_page'] = 20;
        $config['total_rows'] = $this->db->count_all_results('', false);

        $this->db->select('notifications.*, centers.center_name');
        $this->db->join('tt_center as centers', 'centers.id = notifications.center_id', 'left');
        $this->db->order_by('notifications.created_at', 'DESC');
        $this->db->limit($config['per_page'], $this->uri->segment(2));

        $data['notifications'] = $this->db->get()->result();

        // Fetch centers for filter dropdown
        $data['centers'] = $this->db
            ->where('owner_user_id', $owner_id)
            ->get('tt_center')
            ->result();

        $data['selected_center'] = $center_id;

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/dashboard/all_notifications', $data);
        $this->load->view('auth/owner/layouts/footer');
    }

    // Center Owner account Delete
    public function deleteOwnerAccount()
    {
        $owner = $this->authOwner();

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
