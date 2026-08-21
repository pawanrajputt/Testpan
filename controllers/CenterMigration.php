<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CenterMigration extends CI_Controller {
    
    public $old_db;
    public $new_db;
    public $state_id = 7;
    public $center_mapping = array();
    public $user_mapping = array();
    public $duplicate_check = array();
    public $lab_duplicate_check = array();
    public $image_duplicate_check = array();
    public $doc_duplicate_check = array();
    public $video_duplicate_check = array();
    
    // Cache table columns for performance
    public $center_columns = array();
    public $lab_columns = array();
    public $image_columns = array();
    public $doc_columns = array();
    public $video_columns = array();
    
    // Log for debugging
    public $log_messages = array();
    
    public function __construct() {
        parent::__construct();
        
        // Set time limits for large migrations
        set_time_limit(0);
        ini_set('memory_limit', '1024M');
        
        $this->old_db = $this->load->database('old', TRUE);
        $this->new_db = $this->load->database('default', TRUE);
        
        // Cache all table columns for performance
        $this->center_columns = $this->new_db->list_fields('tt_center');
        $this->lab_columns = $this->new_db->list_fields('tt_lab');
        $this->image_columns = $this->new_db->list_fields('tt_center_images');
        $this->doc_columns = $this->new_db->list_fields('tt_center_document');
        $this->video_columns = $this->new_db->list_fields('tt_center_video');
    }
    
    // public function index($state_id = 7) {
    //     $this->state_id = (int)$state_id;
        
    //     echo "<h2>Starting Center Migration (State ID: {$this->state_id})...</h2>\n";
    //     echo "<pre>";
        
    //     try {
    //         // Step 1: Delete old centers and related data
    //         // $this->delete_old_centers_with_relations();
            
    //         // Step 2: Create/update users from CS details
    //         $this->migrate_admin_users_from_cs();
            
    //         // Step 3: Migrate centers
    //         $this->migrate_centers();
            
    //         // Step 4: Migrate child tables
    //         $this->migrate_center_labs();
    //         $this->migrate_center_images();
    //         $this->migrate_center_documents();
    //         $this->migrate_center_videos();
            
    //         // Step 5: Fix center_id = id
    //         $this->fix_center_ids();
            
    //         // Step 6: Copy files
    //         $this->copy_files();
            
    //         // Step 7: Verify
    //         $this->verify_migration();
            
    //         // Step 8: Show logs
    //         $this->show_logs();
            
    //         echo "\n✅ Migration Completed Successfully!\n";
            
    //     } catch (Exception $e) {
    //         echo "\n❌ Error: " . $e->getMessage() . "\n";
    //         $this->show_logs();
    //     }
        
    //     echo "</pre>";
    // }
    
    // ============================================================
    // 1. DELETE OLD CENTERS WITH CHILD TABLES (FIXED)
    // ============================================================
    private function delete_old_centers_with_relations() {
        echo "\n📌 Checking for old centers to delete...\n";
        
        // Get old centers count
        $old_centers = $this->new_db->query("
            SELECT id 
            FROM tt_center 
            WHERE admin_url IS NULL 
            OR admin_url = ''
        ")->result_array();
        
        if (empty($old_centers)) {
            echo "✅ No old centers to delete.\n";
            return;
        }
        
        $center_ids = array_column($old_centers, 'id');
        $ids_string = implode(',', $center_ids);
        
        // Get counts
        $counts = $this->new_db->query("
            SELECT 
                (SELECT COUNT(*) FROM tt_lab WHERE center_id IN ($ids_string)) as labs,
                (SELECT COUNT(*) FROM tt_center_images WHERE center_id IN ($ids_string)) as images,
                (SELECT COUNT(*) FROM tt_center_document WHERE center_id IN ($ids_string)) as docs,
                (SELECT COUNT(*) FROM tt_center_video WHERE center_id IN ($ids_string)) as videos,
                (SELECT COUNT(*) FROM tt_center WHERE id IN ($ids_string)) as centers
        ")->row();
        
        echo "   📊 Found old records:\n";
        echo "      - Labs: {$counts->labs}\n";
        echo "      - Images: {$counts->images}\n";
        echo "      - Documents: {$counts->docs}\n";
        echo "      - Videos: {$counts->videos}\n";
        echo "      - Centers: {$counts->centers}\n";
        
        // ============================================================
        // OPTION 1: DELETE OLD CENTERS (UNCOMMENT TO ENABLE)
        // ============================================================
        /*
        if (!empty($center_ids)) {
            $this->new_db->where_in('center_id', $center_ids)->delete('tt_lab');
            $this->new_db->where_in('center_id', $center_ids)->delete('tt_center_images');
            $this->new_db->where_in('center_id', $center_ids)->delete('tt_center_document');
            $this->new_db->where_in('center_id', $center_ids)->delete('tt_center_video');
            $this->new_db->where_in('id', $center_ids)->delete('tt_center');
            echo "   ✅ Deleted old centers and related data.\n";
        }
        */
        
        // ============================================================
        // OPTION 2: KEEP OLD DATA (CURRENTLY ACTIVE)
        // ============================================================
        echo "   ⚠️ Skipping deletion to preserve existing data.\n";
        echo "   ⚠️ To delete old centers, uncomment the deletion code above.\n";
    }
    
    // ============================================================
    // 2. CREATE/UPDATE USERS FROM CS DETAILS
    // ============================================================
    private function migrate_admin_users_from_cs() {
        echo "\n📌 Creating/Updating Admin Users from CS details (role_id = 9)...\n";
        
        // Get centers for state
        $old_centers = $this->old_db->query("
            SELECT * 
            FROM tt_center 
            WHERE state_id = {$this->state_id}
            AND deleted = 0
            AND center_name IS NOT NULL
            AND center_name != ''
        ")->result_array();
        
        if (empty($old_centers)) {
            echo "⚠️ No centers found for state_id = {$this->state_id}.\n";
            return;
        }
        
        $created_count = 0;
        $updated_count = 0;
        $skipped_count = 0;
        
        foreach ($old_centers as $old_center) {
            // Check required fields
            if (empty($old_center['cs_name'])) {
                $skipped_count++;
                continue;
            }
            
            $identifier_email = trim($old_center['cs_email'] ?? '');
            $identifier_mobile = trim($old_center['cs_contact_number'] ?? '');
            
            if (empty($identifier_email) && empty($identifier_mobile)) {
                $skipped_count++;
                continue;
            }
            
            // Find existing user by email OR mobile
            $existing_user = NULL;
            
            if (!empty($identifier_email)) {
                $existing_user = $this->new_db->where('email', $identifier_email)->get('tt_admin_users')->row();
            }
            
            if (!$existing_user && !empty($identifier_mobile)) {
                $existing_user = $this->new_db->where('mobile_phone', $identifier_mobile)->get('tt_admin_users')->row();
            }
            
            if ($existing_user) {
                // Update role_id to 9 if needed
                if ($existing_user->role_id != 9) {
                    $this->new_db->where('id', $existing_user->id);
                    $this->new_db->update('tt_admin_users', array('role_id' => 9));
                    $updated_count++;
                    $this->log_messages[] = "Updated user ID: {$existing_user->id} to role_id=9";
                }
                $this->user_mapping[$old_center['id']] = $existing_user->id;
                continue;
            }
            
            // Create new user
            $username = $this->generate_unique_username($old_center['cs_name']);
            
            // Check which password method your project uses
            $password_hash = $this->get_password_hash('password123');
            
            $new_user = array(
                'role_id' => 9,
                'user_type' => 'center_owner',
                'username' => $username,
                'email' => $identifier_email ?: $identifier_mobile . '@temp.com',
                'password' => $password_hash,
                'first_name' => $old_center['cs_name'],
                'last_name' => '',
                'birthdate' => NULL,
                'gender' => NULL,
                'profile_pic' => NULL,
                'mobile_country_code' => $old_center['cs_country_code'] ?? '+91',
                'mobile_phone' => $identifier_mobile,
                'mpin' => NULL,
                'alternate_number' => $old_center['cs_phone_alternate'] ?? '',
                'device_type' => 'androi',
                'device_token' => '12345678900987654321',
                'status' => 1,
                'log_status' => 0,
                'created_by' => 0,
                'updated_by' => 0,
                'created' => date('Y-m-d H:i:s'),
                'updated' => date('Y-m-d H:i:s'),
                'signup_step' => 0,
                'signup_completed' => 0,
                'ip_address' => NULL,
                'mobile_otp' => '000000',
                'otp' => NULL,
                'approved' => 1,
                'deleted' => 0,
                'api_token' => NULL,
                'api_token_updated_at' => NULL,
                'is_agree' => 1
            );
            
            // Filter columns
            $user_columns = $this->new_db->list_fields('tt_admin_users');
            foreach ($new_user as $key => $value) {
                if (!in_array($key, $user_columns)) {
                    unset($new_user[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_admin_users', $new_user)) {
                $new_user_id = $this->new_db->insert_id();
                $this->user_mapping[$old_center['id']] = $new_user_id;
                $created_count++;
                $this->log_messages[] = "Created user ID: $new_user_id for center: {$old_center['id']}";
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to create user for center: {$old_center['id']}";
            }
        }
        
        echo "✅ Created: $created_count, Updated: $updated_count, Skipped: $skipped_count\n";
    }
    
    // ============================================================
    // 3. MIGRATE CENTERS
    // ============================================================
    private function migrate_centers() {
        echo "\n📌 Migrating Centers (State ID: {$this->state_id})...\n";
        
        // Get centers
        $old_centers = $this->old_db->query("
            SELECT * 
            FROM tt_center 
            WHERE state_id = {$this->state_id}
            AND deleted = 0
            AND center_name IS NOT NULL
            AND center_name != ''
        ")->result_array();
        
        if (empty($old_centers)) {
            echo "⚠️ No centers found.\n";
            return;
        }
        
        // Build duplicate check from existing centers
        $existing_centers = $this->new_db
            ->select('center_name, state_id, city_id')
            ->where('state_id', $this->state_id)
            ->get('tt_center')
            ->result_array();
        
        foreach ($existing_centers as $ec) {
            $key = $this->normalize_string($ec['center_name']) . '_' . $ec['state_id'] . '_' . $ec['city_id'];
            $this->duplicate_check[$key] = true;
        }
        
        $inserted_count = 0;
        $skipped_count = 0;
        
        foreach ($old_centers as $old_center) {
            // Get user ID from mapping
            $new_user_id = isset($this->user_mapping[$old_center['id']]) 
                ? $this->user_mapping[$old_center['id']] 
                : NULL;
            
            if (!$new_user_id) {
                $skipped_count++;
                continue;
            }
            
            // Check duplicate
            $dup_key = $this->normalize_string($old_center['center_name']) . '_' . $old_center['state_id'] . '_' . $old_center['city_id'];
            if (isset($this->duplicate_check[$dup_key])) {
                $skipped_count++;
                continue;
            }
            
            // Build COMPLETE center array with ALL fields
            $new_center = array(
                // ===== BASIC INFO =====
                'center_name' => $old_center['center_name'],
                'center_type' => $old_center['center_type'] ?? 'exam',
                'center_id' => $old_center['id'], // Temporary, updated later
                'owner_user_id' => $new_user_id,
                
                // ===== LOCATION =====
                'country_id' => $old_center['country_id'] ?? 1,
                'state_id' => $old_center['state_id'],
                'city_id' => $old_center['city_id'],
                'local_area_name' => $old_center['local_area_name'] ?? '',
                'region_code' => $old_center['region_code'] ?? '',
                'state_code' => $old_center['state_code'] ?? '',
                'city_code' => $old_center['city_code'] ?? '',
                'vendor_id' => $old_center['vendor_id'] ?? NULL,
                
                // ===== ADDRESS =====
                'address' => $old_center['address'] ?? '',
                'address_second' => $old_center['address_second'] ?? '',
                'address_lat' => $old_center['address_lat'] ?? '',
                'address_long' => $old_center['address_long'] ?? '',
                'landmark' => $old_center['landmark'] ?? '',
                'city' => $old_center['city'] ?? '',
                'pin_code' => $old_center['pin_code'] ?? '',
                
                // ===== CONTACT =====
                'landline_number' => $this->format_landline($old_center),
                'mobile_no' => $old_center['mobile_no'] ?? '',
                'pan_no' => $old_center['pan_no'] ?? '',
                'gst_no' => $old_center['gst_no'] ?? '',
                'gst_file' => $old_center['gst_file'] ?? NULL,
                'gst_state_code' => $old_center['gst_state_code'] ?? '',
                
                // ===== BANK DETAILS =====
                'bank_name' => $old_center['bank_name'] ?? '',
                'bank_account_number' => $old_center['bank_account_number'] ?? '',
                'bank_ifsc_code' => $old_center['bank_ifsc_code'] ?? '',
                'beneficiary_name' => $old_center['beneficiary_name'] ?? '',
                'sec_bank_option' => $old_center['sec_bank_option'] ?? NULL,
                'secondary_pan_no' => $old_center['secondary_pan_no'] ?? '',
                'secondary_bank_name' => $old_center['secondary_bank_name'] ?? '',
                'secondary_bank_account_no' => $old_center['secondary_bank_account_no'] ?? '',
                'secondary_bank_ifsc_code' => $old_center['secondary_bank_ifsc_code'] ?? '',
                'secondary_beneficiary_name' => $old_center['secondary_beneficiary_name'] ?? '',
                
                // ===== NEARBY LOCATIONS =====
                'nearest_railway_station' => $old_center['nearest_railway_station'] ?? '',
                'station_lat' => $old_center['station_lat'] ?? '',
                'station_long' => $old_center['station_long'] ?? '',
                'distance_from_station' => $old_center['distance_from_station'] ?? 0,
                'nearest_bus_stop' => $old_center['nearest_bus_stop'] ?? '',
                'bus_lat' => $old_center['bus_lat'] ?? '',
                'bus_long' => $old_center['bus_long'] ?? '',
                'distance_from_bus_stop' => $old_center['distance_from_bus_stop'] ?? 0,
                
                // ===== FACILITIES =====
                'for_ph_candidate' => $old_center['for_ph_candidate'] ?? 0,
                'phydical_handicapped' => $old_center['phydical_handicapped'] ?? 0,
                'document_sign' => $old_center['document_sign'] ?? NULL,
                'photographs' => $old_center['photographs'] ?? NULL,
                
                // ===== CS (Center Superintendent) =====
                'cs_name' => $old_center['cs_name'] ?? '',
                'cs_country_code' => $old_center['cs_country_code'] ?? '',
                'cs_contact_number' => $old_center['cs_contact_number'] ?? '',
                'cs_phone_alternate' => $old_center['cs_phone_alternate'] ?? '',
                'cs_email' => $old_center['cs_email'] ?? '',
                
                // ===== AM (Assistant Manager) =====
                'am_name' => $old_center['am_name'] ?? '',
                'am_country_code' => $old_center['am_country_code'] ?? '',
                'am_contact_no' => $old_center['am_contact_no'] ?? '',
                'am_phone_alternate' => $old_center['am_phone_alternate'] ?? '',
                'am_email' => $old_center['am_email'] ?? '',
                
                // ===== POC (Point of Contact) =====
                'poc_name' => $old_center['poc_name'] ?? '',
                'poc_country_code' => $old_center['poc_country_code'] ?? '',
                'poc_contact_no' => $old_center['poc_contact_no'] ?? '',
                'poc_mobile_alternate' => $old_center['poc_mobile_alternate'] ?? '',
                'poc_email' => $old_center['poc_email'] ?? '',
                
                // ===== EMERGENCY =====
                'emergency_counter_code' => $old_center['emergency_counter_code'] ?? '',
                'emergency_contact_no' => $old_center['emergency_contact_no'] ?? '',
                'emergency_number_alternate' => $old_center['emergency_number_alternate'] ?? '',
                
                // ===== TD (Technical Department) =====
                'td_name' => $old_center['td_name'] ?? '',
                'td_country_code' => $old_center['td_country_code'] ?? '',
                'td_contact_no' => $old_center['td_contact_no'] ?? '',
                'td_phone_alternate' => $old_center['td_phone_alternate'] ?? '',
                'td_email' => $old_center['td_email'] ?? '',
                
                // ===== LAB AMENITIES =====
                'total_no_system' => $old_center['total_no_system'] ?? 0,
                'total_no_lab' => $old_center['total_no_lab'] ?? 0,
                'partitaion_each_lab' => $old_center['partitaion_each_lab'] ?? 0,
                'connected_single_network' => $old_center['connected_single_network'] ?? 0,
                'how_many_network' => $old_center['how_many_network'] ?? 0,
                'ac_in_each_lab' => $old_center['ac_in_each_lab'] ?? 0,
                
                // ===== LAN =====
                'lan_company_name' => $old_center['lan_company_name'] ?? '',
                'lan_model_number' => $old_center['lan_model_number'] ?? '',
                'lan_speed' => $old_center['lan_speed'] ?? '',
                'lan_managed' => $old_center['lan_managed'] ?? NULL,
                
                // ===== ISP =====
                'primary_isp_name' => $old_center['primary_isp_name'] ?? '',
                'primary_isp_bband_or_lease' => $old_center['primary_isp_bband_or_lease'] ?? '',
                'primary_isp_speed' => $old_center['primary_isp_speed'] ?? 0,
                'secondary_isp_name' => $old_center['secondary_isp_name'] ?? '',
                'secondary_isp_bband_or_lease' => $old_center['secondary_isp_bband_or_lease'] ?? '',
                'secondary_isp_speed' => $old_center['secondary_isp_speed'] ?? 0,
                
                // ===== POWER BACKUP =====
                'power_backup_generator_kv' => $old_center['power_backup_generator_kv'] ?? 0,
                'power_back_ups_kv' => $old_center['power_back_ups_kv'] ?? 0,
                'power_backup_hour' => $old_center['power_backup_hour'] ?? 0,
                'power_backup_unit' => $old_center['power_backup_unit'] ?? '',
                'is_generator_backup' => !empty($old_center['power_backup_generator_kv']) ? 1 : 0,
                
                // ===== OTHER FACILITIES =====
                'cctv_dvr' => $old_center['cctv_dvr'] ?? 0,
                'network_printer' => $old_center['network_printer'] ?? 0,
                'projector_sound_system' => $old_center['projector_sound_system'] ?? 0,
                'fire_extinguisher' => $old_center['fire_extinguisher'] ?? 0,
                'parking_facility' => $old_center['parking_facility'] ?? 0,
                'security_guard_male' => $old_center['security_guard_male'] ?? 0,
                'security_guard_female' => $old_center['security_guard_female'] ?? 0,
                'entry_point' => $old_center['entry_point'] ?? NULL,
                'exit_point' => $old_center['exit_point'] ?? NULL,
                'locker_facility' => $old_center['locker_facility'] ?? 0,
                'drinking_water_facility' => $old_center['drinking_water_facility'] ?? 0,
                'onsite_engineer' => $old_center['onsite_engineer'] ?? NULL,
                'parents_waiting_hall' => $old_center['parents_waiting_hall'] ?? NULL,
                'candidates_waiting_hall' => $old_center['candidates_waiting_hall'] ?? NULL,
                'availability_of_engineers' => $old_center['availability_of_engineers'] ?? NULL,
                
                // ===== CENTER DETAILS =====
                'type_of_center' => $old_center['type_of_center'] ?? '',
                'center_approved_by' => $old_center['center_approved_by'] ?? NULL,
                'center_affiliation_by' => $old_center['center_affiliation_by'] ?? NULL,
                'center_lab_establish_year' => $old_center['center_lab_establish_year'] ?? NULL,
                'center_client_name' => $old_center['center_client_name'] ?? '',
                'center_prev_exam_name' => $old_center['center_prev_exam_name'] ?? '',
                'feedback' => $old_center['feedback'] ?? NULL,
                
                // ===== UDYAM =====
                'udyam_number' => $old_center['udyam_number'] ?? '',
                'udyam_document' => $old_center['udyam_document'] ?? '',
                
                // ===== IMAGES (will be migrated separately) =====
                'image1' => $old_center['image1'] ?? NULL,
                'image2' => $old_center['image2'] ?? NULL,
                'image3' => $old_center['image3'] ?? NULL,
                'image4' => $old_center['image4'] ?? NULL,
                'image5' => $old_center['image5'] ?? NULL,
                'image6' => $old_center['image6'] ?? NULL,
                'image7' => $old_center['image7'] ?? NULL,
                'image8' => $old_center['image8'] ?? NULL,
                
                // ===== DOCUMENTS =====
                'documt1' => $old_center['documt1'] ?? NULL,
                'documt2' => $old_center['documt2'] ?? NULL,
                'documt3' => $old_center['documt3'] ?? NULL,
                'documt4' => $old_center['documt4'] ?? NULL,
                
                // ===== META =====
                'created_by' => $new_user_id,
                'center_owner' => $old_center['center_owner'] ?? NULL,
                'created_on' => $old_center['created_on'] ?? date('Y-m-d H:i:s'),
                'last_modified_by' => $old_center['last_modified_by'] ?? NULL,
                'last_modified_on' => $old_center['last_modified_on'] ?? NULL,
                'verified' => $old_center['verified'] ?? 0,
                'coupon_code' => $old_center['coupon_code'] ?? NULL,
                'coupon_status' => $old_center['coupon_status'] ?? NULL,
                'coupon_add' => $old_center['coupon_add'] ?? NULL,
                'coupon_create_date' => $old_center['coupon_create_date'] ?? NULL,
                'reason_of_delete' => $old_center['reason_of_delete'] ?? NULL,
                'deleted' => 0,
                
                // ===== NEW COLUMNS (DEFAULTS) =====
                'approved' => 0,
                'audit_status' => 'pending',
                'primary_internet_speed_unit' => 'Mbps',
                'secondary_internet_speed_unit' => 'Mbps',
                'generator_backup_capacity' => $old_center['power_backup_generator_kv'] ?? 0,
                'generator_backup_time' => $old_center['power_backup_hour'] ?? 0,
                'ups_backup_time' => $old_center['power_backup_hour'] ?? 0,
                'backup_hours' => $old_center['power_backup_hour'] ?? 0,
                'backup_minutes' => 0,
                'has_gst' => !empty($old_center['gst_no']) ? 1 : 0,
                'has_msme' => !empty($old_center['msme_number']) ? 1 : 0,
                'msme_number' => $old_center['msme_number'] ?? NULL,
                'uidai_number' => $old_center['uidai_number'] ?? NULL,
                'capacity' => $old_center['capacity'] ?? NULL,
                'logo' => $old_center['logo'] ?? NULL,
                'nearest_metro_station' => $old_center['nearest_metro_station'] ?? NULL,
                'distance_from_metro' => $old_center['distance_from_metro'] ?? NULL,
                'nearest_airport' => $old_center['nearest_airport'] ?? NULL,
                'distance_from_airport' => $old_center['distance_from_airport'] ?? NULL,
                'total_no_of_connection' => $old_center['total_no_of_connection'] ?? NULL,
                'is_there_projector_in_each_lab' => $old_center['is_there_projector_in_each_lab'] ?? NULL,
                'is_there_sound_sytem_in_each_lab' => $old_center['is_there_sound_sytem_in_each_lab'] ?? NULL,
                'how_many_fire_extinguisher_in_each_lab' => $old_center['how_many_fire_extinguisher_in_each_lab'] ?? NULL,
                'generator_fuel_tank_capacity' => $old_center['generator_fuel_tank_capacity'] ?? NULL,
                'ethernet_company_other' => $old_center['ethernet_company_other'] ?? NULL,
                'primary_isp_connect_type' => $old_center['primary_isp_connect_type'] ?? NULL,
                'secondary_isp_connect_type' => $old_center['secondary_isp_connect_type'] ?? NULL,
                'exam_center_url' => $old_center['exam_center_url'] ?? NULL,
                'admin_url' => NULL,
                'api_token' => $old_center['api_token'] ?? NULL,
                'center_description' => $old_center['center_description'] ?? NULL,
                'audit_file' => $old_center['audit_file'] ?? NULL,
                'last_audited' => $old_center['last_audited'] ?? NULL
            );
            
            // Filter only existing columns
            foreach ($new_center as $key => $value) {
                if (!in_array($key, $this->center_columns)) {
                    unset($new_center[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_center', $new_center)) {
                $new_center_id = $this->new_db->insert_id();
                
                // Update center_id to match new id
                $this->new_db->where('id', $new_center_id);
                $this->new_db->update('tt_center', array('center_id' => $new_center_id));
                
                $this->center_mapping[$old_center['id']] = $new_center_id;
                $this->duplicate_check[$dup_key] = true;
                $inserted_count++;
                $this->log_messages[] = "Created center ID: $new_center_id from old ID: {$old_center['id']}";
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to create center: {$old_center['center_name']}";
            }
            
            if ($inserted_count % 10 == 0) {
                echo "   Progress: $inserted_count centers migrated...\n";
            }
        }
        
        echo "✅ Migrated $inserted_count centers (Skipped: $skipped_count).\n";
    }
    
    // ============================================================
    // 4. MIGRATE LABS
    // ============================================================
    private function migrate_center_labs() {
        echo "\n📌 Migrating Center Labs...\n";
        
        if (empty($this->center_mapping)) {
            echo "⚠️ No centers mapped, skipping labs.\n";
            return;
        }
        
        $old_center_ids = array_keys($this->center_mapping);
        $ids_string = implode(',', $old_center_ids);
        
        $old_labs = $this->old_db->query("
            SELECT * 
            FROM tt_lab 
            WHERE center_id IN ($ids_string)
        ")->result_array();
        
        if (empty($old_labs)) {
            echo "⚠️ No labs found.\n";
            return;
        }
        
        // Build duplicate check
        $existing_labs = $this->new_db
            ->select('center_id, lab_name')
            ->get('tt_lab')
            ->result_array();
        
        foreach ($existing_labs as $el) {
            $key = $el['center_id'] . '_' . $this->normalize_string($el['lab_name']);
            $this->lab_duplicate_check[$key] = true;
        }
        
        $inserted_count = 0;
        $skipped_count = 0;
        
        foreach ($old_labs as $old_lab) {
            $new_center_id = isset($this->center_mapping[$old_lab['center_id']]) 
                ? $this->center_mapping[$old_lab['center_id']] 
                : NULL;
            
            if (!$new_center_id) {
                $skipped_count++;
                continue;
            }
            
            // Check duplicate
            $dup_key = $new_center_id . '_' . $this->normalize_string($old_lab['lab_name']);
            if (isset($this->lab_duplicate_check[$dup_key])) {
                $skipped_count++;
                continue;
            }
            
            $new_lab = array(
                'center_id' => $new_center_id,
                'lab_name' => $old_lab['lab_name'],
                'floor_name' => $old_lab['floor_name'] ?? '',
                'no_of_computer' => $old_lab['no_of_computer'] ?? 0,
                'no_of_ac' => $old_lab['no_of_ac'] ?? 0,
                'monitor_type' => $old_lab['monitor_type'] ?? '',
                'operating_system' => $old_lab['operating_system'] ?? '',
                'processor' => $old_lab['processor'] ?? '',
                'ram' => $old_lab['ram'] ?? '',
                'hard_disk' => $old_lab['hard_disk'] ?? '',
                'model_no' => $old_lab['model_no'] ?? '',
                'created_by' => $old_lab['created_by'],
                'created_on' => $old_lab['created_on'],
                'deleted' => 0
            );
            
            // Filter columns
            foreach ($new_lab as $key => $value) {
                if (!in_array($key, $this->lab_columns)) {
                    unset($new_lab[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_lab', $new_lab)) {
                $this->lab_duplicate_check[$dup_key] = true;
                $inserted_count++;
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to insert lab: {$old_lab['lab_name']}";
            }
        }
        
        echo "✅ Migrated $inserted_count labs (Skipped: $skipped_count).\n";
    }
    
    // ============================================================
    // 5. MIGRATE IMAGES
    // ============================================================
    private function migrate_center_images() {
        echo "\n📌 Migrating Center Images...\n";
        
        if (empty($this->center_mapping)) {
            echo "⚠️ No centers mapped, skipping images.\n";
            return;
        }
        
        $old_center_ids = array_keys($this->center_mapping);
        $ids_string = implode(',', $old_center_ids);
        
        $old_data = $this->old_db->query("
            SELECT * 
            FROM tt_center_images 
            WHERE center_id IN ($ids_string)
        ")->result_array();
        
        if (empty($old_data)) {
            echo "⚠️ No images found.\n";
            return;
        }
        
        // Build duplicate check
        $existing = $this->new_db
            ->select('center_id, center_image')
            ->get('tt_center_images')
            ->result_array();
        
        foreach ($existing as $e) {
            $key = $e['center_id'] . '_' . $e['center_image'];
            $this->image_duplicate_check[$key] = true;
        }
        
        $inserted_count = 0;
        $skipped_count = 0;
        
        foreach ($old_data as $row) {
            $new_center_id = isset($this->center_mapping[$row['center_id']]) 
                ? $this->center_mapping[$row['center_id']] 
                : NULL;
            
            if (!$new_center_id || empty($row['center_image'])) {
                $skipped_count++;
                continue;
            }
            
            $dup_key = $new_center_id . '_' . $row['center_image'];
            if (isset($this->image_duplicate_check[$dup_key])) {
                $skipped_count++;
                continue;
            }
            
            $new_row = array(
                'center_id' => $new_center_id,
                'center_image' => $row['center_image'],
                'doe' => $row['doe'] ?? date('Y-m-d H:i:s'),
                'added_by' => $row['added_by'] ?? 0,
                'deleted' => 0
            );
            
            foreach ($new_row as $key => $value) {
                if (!in_array($key, $this->image_columns)) {
                    unset($new_row[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_center_images', $new_row)) {
                $this->image_duplicate_check[$dup_key] = true;
                $inserted_count++;
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to insert image: {$row['center_image']}";
            }
        }
        
        echo "✅ Migrated $inserted_count images (Skipped: $skipped_count).\n";
    }
    
    // ============================================================
    // 6. MIGRATE DOCUMENTS
    // ============================================================
    private function migrate_center_documents() {
        echo "\n📌 Migrating Center Documents...\n";
        
        if (empty($this->center_mapping)) {
            echo "⚠️ No centers mapped, skipping documents.\n";
            return;
        }
        
        $old_center_ids = array_keys($this->center_mapping);
        $ids_string = implode(',', $old_center_ids);
        
        $old_data = $this->old_db->query("
            SELECT * 
            FROM tt_center_document 
            WHERE center_id IN ($ids_string)
        ")->result_array();
        
        if (empty($old_data)) {
            echo "⚠️ No documents found.\n";
            return;
        }
        
        // Build duplicate check
        $existing = $this->new_db
            ->select('center_id, doc_name')
            ->get('tt_center_document')
            ->result_array();
        
        foreach ($existing as $e) {
            $key = $e['center_id'] . '_' . $e['doc_name'];
            $this->doc_duplicate_check[$key] = true;
        }
        
        $inserted_count = 0;
        $skipped_count = 0;
        
        foreach ($old_data as $row) {
            $new_center_id = isset($this->center_mapping[$row['center_id']]) 
                ? $this->center_mapping[$row['center_id']] 
                : NULL;
            
            if (!$new_center_id || empty($row['doc_name'])) {
                $skipped_count++;
                continue;
            }
            
            $dup_key = $new_center_id . '_' . $row['doc_name'];
            if (isset($this->doc_duplicate_check[$dup_key])) {
                $skipped_count++;
                continue;
            }
            
            $new_row = array(
                'center_id' => $new_center_id,
                'doc_name' => $row['doc_name'],
                'doe' => $row['doe'] ?? date('Y-m-d H:i:s'),
                'added_by' => $row['added_by'] ?? 0,
                'url' => $row['url'] ?? '',
                'source' => $row['source'] ?? '',
                'deleted' => 0
            );
            
            foreach ($new_row as $key => $value) {
                if (!in_array($key, $this->doc_columns)) {
                    unset($new_row[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_center_document', $new_row)) {
                $this->doc_duplicate_check[$dup_key] = true;
                $inserted_count++;
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to insert document: {$row['doc_name']}";
            }
        }
        
        echo "✅ Migrated $inserted_count documents (Skipped: $skipped_count).\n";
    }
    
    // ============================================================
    // 7. MIGRATE VIDEOS
    // ============================================================
    private function migrate_center_videos() {
        echo "\n📌 Migrating Center Videos...\n";
        
        if (empty($this->center_mapping)) {
            echo "⚠️ No centers mapped, skipping videos.\n";
            return;
        }
        
        $old_center_ids = array_keys($this->center_mapping);
        $ids_string = implode(',', $old_center_ids);
        
        $old_data = $this->old_db->query("
            SELECT * 
            FROM tt_center_video 
            WHERE center_id IN ($ids_string)
        ")->result_array();
        
        if (empty($old_data)) {
            echo "⚠️ No videos found.\n";
            return;
        }
        
        // Build duplicate check
        $existing = $this->new_db
            ->select('center_id, center_video')
            ->get('tt_center_video')
            ->result_array();
        
        foreach ($existing as $e) {
            $key = $e['center_id'] . '_' . $e['center_video'];
            $this->video_duplicate_check[$key] = true;
        }
        
        $inserted_count = 0;
        $skipped_count = 0;
        
        foreach ($old_data as $row) {
            $new_center_id = isset($this->center_mapping[$row['center_id']]) 
                ? $this->center_mapping[$row['center_id']] 
                : NULL;
            
            if (!$new_center_id || empty($row['center_video'])) {
                $skipped_count++;
                continue;
            }
            
            $dup_key = $new_center_id . '_' . $row['center_video'];
            if (isset($this->video_duplicate_check[$dup_key])) {
                $skipped_count++;
                continue;
            }
            
            $new_row = array(
                'center_id' => $new_center_id,
                'about_video' => $row['about_video'] ?? '',
                'center_video' => $row['center_video'],
                'doe' => $row['doe'] ?? date('Y-m-d H:i:s'),
                'added_by' => $row['added_by'] ?? 0,
                'deleted' => 0
            );
            
            foreach ($new_row as $key => $value) {
                if (!in_array($key, $this->video_columns)) {
                    unset($new_row[$key]);
                }
            }
            
            if ($this->new_db->insert('tt_center_video', $new_row)) {
                $this->video_duplicate_check[$dup_key] = true;
                $inserted_count++;
            } else {
                $skipped_count++;
                $this->log_messages[] = "ERROR: Failed to insert video: {$row['center_video']}";
            }
        }
        
        echo "✅ Migrated $inserted_count videos (Skipped: $skipped_count).\n";
    }
    
    // ============================================================
    // 8. FIX CENTER_ID
    // ============================================================
    private function fix_center_ids() {
        echo "\n📌 Fixing center_id = id for all centers...\n";
        
        $this->new_db->query("UPDATE tt_center SET center_id = id WHERE center_id != id OR center_id IS NULL");
        $affected = $this->new_db->affected_rows();
        $this->log_messages[] = "Fixed center_id for $affected records";
        echo "✅ Fixed $affected center records.\n";
    }
    
    // ============================================================
    // 9. COPY FILES
    // ============================================================
    private function copy_files() {
        echo "\n📌 Copying files...\n";
        
        // Use constants from config/constants.php
        if (!defined('OLD_UPLOAD_PATH')) {
            echo "   ⚠️ OLD_UPLOAD_PATH not defined in constants.php\n";
            echo "   ⚠️ Please define it and run again.\n";
            echo "   ⚠️ Skipping file copy.\n";
            return;
        }
        
        if (!defined('NEW_UPLOAD_PATH')) {
            echo "   ⚠️ NEW_UPLOAD_PATH not defined in constants.php\n";
            echo "   ⚠️ Skipping file copy.\n";
            return;
        }
        
        $old_base_path = OLD_UPLOAD_PATH;
        $new_base_path = NEW_UPLOAD_PATH;
        
        if (!is_dir($old_base_path)) {
            echo "   ⚠️ Old uploads directory not found: $old_base_path\n";
            echo "   ⚠️ Skipping file copy. Please copy manually.\n";
            return;
        }
        
        // Create new directory if not exists
        if (!is_dir($new_base_path)) {
            mkdir($new_base_path, 0777, true);
        }
        
        $tables = array(
            'tt_center_images' => 'center_image',
            'tt_center_document' => 'url',
            'tt_center_video' => 'center_video'
        );
        
        foreach ($tables as $table => $field) {
            $records = $this->new_db
                ->select($field)
                ->where($field . ' IS NOT NULL')
                ->where($field . ' !=', '')
                ->get($table)
                ->result_array();
            
            $copied = 0;
            $skipped = 0;
            
            foreach ($records as $record) {
                $filename = $record[$field];
                $old_file = $old_base_path . $filename;
                $new_file = $new_base_path . $filename;
                
                if (!file_exists($old_file)) {
                    $skipped++;
                    continue;
                }
                
                if (file_exists($new_file)) {
                    $skipped++;
                    continue;
                }
                
                // Create directory if not exists
                $dir = dirname($new_file);
                if (!is_dir($dir)) {
                    mkdir($dir, 0777, true);
                }
                
                if (copy($old_file, $new_file)) {
                    $copied++;
                } else {
                    $skipped++;
                    $this->log_messages[] = "ERROR: Failed to copy file: $filename";
                }
            }
            
            echo "   ✅ $table: Copied $copied, Skipped $skipped\n";
        }
    }
    
    // ============================================================
    // 10. VERIFY MIGRATION
    // ============================================================
    private function verify_migration() {
        echo "\n📌 Verifying Migration...\n";
        
        // Check center_id = id
        $result = $this->new_db->query("SELECT COUNT(*) as count FROM tt_center WHERE center_id != id")->row();
        if ($result->count == 0) {
            echo "✅ All centers have center_id = id\n";
        } else {
            echo "⚠️ Warning: $result->count centers have center_id != id\n";
        }
        
        // Use LEFT JOIN for better performance
        $orphan_labs = $this->new_db->query("
            SELECT COUNT(*) as count 
            FROM tt_lab l
            LEFT JOIN tt_center c ON l.center_id = c.id
            WHERE c.id IS NULL
        ")->row();
        
        $orphan_images = $this->new_db->query("
            SELECT COUNT(*) as count 
            FROM tt_center_images i
            LEFT JOIN tt_center c ON i.center_id = c.id
            WHERE c.id IS NULL
        ")->row();
        
        $orphan_docs = $this->new_db->query("
            SELECT COUNT(*) as count 
            FROM tt_center_document d
            LEFT JOIN tt_center c ON d.center_id = c.id
            WHERE c.id IS NULL
        ")->row();
        
        $orphan_videos = $this->new_db->query("
            SELECT COUNT(*) as count 
            FROM tt_center_video v
            LEFT JOIN tt_center c ON v.center_id = c.id
            WHERE c.id IS NULL
        ")->row();
        
        echo "\n📊 Orphan Records Check:\n";
        echo "   - Orphan Labs: {$orphan_labs->count}\n";
        echo "   - Orphan Images: {$orphan_images->count}\n";
        echo "   - Orphan Documents: {$orphan_docs->count}\n";
        echo "   - Orphan Videos: {$orphan_videos->count}\n";
        
        // Get counts
        $users = $this->new_db->query("SELECT COUNT(*) as count FROM tt_admin_users WHERE role_id = 9")->row();
        $centers = $this->new_db->query("SELECT COUNT(*) as count FROM tt_center WHERE state_id = {$this->state_id}")->row();
        $images = $this->new_db->query("SELECT COUNT(*) as count FROM tt_center_images")->row();
        $docs = $this->new_db->query("SELECT COUNT(*) as count FROM tt_center_document")->row();
        $videos = $this->new_db->query("SELECT COUNT(*) as count FROM tt_center_video")->row();
        $labs = $this->new_db->query("SELECT COUNT(*) as count FROM tt_lab")->row();
        
        echo "\n📊 Migration Summary (State ID: {$this->state_id}):\n";
        echo "   - Admin Users (role_id=9): {$users->count}\n";
        echo "   - Centers: {$centers->count}\n";
        echo "   - Center Images: {$images->count}\n";
        echo "   - Center Documents: {$docs->count}\n";
        echo "   - Center Videos: {$videos->count}\n";
        echo "   - Center Labs: {$labs->count}\n";
    }
    
    // ============================================================
    // 11. SHOW LOGS
    // ============================================================
    private function show_logs() {
        if (empty($this->log_messages)) {
            return;
        }
        
        echo "\n📋 Migration Log:\n";
        foreach ($this->log_messages as $log) {
            echo "   - $log\n";
        }
    }
    
    // ============================================================
    // HELPER FUNCTIONS
    // ============================================================
    
    private function normalize_string($str) {
        if (empty($str)) return '';
        $str = trim($str);
        $str = strtolower($str);
        $str = preg_replace('/\s+/', ' ', $str);
        return $str;
    }
    
    private function generate_unique_username($name) {
        $base = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $name));
        if (empty($base)) {
            $base = 'user';
        }
        
        $username = $base;
        $counter = 1;
        
        while ($this->new_db->where('username', $username)->get('tt_admin_users')->num_rows() > 0) {
            $username = $base . $counter++;
        }
        
        return $username;
    }
    
    private function get_password_hash($password) {
        // IMPORTANT: Check your project's authentication method
        // and uncomment the appropriate line.
        
        // Option 1: BCrypt (PHP 5.5+)
        return password_hash($password, PASSWORD_BCRYPT);
        
        // Option 2: MD5 (if your project uses md5)
        // return md5($password);
        
        // Option 3: SHA1
        // return sha1($password);
        
        // Option 4: Ion Auth
        // $this->load->library('ion_auth');
        // return $this->ion_auth->hash_password($password);
        
        // Option 5: Custom encryption
        // return do_hash($password, 'sha1');
    }
    
    private function format_landline($old_center) {
        $landline = '';
        if (!empty($old_center['landline_country_code'])) {
            $landline .= '+' . $old_center['landline_country_code'] . '-';
        }
        if (!empty($old_center['landline_area_code'])) {
            $landline .= $old_center['landline_area_code'] . '-';
        }
        if (!empty($old_center['landline_number'])) {
            $landline .= $old_center['landline_number'];
        }
        if (!empty($old_center['landline_extension'])) {
            $landline .= ' ext: ' . $old_center['landline_extension'];
        }
        return $landline;
    }
}