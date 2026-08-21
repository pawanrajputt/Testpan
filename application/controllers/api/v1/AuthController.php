<?php
defined('BASEPATH') or exit('No direct script access allowed');

class AuthController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
        $this->load->helper('project_status');
    }

    private function generateToken()
    {
        return bin2hex(random_bytes(32));
    }

    private function authenticateOwner()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $owner = $this->Common_model->getdata('tt_admin_users', [
            'api_token' => $token,
            'role_id' => 9
        ]);

        if (!$owner) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $owner;
    }


    private function authenticateCenter()
    {
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!$token) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'API token missing']);
            exit;
        }

        $center = $this->Common_model->getdata('tt_center', [
            'api_token' => $token,
        ]);

        if (!$center) {
            echo json_encode(['status' => 'unauthorized', 'message' => 'Invalid API token']);
            exit;
        }

        return $center->center_id ?? 0;
    }

    // ===========================================
    // LOGOUT
    // ===========================================
    public function logout()
    {
        // get token from header
        $token = $this->input->get_request_header('X-API-TOKEN');

        if (!empty($token)) {
            $this->db->where('api_token', $token);
            $this->db->update('tt_center', [
                'api_token' => null
            ]);
        }

        // destroy session
        $this->session->sess_destroy();

        echo json_encode([
            'status' => 'success',
            'message' => 'Logged out successfully'
        ]);
    }

    // ============================================================
    // API: STORE EXAM CENTER (SIGNUP / REGISTRATION) - Webflow column names preserved
    // ============================================================
    public function storeExamCenterData()
    {
        $this->db->trans_start();

        $created_at = date('Y-m-d H:i:s');
        $updated_at = $created_at;

        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        // Build center detail payload — using the same DB column names as webflow/site
        $examCenterDetailsdata = [
            'owner_user_id' => $owner_id,
            'center_type' => $this->input->post('center_type'),
            'type_of_center' => $this->input->post('test_center_category') ?? 'University',
            'center_name'    => $this->input->post('center_name'),
            'center_description'    => $this->input->post('center_description'),
            'udyam_number'    => $this->input->post('uidai_number'),
            'uidai_number'    => $this->input->post('uidai_number'),
            'msme_number'    => $this->input->post('msme_number'),
            'capacity'    => $this->input->post('total_number_of_system'),
            'pin_code' => $this->input->post('pincode') ?? 123456,
            'country_id' => $this->input->post('country_id') ?? 1,
            'state_id' => $this->input->post('state_id') ?? 1,
            'city_id' => $this->input->post('city_id') ?? 1,
            'local_area_name' => $this->input->post('local_area_name'),
            'address' => $this->input->post('postal_address'),
            'address_lat' => $this->input->post('address_lat'),
            'address_long' => $this->input->post('address_long'),
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
            'partitaion_each_lab'       => $this->input->post('partition_in_each_lab'),
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

            'backup_hours'              => $this->input->post('backup_hours'),
            'backup_minutes'            => $this->input->post('backup_minutes'),

            'beneficiary_name'    => $this->input->post('beneficiary_name'),
            'bank_name'           => $this->input->post('bank_name'),
            'bank_account_number' => $this->input->post('bank_account_number'),
            'bank_ifsc_code'      => $this->input->post('bank_ifsc'),
            'pan_no'              => $this->input->post('pannumber'),
            'gst_no'              => $this->input->post('gst_number'),
            'gst_state_code'      => $this->input->post('gst_state_code'),
            'uidai_number'        => $this->input->post('uidai_number'),
            'msme_number'         => $this->input->post('msme_number'),
            'has_gst'             => $this->input->post('has_gst'),
            'has_msme'            => $this->input->post('has_msme'),
            'created_on'          => $created_at,
            'last_modified_on'    => $updated_at,
        ];

        // gst file (same as website)
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

        // center logo (first file if provided) — exactly same logic
        $logoPath = '';
        if (!empty($_FILES['center_logo']['name'][0])) {
            $logoDir = 'uploads/center_logo/';
            if (!is_dir($logoDir)) {
                mkdir($logoDir, 0777, true);
            }
            $logoName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', basename($_FILES['center_logo']['name'][0]));
            $targetLogoPath = $logoDir . $logoName;
            if (move_uploaded_file($_FILES['center_logo']['tmp_name'][0], $targetLogoPath)) {
                $logoPath = $targetLogoPath;
            }
        }
        $examCenterDetailsdata['logo'] = $logoPath;

        // insert center details (same table and same column names)
        $lastInsertId = $this->Common_model->insertData('tt_center', $examCenterDetailsdata);
        if ($lastInsertId) {
            $this->Common_model->UpdateRecord(
                'tt_center',
                array('center_id' => $lastInsertId),
                array('id' => $lastInsertId)
            );
        }

        $this->Common_model->UpdateRecord(
            'tt_admin_users',
            [
                'signup_completed' => 1,
                'signup_step' => 5,
                'updated' => date('Y-m-d H:i:s')
            ],
            ['id' => $owner_id]
        );

        // documents upload - same as website
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
                        'added_by' => $owner_id,
                        'url' => $targetPath,
                        'source' => 1,
                        'deleted' => 0
                    ];
                    $this->Common_model->insertData('tt_center_document', $documentData);
                }
            }
        }

        // multiple images helper (kept same signature and table names)
        $this->uploadMultipleImages('center_entrances', 'uploads/center_entrances/', $lastInsertId, 'tt_center_entrances', 'center_entrance');
        $this->uploadMultipleImages('lab_photos', 'uploads/lab_photos/', $lastInsertId, 'tt_center_lab_photos', 'lab_photo');
        $this->uploadMultipleImages('main_gate_images', 'uploads/main_gate_images/', $lastInsertId, 'tt_center_gate_images', 'gate_image');
        $this->uploadMultipleImages('server_room_images', 'uploads/server_room_images/', $lastInsertId, 'tt_center_server_images', 'server_image');
        $this->uploadMultipleImages('observer_room_images', 'uploads/observer_room_images/', $lastInsertId, 'tt_center_observer_images', 'observer_image');
        $this->uploadMultipleImages('ups_generator_images', 'uploads/ups_generator_images/', $lastInsertId, 'tt_center_ups_images', 'ups_image');

        // videos - same as website
        if (!empty($_FILES['walkthrough_video']['name']) && is_array($_FILES['walkthrough_video']['name'])) {
            $videoDir = 'uploads/center_videos/';
            if (!is_dir($videoDir)) {
                mkdir($videoDir, 0777, true);
            }
            $files = $_FILES['walkthrough_video'];
            $about_videos = $this->input->post('about_video') ?? [];
            for ($i = 0; $i < count($files['name']); $i++) {
                if ($files['error'][$i] == 0 && !empty($files['name'][$i])) {
                    $vName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $files['name'][$i]);
                    $target = $videoDir . $vName;
                    if (move_uploaded_file($files['tmp_name'][$i], $target)) {
                        $videoData = [
                            'center_id' => $lastInsertId,
                            'about_video' => isset($about_videos[$i]) ? $about_videos[$i] : '',
                            'center_video' => $target,
                            'doe' => date("Y-m-d H:i:s"),
                            'added_by' => $owner_id,
                            'deleted' => 0
                        ];
                        $this->Common_model->insertData('tt_center_video', $videoData);
                    }
                }
            }
        }

        // lab details arrays - guarded insertion (same column names)
        $floorNumbers = $this->input->post('floor_number');

        if (!empty($floorNumbers) && is_array($floorNumbers)) {

            $noOfComputers      = $this->input->post('no_of_computer') ?? [];
            $windowGenerations  = $this->input->post('window_generation') ?? [];
            $monitorTypes       = $this->input->post('monitor_type') ?? [];
            $operatingSystems   = $this->input->post('operating_system') ?? [];
            $rams               = $this->input->post('ram') ?? [];
            $hdds               = $this->input->post('hard_disk') ?? [];
            $ethernetCompanies  = $this->input->post('ehternet_swtch_company') ?? [];
            $ethernetOther      = $this->input->post('ethernet_company_other') ?? [];
            $switchCategories   = $this->input->post('switch_category') ?? [];
            $ethernetPorts      = $this->input->post('no_of_port_eth_switch') ?? [];

            foreach ($floorNumbers as $key => $floorNumber) {

                if (trim($floorNumber) === '') continue;

                $data = [
                    'center_id'              => $lastInsertId,
                    'floor_name'             => $floorNumber,
                    'no_of_computer'         => $noOfComputers[$key] ?? null,
                    'window_generation'      => $windowGenerations[$key] ?? null,
                    'monitor_type'           => $monitorTypes[$key] ?? null,
                    'operating_system'       => $operatingSystems[$key] ?? null,
                    'ram'                    => $rams[$key] ?? null,
                    'hard_disk'              => $hdds[$key] ?? null,
                    'ehternet_swtch_company' => $ethernetCompanies[$key] ?? null,
                    'ethernet_company_other' => $ethernetOther[$key] ?? null,
                    'switch_category'        => $switchCategories[$key] ?? null,
                    'no_of_port_eth_switch'  => $ethernetPorts[$key] ?? null,
                    'created_on'             => $created_at,
                    'last_modify_on'         => $updated_at
                ];

                $this->Common_model->insertData('tt_lab', $data);
            }
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            echo json_encode(['status' => 'error', 'message' => 'Something went wrong, please try again.']);
            return;
        }

        // admin + user emails (kept as in your website — uncomment if needed)
        $centerOnwerData = $this->Common_model->getdata('tt_admin_users', array('id', $owner_id));
        $center_name = $this->input->post('center_name');
        $center_email = $centerOnwerData->email ?? '';
        $country_code = $centerOnwerData->mobile_country_code ?? '';
        $mobile_phone = $centerOnwerData->mobile_phone ?? '';
        $capacity = $this->input->post('capacity');
        $location = $this->input->post('postal_address');
        $created_at = date("Y-m-d H:i:s"); // current time

        // Admin Email
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
                    <tr><th>Center Name</th><td>{$center_name}</td></tr>
                    <tr><th>Contact Email</th><td>{$center_email}</td></tr>
                    <tr><th>Phone Number</th><td>{$country_code} {$mobile_phone}</td></tr>
                    <tr><th>Capacity</th><td>{$capacity} candidates</td></tr>
                </table>
                <p>This registration was submitted on {$created_at}.</p>
                <p>Please review the complete details in the admin panel.</p>
            </body>
            </html>
        ";

        // Send email to Admin
        $send = send_email(
            $email_content,
            $email_subject,
            "admin@testpanindia.com",
            "centerbooking@bookmytestcenter.com"
        );


        // Center Email
        $user_subject = "Your Registration is Successful - Pending Verification";
        $user_content = "
            <html>
            <head><style>body{font-family:Arial, sans-serif}</style></head>
            <body>
                <h2>Dear {$center_name},</h2>
                <p>Thank you for registering your exam center with us.</p>
                <p>Your registration was successfully submitted on <b>{$created_at}</b>.</p>
                <p>Your details are currently under verification. Once your information is verified, we will notify you by email.</p>
                <br><p>Best Regards,</p><p><b>Testpan India Team</b></p>
            </body>
            </html>
        ";

        // Send email to User
        $send = send_email(
            $user_content,
            $user_subject,
            $center_email,
            "centerbooking@bookmytestcenter.com"
        );

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

        // Send response
        echo json_encode([
            'status' => 'success',
            'message' => 'Your information under verification please wait for 24 hours.',
            'center_id' => $lastInsertId
        ]);
        return;
    }


    // Function to handle multiple uploads — kept identical to your website implementation
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


    public function dashboard()
    {
        header('Content-Type: application/json');

        // Get center_id from header or GET parameter
        $center_id = $this->authenticateCenter();

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Fetch data (same as website)
        $countries = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $center_type = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $result = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);

        if (!$result) {
            echo json_encode([
                'status' => false,
                'message' => 'Center not found'
            ]);
            return;
        }

        $cityId = $result->city_id;

        $labs = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $documents = $this->Common_model->getdata_array('tt_center_document', ['center_id' => $center_id]);
        $images = $this->Common_model->getdata_array('tt_center_images', ['center_id' => $center_id, 'deleted' => 0]);
        $number_of_seats = $this->Common_model->get_total_booked_seat('tt_send_booking_request', $center_id);



        $totalBookingRequest =
            $this->Common_model
            ->get_total_booking_request(
                $center_id,
                '',
                '',
                '',
                $cityId
            );

        $totalInReviewBooking =
            $this->Common_model
            ->get_inreview_booking_request(
                $center_id,
                $cityId
            );

        $totalConfirmBooking =
            $this->Common_model
            ->get_confirmed_booking_request(
                $center_id,
                $cityId
            );

        $totalRejectBooking =
            $this->Common_model
            ->get_rejected_booking_request(
                $center_id,
                $cityId
            );


        $totalPostponedBooking =
            $this->Common_model
            ->get_postponed_booking_request(
                $center_id,
                $cityId
            );

        $selfBookingData = $this->Common_model->get_client_self_booking($center_id, '', '');

        // Calendar data
        $month = $this->input->get('month') ?? date('n');
        $year = $this->input->get('year') ?? date('Y');

        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);

        // JSON Response
        echo json_encode([
            'status' => true,
            'message' => 'Dashboard data loaded',
            'data' => [
                'countries'                     => $countries,
                'center_type'                   => $center_type,
                'center_details'                => $result,
                'labs'                          => $labs,
                'documents'                     => $documents,
                'images'                        => $images,
                'totalBookingRequest'           => $totalBookingRequest,
                'total_booking_req_count'       => count($totalBookingRequest),
                'number_of_seats'               => $number_of_seats,
                'totalInReviewBooking'          => $totalInReviewBooking,
                'totalConfirmBooking'           => $totalConfirmBooking,
                'totalRejectBooking'            => $totalRejectBooking,
                'totalPostponedBooking'         => $totalPostponedBooking,
                'selfBookingData'               => $selfBookingData,
                'total_self_booking_req_count'  => count($selfBookingData),
                'calendar_month'                => $month,
                'calendar_year'                 => $year,
                'exam_dates'                    => $exam_dates
            ]
        ]);
    }


    public function myCalendarApi()
    {
        header('Content-Type: application/json');

        // Get center_id from GET
        $center_id = $this->authenticateCenter();

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Self booking data
        $selfBookingData = $this->Common_model->get_client_self_booking($center_id, '', '');
        $total_self_booking_req_count = count($selfBookingData);

        // Calendar data
        $month = $this->input->get('month') ?? date('n');
        $year  = $this->input->get('year') ?? date('Y');

        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);

        // ❗ API DOES NOT NEED HTML CALENDAR (generate_calendar outputs HTML)
        // API returns only data (clean)

        echo json_encode([
            'status' => true,
            'message' => 'Calendar data loaded',
            'data' => [
                'selfBookingData'                => $selfBookingData,
                'total_self_booking_req_count'   => $total_self_booking_req_count,
                'month'                          => $month,
                'year'                           => $year,
                'exam_dates'                     => $exam_dates
            ]
        ]);
    }


    public function mySelfBookingApi()
    {
        header('Content-Type: application/json');

        // Get center id  
        $center_id = $this->authenticateCenter();

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Fetch lab + self booking data
        $labs = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $selfBookingData = $this->Common_model->get_client_self_booking($center_id, '', '');
        $total_self_booking_req_count = count($selfBookingData);

        echo json_encode([
            'status' => true,
            'message' => 'Self booking data loaded',
            'data' => [
                'labs'                          => $labs,
                'selfBookingData'               => $selfBookingData,
                'total_self_booking_req_count'  => $total_self_booking_req_count
            ]
        ]);
    }


    public function searchBookingRequestApi()
    {
        header('Content-Type: application/json');

        // Accept POST (preferred) or GET fallback
        $center_id = $this->input->post('center_id') ?? $this->input->get('center_id');
        $search    = $this->input->post('search', true) ?? $this->input->get('search', true);
        $type      = $this->input->post('type', true) ?? $this->input->get('type', true);

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required',
                'data' => []
            ]);
            return;
        }

        $cityId = null;
        if ($type === 'all') {
            $data = $this->Common_model->get_total_booking_request($center_id, '', '', $search, $cityId);
        } elseif ($type === 'inreview') {
            $data = $this->Common_model->get_total_inreview_booking_request($center_id, $search);
        } elseif ($type === 'confirmed') {
            $data = $this->Common_model->get_total_booking_request($center_id, 1, 1, $search, $cityId);
        } else {
            $data = [];
        }

        $rows = [];
        if (!empty($data)) {
            foreach ($data as $row) {
                // duration calculation
                $duration = 'N/A';
                if (!empty($row['start_date']) && !empty($row['end_date'])) {
                    try {
                        $start = new DateTime($row['start_date']);
                        $end = new DateTime($row['end_date']);
                        $diffDays = $start->diff($end)->days + 1;
                        $duration = $diffDays . ' day' . ($diffDays > 1 ? 's' : '');
                    } catch (Exception $e) {
                        $duration = 'N/A';
                    }
                }

                // status
                $status_text = 'Pending';
                $status_code = 0; // 0 pending, 1 approved, 2 rejected
                if (isset($row['exam_center_status'])) {
                    if ($row['exam_center_status'] == 1) {
                        $status_text = 'Approved';
                        $status_code = 1;
                    } elseif ($row['exam_center_status'] == 2) {
                        $status_text = 'Rejected';
                        $status_code = 2;
                    }
                }

                // formatted dates
                $formatted_start = !empty($row['start_date']) ? date('M d, Y', strtotime($row['start_date'])) : null;
                $formatted_end   = !empty($row['end_date']) ? date('M d, Y', strtotime($row['end_date'])) : null;
                $formatted_range = ($formatted_start && $formatted_end) ? ($formatted_start . ' - ' . $formatted_end) : null;

                $rows[] = [
                    'project_id'         => $row['project_id'] ?? null,
                    'exam_name'          => $row['exam_name'] ?? null,
                    'client_name'        => $row['client_name'] ?? null,
                    'duration'           => $duration,
                    'start_date'         => $row['start_date'] ?? null,
                    'end_date'           => $row['end_date'] ?? null,
                    'formatted_dates'    => $formatted_range,
                    'number_of_seats'    => $row['number_of_seats'] ?? 0,
                    'price_per_seat'     => $row['price_per_seat'] ?? 0,
                    'status_text'        => $status_text,
                    'status_code'        => $status_code,
                    // include raw row if frontend needs other fields
                    'raw'                => $row
                ];
            }
        }

        // JSON response
        echo json_encode([
            'status' => true,
            'message' => 'Search results',
            'count' => count($rows),
            'data' => $rows
        ]);
    }


    public function getBookingDetailsApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->authenticateCenter();
        $date      = $this->input->get('date');

        if (!$center_id) {
            echo json_encode(['status' => false, 'message' => 'center_id is required']);
            return;
        }
        if (!$date) {
            echo json_encode(['status' => false, 'message' => 'date is required']);
            return;
        }

        $bookings = $this->Common_model->get_bookings_by_date($date, $center_id);

        echo json_encode([
            'status' => true,
            'message' => 'Booking details loaded',
            'date' => $date,
            'center_id' => $center_id,
            'data' => $bookings
        ]);
    }

    public function getCalendarApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->authenticateCenter();
        $month     = $this->input->get('month');
        $year      = $this->input->get('year');

        if (!$center_id) {
            echo json_encode(['status' => false, 'message' => 'center_id is required']);
            return;
        }
        if (!$month || !$year) {
            echo json_encode(['status' => false, 'message' => 'month and year are required']);
            return;
        }

        // Load exam dates
        $exam_dates = $this->Common_model->get_exam_dates($month, $year, $center_id);

        // Calendar array (NOT HTML)
        $calendar = $this->generate_calendar($month, $year, $exam_dates);

        echo json_encode([
            'status' => true,
            'message' => 'Calendar loaded',
            'data' => [
                'month' => $month,
                'year' => $year,
                'calendar' => $calendar
            ]
        ]);
    }


    private function generate_calendar($month, $year, $exam_dates)
    {
        // Create array for calendar
        $calendar = [];

        // Get first day of month and total days
        $first_day = mktime(0, 0, 0, $month, 1, $year);
        $days_in_month = date('t', $first_day);
        $day_of_week = date('w', $first_day); // 0=Sunday, 6=Saturday

        // Get previous month and year
        $prev_month = ($month == 1) ? 12 : $month - 1;
        $prev_year = ($month == 1) ? $year - 1 : $year;

        // Get next month and year
        $next_month = ($month == 12) ? 1 : $month + 1;
        $next_year = ($month == 12) ? $year + 1 : $year;

        // Get days from previous month to show
        $days_in_prev_month = date('t', mktime(0, 0, 0, $prev_month, 1, $prev_year));

        // Fill calendar with previous month's days
        for ($i = 0; $i < $day_of_week; $i++) {
            $calendar[] = [
                'day' => $days_in_prev_month - ($day_of_week - $i - 1),
                'month' => 'prev',
                'has_exam' => false
            ];
        }

        // Fill calendar with current month's days
        for ($day = 1; $day <= $days_in_month; $day++) {
            $current_date = date('Y-m-d', mktime(0, 0, 0, $month, $day, $year));
            $bookings = [];

            // Check all exam dates
            foreach ($exam_dates as $exam) {
                if ($current_date >= $exam['start_date'] && $current_date <= $exam['end_date']) {
                    $bookings[] = $exam;
                }
            }

            $has_exam = !empty($bookings);
            $booking_types = array_unique(array_column($bookings, 'type'));

            // Add mixed_booking class if both types exist
            if (count($booking_types) > 1) {
                $booking_types = ['mixed_booking'];
            }

            $calendar[] = [
                'day' => $day,
                'month' => 'current',
                'has_exam' => $has_exam,
                'date' => $current_date,
                'booking_types' => $booking_types
            ];
        }

        // Fill calendar with next month's days
        $days_left = 42 - count($calendar); // 6 weeks calendar
        for ($day = 1; $day <= $days_left; $day++) {
            $calendar[] = [
                'day' => $day,
                'month' => 'next',
                'has_exam' => false
            ];
        }

        // Split into weeks (7 days each)
        $weeks = array_chunk($calendar, 7);

        return [
            'weeks' => $weeks,
            'month_name' => date('F', $first_day),
            'year' => $year,
            'prev_month' => $prev_month,
            'prev_year' => $prev_year,
            'next_month' => $next_month,
            'next_year' => $next_year
        ];
    }



    public function detailProjectApi()
    {
        header('Content-Type: application/json');

        $center_id  = $this->input->post('center_id');
        $project_id = $this->input->post('project_id');
        $booking_id = $this->input->post('booking_id');

        if (!$center_id || !$project_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id and project_id are required'
            ]);
            return;
        }

        $result = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);
        $cityId = $result->city_id ?? null;

        $data['project'] = $this->Common_model->get_single_booking_request($center_id, $project_id, $cityId, $booking_id);

        $data['batchAllocation'] = $this->db
            ->select("
                b.batch_no,
                b.batch_start,
                b.batch_end,
                b.seat AS required_seat,
                sbrb.center_seat
            ")
            ->from('tt_send_booking_request_batch sbrb')
            ->join(
                'tt_project_batch_detail b',
                'b.project_id = sbrb.project_id
                AND b.city_id = sbrb.city_id
                AND b.batch_no = sbrb.batch_no'
            )
            ->where('sbrb.request_id', $booking_id)
            ->order_by('b.batch_no')
            ->get()
            ->result_array();

        echo json_encode([
            'status' => true,
            'message' => 'Project details loaded',
            'data' => $data
        ]);
    }


    public function updateBookingStatusApi()
    {
        header('Content-Type: application/json');

        $center_id  = $this->input->post('center_id');
        $project_id = $this->input->post('project_id');

        if (!$center_id || !$project_id) {
            echo json_encode(['status' => false, 'message' => 'center_id and project_id are required']);
            return;
        }

        // Update status
        $where = ['center_id' => $center_id, 'project_id' => $project_id];
        $data  = [
            'exam_center_status' => 1,
            'center_booking_accept_date' => date('Y-m-d H:i:s')
        ];
        $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);

        // Get booking details with joins
        $booking_details = $this->db->select('
            pd.exam_name,
            pd.client_id,
            pd.client_name,
            c.center_name,
            c.address,
            ci.city_name,
            c.pin_code,
            client_au.email as client_email,
            owner_au.email as center_email
        ')
            ->from('tt_send_booking_request sbr')
            ->join('tt_project_detail pd', 'pd.project_id = sbr.project_id')
            ->join('tt_center c', 'c.center_id = sbr.center_id')
            ->join('tt_admin_users client_au', 'client_au.id = pd.client_id')
            ->join('tt_admin_users owner_au', 'owner_au.id = c.owner_user_id')
            ->join('tt_city_master ci', 'ci.city_id = c.city_id', 'left')
            ->where('sbr.center_id', $center_id)
            ->where('sbr.project_id', $project_id)
            ->get()
            ->row();

        if ($booking_details) {
            // Format full address
            $full_address = implode(', ', array_filter([
                $booking_details->address,
                $booking_details->city_name,
                $booking_details->pin_code
            ]));

            // Prepare email content
            $email_subject = "New Center Assigned To You: " . $booking_details->center_name;

            $email_content = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .header { color: #2c3e50; }
                        .content { margin: 20px 0; }
                        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                        .button { 
                            display: inline-block; 
                            padding: 10px 20px; 
                            background: #3498db; 
                            color: white !important; 
                            text-decoration: none; 
                            border-radius: 5px; 
                            margin: 10px 0;
                        }
                        .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                    </style>
                </head>
                <body>
                    <h2 class="header">New Center For Your Project</h2>
                    
                    <div class="content">
                        <p>Dear ' . htmlspecialchars($booking_details->client_name) . ',</p>
                        
                        <p>We are pleased to inform you that we send you a new exam center for your project.</p>
                        
                        <div class="details">
                            <h3>Booking Details:</h3>
                            <p><strong>Exam Name:</strong> ' . htmlspecialchars($booking_details->exam_name) . '</p>
                            <p><strong>Center Name:</strong> ' . htmlspecialchars($booking_details->center_name) . '</p>
                            <p><strong>Center Address:</strong> ' . htmlspecialchars($full_address) . '</p>
                            <p><strong>Confirmation Date:</strong> ' . date('d M Y, h:i A') . '</p>
                        </div>
                        
                        <p>You can view the complete details in your client portal:</p>
                    </div>
                </body>
                </html>
            ';

            // Send email to assessment company
            $send = send_email(
                $email_content,
                $email_subject,
                $booking_details->client_email,
                "centerbooking@bookmytestcenter.com"
            );

            // ====================== Client NOTIFICATION ======================

            // Title & Message
            $notification_title = "Exam Center Assigned";

            $notification_message = "Exam center has been assigned to you. Center Name: {$booking_details->center_name} and Email: {$booking_details->center_email}";

            // Notification data
            $notification_data = [
                'admin_user_id' => $booking_details->client_id,
                'center_id'     => null,
                'client_id'     => $booking_details->client_id,
                'title'         => $notification_title,
                'message'       => $notification_message,
                'type'          => 'client',
                'is_read'       => 0,
                'is_remove'     => 0,
                'created_at'    => date('Y-m-d H:i:s')
            ];

            // Insert notification
            $this->db->insert('notifications', $notification_data);
        }

        echo json_encode([
            'status' => true,
            'message' => 'Booking status updated successfully!'
        ]);
    }


    public function rejectBookingStatusApi()
    {
        header('Content-Type: application/json');

        $project_id   = $this->input->post('project_id');
        $center_id    = $this->input->post('center_id');
        $action       = $this->input->post('action'); // reject | negotiate

        if (!$project_id || !$center_id || !$action) {
            echo json_encode([
                'status' => false,
                'message' => 'project_id, center_id and action are required'
            ]);
            return;
        }

        $where = [
            'project_id' => $project_id,
            'center_id'  => $center_id
        ];

        // ================= NEGOTIATION FLOW =================
        if ($action === 'negotiate') {

            $negotiate_price = $this->input->post('negotiate');
            $comment         = $this->input->post('rejection_comment');

            $data = [
                'exam_center_status' => 3, // Negotiation Requested
                'negotiate'          => $negotiate_price,
                'comment'            => $comment,
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);


            // Get booking details with joins
            $booking_details = $this->db->select('
                    pd.exam_name,
                    pd.client_id,
                    pd.client_name,
                    c.center_name,
                    c.address,
                    ci.city_name,
                    c.pin_code,

                    client.email as client_email,

                    center.email as center_owner_email,
                    center.mobile_phone as center_owner_mobile

                ')
                ->from('tt_send_booking_request sbr')
                ->join('tt_project_detail pd', 'pd.project_id = sbr.project_id')
                ->join('tt_center c', 'c.center_id = sbr.center_id')

                // Client join
                ->join('tt_admin_users client', 'client.id = pd.client_id')

                // Center owner join
                ->join('tt_admin_users center', 'center.id = c.owner_user_id')

                ->join('tt_city_master ci', 'ci.city_id = c.city_id', 'left')
                ->where('sbr.center_id', $center_id)
                ->where('sbr.project_id', $project_id)
                ->get()
                ->row();

            // Format full address
            $full_address = implode(', ', array_filter([
                $booking_details->address,
                $booking_details->city_name,
                $booking_details->state_name,
                $booking_details->pin_code
            ]));


            // Prepare negotiation email content
            $email_subject = "Price Negotiation Request: " . $booking_details->exam_name . " at " . $booking_details->center_name;

            $email_content = '
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; line-height: 1.6; }
                        .header { color: #2c3e50; }
                        .content { margin: 20px 0; }
                        .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                        .negotiation { background: #fff8e1; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                        .button { 
                            display: inline-block; 
                            padding: 10px 20px; 
                            background: #3498db; 
                            color: white !important; 
                            text-decoration: none; 
                            border-radius: 5px; 
                            margin: 10px 0;
                        }
                        .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                    </style>
                </head>
                <body>
                    <h2 class="header">Price Negotiation Request</h2>
                    
                    <div class="content">
                        <p>Dear Admin,</p>
                        
                        <p>The following center has requested price negotiation for a booking:</p>
                        
                        <div class="details">
                            <h3>Project Details:</h3>
                            <p><strong>Exam Name:</strong> ' . htmlspecialchars($booking_details->exam_name) . '</p>
                            <p><strong>Client Name:</strong> ' . htmlspecialchars($booking_details->client_name) . '</p>
                        </div>
                        
                        <div class="details">
                            <h3>Center Details:</h3>
                            <p><strong>Center Name:</strong> ' . htmlspecialchars($booking_details->center_name) . '</p>
                            <p><strong>Contact Person:</strong> ' . htmlspecialchars($booking_details->center_owner_mobile) . '</p>
                            <p><strong>Email:</strong> ' . htmlspecialchars($booking_details->center_owner_email) . '</p>
                            <p><strong>Address:</strong> ' . htmlspecialchars($full_address) . '</p>
                        </div>
                        
                        <div class="negotiation">
                            <h3>Negotiation Details:</h3>
                            <p><strong>Original Price Per Seat:</strong> ₹' . htmlspecialchars($booking_details->original_price) . '</p>
                            <p><strong>Rejection Reasons:</strong> ' . htmlspecialchars($rejection_reasons) . '</p>
                            <p><strong>Additional Comments:</strong> ' . htmlspecialchars($rejection_comment) . '</p>
                        </div>
                        
                        <p>Please review this negotiation request in the admin panel:</p>
                    </div>
                </body>
                </html>
            ';

            $send = send_email(
                $email_content,
                $email_subject,
                "admin@testpanindia.com",
                "centerbooking@bookmytestcenter.com"
            );


            // ====================== Admin NOTIFICATION ======================

            // Title & Message
            $notification_title = "Price Negotiation";

            $notification_message = "Center has requested price negotiation for a booking. Center Name: {$booking_details->center_name} and Email: {$booking_details->center_email}";

            // Notification data
            $notification_data = [
                'admin_user_id' => $booking_details->admin_user_id,
                'center_id'     => $center_id,
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


            echo json_encode([
                'status' => true,
                'message' => 'Negotiation request sent successfully'
            ]);
            return;
        }

        // ================= FINAL REJECT FLOW =================
        if ($action === 'reject') {

            $reasons = $this->input->post('rejection_reasons');
            $comment = $this->input->post('rejection_comment');

            $data = [
                'exam_center_status' => 2, // Rejected
                'reason'             => is_array($reasons) ? implode(',', $reasons) : $reasons,
                'comment'            => $comment,
                'updated_at'         => date('Y-m-d H:i:s')
            ];

            $this->Common_model->UpdateRecord('tt_send_booking_request', $data, $where);

            echo json_encode([
                'status' => true,
                'message' => 'Booking rejected successfully'
            ]);
            return;
        }

        echo json_encode([
            'status' => false,
            'message' => 'Invalid action'
        ]);
    }


    public function createSelfBookingApi()
    {
        header("Content-Type: application/json");

        // Accept JSON or POST
        $raw = json_decode($this->input->raw_input_stream, true);

        $start_date = $raw['start_date'] ?? $this->input->post('start_date');
        $end_date   = $raw['end_date'] ?? $this->input->post('end_date');
        $center_id  = $raw['center_id'] ?? $this->input->post('center_id');

        if (!$center_id || !$start_date || !$end_date) {
            echo json_encode(['status' => 'error', 'message' => 'center_id, start_date, end_date required']);
            return;
        }

        // Conflict checks
        $selfConflict = $this->Common_model->check_date_conflict_self_booking($center_id, $start_date, $end_date);
        $projectConflict = $this->Common_model->check_date_conflict_project($center_id, $start_date, $end_date);

        if ($selfConflict || $projectConflict) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking dates conflict with an existing booking!'
            ]);
            return;
        }

        // Prepare booking data
        $exam_date = $start_date . "-" . $end_date;

        $data = [
            'client_name'    => $raw['client_name'] ?? $this->input->post('client_name'),
            'client_email'   => $raw['client_email'] ?? $this->input->post('client_email'),
            'client_phone'   => $raw['client_phone'] ?? $this->input->post('client_phone'),
            'exam_name'      => $raw['exam_name'] ?? $this->input->post('exam_name'),
            'exam_type'      => $raw['exam_type'] ?? $this->input->post('exam_type'),
            'exam_location'  => $raw['exam_location'] ?? $this->input->post('exam_location'),
            'exam_date'      => $exam_date,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'exam_duration'  => $raw['exam_duration'] ?? $this->input->post('exam_duration'),
            'exam_time'      => $raw['exam_time'] ?? $this->input->post('exam_time'),
            'seats_booked'   => $raw['seats_booked'] ?? $this->input->post('seats_booked'),
            'labs_assigned'  => $raw['labs_assigned'] ?? $this->input->post('labs_assigned'),
            'center_id'      => $center_id,
            'total_batch'    => $raw['exam_batch'] ?? $this->input->post('exam_batch'),
        ];

        // Add batch fields
        for ($i = 1; $i <= 5; $i++) {

            $batchStart = trim($raw["batch{$i}_start"] ?? $this->input->post("batch{$i}_start"));
            if ($batchStart) {
                $data["batch{$i}_start"] = str_replace("'", "&#8217;", $batchStart);
            }

            $batchEnd = trim($raw["batch{$i}_end"] ?? $this->input->post("batch{$i}_end"));
            if ($batchEnd) {
                $data["batch{$i}_end"] = str_replace("'", "&#8217;", $batchEnd);
            }
        }

        $insert_id = $this->Common_model->insertData("tt_self_bookings", $data);

        echo json_encode([
            'status' => 'success',
            'message' => 'Booking created successfully!',
            'booking_id' => $insert_id
        ]);
    }


    public function fetchBookingViewByIdApi()
    {
        header("Content-Type: application/json");

        $raw = json_decode($this->input->raw_input_stream, true);

        $id    = $raw['id'] ?? $this->input->post('id');
        $type  = $raw['type'] ?? $this->input->post('type');

        if (!$id || !$type) {
            echo json_encode(['status' => false, 'message' => 'id and type required']);
            return;
        }

        if ($type == 'self-booking') {
            $result = $this->Common_model->get_self_booking_data_by_id($id);
            if ($result) {
                $result->id = $id;
            }
            $booking_type = 'self';
        } else {
            $result = $this->Common_model->get_assigned_booking_data_by_id($id);
            if ($result) {
                $result->id = $id;
            }
            $booking_type = 'assigned';
        }

        echo json_encode([
            'status' => true,
            'booking_type' => $booking_type,
            'data' => $result
        ]);
    }


    public function editSelfBookingByIdApi()
    {
        header("Content-Type: application/json");

        $raw = json_decode($this->input->raw_input_stream, true);

        $id        = $raw['id'] ?? $this->input->post('id');
        $center_id = $raw['center_id'] ?? $this->input->post('center_id');

        if (!$id || !$center_id) {
            echo json_encode(['status' => false, 'message' => 'id and center_id required']);
            return;
        }

        $result = $this->Common_model->getdata('tt_self_bookings', ['id' => $id]);
        $labs   = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);

        echo json_encode([
            'status' => true,
            'data' => [
                'booking' => $result,
                'labs' => $labs
            ]
        ]);
    }


    public function updateSelfBookingApi()
    {
        header("Content-Type: application/json");

        $raw = json_decode($this->input->raw_input_stream, true);

        $id         = $raw['id'] ?? $this->input->post('id');
        $center_id  = $raw['center_id'] ?? $this->input->post('center_id');
        $start_date = $raw['start_date'] ?? $this->input->post('start_date');
        $end_date   = $raw['end_date'] ?? $this->input->post('end_date');

        if (!$id || !$center_id || !$start_date || !$end_date) {
            echo json_encode(['status' => false, 'message' => 'id, center_id, start_date, end_date required']);
            return;
        }

        // Check conflicts
        $selfConflict = $this->Common_model->check_date_conflict_self_booking($center_id, $start_date, $end_date, $id);
        $projectConflict = $this->Common_model->check_date_conflict_project($center_id, $start_date, $end_date);

        if ($selfConflict || $projectConflict) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Booking dates conflict with an existing booking!'
            ]);
            return;
        }

        $exam_date = $start_date . "-" . $end_date;

        $data = [
            'client_name'    => $raw['client_name'] ?? $this->input->post('client_name'),
            'client_email'   => $raw['client_email'] ?? $this->input->post('client_email'),
            'client_phone'   => $raw['client_phone'] ?? $this->input->post('client_phone'),
            'exam_name'      => $raw['exam_name'] ?? $this->input->post('exam_name'),
            'exam_type'      => $raw['exam_type'] ?? $this->input->post('exam_type'),
            'exam_location'  => $raw['exam_location'] ?? $this->input->post('exam_location'),
            'exam_date'      => $exam_date,
            'start_date'     => $start_date,
            'end_date'       => $end_date,
            'exam_duration'  => $raw['exam_duration'] ?? $this->input->post('exam_duration'),
            'seats_booked'   => $raw['seats_booked'] ?? $this->input->post('seats_booked'),
            'labs_assigned'  => $raw['labs_assigned'] ?? $this->input->post('labs_assigned'),
            'total_batch'    => $raw['exam_batch'] ?? $this->input->post('exam_batch'),
        ];

        for ($i = 1; $i <= 5; $i++) {

            $batchStart = trim($raw["batch{$i}_start"] ?? $this->input->post("batch{$i}_start"));
            $batchEnd   = trim($raw["batch{$i}_end"] ?? $this->input->post("batch{$i}_end"));

            if ($batchStart) {
                $data["batch{$i}_start"] = str_replace("'", "&#8217;", $batchStart);
            }

            if ($batchEnd) {
                $data["batch{$i}_end"] = str_replace("'", "&#8217;", $batchEnd);
            }
        }

        $this->Common_model->UpdateRecord('tt_self_bookings', $data, ['id' => $id]);

        echo json_encode([
            'status' => 'success',
            'message' => 'Booking updated successfully!'
        ]);
    }


    public function deleteSelfBookingApi()
    {
        header('Content-Type: application/json');

        // Accept JSON or POST
        $raw = json_decode($this->input->raw_input_stream, true);

        $booking_id = $raw['booking_id'] ?? $this->input->post('booking_id');
        $center_id  = $raw['center_id']  ?? $this->input->post('center_id');

        if (!$booking_id || !$center_id) {
            echo json_encode([
                'status'  => false,
                'message' => 'booking_id and center_id are required'
            ]);
            return;
        }

        // Fetch booking (NO deleted check since hard delete)
        $booking = $this->db
            ->where('id', $booking_id)
            ->where('center_id', $center_id)
            ->get('tt_self_bookings')
            ->row();

        if (!$booking) {
            echo json_encode([
                'status'  => false,
                'message' => 'Booking not found'
            ]);
            return;
        }

        /* =====================================================
           ⏱️ 24 HOURS DELETE RESTRICTION
        ===================================================== */

        $examTime = !empty($booking->exam_time) ? $booking->exam_time : '00:00:00';

        $examDateTime = strtotime($booking->start_date . ' ' . $examTime);
        $currentTime  = time();

        $hoursLeft = ($examDateTime - $currentTime) / 3600;

        if ($hoursLeft <= 24) {
            echo json_encode([
                'status'  => false,
                'message' => 'Booking cannot be deleted within 24 hours of exam start'
            ]);
            return;
        }

        /* =====================================================
           ❌ HARD DELETE
        ===================================================== */

        $this->db
            ->where('id', $booking_id)
            ->where('center_id', $center_id)
            ->delete('tt_self_bookings');

        echo json_encode([
            'status'     => true,
            'message'    => 'Booking deleted successfully',
            'booking_id' => $booking_id
        ]);
    }



    public function deleteAccountApi()
    {
        header("Content-Type: application/json");

        // Accept JSON (raw) or POST params
        $raw = json_decode($this->input->raw_input_stream, true);

        $center_id     = $raw['center_id'] ?? $this->input->post('center_id');
        $mobile_phone  = $raw['mobile_phone'] ?? $this->input->post('mobile_phone');
        $mpin          = $raw['mpin'] ?? $this->input->post('mpin');

        // Required fields check
        if (!$center_id || !$mobile_phone || !$mpin) {
            echo json_encode([
                'status'  => false,
                'message' => 'center_id, mobile_phone, and mpin are required'
            ]);
            return;
        }

        $centerData = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));

        if (!$centerData) {
            echo json_encode([
                'status'  => false,
                'message' => 'Center account not found.'
            ]);
            return;
        }

        // Fetch user
        $user = $this->Common_model->getdata('tt_admin_users', [
            'id'           => $centerData->owner_user_id,
            'mobile_phone' => $mobile_phone,
            'role_id'      => 9,
            'deleted'      => 0
        ]);

        if (!$user) {
            echo json_encode([
                'status'  => false,
                'message' => 'Account not found or role mismatch'
            ]);
            return;
        }

        // MPIN check
        if ($user->mpin !== $mpin) {
            echo json_encode([
                'status'  => false,
                'message' => 'Incorrect MPIN'
            ]);
            return;
        }

        /* =====================================================
           🔒 BOOKING EXISTENCE CHECK (SELF + ASSIGNED)
        ===================================================== */

        // Self booking check
        $selfBookingExists = $this->db
            ->where('center_id', $center_id)
            ->limit(1)
            ->count_all_results('tt_self_bookings') > 0;

        if ($selfBookingExists) {
            echo json_encode([
                'status'  => false,
                'message' => 'Account cannot be deleted because self bookings exist.'
            ]);
            return;
        }

        // Assigned booking check
        $assignedBookingExists = $this->db
            ->where('center_id', $center_id)
            ->limit(1)
            ->count_all_results('tt_send_booking_request') > 0;

        if ($assignedBookingExists) {
            echo json_encode([
                'status'  => false,
                'message' => 'Account cannot be deleted because assigned bookings exist.'
            ]);
            return;
        }

        /* =====================================================
           ✅ SAFE TO DELETE (SOFT DELETE)
        ===================================================== */

        $data = ['deleted' => 1];

        $this->Common_model->UpdateRecord(
            'tt_center',
            $data,
            ['center_id' => $center_id]
        );

        echo json_encode([
            'status'    => true,
            'message'   => 'Account deleted successfully!',
            'center_id' => $center_id
        ]);
    }


    /**
     * API: Update exam center data
     * Accepts: multipart/form-data (for files) OR raw JSON (for fields).
     * URL: POST /api/v1/update-center
     */
    public function updateExamCenterDataApi()
    {

        // ======================
        // DEBUG LOGGER START
        // ======================

        $logDir = FCPATH . 'debug_logs/';
        if (!is_dir($logDir)) {
            mkdir($logDir, 0777, true);
        }

        $logFile = $logDir . 'flutter_debug_' . date('Y-m-d') . '.log';

        $logData = [
            'datetime'      => date('Y-m-d H:i:s'),
            'content_type'  => $_SERVER['CONTENT_TYPE'] ?? '',
            'request_method' => $_SERVER['REQUEST_METHOD'] ?? '',
            'raw_input'     => file_get_contents("php://input"),
            'post_data'     => $_POST,
            'files_data'    => $_FILES,
        ];

        file_put_contents(
            $logFile,
            "\n\n====================\n" . print_r($logData, true),
            FILE_APPEND
        );

        // ======================
        // DEBUG LOGGER END
        // ======================

        header('Content-Type: application/json');

        // Parse raw JSON if provided
        $raw = json_decode($this->input->raw_input_stream, true);

        // Accept center_id from JSON or POST (form-data) - REQUIRED
        $examCenterId = $raw['center_id'] ?? $this->input->post('center_id');
        if (empty($examCenterId)) {
            echo json_encode(['status' => false, 'message' => 'center_id is required']);
            return;
        }

        $updated_at = date('Y-m-d H:i:s');

        // Helper to fetch a value from JSON or POST
        $fv = function ($key, $default = null) use ($raw) {
            if (isset($raw[$key])) return $raw[$key];
            $val = $this->input->post($key);
            return ($val === null) ? $default : $val;
        };

        // Build data array (fields taken from either raw JSON or POST)
        $examCenterDetailsdata = [
            'center_type'               => $fv('center_type'),
            'type_of_center'            => $fv('type_of_center', 'University'),
            'center_name'               => $fv('center_name'),
            'center_description'        => $fv('center_description'),
            'msme_number'               => $fv('msme_number'),
            'capacity'                  => $fv('total_no_system'),

            'pin_code'                  => $fv('pin_code', 123456),
            'country_id'                => $fv('country_id'),
            'state_id'                  => $fv('state_id'),
            'city_id'                   => $fv('city_id'),
            'local_area_name'           => $fv('local_area_name'),

            'address'                   => $fv('address'),
            'address_lat'               => $fv('address_lat'),
            'address_long'              => $fv('address_long'),
            'landmark'                  => $fv('landmark'),

            'for_ph_candidate'          => $fv('for_ph_candidate'),

            'nearest_railway_station'   => $fv('nearest_railway_station'),
            'distance_from_station'     => $fv('distance_from_station'),

            'nearest_bus_stop'          => $fv('nearest_bus_stop'),
            'distance_from_bus_stop'    => $fv('distance_from_bus_stop'),

            'nearest_metro_station'     => $fv('nearest_metro_station'),
            'distance_from_metro'       => $fv('distance_from_metro'),

            'nearest_airport'           => $fv('nearest_airport'),
            'distance_from_airport'     => $fv('distance_from_airport'),


            'poc_name'                 => $fv('poc_name'),
            'poc_contact_no'           => $fv('poc_contact_no'),
            'poc_mobile_alternate'     => $fv('poc_mobile_alternate'),
            'poc_email'                => $fv('poc_email'),
            'cs_name'                  => $fv('cs_name'),
            'cs_contact_number'        => $fv('cs_contact_number'),
            'cs_email'                 => $fv('cs_email'),
            'am_name'                  => $fv('am_name'),
            'am_contact_no'            => $fv('am_contact_no'),
            'am_email'                 => $fv('am_email'),
            'emergency_contact_no'     => $fv('emergency_contact_no'),
            'landline_number'          => $fv('landline_number'),


            'total_no_lab'              => $fv('total_no_lab'),
            'total_no_system'           => $fv('total_no_system'),
            'connected_single_network'  => $fv('connected_single_network'),
            'how_many_network'          => $fv('how_many_network'),
            'partitaion_each_lab'       => $fv('partitaion_each_lab'),
            'ac_in_each_lab'            => $fv('ac_in_each_lab'),
            'network_printer'           => $fv('network_printer'),
            'is_there_projector_in_each_lab'    => $fv('is_there_projector_in_each_lab'),
            'is_there_sound_sytem_in_each_lab'    => $fv('is_there_sound_sytem_in_each_lab'),
            'how_many_fire_extinguisher_in_each_lab' => $fv('how_many_fire_extinguisher_in_each_lab'),
            'locker_facility'           => $fv('locker_facility'),
            'drinking_water_facility'   => $fv('drinking_water_facility'),


            'primary_isp_name'          => $fv('primary_isp_name'),
            'primary_isp_connect_type'  => $fv('primary_isp_connect_type'),
            'primary_isp_speed'         => $fv('primary_isp_speed') ?? 10,
            'primary_internet_speed_unit' => $fv('primary_internet_speed_unit'),

            'secondary_isp_name'        => $fv('secondary_isp_name'),
            'secondary_isp_connect_type'  => $fv('secondary_isp_connect_type'),
            'secondary_isp_speed'       => $fv('secondary_isp_speed') ?? 0,
            'secondary_internet_speed_unit' => $fv('secondary_internet_speed_unit'),

            'is_generator_backup'       => $fv('is_generator_backup'),
            'generator_backup_capacity' => $fv('generator_backup_capacity'),
            'generator_fuel_tank_capacity'     => $fv('generator_fuel_tank_capacity'),

            'power_back_ups_kv'         => $fv('power_back_ups_kv'),
            'ups_backup_time'           => $fv('ups_backup_time'),

            'total_no_of_connection'    => $fv('total_no_of_connection'),

            'backup_hours'              => $fv('backup_hours'),
            'backup_minutes'            => $fv('backup_minutes'),


            'beneficiary_name'    => $fv('beneficiary_name'),
            'bank_name'           => $fv('bank_name'),
            'bank_account_number' => $fv('bank_account_number'),
            'bank_ifsc_code'      => $fv('bank_ifsc_code'),
            'pan_no'              => $fv('pan_no'),
            'gst_no'              => $fv('gst_no'),
            'gst_state_code'      => $fv('gst_state_code'),
            'uidai_number'        => $fv('uidai_number'),
            'udyam_number'        => $fv('uidai_number'),
            'msme_number'         => $fv('msme_number'),
            'has_gst'             => $fv('has_gst'),
            'has_msme'            => $fv('has_msme'),
            'last_modified_on'    => $updated_at,
        ];

        // =======================
        // GST File Upload (single)
        // =======================
        if (!empty($_FILES['gst_file']['name'])) {
            $logoDir = 'uploads/gst_file/';
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);

            $logoName = time() . '_' . basename($_FILES['gst_file']['name']);
            $targetGSTFilePath = $logoDir . $logoName;

            if (move_uploaded_file($_FILES['gst_file']['tmp_name'], $targetGSTFilePath)) {
                // Update immediately
                $this->Common_model->UpdateRecord('tt_center', ['gst_file' => $targetGSTFilePath], ['center_id' => $examCenterId]);
                $examCenterDetailsdata['gst_file'] = $targetGSTFilePath;
            }
        }

        // =======================
        // Logo / center_entrances first image as logo (single)
        // =======================
        $logoPath = '';
        if (!empty($_FILES['center_logo']['name'][0])) {
            $logoDir = 'uploads/center_logo/';
            if (!is_dir($logoDir)) mkdir($logoDir, 0777, true);

            $logoName = time() . '_' . basename($_FILES['center_logo']['name'][0]);
            $targetLogoPath = $logoDir . $logoName;

            if (move_uploaded_file($_FILES['center_logo']['tmp_name'][0], $targetLogoPath)) {

                $logoPath = $targetLogoPath;
                $this->Common_model->UpdateRecord('tt_center', ['logo' => $logoPath], ['center_id' => $examCenterId]);
                $examCenterDetailsdata['logo'] = $logoPath;
            }
        }

        // Center Log
        // STEP 1: Get old data
        $oldData = $this->Common_model->getdata('tt_center', [
            'center_id' => $examCenterId
        ]);

        if ($oldData) {

            foreach ($examCenterDetailsdata as $field => $newValue) {

                $oldValue = $oldData->$field ?? null;

                // Normalize values (important)
                $oldValue = is_null($oldValue) ? '' : trim((string)$oldValue);
                $newValue = is_null($newValue) ? '' : trim((string)$newValue);

                // Compare
                if ($oldValue != $newValue) {

                    $logData = [
                        'center_id'   => $examCenterId,
                        'field_name'  => $field,
                        'old_value'   => $oldValue,
                        'new_value'   => $newValue,
                        'changed_by'  => $examCenterId, // or user id
                        'changed_on'  => date('Y-m-d H:i:s')
                    ];

                    $this->Common_model->insertData('tt_center_logs', $logData);
                }
            }
        }

        // =======================
        // Update center main record
        // =======================
        $this->Common_model->UpdateRecord('tt_center', $examCenterDetailsdata, ['center_id' => $examCenterId]);

        $this->db->where('center_id', $examCenterId)
            ->update('center_edit_permissions', [
                'is_edit_allowed' => 0
            ]);

        // =======================
        // Documents Upload / Update
        // Expected docs: canceled_cheque, agreement, mou, gst_certificate, udyam_certificate, pan_number
        // =======================
        $uploadPath = 'uploads/center_documents/';
        if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

        $expectedDocs = [
            'canceled_cheque',
            'agreement',
            'mou',
            'gst_certificate',
            'udyam_certificate',
            'pan_number',
            'NDA',
        ];

        foreach ($expectedDocs as $docName) {
            if (!empty($_FILES[$docName]['name'])) {
                $fileName = time() . '_' . basename($_FILES[$docName]['name']);
                $targetPath = $uploadPath . $fileName;

                if (move_uploaded_file($_FILES[$docName]['tmp_name'], $targetPath)) {

                    $existingDoc = $this->Common_model->getSingleData('tt_center_document', [
                        'center_id' => $examCenterId,
                        'doc_name'  => $docName,
                        'deleted'   => 0
                    ]);

                    $documentData = [
                        'center_id' => $examCenterId,
                        'doc_name'  => $docName,
                        'doe'       => date('Y-m-d H:i:s'),
                        'added_by'  => $fv('added_by') ?? $examCenterId,
                        'url'       => $targetPath,
                        'source'    => 1,
                        'deleted'   => 0
                    ];

                    if ($existingDoc) {

                        if (!empty($existingDoc->url) && file_exists($existingDoc->url)) {
                            @unlink($existingDoc->url);
                        }

                        $this->Common_model->UpdateRecord(
                            'tt_center_document',
                            $documentData,
                            [
                                'center_id' => $examCenterId,
                                'doc_name'  => $docName
                            ]
                        );
                    } else {

                        $this->Common_model->insertData('tt_center_document', $documentData);
                    }
                }
            }
        }

        // =======================
        // Multiple image uploads: center_entrances, lab_photos, main_gate_images, server_room_images,
        // observer_room_images, ups_generator_images
        // =======================
        // Use helper to insert images into tt_center_images table (uses $examCenterId)
        $this->uploadMultipleImagesUpdate('center_entrances', 'uploads/center_entrances/', $examCenterId, 'tt_center_images', 'center_entrance');
        $this->uploadMultipleImagesUpdate('lab_photos', 'uploads/lab_photos/', $examCenterId, 'tt_center_images', 'lab_photo');
        $this->uploadMultipleImagesUpdate('main_gate_images', 'uploads/main_gate_images/', $examCenterId, 'tt_center_images', 'gate_image');
        $this->uploadMultipleImagesUpdate('server_room_images', 'uploads/server_room_images/', $examCenterId, 'tt_center_images', 'server_image');
        $this->uploadMultipleImagesUpdate('observer_room_images', 'uploads/observer_room_images/', $examCenterId, 'tt_center_images', 'observer_image');
        $this->uploadMultipleImagesUpdate('ups_generator_images', 'uploads/ups_generator_images/', $examCenterId, 'tt_center_images', 'ups_image');

        // =======================
        // Walkthrough videos (multiple)
        // =======================
        if (!empty($_FILES['walkthrough_video']['name']) && is_array($_FILES['walkthrough_video']['name'])) {

            $videoDir = 'uploads/center_videos/';
            if (!is_dir($videoDir)) {
                mkdir($videoDir, 0777, true);
            }

            $files = $_FILES['walkthrough_video'];
            $about_videos = $fv('about_video', []);

            for ($i = 0; $i < count($files['name']); $i++) {

                if ($files['error'][$i] == 0 && !empty($files['name'][$i])) {

                    $vName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $files['name'][$i]);
                    $targetVideoPath = $videoDir . $vName;

                    if (move_uploaded_file($files['tmp_name'][$i], $targetVideoPath)) {

                        // Check existing video
                        $existingVideo = $this->Common_model->getSingleData('tt_center_video', [
                            'center_id' => $examCenterId,
                            'deleted'   => 0
                        ]);

                        // Delete old file if exists
                        if ($existingVideo && !empty($existingVideo->center_video) && file_exists($existingVideo->center_video)) {
                            @unlink($existingVideo->center_video);
                        }

                        $videoData = [
                            'center_id'    => $examCenterId,
                            'about_video'  => isset($about_videos[$i]) ? $about_videos[$i] : '',
                            'center_video' => $targetVideoPath,
                            'doe'          => date("Y-m-d H:i:s"),
                            'added_by'     => $examCenterId,
                            'deleted'      => 0
                        ];

                        if ($existingVideo) {

                            // UPDATE existing record
                            $this->Common_model->UpdateRecord(
                                'tt_center_video',
                                $videoData,
                                ['center_id' => $examCenterId]
                            );
                        } else {

                            // INSERT new record
                            $this->Common_model->insertData('tt_center_video', $videoData);
                        }
                    }
                }
            }
        }

        // =======================
        // Lab details: clear existing labs and insert new
        // Expect arrays in POST/JSON: floor_number[], no_of_computer[], window_generation[], monitor_type[], operating_system[], ram[], hard_disk[], ehternet_swtch_company[], switch_category[], no_of_port_eth_switch[]
        // =======================
        $floorNumbers          = $fv('floor_number', []);
        $noOfComputers         = $fv('no_of_computer', []);
        $windowGeneration      = $fv('window_generation', []);
        $monitorTypes          = $fv('monitor_type', []);
        $operatingSystems      = $fv('operating_system', []);
        $rams                  = $fv('ram', []);
        $hdds                  = $fv('hard_disk', []);
        $ethernetCompanies     = $fv('ehternet_swtch_company', []);
        $ethernetOther         = $fv('ethernet_company_other', []);
        $switchCategories      = $fv('switch_category', []);
        $ethernetPorts         = $fv('no_of_port_eth_switch', []);


        // Center Log
        $oldLabs = $this->Common_model->getdata_array('tt_lab', [
            'center_id' => $examCenterId
        ]);

        $newLabs = $fv('floor_number', []);

        if (!empty($oldLabs)) {

            // simple compare (count based)
            if (count($oldLabs) != count($newLabs)) {

                $this->Common_model->insertData('tt_center_logs', [
                    'center_id'  => $examCenterId,
                    'field_name' => 'lab_count',
                    'old_value'  => count($oldLabs),
                    'new_value'  => count($newLabs),
                    'changed_by' => $examCenterId,
                    'changed_on' => date('Y-m-d H:i:s')
                ]);
            }
        }

        if (!empty($floorNumbers) && is_array($floorNumbers)) {

            // Clean update
            $this->Common_model->Deletedata('tt_lab', ['center_id' => $examCenterId]);

            foreach ($floorNumbers as $key => $floorNumber) {

                if (trim($floorNumber) === '') continue;

                $data = [
                    'center_id'              => $examCenterId,
                    'floor_name'             => $floorNumber,
                    'no_of_computer'         => $noOfComputers[$key] ?? null,
                    'window_generation'      => $windowGeneration[$key] ?? null,
                    'monitor_type'           => $monitorTypes[$key] ?? null,
                    'operating_system'       => $operatingSystems[$key] ?? null,
                    'ram'                    => $rams[$key] ?? null,
                    'hard_disk'              => $hdds[$key] ?? null,
                    'ehternet_swtch_company' => $ethernetCompanies[$key] ?? null,
                    'ethernet_company_other' => $ethernetOther[$key] ?? null,
                    'switch_category'        => $switchCategories[$key] ?? null,
                    'no_of_port_eth_switch'  => $ethernetPorts[$key] ?? null,
                    'last_modify_on'         => $updated_at
                ];

                $this->Common_model->insertData('tt_lab', $data);
            }
        }


        // =======================
        // Final response
        // =======================
        echo json_encode([
            'status' => 'success',
            'message' => 'Data updated successfully!',
            'center_id' => $examCenterId
        ]);
        exit;
    }

    /**
     * Handle multiple image uploads and insert into tt_center_images
     *
     * @param string $fieldName - name of file field in $_FILES
     * @param string $uploadDir - destination folder
     * @param int    $centerId
     * @param string $tableName - (not used for DB write here; tt_center_images used)
     * @param string $columnName - image_type field value
     */
    private function uploadMultipleImagesUpdate($fieldName, $uploadDir, $centerId, $tableName, $columnName)
    {
        if (!empty($_FILES[$fieldName]['name']) && is_array($_FILES[$fieldName]['name'])) {

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $files = $_FILES[$fieldName];
            $filesCount = count($files['name']);

            for ($i = 0; $i < $filesCount; $i++) {

                if ($files['error'][$i] == 0 && !empty($files['name'][$i])) {

                    $imageName = time() . '_' . preg_replace('/[^A-Za-z0-9_\-\.]/', '_', $files['name'][$i]);
                    $imagePath = $uploadDir . $imageName;

                    if (move_uploaded_file($files['tmp_name'][$i], $imagePath)) {

                        $imageData = [
                            'center_id'    => $centerId,
                            'center_image' => $imagePath,
                            'image_type'   => $columnName,
                            'doe'          => date('Y-m-d H:i:s'),
                            'added_by'     => $centerId,
                            'deleted'      => 0
                        ];

                        $this->Common_model->insertData($tableName, $imageData);
                    }
                }
            }
        }
    }


    // =============================
    // GET SETTINGS API
    // =============================
    public function getSettingsApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->authenticateCenter();

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        $center_data = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);

        $user_data   = $this->Common_model->getdata('tt_admin_users', ['id' => $center_data->owner_user_id]);

        // Fetch active countries
        $where = '';
        $countries = $this->Common_model->getdata_array('tt_countries', $where);
        $states = $this->Common_model->getdata_array('tt_states', $where);
        $cities = $this->Common_model->getdata_array('tt_city_master', $where);

        echo json_encode([
            'status' => true,
            'message' => 'Settings data loaded',
            'data' => [
                'user'   => $user_data,
                'center' => $center_data,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities,
            ]
        ]);
    }


    // =============================
    // UPDATE SETTINGS API
    // =============================
    public function updateSettingApi()
    {
        header('Content-Type: application/json');

        // Read raw JSON if available
        $raw = json_decode($this->input->raw_input_stream, true);

        $center_id    = $raw['center_id'] ?? $this->input->post('center_id');
        $name         = $raw['name'] ?? $this->input->post('name');
        $email        = $raw['email'] ?? $this->input->post('email');
        $mobile_phone = $raw['mobile_phone'] ?? $this->input->post('mobile_phone');

        if (!$center_id || !$name || !$email || !$mobile_phone) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id, name, email, mobile_phone are required'
            ]);
            return;
        }

        $centerData = $this->Common_model->getdata('tt_center', array('center_id' => $center_id));

        if (!$centerData) {
            echo json_encode([
                'status' => false,
                'message' => 'Center owner account not found.'
            ]);
            return;
        }

        $updated_at = date('Y-m-d H:i:s');

        // Split name into first & last
        $name_parts = explode(' ', trim($name), 2);
        $first_name = $name_parts[0] ?? '';
        $last_name  = $name_parts[1] ?? '';

        $examCenterdata = [
            'username'     => $name,
            'email'        => $email,
            'mobile_phone' => $mobile_phone,
            'updated'      => $updated_at,
            'first_name'   => $first_name,
            'last_name'    => $last_name
        ];

        $result = $this->Common_model->UpdateRecord(
            'tt_admin_users',
            $examCenterdata,
            ['id' => $centerData->owner_user_id]
        );

        if ($result) {
            echo json_encode([
                'status' => true,
                'message' => 'Settings updated successfully'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Failed to update settings'
            ]);
        }
    }


    public function removeImages()
    {
        // Allow only POST
        if ($this->input->server('REQUEST_METHOD') !== 'POST') {
            echo json_encode([
                'status'  => false,
                'message' => 'Invalid request method'
            ]);
            return;
        }

        $id = $this->input->post('id');

        // Validation
        if (empty($id)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Image ID is required'
            ]);
            return;
        }

        $center_id = $this->input->post('center_id');

        // Validation
        if (empty($center_id)) {
            echo json_encode([
                'status'  => false,
                'message' => 'Center ID is required'
            ]);
            return;
        }

        $where = ['id' => $id];
        $data  = ['deleted' => 1];

        $update = $this->Common_model->UpdateRecord(
            'tt_center_images',
            $data,
            $where
        );

        if ($update) {
            echo json_encode([
                'status'  => true,
                'message' => 'Image removed successfully'
            ]);
        } else {
            echo json_encode([
                'status'  => false,
                'message' => 'Failed to remove image'
            ]);
        }
    }


    public function getNotificationsApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->authenticateCenter();
        $limit     = $this->input->get('limit'); // all / 10 / 20

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Base where condition
        $this->db->where('center_id', $center_id);
        $this->db->where('type', 'center');
        $this->db->where('is_remove', 0);
        $this->db->order_by('id', 'DESC');

        // Apply limit if not "all"
        if ($limit && $limit != 'all') {
            $this->db->limit((int)$limit);
        }

        $query = $this->db->get('notifications');
        $notifications = $query->result();

        echo json_encode([
            'status' => true,
            'message' => 'Notification list fetched successfully',
            'total' => count($notifications),
            'data' => $notifications
        ]);
    }


    public function markAllNotificationsReadApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->input->post('center_id');

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Update all notifications
        $this->db->where('center_id', $center_id);
        $this->db->where('type', 'center');
        $this->db->where('is_remove', 0);

        $updated = $this->db->update('notifications', [
            'is_read' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            echo json_encode([
                'status' => true,
                'message' => 'All notifications marked as read'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Something went wrong'
            ]);
        }
    }

    public function removeNotificationApi()
    {
        header('Content-Type: application/json');

        $notification_id = $this->input->post('notification_id');
        $center_id       = $this->input->post('center_id');

        if (!$notification_id || !$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'notification_id and center_id are required'
            ]);
            return;
        }

        // Security check: only center type + correct center_id
        $this->db->where('id', $notification_id);
        $this->db->where('center_id', $center_id);
        $this->db->where('type', 'center');
        $this->db->where('is_remove', 0);

        $updated = $this->db->update('notifications', [
            'is_remove' => 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($this->db->affected_rows() > 0) {
            echo json_encode([
                'status' => true,
                'message' => 'Notification removed successfully'
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Notification not found or already removed'
            ]);
        }
    }


    public function myCenterApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->authenticateCenter();

        if (!$center_id) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id is required'
            ]);
            return;
        }

        // Fetch center main info
        $result = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);

        if (!$result) {
            echo json_encode([
                'status' => false,
                'message' => 'Center not found'
            ]);
            return;
        }

        $ownerUserId = $result->owner_user_id ?? 0;

        // ================= RELATED DATA =================
        $countries   = $this->Common_model->getdata_array('tt_countries', ['is_active' => 1]);
        $states      = $this->Common_model->getdata_array('tt_states', '');
        $cities      = $this->Common_model->getdata_array('tt_city_master', '');
        $center_type = $this->Common_model->getdata_array('tt_center_type', ['deleted' => 0]);
        $labs        = $this->Common_model->getdata_array('tt_lab', ['center_id' => $center_id]);
        $documents   = $this->Common_model->getdata_array('tt_center_document', ['center_id' => $center_id]);
        $center_video = $this->Common_model->getdata_array('tt_center_video', ['center_id' => $center_id, 'deleted' => 0]);

        // Image types separated
        $center_entrances = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'center_entrance'
        ]);

        $lab_images = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'lab_photo'
        ]);

        $gate_images = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'gate_image'
        ]);

        $server_images = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'server_image'
        ]);

        $observer_images = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'observer_image'
        ]);

        $ups_images = $this->Common_model->getdata_array('tt_center_images', [
            'center_id' => $center_id,
            'deleted' => 0,
            'image_type' => 'ups_image'
        ]);

        // ================= EDIT REQUEST =================
        $editRequest = $this->db
            ->where('center_id', $center_id)
            ->where('owner_user_id', $ownerUserId)
            ->where('is_active', 1)
            ->order_by('id', 'DESC')
            ->get('profile_edit_requests')
            ->row();

        // ================= EDIT PERMISSION =================
        $editPermission = $this->db
            ->where('center_id', $center_id)
            ->where('is_edit_allowed', 1)
            ->get('center_edit_permissions')
            ->row();

        // ================= FRONTEND ACTION LOGIC =================
        $edit_action = '';

        if (!empty($editPermission)) {
            $edit_action = 'allow_edit'; // show Edit Center button
        } elseif (!empty($editRequest) && $editRequest->status == 'pending') {
            $edit_action = 'pending_request'; // show badge
        } else {
            $edit_action = 'can_request'; // show Request Edit button
        }

        echo json_encode([
            'status'  => true,
            'message' => 'Center details loaded successfully',
            'data' => [
                'countries'   => $countries,
                'states'      => $states,
                'cities'      => $cities,
                'center_type' => $center_type,
                'center'      => $result,
                'labs'        => $labs,
                'documents'   => $documents,
                'center_entrances' => $center_entrances,
                'lab_images'  => $lab_images,
                'gate_images'  => $gate_images,
                'server_images'  => $server_images,
                'observer_images'  => $observer_images,
                'ups_images'  => $ups_images,
                'walkthrough_video' => $center_video,
                'edit_request'     => $editRequest,
                'edit_permission'  => $editPermission,
                'edit_action'      => $edit_action
            ]
        ]);
    }


    public function requestProfileEditApi()
    {
        header('Content-Type: application/json');

        $center_id = $this->input->post('center_id');
        $request_message = $this->input->post('request_message');

        if (!$center_id || !$request_message) {
            echo json_encode([
                'status' => false,
                'message' => 'center_id and request_message are required'
            ]);
            return;
        }

        $center = $this->Common_model->getdata('tt_center', ['center_id' => $center_id]);

        if (!$center) {
            echo json_encode([
                'status' => false,
                'message' => 'Center not found'
            ]);
            return;
        }

        $ownerUserId = $center->owner_user_id ?? 0;

        // Deactivate old pending requests
        $this->db->where('center_id', $center_id)
            ->where('status', 'pending')
            ->update('profile_edit_requests', ['is_active' => 0]);

        $data = [
            'center_id'       => $center_id,
            'owner_user_id'   => $ownerUserId,
            'request_message' => $request_message,
            'status'          => 'pending',
            'is_active'       => 1,
            'requested_at'    => date('Y-m-d H:i:s')
        ];

        $this->db->insert('profile_edit_requests', $data);


        $this->db->select('c.center_name, c.address, au.email, au.mobile_phone');
        $this->db->from('tt_center c');
        $this->db->join('tt_admin_users au', 'au.id = c.owner_user_id', 'left');
        $this->db->where('c.center_id', $center_id);
        $result = $this->db->get()->row();

        $owner_email  = $result->email;
        $owner_mobile = $result->mobile_phone;

        $email_subject = "Profile Edit Request Submitted – " . $center->center_name;

        $email_content = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                    .header { color: #2c3e50; }
                    .content { margin: 20px 0; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                    .highlight { background: #fff3cd; padding: 15px; border-left: 4px solid #ffc107; margin: 15px 0; }
                    .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
                </style>
            </head>
            <body>

                <h2 class="header">Profile Edit Request Notification</h2>
                
                <div class="content">
                    <p>Dear Admin,</p>
                    
                    <p>
                        A profile edit request has been submitted by the following center. 
                        Kindly review and take the necessary action.
                    </p>

                    <div class="highlight">
                        <strong>Status:</strong> Pending Approval<br>
                        Please login to the admin panel to review the requested changes.
                    </div>

                    <div class="details">
                        <h3>Center Details:</h3>
                        <p><strong>Center Name:</strong> ' . htmlspecialchars($center->center_name) . '</p>
                        <p><strong>Registered Email:</strong> ' . htmlspecialchars($owner_email) . '</p>
                        <p><strong>Contact Number:</strong> ' . htmlspecialchars($owner_mobile) . '</p>
                        <p><strong>Address:</strong> ' . htmlspecialchars($center->address) . '</p>
                    </div>

                    <div class="details">
                        <h3>Request Message:</h3>
                        <p>' . nl2br(htmlspecialchars($this->input->post('request_message'))) . '</p>
                    </div>

                    <p>
                        Please review the request at your earliest convenience.
                    </p>
                </div>

            </body>
            </html>
            ';


        $send = send_email(
            $email_content,
            $email_subject,
            "admin@testpanindia.com",
            "centerbooking@bookmytestcenter.com"
        );

        echo json_encode([
            'status' => true,
            'message' => 'Edit request submitted successfully'
        ]);
    }
}
