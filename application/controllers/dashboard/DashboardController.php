<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DashboardController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // Load required libraries/helpers only
        $this->load->library(['session', 'form_validation']);
        $this->load->helper(['url', 'security']);
        $this->load->database();
        $this->load->helper('project_status');
        $this->load->helper('project_helper');

        // Auth Guard (industry standard)
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }
    }

    /**
     * Admin Dashboard
     */
    public function index()
    {
        // Logged-in admin
        $admin = $this->session->userdata('admin_user');

        // Optional role check
        if (!$admin) {
            redirect('login');
        }

        // ---------- DASHBOARD COUNTS ----------
        $data['stats'] = [];

        $data['stats'] = $this->getDashboardStats();

        // ---------- PAGE DATA ----------
        $data['page_title'] = 'Dashboard';
        $data['admin']      = $admin;

        // ---------- VIEWS ----------
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/dashboard/index', $data);
        $this->load->view('layouts/footer');
    }

    // Stats
    private function getDashboardStats()
    {
        $today = date('Y-m-d');

        $stats = [];

        // Total Clients
        $stats['total_clients'] = $this->db
            ->where('role_id', 12)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');

        // Total Centers
        $stats['total_centers'] = $this->db
            ->where('deleted', 0)
            ->count_all_results('tt_center');

        // Today Bookings
        $stats['today_bookings'] = $this->db
            ->where('DATE(created_at)', $today)
            ->where('admin_status', 1)
            ->where('client_status', 1)
            ->where('exam_center_status', 1)
            ->count_all_results('tt_send_booking_request');

        // Upcoming Projects
        $query = $this->db
            ->select('COUNT(DISTINCT project_id) AS total')
            ->from('tt_project_detail')
            ->where('deleted', 0)
            ->where('start_date >', $today)
            ->where_not_in('status', [1, 2])
            ->get();

        $stats['upcoming_projects'] = (int) $query->row()->total;

        // Completed Projects
        $stats['completed_projects'] = $this->db
            ->where('deleted', 0)
            ->where('status', 1)
            ->count_all_results('tt_project_detail');


        // ---------- FINANCIAL YEAR ----------
        $currentYear = date('Y');
        if (date('m') < 4) {
            $startYear = $currentYear - 1;
            $endYear   = $currentYear;
        } else {
            $startYear = $currentYear;
            $endYear   = $currentYear + 1;
        }

        $fyStart = $startYear . '-04-01';
        $fyEnd   = $endYear . '-03-31';

        // Projects in financial year
        $stats['projects_year'] = $this->db
            ->select('COUNT(DISTINCT project_id) AS total')
            ->where('deleted', 0)
            ->where("start_date BETWEEN '$fyStart' AND '$fyEnd'")
            ->get('tt_project_detail')
            ->row()
            ->total ?? 0;

        // Projects in current month
        $monthStart = date('Y-m-01');
        $monthEnd   = date('Y-m-t');

        $stats['current_month_projects'] = $this->db
            ->select('
                p.project_id,
                p.exam_name,
                p.start_date,
                p.end_date,
                p.exam_type,
                p.number_of_seats,
                p.status,
                p.manual_status,
                p.project_remark,
                p.exam_city_id,
                c.company_name,
                c.company_type,
                c.address,
                c.mobile_no,
                cm.city_name,
                au.username
            ')
            ->from('tt_project_detail p')
            ->join('tt_client c', 'c.ac_id = p.client_id', 'left')
            ->join('tt_admin_users au', 'au.id = c.ac_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = p.exam_city_id', 'left')
            ->where('p.deleted', 0)
            ->where('p.start_date >=', $monthStart)
            ->where('p.end_date <=', $monthEnd)
            ->order_by('p.start_date', 'DESC')
            ->limit(20)
            ->get()
            ->result_array();



        $stats['projects_month'] = $this->db
            ->select('COUNT(DISTINCT project_id) AS total')
            ->where('deleted', 0)
            ->where("start_date BETWEEN '$monthStart' AND '$monthEnd'")
            ->get('tt_project_detail')
            ->row()
            ->total ?? 0;


        // Mapped Cities (Distinct city_id)
        $stats['mapped_cities'] = $this->db
            ->select('COUNT(DISTINCT city_id) AS total')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total ?? 0;

        // Country Mapped (Distinct country_id)
        $stats['country_mapped'] = $this->db
            ->select('COUNT(DISTINCT country_id) AS total')
            ->where('deleted', 0)
            ->get('tt_center')
            ->row()
            ->total ?? 0;

        // App download
        $stats['bmtc_app_venue'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 0)
            ->where('api_token IS NOT NULL', null, false)
            ->count_all_results('tt_admin_users');


        // Total Center Owners
        $stats['total_owners'] = $this->db
            ->where('role_id', 9)
            ->where('deleted', 0)
            ->count_all_results('tt_admin_users');


        // Subscribed Owners
        $stats['subscribed_owners'] = $this->db
            ->distinct()
            ->select('us.center_owner_id')
            ->from('user_subscriptions us')
            ->join(
                'tt_admin_users au',
                'au.id = us.center_owner_id',
                'inner'
            )
            ->where('au.role_id', 9)
            ->where('au.deleted', 0)
            ->where('us.is_active', 1)
            ->count_all_results();


        // Non Subscribed Owners
        $stats['non_subscribed_owners'] =
            $stats['total_owners'] - $stats['subscribed_owners'];



        // Allocated Seats
        $seat = $this->db
            ->select_sum('center_seat')
            ->where([
                'exam_center_status' => 1,
                'client_status'      => 1,
                'admin_status'       => 1
            ])
            ->get('tt_send_booking_request')
            ->row();

        $stats['allocated_seats'] = (int)($seat->center_seat ?? 0);

        // Manpower Deployed
        $stats['allocated_manpower'] = 0;

        $projects = $this->db
            ->select("
                start_date,
                end_date,
                status,
                manual_status,

                invigilator_male,
                invigilator_female,
                tech_person_count,
                security_guard_male,
                security_guard_female,
                center_suptn_count
            ")
            ->where('deleted', 0)
            ->get('tt_project_detail')
            ->result();

        foreach ($projects as $project) {
            $status = getProjectStatusText($project);

            // Count only Running & Completed Projects
            if (in_array($status, ['Running', 'Completed'])) {
                $stats['allocated_manpower'] +=
                    (int)$project->invigilator_male +
                    (int)$project->invigilator_female +
                    (int)$project->tech_person_count +
                    (int)$project->security_guard_male +
                    (int)$project->security_guard_female +
                    (int)$project->center_suptn_count;
            }
        }

        return $stats;
    }


    /**
     * Load Admin Profile
     */
    public function profile()
    {
        $admin = $this->session->userdata('admin_user');

        // Fresh data from DB (industry standard)
        $user = $this->db
            ->select('id, username as username, email, mobile_phone')
            ->from('tt_admin_users')
            ->where('id', $admin['id'])
            ->get()
            ->row_array();

        $data = [
            'page_title' => 'My Profile',
            'admin'      => $admin,
            'user'       => $user
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/profile/index', $data);
        $this->load->view('layouts/footer');
    }

    /**
     * Update Admin Profile (POST)
     */
    public function updateProfile()
    {
        // JSON response
        $this->output->set_content_type('application/json');

        // Validation
        $this->form_validation->set_rules('username', 'Username', 'required|trim|min_length[2]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        $this->form_validation->set_rules('mobile_phone', 'Mobile', 'required|numeric|min_length[10]|max_length[15]');

        if ($this->form_validation->run() === FALSE) {
            echo json_encode([
                'status'  => false,
                'message' => strip_tags(validation_errors())
            ]);
            return;
        }

        $admin = $this->session->userdata('admin_user');

        $mobile_phone = $this->input->post('mobile_phone', true);

        // Check mobile number already exists for another admin
        $mobileExists = $this->db
            ->where('mobile_phone', $mobile_phone)
            ->where('id !=', $admin['id'])
            ->count_all_results('tt_admin_users');

        if ($mobileExists > 0) {
            echo json_encode([
                'status'  => false,
                'message' => 'This mobile number is already registered with another account.'
            ]);
            return;
        }

        $updateData = [
            'username'    => $this->input->post('username', true),
            'email'       => $this->input->post('email', true),
            'mobile_phone' => $mobile_phone,
            'updated'     => date('Y-m-d H:i:s')
        ];

        // Update DB
        $this->db
            ->where('id', $admin['id'])
            ->update('tt_admin_users', $updateData);

        // Update session data also
        $admin['username']     = ucwords($updateData['username']);
        $admin['email']        = $updateData['email'];
        $admin['mobile_phone'] = $updateData['mobile_phone'];

        $this->session->set_userdata('admin_user', $admin);

        echo json_encode([
            'status'  => true,
            'message' => 'Profile updated successfully'
        ]);
    }
}
