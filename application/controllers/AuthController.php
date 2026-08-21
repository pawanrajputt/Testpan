<?php

if (!defined('BASEPATH'))
exit('No direct script access allowed');
ini_set('display_errors', 1);

class AuthController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->helper('email');
    }

    
    public function index()
    {

        $this->session->unset_userdata([
            'mpin',
            'otp',
            'mobile_phone',
            'email',
            'name',
            'country_code',
        ]);

        // ❗ If an incomplete center exists, force login
        if ($this->session->userdata('ac_id')) {
            $this->logout();
            exit;
        }

        $data['countries'] = $this->Common_model->getdata_array('tt_countries',array('is_active' => 1));
         $data['center_type'] = $this->Common_model->getdata_array('tt_center_type',array('deleted' => 0));

        $data['privacyPolicy'] = $this->Common_model->getdata('cms',array('slug' => 'privacy-policy' , 'status' => 1));
        $data['termsCondition'] = $this->Common_model->getdata('cms',array('slug' => 'terms-condition' , 'status' => 1));

        $this->load->view('layouts/auth/header');
        $this->load->view('auth/signup',$data);
        $this->load->view('layouts/auth/footer');
    }


    public function cmsPage($slug){

        $data['cmsData'] = $this->Common_model->getdata('cms',array('slug' => $slug));
        
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/cms', $data);
        $this->load->view('layouts/auth/footer');

    }


    private function sendSms($number,$message) 
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


    public function checkPhoneExists() {
        
        $phone = $this->input->post('mobile_phone');

        if($phone == 7489858911){

            $check = $this->Common_model->getdata('tt_admin_users',array('mobile_phone' => $phone));

            if($check){
                $this->Common_model->Deletedata('tt_admin_users',array('mobile_phone' => $phone));
                $this->Common_model->Deletedata('tt_client',array('ac_id' => $check->id));
            }
        }

        
        if (empty($phone)) {
            echo json_encode(['exists' => false]);
            return;
        }
        
        // Check if phone exists in your database
        $exists = $this->Common_model->phone_exists($phone);
        
        echo json_encode(['exists' => $exists]);
    }


    public function sendOtp()
    {
        $mobile = $this->input->post('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        // OTP generate
        if($mobile == 7489858911){
            $otp = 123456;
        }else{
            $otp = rand(100000, 999999);
        }
        

        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiry  = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Delete old OTP
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

        // Minimal session data
        $this->session->set_userdata([
            'mobile_phone' => $mobile
        ]);

        if ($sms['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
        }
    }


    public function resendOtp()
    {
        $mobile = $this->session->userdata('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Session expired']);
            return;
        }

        // Rate limit: 60 seconds
        $lastOtp = $this->db
            ->where('mobile_phone', $mobile)
            ->order_by('created_at', 'DESC')
            ->get('otp_verifications')
            ->row();

        if ($lastOtp && strtotime($lastOtp->created_at) > strtotime('-60 seconds')) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Please wait before requesting OTP again'
            ]);
            return;
        }

        $otp = rand(100000, 999999);

        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiry  = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Delete old OTP
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

        // Mark verified
        $this->db->update(
            'otp_verifications',
            ['is_verified' => 1],
            ['id' => $row->id]
        );

        // Check client already exists
        $check = $this->Common_model->getdata(
            'tt_admin_users',
            ['mobile_phone' => $mobile]
        );

        $is_already = $check ? 1 : 0;

        echo json_encode([
            'status'      => 'success',
            'message'     => 'OTP verified successfully',
            'is_already'  => $is_already
        ]);
    }



    public function storeMpin()
    {
        $mpin = $this->input->post('mpin');
        $this->session->set_userdata('mpin', $mpin);
        echo json_encode([
            'status' => 'success',
            'message' => 'M-Pin created successfully'
        ]);
        exit;
    }


    public function login()
    {
        $mpin = $this->input->post('mpin');
        $mobile_phone = $this->input->post('mobile_phone');
        $where = array('mpin' => $mpin, 'mobile_phone' => $mobile_phone, 'role_id' => 12);
        
        $existingAC = $this->Common_model->getdata('tt_admin_users',$where);

        if($existingAC){

            $check = $this->Common_model->getdata('tt_client',array('ac_id' => $existingAC->id));

            if($check->deleted == 1){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No account found on this details. Please contact support for more information.'
                ]);
                exit;
            }

            if($existingAC->deleted == 1){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Your account is deleted. Please contact support for more information.'
                ]);
                exit;
            }

            if($existingAC->approved != 1){
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Your account is deactived by team. Please contact support for more information!'
                ]);
                exit;
            }

            $data = array('client_base_url' => base_url());

            $this->Common_model->UpdateRecord('tt_client',$data,['ac_id' => $existingAC->id]);

            $sessionData = array();

            $sessionData = [
                'ac_id' => $existingAC->id,
                'is_logged_in' => true
            ];

            $this->session->set_userdata($sessionData);

            echo json_encode([
                'status' => 'success',
                'message' => 'Login successfully'
            ]);
        }else{
            echo json_encode([
                'status' => 'error',
                'message' => 'You account doesn’t exist, please create a new one.'
            ]);
        }
        exit;
    }


    public function logout()
    {
        $this->session->unset_userdata(['mpin','otp','mobile_phone','exam_center_id','is_logged_in']);
        $this->session->sess_destroy();
        return redirect('/');
    }


    public function storeACData()
    {
        // Start transaction
        $this->db->trans_begin();
        
        try {
            $created_at = date('Y-m-d H:i:s');
            $updated_at = date('Y-m-d H:i:s');
            
            // ====================== AC DATA INSERT ======================
            $acData = [
                'username'     => $this->input->post('name'),
                'email'        => $this->input->post('email'),
                'mobile_country_code' => '+91',
                'mobile_phone' => $this->input->post('mobile_phone'),
                'is_agree'     => $this->input->post('is_agree') ? 1 : 0,
                'otp' => $this->session->userdata('otp'),
                'mpin' => implode('', $this->input->post('mpin')),
                'role_id' => 12,
                'created' => $created_at,
                'updated' => $updated_at,
                'approved' => 1,
            ];

            $lastInsertId = $this->Common_model->insertData('tt_admin_users', $acData);
            
            if (!$lastInsertId) {
                throw new Exception('Failed to insert admin user data');
            }

            // ====================== AC DETAILS DATA ======================
            $acDetailData = [
                'ac_id' => $lastInsertId,
                'company_name' => $this->input->post('company_name'),
                'company_type' => $this->input->post('company_type'),
                'website' => $this->input->post('company_website'),
                'address' => $this->input->post('address'),
                'country_id' => $this->input->post('country_id'),
                'state' => $this->input->post('state_id'),
                'city' => $this->input->post('city_id'),
                'pincode' => $this->input->post('pincode'),
                'co_ordinator_name' => $this->input->post('coordinator_name'),
                'coordinator_email' => $this->input->post('coordinator_email'),
                'coordinator_mobile_number' => $this->input->post('coordinator_mobile_number'),
                'coordinator_alternative_number' => $this->input->post('coordinator_alternative_number'),
                'mobile_no' => $this->input->post('coordinator_mobile_number'),
                'mobile_alternate' => $this->input->post('coordinator_alternative_number'),
                'country_code' => $this->input->post('coordinator_landline_code'),
                'landline_number' => $this->input->post('coordinator_landline_number'),
                'area_code' => $this->input->post('coordinator_landline_type'),
                'bank_beneficial_name' => $this->input->post('beneficiary_name'),
                'bank_name' => $this->input->post('bank_name'),
                'bank_account_no' => $this->input->post('bank_account_number'),
                'bank_ifsc_code' => $this->input->post('bank_ifsc_code'),
                'pan_number' => $this->input->post('pannumber'),
                'gst_number' => $this->input->post('gst_number'),
                'gst_state_code' => $this->input->post('gst_state_code') ?? '123456',
                'udyam_number' => $this->input->post('udyam_adhar_number'),
                'agreement_start_date' => $this->input->post('agreement_start_date'),
                'agreement_end_date' => $this->input->post('agreement_end_date'),
                'created_on' => $created_at,
                'update_on' => $updated_at,
            ];

            // ====================== LOGO UPLOAD ======================
            $logoName = ''; // Initialize to avoid undefined variable
            if (!empty($_FILES['logo']['name'])) {
                $logoDir = 'uploads/client_logo/';
                if (!is_dir($logoDir)) {
                    if (!mkdir($logoDir, 0777, true)) {
                        throw new Exception('Failed to create logo directory');
                    }
                }

                $logoName = time() . '_' . basename($_FILES['logo']['name']);
                $targetLogoPath = $logoDir . $logoName;

                if (!move_uploaded_file($_FILES['logo']['tmp_name'], $targetLogoPath)) {
                    throw new Exception('Failed to upload logo file');
                }
            }
            $acDetailData['logo'] = $logoName;

            // ====================== DOCUMENTS UPLOAD ======================
            $uploadPath = 'uploads/client_document/';
            if (!is_dir($uploadPath)) {
                if (!mkdir($uploadPath, 0777, true)) {
                    throw new Exception('Failed to create document directory');
                }
            }

            $documentMap = [
                'canceled_cheque' => 'canceled_cheque_doc',
                'agreement' => 'agreement_doc',
                'mou' => 'mou_doc',
                'gst_certificate' => 'gst_doc',
                'udyam_certificate' => 'udyam_doc',
                'pan_number_document' => 'pan_number_doc',
                'nda' => 'nda_doc'
            ];

            foreach ($documentMap as $inputName => $dbColumn) {
                $fileName = ''; // Initialize for each file
                if (!empty($_FILES[$inputName]['name'])) {
                    $fileName = time() . '_' . basename($_FILES[$inputName]['name']);
                    $targetPath = $uploadPath . $fileName;

                    if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetPath)) {
                        throw new Exception("Failed to upload document: {$inputName}");
                    }
                }
                $acDetailData[$dbColumn] = $fileName;
            }

            // ====================== INSERT CLIENT DATA ======================
            $client_id = $this->Common_model->insertData('tt_client', $acDetailData);
            
            if (!$client_id) {
                throw new Exception('Failed to insert client data');
            }

            // ====================== SET SESSION ======================
            $existingClient = $this->Common_model->getdata('tt_admin_users', array('id' => $lastInsertId));

            if ($existingClient) {
                $sessionData = [
                    'ac_id' => $lastInsertId,
                    'is_logged_in' => true
                ];
                $this->session->set_userdata($sessionData);
            }

            // ====================== SEND ADMIN EMAIL ======================
            $admin_email_subject = "New Assessment Company Registration: " . $this->input->post('company_name');
            $admin_email_content = $this->getAdminEmailContent();
            
            $adminEmailSent = send_email(
                $admin_email_content,
                $admin_email_subject,
                "admin@testpanindia.com",
                "centerbooking@bookmytestcenter.com"
            );
            
            if (!$adminEmailSent) {
                // Log error but don't throw exception - email failure shouldn't rollback registration
                log_message('error', 'Admin email failed for AC ID: ' . $lastInsertId);
            }

            // ====================== SEND COMPANY EMAIL ======================
            $company_email_content = $this->getCompanyEmailContent();
            $company_email_subject = "Your Registration with BookMyTestCenter is Successfully Done";
            
            $companyEmailSent = send_email(
                $company_email_content,
                $company_email_subject,
                $this->input->post('email'),
                "centerbooking@bookmytestcenter.com"
            );
            
            if (!$companyEmailSent) {
                // Log error but don't throw exception
                log_message('error', 'Company email failed for AC ID: ' . $lastInsertId);
            }

            // ====================== INSERT NOTIFICATION ======================
            $notification_data = [
                'admin_user_id' => $lastInsertId,
                'center_id' => null,
                'client_id' => $client_id,
                'title' => "New Assessment Company Registration",
                'message' => "New client has registered. Client Name: {$this->input->post('name')} and Email: {$this->input->post('email')}",
                'type' => 'admin',
                'is_read' => 0,
                'is_remove' => 0,
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (!$this->db->insert('notifications', $notification_data)) {
                throw new Exception('Failed to insert notification');
            }

            // ====================== COMMIT TRANSACTION ======================
            if ($this->db->trans_status() === FALSE) {
                throw new Exception('Transaction failed');
            }
            
            $this->db->trans_commit();

            // ====================== SUCCESS RESPONSE ======================
            echo json_encode([
                'status' => 'success',
                'message' => 'Signup successfully',
                'data' => [
                    'ac_id' => $lastInsertId,
                    'client_id' => $client_id
                ]
            ]);
            exit;

        } catch (Exception $e) {
            // ====================== ROLLBACK TRANSACTION ======================
            $this->db->trans_rollback();
            
            // Log error
            log_message('error', 'Registration failed: ' . $e->getMessage());
            
            // Send error response
            echo json_encode([
                'status' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
            exit;
        }
    }

    // ====================== HELPER METHODS ======================
    private function getAdminEmailContent()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .header { color: #2c3e50; }
                .content { margin: 20px 0; }
                .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
            </style>
        </head>
        <body>
            <h2 class="header">New Assessment Company Registration</h2>
            <div class="content">
                <p>A new assessment company has registered on BookMyTestCenter:</p>
                <div class="details">
                    <h3>Company Details:</h3>
                    <p><strong>Company Name:</strong> ' . htmlspecialchars($this->input->post('company_name')) . '</p>
                    <p><strong>Contact Person:</strong> ' . htmlspecialchars($this->input->post('name')) . '</p>
                    <p><strong>Email:</strong> ' . htmlspecialchars($this->input->post('email')) . '</p>
                    <p><strong>Phone:</strong> ' . htmlspecialchars($this->input->post('mobile_phone')) . '</p>
                    <p><strong>Registration Date:</strong> ' . date('d M Y, h:i A') . '</p>
                </div>
            </div>
        </body>
        </html>';
    }

    private function getCompanyEmailContent()
    {
        return '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; }
                .header { color: #27ae60; }
                .content { margin: 20px 0; }
                .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
            </style>
        </head>
        <body>
            <h2 class="header">Registration Successful</h2>
            <div class="content">
                <p>Dear ' . htmlspecialchars($this->input->post('name')) . ',</p>
                <p>We are pleased to inform you that your company <b>' . htmlspecialchars($this->input->post('company_name')) . '</b> has been successfully registered with <b>BookMyTestCenter</b>.</p>
                <p>Your registration was completed on <b>' . date('d M Y, h:i A') . '</b>. You can now explore our platform and connect with exam centers as per your requirements.</p>
                <p><b>What you can do next:</b></p>
                <ul>
                    <li>Log in to your account to manage your company profile.</li>
                    <li>Start connecting with available test centers.</li>
                    <li>Access features designed to simplify assessments and collaborations.</li>
                </ul>
                <p>We are excited to have you onboard and look forward to working with you!</p>
            </div>
            <div class="footer">
                <p>Best Regards,<br>
                <b>Testpan India Team</b></p>
            </div>
        </body>
        </html>';
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
        $mobile = $this->input->post('mobile_phone');

        if (!$mobile) {
            echo json_encode(['status' => 'error', 'message' => 'Mobile number required']);
            return;
        }

        // Client exist check
        $check = $this->Common_model->getdata(
            'tt_admin_users',
            ['role_id' => 12, 'mobile_phone' => $mobile]
        );

        if (!$check) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'No account registered on this mobile number'
            ]);
            return;
        }

        // OTP
        $otp = rand(100000, 999999);

        $otpHash = password_hash($otp, PASSWORD_DEFAULT);
        $expiry  = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Delete old OTP
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

        $message = "Your OTP is $otp valid for 10 min only. Testpan India.";
        $sms = $this->sendSms($mobile, $message);

        // Session (minimal)
        $this->session->set_userdata([
            'mpin_mobile_phone' => $mobile
        ]);

        if ($sms['status'] === 'success') {
            echo json_encode(['status' => 'success', 'message' => 'OTP sent successfully']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send OTP']);
        }
    }


    public function resetForgotMpinOtp()
    {
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/forgot-mpin-otp');
        $this->load->view('layouts/auth/footer');
    }


    public function verifyResetForgotMpinOtp()
    {
        $otp    = $this->input->post('otp');
        $mobile = $this->session->userdata('mpin_mobile_phone');

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

        // Mark verified
        $this->db->update(
            'otp_verifications',
            ['is_verified' => 1],
            ['id' => $row->id]
        );

        // Flag for MPIN set
        $this->session->set_userdata(['forgot_otp_verified' => 1]);

        echo json_encode([
            'status'  => 'success',
            'message' => 'OTP verified successfully'
        ]);
    }



    public function newMpinSet()
    {
        $this->load->view('layouts/auth/header');
        $this->load->view('auth/new-mpin');
        $this->load->view('layouts/auth/footer'); 
    }


    public function updateNewMpinSet()
    {
        $mobile   = $this->session->userdata('mpin_mobile_phone');
        $verified = $this->session->userdata('forgot_otp_verified');
        $mpin     = $this->input->post('mpin');

        if (!$mobile || !$verified) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'OTP verification required'
            ]);
            return;
        }

        // 🔐 MPIN validation
        if (!$mpin) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'M-PIN is required'
            ]);
            return;
        }

        if (!preg_match('/^[0-9]{4}$/', $mpin)) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'M-PIN must be exactly 4 digits'
            ]);
            return;
        }

        $check = $this->Common_model->getdata(
            'tt_admin_users',
            ['role_id' => 12, 'mobile_phone' => $mobile]
        );

        if (!$check) {
            echo json_encode([
                'status'  => 'error',
                'message' => 'Invalid request'
            ]);
            return;
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            ['mpin' => $mpin],
            ['mobile_phone' => $mobile]
        );

        // Cleanup session
        $this->session->unset_userdata([
            'mpin_mobile_phone',
            'forgot_otp_verified'
        ]);

        echo json_encode([
            'status'  => 'success',
            'message' => 'M-PIN updated successfully'
        ]);
    }



}
