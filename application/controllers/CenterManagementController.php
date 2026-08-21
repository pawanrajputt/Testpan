<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

class CenterManagementController extends MY_Controller
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
        if (!$this->session->userdata('is_owner_logged_in')) {
            redirect('/');
        }

        $data['owner'] = $this->authOwner();

        if (!$data['owner']) {
            redirect('/');
        }

        $this->load->view('layouts/auth/header');
        $this->load->view('auth/owner/dashboard/center/create_center', $data);
        $this->load->view('layouts/auth/footer');
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

    // ===================================Center========================
    public function storeExamCenterData()
    {
        // ================= AUTHENTICATED OWNER CHECK =================
        if (!$this->session->userdata('is_owner_logged_in')) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Unauthorized request'
            ]);
            return;
        }

        // Owner ID comes from session — never trust frontend owner/mobile data
        $owner_id = $this->session->userdata('owner_id');

        if (empty($owner_id)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Owner session expired. Please login again.'
            ]);
            return;
        }

        // ================= BASIC VALIDATION =================
        if (empty($this->input->post('center_name'))) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Center name is required'
            ]);
            return;
        }

        // ================= OWNER CHECK =================
        $owner = $this->Common_model->getdata('tt_admin_users', [
            'id' => $owner_id,
            'role_id' => 9
        ]);

        if (!$owner) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Owner not found'
            ]);
            return;
        }

        // ================= DUPLICATE CENTER CHECK =================
        $centerName = strtolower(trim(
            $this->input->post('center_name')
        ));

        $this->db->where(
            "LOWER(TRIM(center_name)) = " .
                $this->db->escape($centerName),
            NULL,
            FALSE
        );

        $this->db->where(
            'country_id',
            (int) $this->input->post('country_id')
        );

        $this->db->where(
            'state_id',
            (int) $this->input->post('state_id')
        );

        $this->db->where(
            'city_id',
            (int) $this->input->post('city_id')
        );

        $duplicateCenter = $this->db
            ->get('tt_center')
            ->row();

        if ($duplicateCenter) {
            echo json_encode([
                'status' => 'error',
                'message' => 'This exam center already exists for the selected country, state, and city.'
            ]);
            return;
        }

        try {

            // ================= TRANSACTION =================
            $this->db->trans_begin();

            $created_at = date('Y-m-d H:i:s');
            $updated_at = $created_at;

            // ================= CENTER DETAILS =================
            $examCenterDetailsdata = [
                'owner_user_id' => $owner_id,
                'center_type' => $this->input->post('center_type') ?? 'online',
                'type_of_center' => $this->input->post('test_center_category'),
                'center_name'    => $this->input->post('center_name'),
                'center_description'    => $this->input->post('center_description'),
                'capacity'       => $this->input->post('total_number_of_system'),
                'pin_code' => $this->input->post('pincode'),
                'country_id' => $this->input->post('country_id') ?? 1,
                'state_id' => $this->input->post('state_id') ?? 1,
                'city_id' => $this->input->post('city_id') ?? 1,
                'local_area_name' => $this->input->post('local_area_name'),
                'address' => $this->input->post('postal_address'),
                "address_lat" => $this->input->post('address_lat'),
                "address_long" => $this->input->post('address_long'),
                'landmark' => $this->input->post('nearby_landmark'),
                'for_ph_candidate'    => $this->input->post('is_lift_available'),
                'nearest_railway_station' => $this->input->post('nearest_railway_station'),
                'distance_from_station'   => $this->input->post('distance_from_railway_station'),
                'nearest_bus_stop'        => $this->input->post('nearest_bus_stop'),
                'distance_from_bus_stop'  => $this->input->post('distance_from_bus_stop'),
                'nearest_metro_station'   => $this->input->post('nearest_metro_station'),
                'distance_from_metro'     => $this->input->post('distance_from_metro_station'),
                'nearest_airport'         => $this->input->post('nearest_airport'),
                'distance_from_airport'   => $this->input->post('distance_from_airport'),
                'poc_name'    => $this->input->post('point_of_contact'),
                'poc_contact_no' => $this->input->post('contact_phone_number'),
                'poc_mobile_alternate' => $this->input->post('contact_alternate_phone_number'),
                'poc_email'         => $this->input->post('contact_email'),
                'cs_name'        => $this->input->post('superintendent_name'),
                'cs_contact_number' => $this->input->post('superintendent_number'),
                'cs_email' => $this->input->post('superintendent_email'),
                'am_name'    => $this->input->post('assistant_manager_name'),
                'am_contact_no' => $this->input->post('assistant_manager_phone_number'),
                'am_email' => $this->input->post('assistant_manager_email'),
                'emergency_contact_no'    => $this->input->post('emergency_phone_number'),
                'landline_number'    => $this->input->post('emergency_landline_number'),

                // 🔹 General Lab Details
                'total_no_lab'              => $this->input->post('total_number_of_lab'),
                'total_no_system'           => $this->input->post('total_number_of_system'),
                'connected_single_network'  => $this->input->post('lab_are_connect_to_single_network'),
                'how_many_network'          => $this->input->post('total_network'),
                'partitaion_each_lab'        => $this->input->post('partition_in_each_lab'),
                'ac_in_each_lab'            => $this->input->post('ac_in_each_lab'),
                'network_printer'           => $this->input->post('is_network_printer_availabel'),
                'is_there_projector_in_each_lab'    => $this->input->post('is_there_projector_in_each_lab'),
                'is_there_sound_sytem_in_each_lab'    => $this->input->post('is_there_sound_sytem_in_each_lab'),
                'how_many_fire_extinguisher_in_each_lab' => $this->input->post('how_many_fire_extinguisher_in_each_lab'),
                'locker_facility'           => $this->input->post('is_there_a_locker_facility_in_lab'),
                'drinking_water_facility'   => $this->input->post('is_there_a_drinking_water_facility_in_lab'),

                // 🔹 Lab Infrastructure Details
                'primary_isp_name'          => $this->input->post('primary_infrastructure'),
                'primary_isp_connect_type'  => $this->input->post('primary_isp_connect_type'),
                'primary_isp_speed'         => $this->input->post('primary_isp_speed') ?? 10,
                'primary_internet_speed_unit' => $this->input->post('primary_internet_speed_unit'),
                'secondary_isp_name'        => $this->input->post('secondary_infrastructure'),
                'secondary_isp_connect_type'  => $this->input->post('secondary_isp_connect_type'),
                'secondary_isp_speed'       => $this->input->post('secondary_isp_speed') ?? 0,
                'secondary_internet_speed_unit' => $this->input->post('secondary_internet_speed_unit'),
                'is_generator_backup'       => $this->input->post('is_generator_backup'),
                'generator_backup_capacity' => $this->input->post('generator_backup_capacity'),
                'generator_fuel_tank_capacity'     => $this->input->post('generator_fuel_tank_capacity'),
                'power_back_ups_kv'         => $this->input->post('ups_backup'),
                'ups_backup_time'           => $this->input->post('ups_backup_time'),
                'total_no_of_connection'    => $this->input->post('total_no_of_connection'),
                'beneficiary_name'    => $this->input->post('beneficiary_name'),
                'bank_name'           => $this->input->post('bank_name'),
                'bank_account_number' => $this->input->post('bank_account_number'),
                'bank_ifsc_code'      => $this->input->post('bank_ifsc'),
                'pan_no'              => $this->input->post('pannumber'),
                'gst_no'              => $this->input->post('gst_number'),
                'gst_state_code'      => $this->input->post('gst_state_code'),
                'uidai_number'        => $this->input->post('uidai_number'),
                'udyam_number'        => $this->input->post('uidai_number'),
                'msme_number'         => $this->input->post('msme_number'),
                'has_gst'             => $this->input->post('has_gst'),
                'has_msme'            => $this->input->post('has_msme'),
                'created_on'          => $created_at,
                'last_modified_on'    => $updated_at,
            ];

            // gst file
            $gstFilePath = '';
            if (!empty($_FILES['gst_file']['name'])) {
                $logoDir = 'uploads/gst_file/';
                if (!is_dir($logoDir)) {
                    mkdir($logoDir, 0777, true);
                }

                $safeName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['gst_file']['name']));
                $targetGSTFilePath = $logoDir . $safeName;

                if (move_uploaded_file($_FILES['gst_file']['tmp_name'], $targetGSTFilePath)) {
                    $gstFilePath = $targetGSTFilePath;
                }
            }

            $examCenterDetailsdata['gst_file'] = $gstFilePath;

            // center logo (first file if provided)
            $logoPath = '';

            if (!empty($_FILES['center_logo']['name'])) {

                $logoDir = 'uploads/center_logo/';
                if (!is_dir($logoDir)) {
                    mkdir($logoDir, 0777, true);
                }

                if ($_FILES['center_logo']['error'] == 0) {

                    $logoName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['center_logo']['name']);
                    $targetLogoPath = $logoDir . $logoName;

                    if (move_uploaded_file($_FILES['center_logo']['tmp_name'], $targetLogoPath)) {
                        $logoPath = $targetLogoPath;
                    }
                }
            }

            $examCenterDetailsdata['logo'] = $logoPath;

            // ================= INSERT CENTER =================
            $lastInsertId = $this->Common_model->insertData('tt_center', $examCenterDetailsdata);

            if (!$lastInsertId) {
                $db_error = $this->db->error();

                // Log the exact error
                log_message('error', '================ CENTER INSERT FAILED ================');
                log_message('error', 'ERROR CODE: ' . $db_error['code']);
                log_message('error', 'ERROR MESSAGE: ' . $db_error['message']);
                log_message('error', 'LAST QUERY: ' . $this->db->last_query());
                log_message('error', 'POST DATA: ' . json_encode($this->input->post()));
                log_message('error', '===================================================');

                // Rollback transaction
                $this->db->trans_rollback();

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Database insert failed. Please try again.'
                ]);
                exit;
            }

            // SET center_id = PRIMARY ID
            $this->Common_model->UpdateRecord(
                'tt_center',
                ['center_id' => $lastInsertId],
                ['id' => $lastInsertId]
            );


            // documents upload - simple loop but guarded
            $uploadPath = 'uploads/center_documents/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $expectedDocs = [
                'canceled_cheque',
                'agreement',
                'mou',
                'gst_certificate',
                'udyam_certificate',
                'pan_number',
                'NDA'
            ];

            foreach ($expectedDocs as $docName) {
                if (!empty($_FILES[$docName]['name'])) {
                    $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES[$docName]['name']));
                    $targetPath = $uploadPath . $fileName;
                    if (move_uploaded_file($_FILES[$docName]['tmp_name'], $targetPath)) {
                        $documentData = [
                            'center_id' => $lastInsertId,
                            'doc_name' => $docName,
                            'doe' => date('Y-m-d H:i:s'),
                            'added_by' => $lastInsertId,
                            'url' => $targetPath,
                            'source' => 1,
                            'deleted' => 0
                        ];
                        $this->Common_model->insertData('tt_center_document', $documentData);
                    }
                }
            }

            // multiple images helper
            $this->uploadMultipleImages('center_entrances', 'uploads/center_entrances/', $lastInsertId, 'tt_center_entrances', 'center_entrance');
            $this->uploadMultipleImages('lab_photos', 'uploads/lab_photos/', $lastInsertId, 'tt_center_lab_photos', 'lab_photo');
            $this->uploadMultipleImages('main_gate_images', 'uploads/main_gate_images/', $lastInsertId, 'tt_center_gate_images', 'gate_image');
            $this->uploadMultipleImages('server_room_images', 'uploads/server_room_images/', $lastInsertId, 'tt_center_server_images', 'server_image');
            $this->uploadMultipleImages('observer_room_images', 'uploads/observer_room_images/', $lastInsertId, 'tt_center_observer_images', 'observer_image');
            $this->uploadMultipleImages('ups_generator_images', 'uploads/ups_generator_images/', $lastInsertId, 'tt_center_ups_images', 'ups_image');

            // videos - guard against missing indexes
            if (!empty($_FILES['walkthrough_video']['name'])) {

                $videoDir = 'uploads/center_videos/';
                if (!is_dir($videoDir)) {
                    mkdir($videoDir, 0777, true);
                }

                if ($_FILES['walkthrough_video']['error'] == 0) {

                    $vName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $_FILES['walkthrough_video']['name']);
                    $target = $videoDir . $vName;

                    if (move_uploaded_file($_FILES['walkthrough_video']['tmp_name'], $target)) {

                        $videoData = [
                            'center_id'    => $lastInsertId,
                            'about_video'  => $this->input->post('about_video') ?? '',
                            'center_video' => $target,
                            'doe'          => date("Y-m-d H:i:s"),
                            'added_by'     => $owner_id,
                            'deleted'      => 0
                        ];

                        $this->Common_model->insertData('tt_center_video', $videoData);
                    }
                }
            }

            // lab details arrays - guarded insertion
            $floorNumbers = $this->input->post('floor_number');
            if (!empty($floorNumbers) && is_array($floorNumbers)) {
                $totalComputers = $this->input->post('no_of_computer') ?? [];
                $windowGenerations = $this->input->post('window_generation') ?? [];
                $monitorTypes = $this->input->post('monitor_type') ?? [];
                $operatingSystems = $this->input->post('operating_system') ?? [];
                $rams = $this->input->post('ram') ?? [];
                $hdds = $this->input->post('hdd') ?? [];
                $ethernetCompanies = $this->input->post('ethernet_company') ?? [];
                $switchCategories = $this->input->post('switch_category') ?? [];
                $noOfEachEthernetPorts = $this->input->post('no_of_each_ethernet_ports') ?? [];
                $ethernetCompanyOthers = $this->input->post('ethernet_company_other') ?? [];

                foreach ($floorNumbers as $key => $floorNumber) {
                    $examCenterLabDetailsdata = [
                        'center_id' => $lastInsertId,
                        'floor_name' => $floorNumber,
                        'no_of_computer' => $totalComputers[$key] ?? null,
                        'window_generation' => $windowGenerations[$key] ?? null,
                        'monitor_type' => $monitorTypes[$key] ?? null,
                        'operating_system' => $operatingSystems[$key] ?? null,
                        'ram' => $rams[$key] ?? null,
                        'hard_disk' => $hdds[$key] ?? null,
                        'ehternet_swtch_company' => $ethernetCompanies[$key] ?? null,
                        'ethernet_company_other' => $ethernetCompanyOthers[$key] ?? null,
                        'switch_category' => $switchCategories[$key] ?? null,
                        'no_of_port_eth_switch' => $noOfEachEthernetPorts[$key] ?? null,
                        'created_on' => $created_at,
                        'last_modify_on' => $updated_at,
                    ];
                    $this->Common_model->insertData('tt_lab', $examCenterLabDetailsdata);
                }
            }

            // Commit transaction if all successful
            if ($this->db->trans_status() === FALSE) {
                $db_error = $this->db->error();

                log_message('error', '================ TRANSACTION FAILED ================');
                log_message('error', 'DB CODE: ' . ($db_error['code'] ?? 'NO CODE'));
                log_message('error', 'DB MESSAGE: ' . ($db_error['message'] ?? 'NO MESSAGE'));
                log_message('error', 'LAST QUERY: ' . $this->db->last_query());

                $post = $this->input->post();
                unset($post['mpin'], $post['otp']);
                log_message('error', 'POST DATA: ' . json_encode($post));
                log_message('error', '===================================================');

                $this->db->trans_rollback();

                echo json_encode([
                    'status' => 'error',
                    'message' => 'Something went wrong. Please contact support.'
                ]);
                exit;
            } else {
                $this->db->trans_commit();
            }

            // MARK SIGNUP AS COMPLETED
            $this->Common_model->UpdateRecord(
                'tt_admin_users',
                [
                    'signup_completed' => 1,
                    'signup_step' => 5,
                    'updated' => date('Y-m-d H:i:s')
                ],
                ['id' => $owner_id]
            );

            // Prepare and send email notification to admin
            $center_name = $this->input->post('center_name');
            $center_email = $this->input->post('email');
            $capacity = $this->input->post('capacity');
            $location = $this->input->post('postal_address');
            $created_at = date("Y-m-d H:i:s");

            // ====================== ADMIN EMAIL ======================
            $email_subject = "New Exam Center Registration: " . $center_name;

            $email_content = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .details-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
                        .details-table th, .details-table td { padding: 10px; border: 1px solid #ddd; text-align: left; }
                        .details-table th { background-color: #f5f5f5; }
                    </style>
                </head>
                <body>
                    <h2>New Exam Center Registration</h2>
                    
                    <h3>Basic Information</h3>
                    <table class='details-table'>
                        <tr>
                            <th>Center Name</th>
                            <td>{$center_name}</td>
                        </tr>
                        <tr>
                            <th>Contact Email</th>
                            <td>{$center_email}</td>
                        </tr>
                        <tr>
                            <th>Phone Number</th>
                            <td>{$this->input->post('country_code')} {$this->input->post('mobile_phone')}</td>
                        </tr>
                        <tr>
                            <th>Capacity</th>
                            <td>{$capacity} candidates</td>
                        </tr>
                    </table>
                    
                    <p>This registration was submitted on {$created_at}.</p>
                    <p>Please review the complete details in the admin panel.</p>
                </body>
                </html>
            ";

            // Send email to Admin
            try {
                $send = send_email(
                    $email_content,
                    $email_subject,
                    "admin@testpanindia.com",
                    "centerbooking@bookmytestcenter.com"
                );
                if (!$send) {
                    log_message('error', 'Failed to send admin email for center: ' . $center_name);
                }
            } catch (Exception $e) {
                log_message('error', 'Email sending exception (admin): ' . $e->getMessage());
            }

            // ====================== USER EMAIL ======================
            $user_subject = "Your Registration is Successful - Pending Verification";

            $user_content = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                    </style>
                </head>
                <body>
                    <h2>Dear {$center_name},</h2>
                    <p>Thank you for registering your exam center with us.</p>
                    <p>Your registration was successfully submitted on <b>{$created_at}</b>.</p>
                    <p>Your details are currently under verification. Once your information is verified, we will notify you by email.</p>
                    
                    <br>
                    <p>Best Regards,</p>
                    <p><b>Testpan India Team</b></p>
                </body>
                </html>";

            // Send email to User
            try {
                $send = send_email(
                    $user_content,
                    $user_subject,
                    $center_email,
                    "centerbooking@bookmytestcenter.com"
                );
                if (!$send) {
                    log_message('error', 'Failed to send user email to: ' . $center_email);
                }
            } catch (Exception $e) {
                log_message('error', 'Email sending exception (user): ' . $e->getMessage());
            }

            // ====================== ADMIN NOTIFICATION ======================
            try {
                // Title & Message
                $notification_title = "New Exam Center Registration";
                $notification_message = "New exam center has registered. Center Name: {$center_name} and Email: {$center_email}";

                // Notification data
                $notification_data = [
                    'admin_user_id' => $owner_id,
                    'center_id'     => $lastInsertId,
                    'client_id'     => null,
                    'title'         => $notification_title,
                    'message'       => $notification_message,
                    'type'          => 'admin',
                    'is_read'       => 0,
                    'is_remove'     => 0,
                    'created_at'    => date('Y-m-d H:i:s')
                ];

                // Insert notification
                $this->db->insert('notifications', $notification_data);
            } catch (Exception $e) {
                log_message('error', 'Notification insertion failed: ' . $e->getMessage());
            }

            // Send response
            echo json_encode([
                'status' => 'success',
                'message' => 'Your information under verification please wait for 24 hours.',
            ]);
            exit;
        } catch (Exception $e) {
            // Rollback transaction on exception
            $this->db->trans_rollback();

            // Log the exact error with full details
            log_message('error', '================ EXCEPTION IN CENTER REGISTRATION ================');
            log_message('error', 'ERROR MESSAGE: ' . $e->getMessage());
            log_message('error', 'ERROR CODE: ' . $e->getCode());
            log_message('error', 'FILE: ' . $e->getFile());
            log_message('error', 'LINE: ' . $e->getLine());
            log_message('error', 'TRACE: ' . $e->getTraceAsString());

            // Log database error if available
            $db_error = $this->db->error();
            if ($db_error['code'] != 0) {
                log_message('error', 'DB ERROR CODE: ' . $db_error['code']);
                log_message('error', 'DB ERROR MESSAGE: ' . $db_error['message']);
            }

            // Log POST data (excluding sensitive info)
            $post = $this->input->post();
            unset($post['mpin'], $post['otp']);
            log_message('error', 'POST DATA: ' . json_encode($post));

            // Log FILES data (without full paths to avoid clutter)
            $files_log = [];
            if (!empty($_FILES)) {
                foreach ($_FILES as $key => $file) {
                    $files_log[$key] = [
                        'name' => $file['name'] ?? '',
                        'size' => $file['size'] ?? 0,
                        'error' => $file['error'] ?? ''
                    ];
                }
            }
            log_message('error', 'FILES DATA: ' . json_encode($files_log));
            log_message('error', '===============================================================');

            // Send error response to client
            echo json_encode([
                'status' => 'error',
                'message' => 'An unexpected error occurred. Please try again or contact support.'
            ]);
            exit;
        }
    }


    // Function to handle multiple uploads
    private function uploadMultipleImages($fieldName, $uploadDir, $lastInsertId, $tableName, $columnName)
    {
        if (!empty($_FILES[$fieldName]['name'][0])) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $filesCount = count($_FILES[$fieldName]['name']);
            for ($i = 0; $i < $filesCount; $i++) {
                if (!empty($_FILES[$fieldName]['name'][$i])) {
                    $imageName = time() . '_' . basename($_FILES[$fieldName]['name'][$i]);
                    $imagePath = $uploadDir . $imageName;

                    if (move_uploaded_file($_FILES[$fieldName]['tmp_name'][$i], $imagePath)) {
                        $imageData = [
                            'center_id'     => $lastInsertId,
                            'center_image'  => $imagePath,
                            'image_type'    => $columnName,
                            'doe'           => date('Y-m-d H:i:s'),
                            'added_by'      => $lastInsertId,
                            'deleted'       => 0,
                        ];
                        $this->Common_model->insertData('tt_center_images', $imageData);
                    }
                }
            }
        }
    }
    // ===================================Center========================

}
