<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthAPIController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
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
     REGISTER CLIENT
    ======================================================= */
    public function storeACData()
    {
        // Set JSON response header
        $this->output->set_content_type('application/json');

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
                'mpin'         => $this->input->post('mpin'),
                'role_id'      => 12,
                'created'      => $created_at,
                'updated'      => $updated_at,
                'approved'     => 1,
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
            $logoName = '';
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
                $fileName = '';
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
            $this->output
                ->set_status_header(201) // Created
                ->set_output(json_encode([
                    'status' => 'success',
                    'message' => 'Signup successfully',
                    'data' => [
                        'ac_id' => $lastInsertId,
                        'client_id' => $client_id
                    ]
                ]));
        } catch (Exception $e) {
            // ====================== ROLLBACK TRANSACTION ======================
            $this->db->trans_rollback();

            log_message('error', 'Registration failed: ' . $e->getMessage());

            $this->output
                ->set_status_header(500)
                ->set_output(json_encode([
                    'status' => 'error',
                    'message' => 'Registration failed: ' . $e->getMessage()
                ]));
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

        $client = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 12
        ]);

        if (!$client || $client->mpin !== $mpin) {
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
            ['id' => $client->id]
        );

        if (!empty($deviceToken)) {

            $this->FirebaseNotification_model->saveDeviceToken([
                'user_id'      => $client->id,
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
     AUTH HELPER
    ======================================================= */
    private function authenticateClient()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $client = $this->Common_model->getdata('tt_admin_users', [
            'api_token' => $token,
            'role_id'   => 12
        ]);

        if (!$client) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $client;
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(32));
    }


    /* =======================================================
     LOGOUT
    ======================================================= */
    public function logout()
    {
        $client = $this->authenticateClient();

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            ['api_token' => NULL],
            ['id' => $client->id]
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
        $client = $this->Common_model->getdata('tt_admin_users', [
            'mobile_phone' => $mobile,
            'role_id' => 12
        ]);

        if (!$client) {
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
            ['mobile_phone' => $mobile, 'role_id' => 12]
        );

        // Cleanup OTP
        $this->db->delete('otp_verifications', ['mobile_phone' => $mobile, 'purpose' => 'forgot_mpin']);

        echo json_encode(['status' => 'success', 'message' => 'MPIN reset successfully']);
    }
}
