<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class ClientProjectController extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper(['url']);
        $this->load->model('Common_model');
        $this->load->model('Project_model');
        $this->load->library("Common_options");
        $this->load->helper('project_status');
        $this->load->helper('project_helper');

        // Auth guard
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->check_permission('client_project');
    }

    /**
     * Page load
     */
    public function index()
    {
        $data['page_title'] = 'Client Projects';
        $data['admin'] = $this->session->userdata('admin_user');
        $data['clientData'] = $this->Common_model->getdata_array('tt_admin_users', array('role_id' => 12));

        // Update Project Statuses
        syncProjectStatuses();
        sendExamReminders();

        $today = date('Y-m-d');

        // Total Projects
        $data['total_projects'] = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->where('deleted', 0)
            ->get('tt_project_detail')
            ->row()
            ->total;

        // Upcoming
        $data['upcoming_projects'] = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->where('deleted', 0)
            ->where('manual_status', 0)
            ->where('status', 0)
            ->where('DATE(start_date) >', $today)
            ->get('tt_project_detail')
            ->row()
            ->total;

        // Running
        $data['running_projects'] = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->where('deleted', 0)
            ->where('manual_status', 0)
            ->where('status', 0)
            ->where('DATE(start_date) <=', $today)
            ->where('DATE(end_date) >=', $today)
            ->get('tt_project_detail')
            ->row()
            ->total;

        // Completed
        $data['completed_projects'] = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->where('deleted', 0)
            ->where('status', 1)
            ->get('tt_project_detail')
            ->row()
            ->total;

        // Postponed
        $data['postponed_projects'] = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->where('deleted', 0)
            ->where('manual_status', 1)
            ->get('tt_project_detail')
            ->row()
            ->total;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/index');
        $this->load->view('layouts/footer');
    }

    /**
     * AJAX DataTable
     */
    public function ajaxList()
    {
        $this->output->set_content_type('application/json');

        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value']; // DataTables default search

        // 🔹 Get all filter values
        $global_search = $this->input->post('global_search'); // Our custom global search
        $exam_name = $this->input->post('exam_name');
        $client_id = $this->input->post('client_id');
        $status_filter = $this->input->post('status');
        $from_date = $this->input->post('from');
        $to_date = $this->input->post('to');

        // 🔹 Base query (group by project)
        $this->db->select('
            tt_project_detail.*, 
            tc.company_name,
            tc.company_type,
        ');
        $this->db->from('tt_project_detail tt_project_detail');
        $this->db->join('tt_client tc', 'tc.ac_id = tt_project_detail.client_id', 'left');
        $this->db->where('tt_project_detail.deleted', 0);

        // 🔹 Apply DataTables default search (if used)
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('exam_name', $search);
            $this->db->or_like('client_name', $search);
            $this->db->or_like('project_id', $search);
            $this->db->group_end();
        }

        // 🔹 Apply Client ID filter
        if (!empty($client_id)) {
            $this->db->where('client_id', $client_id);
        }

        // 🔹 Apply Client name filter
        if (!empty($exam_name)) {
            $this->db->like('exam_name', $exam_name);
        }

        // 🔹 Apply Date range filter
        if (!empty($from_date) && !empty($to_date)) {
            $this->db->where("DATE(start_date) BETWEEN '$from_date' AND '$to_date'");
        } elseif (!empty($from_date)) {
            $this->db->where('DATE(start_date) >=', $from_date);
        } elseif (!empty($to_date)) {
            $this->db->where('DATE(end_date) <=', $to_date);
        }


        // 🔹 Apply Status filter
        if (!empty($status_filter)) {

            $today = date('Y-m-d');

            switch ($status_filter) {

                case 'Upcoming':

                    $this->db->where('manual_status', 0);
                    $this->db->where('status', 0);
                    $this->db->where('DATE(start_date) >', $today);

                    break;

                case 'Running':

                    $this->db->where('manual_status', 0);
                    $this->db->where('status', 0);
                    $this->db->where('DATE(start_date) <=', $today);
                    $this->db->where('DATE(end_date) >=', $today);

                    break;

                case 'Postponed':

                    $this->db->where('manual_status', 1);

                    break;

                case 'Completed':

                    $this->db->where('status', 1);

                    break;
            }
        }

        $count_query = clone $this->db;
        $count_query->group_by('project_id');
        $recordsFiltered = $count_query->count_all_results();

        $this->db->group_by('project_id');
        $this->db->order_by('start_date', 'DESC');
        $this->db->limit($length, $start);
        $projects = $this->db->get()->result();

        // 🔹 Get total records count (without filters)
        $recordsTotal = $this->db
            ->select('COUNT(DISTINCT project_id) as total')
            ->from('tt_project_detail')
            ->where('deleted', 0)
            ->get()
            ->row()
            ->total;

        $data = [];

        foreach ($projects as $row) {

            $projectId = $row->project_id;

            $encodedId = rtrim(
                strtr(
                    base64_encode($projectId),
                    '+/',
                    '-_'
                ),
                '='
            );


            // =====================================================
            // SEAT ALLOCATION
            // =====================================================

            $seat = getProjectSeatAllocation(
                $projectId
            );

            $required  = $seat['required'];
            $allocated = $seat['allocated'];
            $percent   = $seat['percent'];


            // =====================================================
            // SEAT PROGRESS
            // =====================================================

            $seatProgress = getSeatProgressHtml(
                $seat
            );


            // =====================================================
            // ALLOCATION STATUS
            // =====================================================

            $requirementStatus =
                $seat['badge'];


            // =====================================================
            // TOTAL CITIES
            // =====================================================

            $totalCity = $this->db
                ->select(
                    'COUNT(DISTINCT exam_city_id) AS total'
                )
                ->where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'deleted',
                    0
                )
                ->get(
                    'tt_project_detail'
                )
                ->row()
                ->total ?? 0;


            // =====================================================
            // PROJECT STATUS
            // =====================================================

            $projectStatus =
                getProjectStatusBadge(
                    $row
                );


            // =====================================================
            // WORK PROGRESS STATUS
            // =====================================================

            $bookFlag =
                (int)($row->book_flag ?? 0);

            $selectedDefault =
                $bookFlag == 0
                ? 'selected'
                : '';

            $selectedWip =
                $bookFlag == 1
                ? 'selected'
                : '';


            // =====================================================
            // ACTION
            // =====================================================

            $action = '

        <a
            href="' . base_url(
                'admin/client-project-detail-list/' .
                    $encodedId
            ) . '"
            class="btn btn-sm btn-success me-1"
            target="_blank"
        >
            View Detail
        </a>

        <select
            class="form-select select2 mt-3 form-select-sm d-inline-block work-progress-status"
            data-project-id="' . $projectId . '"
            style="width:170px;"
        >

            <option
                value="0"
                ' . $selectedDefault . '
            >
                Progress Status (Default)
            </option>

            <option
                value="1"
                ' . $selectedWip . '
            >
                Work In Progress
            </option>

        </select>

    ';


            // =====================================================
            // CHANGE STATUS
            // =====================================================

            if (isProjectUpcoming($row)) {

                $projectStatus .= '

            <button
                class="btn btn-sm btn-warning mt-2 changeProjectStatus"
                data-project_id="' . $projectId . '"
                data-exam="' .
                    htmlspecialchars(
                        $row->exam_name,
                        ENT_QUOTES,
                        'UTF-8'
                    ) . '"
            >
                Change Status
            </button>

        ';
            }


            // =====================================================
            // REMARK
            // =====================================================

            if (!empty($row->project_remark)) {

                $projectStatus .=
                    isHaveAnyRemark(
                        $row->project_remark
                    );
            }


            // =====================================================
            // FINAL DATA
            // =====================================================

            $data[] = [

                'project' =>
                $row->exam_name,


                'client' =>

                ucwords(
                    $row->client_name
                )

                    . '

            <br>

            <a
                href="javascript:void(0)"
                onclick="showProjectInfo(
                    \'' .
                    addslashes(
                        $row->company_name
                    ) . '\',
                    \'' .
                    addslashes(
                        $row->company_type
                    ) . '\',
                    \'' .
                    addslashes(
                        $row->client_name
                    ) . '\',
                    \'' .
                    addslashes(
                        $projectId
                    ) . '\',
                    \'' .
                    addslashes(
                        $row->exam_name
                    ) . '\'
                )"
            >
                Project ID: ' .
                    $projectId .
                    '
            </a>',


                // =================================================
                // SEAT PROGRESS
                // =================================================

                'seat' =>
                $seatProgress,


                // =================================================
                // ALLOCATION STATUS
                // =================================================

                'req_status' =>
                $requirementStatus,


                'exam_date' =>

                date(
                    'd M Y',
                    strtotime(
                        $row->start_date
                    )
                )

                    . ' - ' .

                    date(
                        'd M Y',
                        strtotime(
                            $row->end_date
                        )
                    ),


                'city' =>
                number_format(
                    $totalCity
                ),


                'status' =>
                $projectStatus,


                'action' =>
                $action
            ];
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    // Update Project Book Flag
    public function updateProjectBookFlag()
    {
        $project_id = $this->input->post('project_id');
        $book_flag  = (int)$this->input->post('book_flag');

        if (empty($project_id)) {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid project id'
            ]);
            return;
        }

        // project ke saare detail records update honge
        $this->db->where('project_id', $project_id);
        $updated = $this->db->update('tt_project_detail', [
            'book_flag' => $book_flag
        ]);

        echo json_encode([
            'status' => $updated,
            'message' => $updated ? 'Status updated successfully' : 'Unable to update status'
        ]);
    }

    // Update status
    public function updateProjectStatus()
    {
        $projectId = $this->input->post('project_id');
        $hasFuture = $this->input->post('has_future_date');
        $remark    = trim($this->input->post('remark'));

        if (
            $hasFuture &&
            strtotime($this->input->post('end_date')) < strtotime($this->input->post('start_date'))
        ) {
            echo json_encode([
                'status'  => false,
                'message' => 'End Date cannot be earlier than Start Date.'
            ]);
            return;
        }

        // Get any one project row
        $project = $this->db
            ->where('project_id', $projectId)
            ->limit(1)
            ->get('tt_project_detail')
            ->row();

        if (!$project) {
            echo json_encode([
                'status'  => false,
                'message' => 'Project not found.'
            ]);
            return;
        }

        /* ===========================
           Prepare Update Data
        =========================== */

        $update = [
            'project_remark'  => $remark,
            'has_future_date' => $hasFuture
        ];

        if ($hasFuture) {

            $update['old_start_date'] = $project->start_date;
            $update['old_end_date']   = $project->end_date;

            $update['start_date'] = $this->input->post('start_date');
            $update['end_date']   = $this->input->post('end_date');

            // New future date available
            $update['manual_status'] = 0;
        } else {

            // Postponed without new date
            $update['manual_status'] = 1;
        }

        /* ===========================
           Transaction Start
        =========================== */

        $this->db->trans_begin();

        /* ===========================
           Update Project Detail
        =========================== */

        $this->db
            ->where('project_id', $projectId)
            ->update('tt_project_detail', $update);

        /* ===========================
           Backup Booking Requests
        =========================== */

        $sql = "
            INSERT INTO tt_booking_release_log
            (
                center_id,
                center_seat,
                project_id,
                city_id,
                client_id,
                status,
                reason,
                comment,
                negotiate,
                admin_center_final_price,
                client_status,
                client_accept_booking_date,
                exam_center_status,
                center_booking_accept_date,
                created_at,
                updated_at,
                admin_status,
                admin_remark,
                admin_action_by,
                admin_action_date,
                final_booking_flag,
                re_request_count,
                center_response_date,

                release_type,
                release_reason,
                project_remark,
                released_by,
                released_at
            )

            SELECT

                center_id,
                center_seat,
                project_id,
                city_id,
                client_id,
                status,
                reason,
                comment,
                negotiate,
                admin_center_final_price,
                client_status,
                client_accept_booking_date,
                exam_center_status,
                center_booking_accept_date,
                created_at,
                updated_at,
                admin_status,
                admin_remark,
                admin_action_by,
                admin_action_date,
                final_booking_flag,
                re_request_count,
                center_response_date,

                'Project Postponed',
                'Project Postponed',
                ?,
                ?,
                NOW()

            FROM tt_send_booking_request
            WHERE project_id = ?
        ";


        $adminUser = $this->session->userdata('admin_user');
        $releasedBy = !empty($adminUser['id']) ? $adminUser['id'] : NULL;

        $this->db->query($sql, [
            $remark,
            $this->session->userdata('admin_user')['id'],
            $projectId
        ]);

        if ($this->db->affected_rows() == 0) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => false,
                'message' => 'No booking found to release.'
            ]);
            return;
        }

        /* ===========================
           Delete Active Booking
        =========================== */

        $this->db
            ->where('project_id', $projectId)
            ->delete('tt_send_booking_request');

        /* ===========================
           Release Seat Allocation
           (Replace table name)
        =========================== */

        /*
        $this->db
            ->where('project_id', $projectId)
            ->delete('tt_project_seat_allocation');
        */

        /* ===========================
           Release Manpower
           (Replace table name)
        =========================== */

        /*
        $this->db
            ->where('project_id', $projectId)
            ->delete('tt_project_manpower');
        */

        /* ===========================
           Transaction End
        =========================== */

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => false,
                'message' => 'Something went wrong.'
            ]);
            return;
        }

        $this->db->trans_commit();

        echo json_encode([
            'status'  => true,
            'message' => 'Project postponed successfully.'
        ]);
    }


    /**
     * Custom Export (CSV)
     */
    public function export()
    {
        $filename = "client_projects_" . date('Ymd_His') . ".csv";

        header("Content-Disposition: attachment; filename={$filename}");
        header("Content-Type: text/csv; charset=utf-8");

        $file = fopen('php://output', 'w');

        /*
        |--------------------------------------------------------------------------
        | CSV HEADERS
        |--------------------------------------------------------------------------
        */
        fputcsv($file, [
            'Project ID',
            'Client ID',
            'Client Name',
            'Exam Name',
            'Exam Type',
            'Start Date',
            'End Date',
            'Project Status',
            'State',
            'City',
            'Total Seats',
            'Price Per Seat',
            'Total Batch',

            'Exam Mode',
            'Internet Mode OS',
            'Internet Mode RAM',
            'Internet Mode Processor',
            'Internet Mode Display',
            'Internet Mode Internet Each',

            'Server Mode OS',
            'Server Mode RAM',
            'Server Mode Processor',
            'Server Mode Ratio',
            'Server Mode Internet',

            'Parking Facility',
            'Locker Facility',
            'Waiting Area',
            'Power Backup',
            'PH Handicapped',
            'Printer',

            'Rough Sheet',
            'Partition in Lab',
            'AC in Lab',
            'CCTV Required',
            'CCTV Recording',

            'Center Superintendent Ratio',
            'Tech Person Ratio',
            'Invigilator Ratio',
            'Security Guard Ratio',

            'Tech Person Male',
            'Tech Person Female',
            'Invigilator Male',
            'Invigilator Female',
            'Security Guard Male',
            'Security Guard Female',
            'Center Superintendent Male',
            'Center Superintendent Female'
        ]);

        /*
        |--------------------------------------------------------------------------
        | QUERY
        |--------------------------------------------------------------------------
        */
        $this->db->reset_query();

        $projects = $this->db
            ->select("
                p.project_id,
                p.client_id,
                p.client_name,
                p.exam_name,
                p.exam_type,
                MIN(p.start_date) AS start_date,
                MAX(p.end_date) AS end_date,
                MAX(p.status) AS status,
                MAX(p.manual_status) AS manual_status,

                s.title AS state_name,
                c.city_name,

                SUM(p.number_of_seats) AS total_seats,
                MAX(p.price_per_seat) AS price_per_seat,
                MAX(p.total_batch) AS total_batch,

                MAX(p.exam_mode) AS exam_mode,
                MAX(p.inet_mode_os) AS inet_mode_os,
                MAX(p.inet_mode_ram) AS inet_mode_ram,
                MAX(p.inet_mode_processor) AS inet_mode_processor,
                MAX(p.inet_mode_display) AS inet_mode_display,
                MAX(p.inet_mode_internet_each) AS inet_mode_internet_each,

                MAX(p.server_mode_os) AS server_mode_os,
                MAX(p.server_mode_ram) AS server_mode_ram,
                MAX(p.server_mode_processor) AS server_mode_processor,
                MAX(p.server_mode_ratio) AS server_mode_ratio,
                MAX(p.server_mode_internet) AS server_mode_internet,

                MAX(p.parking_facility) AS parking_facility,
                MAX(p.locker_facility) AS locker_facility,
                MAX(p.waiting_area) AS waiting_area,
                MAX(p.power_backup) AS power_backup,
                MAX(p.ph_handicaped) AS ph_handicaped,
                MAX(p.printer) AS printer,

                MAX(p.rough_sheet) AS rough_sheet,
                MAX(p.partition_in_lab) AS partition_in_lab,
                MAX(p.ac_in_lab) AS ac_in_lab,
                MAX(p.cctv_required) AS cctv_required,
                MAX(p.cctv_recording) AS cctv_recording,

                -- RATIOS (VARCHAR SAFE)
                MAX(CAST(p.center_suptn_count AS CHAR)) AS center_suptn_count,
                MAX(CAST(p.tech_person_count AS CHAR)) AS tech_person_count,
                MAX(CAST(p.invigilator_ratio AS CHAR)) AS invigilator_ratio,
                MAX(CAST(p.security_guard_ratio AS CHAR)) AS security_guard_ratio,

                -- STAFF COUNTS
                SUM(p.tech_person_male) AS tech_person_male,
                SUM(p.tech_person_female) AS tech_person_female,

                SUM(p.invigilator_male) AS invigilator_male,
                SUM(p.invigilator_female) AS invigilator_female,

                SUM(p.security_guard_male) AS security_guard_male,
                SUM(p.security_guard_female) AS security_guard_female,

                SUM(p.center_suptn_male) AS center_suptn_male,
                SUM(p.center_suptn_female) AS center_suptn_female
            ")
            ->from('tt_project_detail p')
            ->join('tt_states s', 's.id = p.state_id', 'left')
            ->join('tt_city_master c', 'c.city_id = p.exam_city_id', 'left')
            ->where('p.deleted', 0)
            ->group_by('p.project_id')
            ->order_by('start_date', 'DESC')
            ->get()
            ->result_array();

        /*
        |--------------------------------------------------------------------------
        | WRITE CSV
        |--------------------------------------------------------------------------
        */
        foreach ($projects as $p) {
            $projectStatus = getProjectStatusText($p);
            fputcsv($file, [
                $p['project_id'],
                $p['client_id'],
                $p['client_name'],
                $p['exam_name'],
                $p['exam_type'],
                date('d-m-Y', strtotime($p['start_date'])),
                date('d-m-Y', strtotime($p['end_date'])),
                $projectStatus,

                $p['state_name'],
                $p['city_name'],

                $p['total_seats'],
                $p['price_per_seat'],
                $p['total_batch'],

                $p['exam_mode'],
                $p['inet_mode_os'],
                $p['inet_mode_ram'],
                $p['inet_mode_processor'],
                $p['inet_mode_display'],
                $p['inet_mode_internet_each'],

                $p['server_mode_os'],
                $p['server_mode_ram'],
                $p['server_mode_processor'],
                $p['server_mode_ratio'],
                $p['server_mode_internet'],

                $p['parking_facility'] ? 'Yes' : 'No',
                $p['locker_facility'] ? 'Yes' : 'No',
                $p['waiting_area'] ? 'Yes' : 'No',
                $p['power_backup'] ? 'Yes' : 'No',
                $p['ph_handicaped'] ? 'Yes' : 'No',
                $p['printer'] ? 'Yes' : 'No',

                $p['rough_sheet'] ? 'Yes' : 'No',
                $p['partition_in_lab'] ? 'Yes' : 'No',
                $p['ac_in_lab'] ? 'Yes' : 'No',
                $p['cctv_required'] ? 'Yes' : 'No',
                $p['cctv_recording'] ? 'Yes' : 'No',

                $p['center_suptn_count'],
                $p['tech_person_count'],
                $p['invigilator_ratio'],
                $p['security_guard_ratio'],

                $p['tech_person_male'],
                $p['tech_person_female'],
                $p['invigilator_male'],
                $p['invigilator_female'],
                $p['security_guard_male'],
                $p['security_guard_female'],
                $p['center_suptn_male'],
                $p['center_suptn_female']
            ]);
        }

        fclose($file);
        exit;
    }

    // =================Client Project Detail===============
    public function clientProjectDetailList($projectcId = NULL)
    {
        if (empty($projectcId)) {
            show_404();
        }
        $data['projectId'] = $projectcId;

        $projectcId = strtr($projectcId, '-_', '+/');
        $projectId = base64_decode($projectcId);

        // 🔹 Get project info
        $data['all_project_info'] =
            $this->Project_model->select_project_without_groupby($projectId);

        // 🔹 City wise summary
        $data['cityWiseSummary'] = $this->db->query("
            SELECT
                c.city_name,
                pd.exam_city_id,
                SUM(pd.number_of_seats) AS total_seats,

                (
                    SELECT IFNULL(SUM(sbr.center_seat),0)
                    FROM tt_send_booking_request sbr
                    WHERE sbr.project_id = pd.project_id
                    AND sbr.city_id = pd.exam_city_id
                    AND sbr.client_status = 1
                    AND sbr.exam_center_status = 1
                    AND sbr.admin_status = 1
                ) AS booked_seats

            FROM tt_project_detail pd
            LEFT JOIN tt_city_master c
                ON c.city_id = pd.exam_city_id

            WHERE pd.project_id = ?
            AND pd.deleted = 0

            GROUP BY
                pd.exam_city_id,
                c.city_name
        ", [$projectId])->result_array();

        $data['batchStatistics'] = $this
            ->Common_model
            ->getProjectBatchStatistics(
                $projectId
            );

        $data['changeLogs'] = $this->db

            ->select('
                pcl.*,
                cm.city_name
            ')

            ->from('tt_project_change_log pcl')

            ->join(
                'tt_city_master cm',
                'cm.city_id = pcl.city_id',
                'left'
            )

            ->where('pcl.project_id', $projectId)

            ->where('pcl.is_read', 0)

            ->order_by('pcl.id', 'DESC')

            ->get()

            ->result();

        $data['page_title'] = 'Projects Detailing';
        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/project-detailing');
        $this->load->view('layouts/footer');
    }


    // Update Global Price
    public function updateAdminSeatPrice()
    {
        $projectId = $this->input->post('project_id');
        $cityId    = $this->input->post('exam_city_id');
        $price     = $this->input->post('admin_price_per_seat');

        if (empty($projectId) || empty($cityId) || $price === '') {
            echo json_encode([
                'status' => false,
                'message' => 'Invalid price data.'
            ]);
            exit;
        }

        $this->db->trans_begin();

        $this->db->where('project_id', $projectId);
        $this->db->where('exam_city_id', $cityId);
        $this->db->update('tt_project_detail', [
            'admin_price_per_seat' => $price
        ]);

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            echo json_encode([
                'status' => false,
                'message' => 'Something went wrong. Please try again.'
            ]);
        } else {

            $this->db->trans_commit();

            echo json_encode([
                'status' => true,
                'message' => 'Admin price per seat updated successfully.'
            ]);
        }

        exit;
    }


    // Find Center
    public function findExamCenter($encodedProjectId = NULL, $cityId = NULL)
    {
        // ❌ Invalid URL
        if (empty($encodedProjectId) || empty($cityId)) {
            show_404();
        }

        $urlSafeProjectId = $encodedProjectId;

        // 🔓 URL-safe base64 decode
        $encodedProjectId = strtr($encodedProjectId, '-_', '+/');

        // Restore removed padding
        $padding = strlen($encodedProjectId) % 4;
        if ($padding) {
            $encodedProjectId .= str_repeat(
                '=',
                4 - $padding
            );
        }

        $projectId = base64_decode(
            $encodedProjectId,
            true
        );

        // Validate decoded value
        if ($projectId === false || empty($projectId)) {
            show_error('Invalid Project ID');
        }

        /**
         * ===============================
         * Filters (GET based, clean)
         * ===============================
         */
        $filters = [
            'city' => $this->input->get('city', TRUE),
            'capacity' => $this->input->get('capacity', TRUE),
            'center_name' => $this->input->get('center_name', TRUE),
            'owner' => $this->input->get('owner', TRUE),
            'subscription_status' => $this->input->get('subscription_status', TRUE),
            'monitor_type' => $this->input->get('monitor_type', TRUE),
            'ram' => $this->input->get('ram', TRUE),
            'switch_category' => $this->input->get('switch_category', TRUE),
            'hdd' => $this->input->get('hdd', TRUE),
            'operating_system' => $this->input->get('operating_system', TRUE),
            'ethernet_company' => $this->input->get('ethernet_company', TRUE),
            'no_of_each_ethernet_ports' => $this->input->get('no_of_each_ethernet_ports', TRUE)
        ];

        /**
         * ===============================
         * Project info (safe query)
         * ===============================
         */
        $projectInfo = $this->db
            ->select('exam_name, client_name, number_of_seats,admin_price_per_seat')
            ->from('tt_project_detail')
            ->where([
                'project_id' => $projectId,
                'exam_city_id' => $cityId,
                'deleted' => 0
            ])
            ->get()
            ->row();

        if (!$projectInfo) {
            show_error('Project not found for selected city.');
        }

        /**
         * ===============================
         * Center listing (existing model)
         * ===============================
         */
        $data['manage_project_infos'] = $this->Project_model->search_all_exam_center(
            $projectId,
            $cityId,
            $filters['city'],
            $filters['capacity'],
            $filters['center_name'],
            $filters['owner'],
            $filters['subscription_status'],
            $filters['monitor_type'],
            $filters['ram'],
            $filters['switch_category'],
            $filters['hdd'],
            $filters['operating_system'],
            $filters['ethernet_company'],
            $filters['no_of_each_ethernet_ports']
        );

        /**
         * ===============================
         * View Data
         * ===============================
         */
        $data['project'] = $projectInfo;

        $data['project_batches'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $cityId)
            ->order_by('batch_no')
            ->get('tt_project_batch_detail')
            ->result_array();

        $data['batchStatistics'] = $this
            ->Common_model
            ->getProjectBatchStatistics(
                $projectId,
                $cityId
            );

        $data['filters'] = $filters;

        $data['page_title'] = 'Find Exam Center';
        $data['admin'] = $this->session->userdata('admin_user');
        $data['encodedProjectId'] = $urlSafeProjectId;
        $data['cityId'] = $cityId;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/find-exam-center');
        $this->load->view('layouts/footer');
    }


    // Send Booking Request
    public function sendBookingRequest($encodedProjectId = NULL, $cityId = NULL, $centerId = NULL)
    {
        // Invalid params
        if (!$encodedProjectId || !$cityId || !$centerId) {
            show_404();
        }

        // Decode URL-safe base64 project ID
        $encodedProjectId = strtr($encodedProjectId, '-_', '+/');

        // Restore removed padding
        $padding = strlen($encodedProjectId) % 4;
        if ($padding) {
            $encodedProjectId .= str_repeat(
                '=',
                4 - $padding
            );
        }

        $projectId = base64_decode(
            $encodedProjectId,
            true
        );

        // Validate decoded value
        if ($projectId === false || empty($projectId)) {
            show_error('Invalid Project ID');
        }

        $admin_price = $this->input->post('admin_price');
        $center_seat = (int)$this->input->post('center_seat');

        $batchData = json_decode(
            $this->input->post('batch_data'),
            true
        );

        /**
         * ======================================
         * 1. Get project details
         * ======================================
         */
        $project = $this->db
            ->select('exam_name, client_name, client_id, admin_price_per_seat')
            ->from('tt_project_detail')
            ->where('project_id', $projectId)
            ->get()
            ->row();

        if (!$project) {
            show_error('Project not found');
        }

        /**
         * ======================================
         * 2. Get center + owner details
         * ======================================
         */
        $center = $this->db
            ->select('c.center_name,c.capacity,c.owner_user_id, a.email, a.first_name, a.last_name')
            ->from('tt_center c')
            ->join('tt_admin_users a', 'a.id = c.owner_user_id')
            ->where('c.center_id', $centerId)
            ->get()
            ->row();

        if (!$center) {
            show_error('Center not found');
        }


        /*
        ======================================
        Per Batch Capacity Validation
        ======================================
        */

        if (empty($batchData)) {

            echo json_encode([
                'status'  => 'fail',
                'message' => 'Please allocate batch wise seats.'
            ]);

            exit;
        }

        $totalSeat = 0;

        foreach ($batchData as $batch) {

            $batchSeat = (int)$batch['center_seat'];

            // Negative / zero validation
            if ($batchSeat < 0) {

                echo json_encode([
                    'status'  => 'fail',
                    'message' => 'Invalid batch seat allocation.'
                ]);

                exit;
            }

            // Batch cannot exceed center capacity
            if ($batchSeat > (int)$center->capacity) {

                echo json_encode([
                    'status'  => 'fail',
                    'message' => 'Batch ' . $batch['batch_no'] .
                        ' allocation cannot exceed center capacity (' .
                        $center->capacity . ').'
                ]);

                exit;
            }

            $totalSeat += $batchSeat;
        }

        // Keep summary seat synced with batches
        $center_seat = $totalSeat;

        // Final validation
        if ($center_seat <= 0) {

            echo json_encode([
                'status'  => 'fail',
                'message' => 'Please allocate at least one seat.'
            ]);

            exit;
        }

        /**
         * ======================================
         * Check latest booking request
         * ======================================
         */

        $oldRequest = $this->db
            ->where([
                'project_id' => $projectId,
                'city_id'    => $cityId,
                'center_id'  => $centerId
            ])
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('tt_send_booking_request')
            ->row();

        $reRequestCount = 0;

        /**
         * ======================================
         * Booking workflow validation
         * ======================================
         */

        if ($oldRequest) {

            /*
            |--------------------------------------------------------------------------
            | Already Fully Assigned
            |--------------------------------------------------------------------------
            */

            if (
                $oldRequest->exam_center_status == 1 &&
                $oldRequest->admin_status == 1 &&
                $oldRequest->client_status == 1
            ) {

                echo json_encode([
                    'status'  => 'fail',
                    'message' => 'This center is already assigned to this project.'
                ]);
                exit;
            }

            /*
            |--------------------------------------------------------------------------
            | Center Rejected
            |--------------------------------------------------------------------------
            */

            if ($oldRequest->exam_center_status == 2) {

                $reRequestCount =
                    ((int)$oldRequest->re_request_count) + 1;
            }

            /*
            |--------------------------------------------------------------------------
            | Client Rejected
            |--------------------------------------------------------------------------
            */ elseif ($oldRequest->client_status == 2) {

                $reRequestCount =
                    ((int)$oldRequest->re_request_count) + 1;
            }

            /*
            |--------------------------------------------------------------------------
            | Active Request Exists
            |--------------------------------------------------------------------------
            */ else {

                echo json_encode([
                    'status'  => 'fail',
                    'message' => 'Booking request already exists.'
                ]);
                exit;
            }
        }

        /**
         * ======================================
         * Save booking request
         * ======================================
         */
        $this->db->trans_begin();

        $save = [

            'center_id' => $centerId,

            'center_seat' => $center_seat,

            'project_id' => $projectId,

            'city_id' => $cityId,

            'client_id' => $project->client_id ?? 0,

            'admin_center_final_price' => $admin_price,

            'status' => 1,

            'client_status' => 0,

            'exam_center_status' => 0,

            'admin_status' => 0,

            're_request_count' => $reRequestCount,

            'created_at' => date('Y-m-d H:i:s'),

            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->insert(
            'tt_send_booking_request',
            $save
        );

        $requestId = $this->db->insert_id();

        if (!empty($batchData)) {

            foreach ($batchData as $batch) {

                $this->db->insert(
                    'tt_send_booking_request_batch',
                    [

                        'request_id' => $requestId,

                        'project_id' => $projectId,

                        'center_id' => $centerId,

                        'city_id' => $cityId,

                        'batch_no' => $batch['batch_no'],

                        'required_seat' => $batch['required_seat'],

                        'center_seat' => $batch['center_seat'],

                        'created_at' => date('Y-m-d H:i:s'),

                        'updated_at' => date('Y-m-d H:i:s')

                    ]
                );
            }
        }


        /**
         * ======================================
         * 5. Email notification (OLD TEMPLATE)
         * ======================================
         */
        $email_subject = 'New Booking Request - ' . $project->exam_name;

        $email_content = '
            <html>
            <head>
                <style>
                    body { font-family: Arial, sans-serif; line-height: 1.6; }
                    .header { color: #2c3e50; }
                    .details { background: #f9f9f9; padding: 15px; border-radius: 5px; }
                </style>
            </head>
            <body>
                <h2 class="header">New Booking Request</h2>

                <p>Dear ' . htmlspecialchars($center->first_name . ' ' . $center->last_name) . ',</p>

                <p>
                    You have received a new booking request for your center
                    <strong>' . htmlspecialchars($center->center_name) . '</strong>.
                </p>

                <div class="details">
                    <p><strong>Exam Name:</strong> ' . htmlspecialchars($project->exam_name) . '</p>
                    <p><strong>Client:</strong> ' . htmlspecialchars($project->client_name) . '</p>
                    <p><strong>Request Date:</strong> ' . date('d M Y, h:i A') . '</p>
                </div>

                <p>Please log in to your portal to accept or reject this booking request.</p>
            </body>
            </html>
        ';

        $send = send_email(
            $email_content,
            $email_subject,
            $center->email,
            "centerbooking@bookmytestcenter.com"
        );


        /**
         * ======================================
         * Center Notification (NEW BOOKING REQUEST)
         * ======================================
         */

        // Get city name
        $cityName = $this->db
            ->select('city_name')
            ->from('tt_city_master')
            ->where('city_id', $cityId)
            ->get()
            ->row()
            ->city_name ?? 'N/A';

        // Notification title & message
        $notification_title = 'New Booking Request';

        $notification_message = sprintf(
            'You have received a new booking request for Exam: %s from Client: %s (City: %s)',
            $project->exam_name,
            $project->client_name,
            $cityName
        );

        // Prepare notification data (FOR CENTER)
        $notification_data = [
            'admin_user_id' => $center->owner_user_id,
            'center_id' => $centerId,
            'client_id' => $project->client_id ?? null,
            'title' => $notification_title,
            'message' => $notification_message,
            'type' => 'center',
            'is_read' => 0,
            'is_remove' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Insert notification
        $this->db->insert('notifications', $notification_data);


        /**
         * ======================================
         * 6. Flash + redirect back
         * ======================================
         */
        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();

            echo json_encode([
                'status'  => 'fail',
                'message' => 'Something went wrong.'
            ]);
        } else {

            $this->db->trans_commit();

            // Firebase notification AFTER successful commit
            $this->load->library('NotificationService');

            $tokens = $this->FirebaseNotification_model
                ->getActiveTokensByUserId($center->owner_user_id);

            if (!empty($tokens)) {

                $this->notificationservice->sendNotification(
                    'New Booking Request',
                    $notification_message,
                    null,
                    $requestId,
                    'booking_assigned',
                    'booking_detail',
                    $tokens
                );
            }

            $this->session->set_flashdata(
                'success',
                'Booking request sent successfully!'
            );

            echo json_encode([
                'status'  => 'pass',
                'message' => 'Booking request sent successfully!'
            ]);
        }
    }


    public function checkBookingRequestStatus($encodedProjectId = NULL, $cityId = NULL)
    {
        if (!$encodedProjectId || !$cityId) {
            show_404();
        }

        /**
         * ===============================
         * Decode URL-safe base64 project ID
         * ===============================
         */

        // 🔓 URL-safe base64 decode
        $encodedProjectId = strtr($encodedProjectId, '-_', '+/');

        // Restore removed padding
        $padding = strlen($encodedProjectId) % 4;
        if ($padding) {
            $encodedProjectId .= str_repeat(
                '=',
                4 - $padding
            );
        }

        $projectId = base64_decode(
            $encodedProjectId,
            true
        );

        if ($projectId === false || empty($projectId)) {
            show_error('Invalid Project ID');
        }

        /**
         * ===============================
         * Project info (same as old panel)
         * ===============================
         */
        $project = $this->db
            ->select('exam_name, client_name')
            ->from('tt_project_detail')
            ->where([
                'project_id' => $projectId,
                'exam_city_id' => $cityId,
                'deleted' => 0
            ])
            ->get()
            ->row();

        if (!$project) {
            show_error('Project not found for selected city.');
        }

        /**
         * ===============================
         * Booking request list (MODEL)
         * ===============================
         */
        $this->load->model('Booking_model');

        $type = $this->input->get('type');

        if (empty($type)) {
            $type = 'current';
        }

        $data['currentType'] = $type;

        $data['booking_requests'] =
            $this->Project_model->getBookingRequestStatusList($projectId, $cityId, $type);



        /**
         * ==========================================
         * Booking Summary & Financial Summary
         * ==========================================
         */

        $summary = $this->db
            ->select("
                COUNT(sbr.id) as total_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN 1
                        ELSE 0
                    END
                ) as approved_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 0
                        THEN 1
                        ELSE 0
                    END
                ) as pending_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 2
                        THEN 1
                        ELSE 0
                    END
                ) as rejected_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 3
                        THEN 1
                        ELSE 0
                    END
                ) as hold_centers,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN sbr.center_seat
                        ELSE 0
                    END
                ) as allocated_seats,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN
                            (
                                sbr.center_seat *
                                pd.price_per_seat
                            )
                        ELSE 0
                    END
                ) as client_amount,

                SUM(
                    CASE
                        WHEN sbr.admin_status = 1
                        THEN
                            (
                                sbr.center_seat *
                                IFNULL(
                                    sbr.admin_center_final_price,
                                    pd.admin_price_per_seat
                                )
                            )
                        ELSE 0
                    END
                ) as center_amount
            ")

            ->from('tt_send_booking_request sbr')

            ->join(
                'tt_project_detail pd',
                'pd.project_id = sbr.project_id
                AND pd.exam_city_id = sbr.city_id',
                'left'
            )

            ->where('sbr.project_id', $projectId)

            ->where('sbr.city_id', $cityId)

            ->get()

            ->row();

        $requiredSeats = (int)$this->db
            ->select('number_of_seats')
            ->where('project_id', $projectId)
            ->where('exam_city_id', $cityId)
            ->get('tt_project_detail')
            ->row()
            ->number_of_seats;

        $allocatedSeats = min(
            $requiredSeats,
            (int)$summary->allocated_seats
        );

        $remainingSeats = max(
            0,
            $requiredSeats - $allocatedSeats
        );

        $completion = 0;

        if ($requiredSeats > 0) {
            $completion =
                round(
                    ($allocatedSeats / $requiredSeats)
                        * 100
                );
        }

        $data['booking_summary'] = [

            'required_seats'      => $requiredSeats,

            'allocated_seats'     => $allocatedSeats,

            'remaining_seats'     => $remainingSeats,

            'completion'          => $completion,

            'total_centers'       => $summary->total_centers,

            'approved_centers'    => $summary->approved_centers,

            'pending_centers'     => $summary->pending_centers,

            'rejected_centers'    => $summary->rejected_centers,

            'hold_centers'        => $summary->hold_centers,

            'client_amount'       => $summary->client_amount,

            'center_amount'       => $summary->center_amount,

            'expected_profit'     =>
            $summary->client_amount
                -
                $summary->center_amount

        ];

        /**
         * ===============================
         * View data
         * ===============================
         */
        $data['project'] = $project;
        $data['cityId'] = $cityId;
        $data['page_title'] =
            "Booking Request List: {$project->exam_name} (Client: {$project->client_name})";

        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/booking-request-status', $data);
        $this->load->view('layouts/footer');
    }


    public function updateAdminBookingStatus()
    {

        $id = $this->input
            ->post('id');

        $status = $this->input
            ->post('status');

        $remark = $this->input
            ->post('remark') ?? 'Approved by Admin';

        $admin =

            $this->session
            ->userdata(
                'admin_user'
            );


        $update = [

            'admin_status' => $status,

            'admin_remark' => $remark,

            'admin_action_by' => $admin['id'],

            'admin_action_date' => date('Y-m-d H:i:s')

        ];


        $this->db
            ->where(
                'id',
                $id
            );

        $this->db
            ->update(

                'tt_send_booking_request',

                $update

            );

        echo json_encode([

            'status' => 'success'

        ]);
    }


    public function bulkApproveBooking()
    {

        $ids = $this->input
            ->post(
                'booking_ids'
            );

        if (
            empty($ids)
        ) {

            echo json_encode([

                'status' => 'error'

            ]);

            return;
        }

        $this->db
            ->where_in(

                'id',

                $ids

            );

        $this->db
            ->update(

                'tt_send_booking_request',

                [

                    'admin_status' => 1,

                    'admin_action_by' =>

                    $this->session
                        ->userdata(
                            'admin_user'
                        )['id'],

                    'admin_action_date' =>

                    date(
                        'Y-m-d H:i:s'

                    )

                ]

            );

        echo json_encode([

            'status' => 'success'

        ]);
    }


    public function updateSendBookingPrice()
    {
        $request_id = $this->input->post('request_id');
        $price = $this->input->post('admin_center_final_price');

        if (!$request_id || !$price) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            exit;
        }

        $this->db->where('id', $request_id)
            ->update('tt_send_booking_request', [
                'admin_center_final_price' => $price,
                'exam_center_status' => 4, // Admin Revised Price
                'updated_at' => date('Y-m-d H:i:s')
            ]);


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
            ->where('sbr.id', $request_id)
            ->get()
            ->row();


        // Prepare negotiation email content
        $email_subject = "Update on Price Negotiation – " . $booking_details->exam_name . " | " . $booking_details->center_name;

        $email_content = '
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color:#333; }
                .header { color: #2c3e50; }
                .content { margin: 20px 0; }
                .details { background: #f9f9f9; padding: 15px; border-radius: 5px; margin-bottom:15px; }
                .highlight { background: #e8f4fd; padding: 15px; border-left: 4px solid #3498db; margin: 15px 0; }
                .footer { margin-top: 30px; font-size: 0.9em; color: #7f8c8d; }
            </style>
        </head>
        <body>

            <h2 class="header">Price Negotiation Update</h2>
            
            <div class="content">
                <p>Dear ' . htmlspecialchars($booking_details->center_name) . ' Team,</p>
                
                <p>
                    This is to inform you that the price negotiation request submitted by your center 
                    has been reviewed and processed by the Admin team.
                </p>

                <div class="highlight">
                    <strong>The revised pricing details have been updated in your center portal.</strong><br>
                    Kindly login to your dashboard to review the updated information and proceed accordingly.
                </div>

                <div class="details">
                    <h3>Project Details:</h3>
                    <p><strong>Exam Name:</strong> ' . htmlspecialchars($booking_details->exam_name) . '</p>
                    <p><strong>Client Name:</strong> ' . htmlspecialchars($booking_details->client_name) . '</p>
                </div>

                <div class="details">
                    <h3>Center Details:</h3>
                    <p><strong>Center Name:</strong> ' . htmlspecialchars($booking_details->center_name) . '</p>
                    <p><strong>Registered Email:</strong> ' . htmlspecialchars($booking_details->center_owner_email) . '</p>
                    <p><strong>Contact Number:</strong> ' . htmlspecialchars($booking_details->center_owner_mobile) . '</p>
                    <p><strong>Address:</strong> ' . htmlspecialchars($full_address) . '</p>
                </div>

                <p>
                    If you have any further queries, please feel free to reach out to the Admin team.
                </p>

                <p>Thank you for your cooperation.</p>

                <div class="footer">
                    Regards,<br>
                    <strong>Testpan India Team</strong><br>
                    BookMyTestCenter
                </div>
            </div>

        </body>
        </html>
        ';

        // Send email to center owner
        $send = send_email(
            $email_content,
            $email_subject,
            $booking_details->center_owner_email,
            "centerbooking@bookmytestcenter.com"
        );

        $this->session->set_flashdata('success', 'Price updated successfully');

        echo json_encode([
            'status' => 'success',
            'message' => 'Price updated successfully'
        ]);
        exit;
    }


    public function projectOverview($projId = null, $cityId = null)
    {
        if (empty($projId)) {
            show_404();
        }

        $projectId = base64_decode($projId);

        $this->db->select('
            pd.*, 
            c.city_name, 
            s.title as state_name,
            tc.company_name,
            tc.company_type,
            tc.logo,
            tc.address,
        ');
        $this->db->from('tt_project_detail pd');
        $this->db->join('tt_city_master c', 'c.city_id = pd.exam_city_id', 'left');
        $this->db->join('tt_states s', 's.id = pd.state_id', 'left');
        $this->db->join('tt_client tc', 'tc.ac_id = pd.client_id', 'left');
        $this->db->where('pd.project_id', $projectId);
        if (!empty($cityId)) {
            $this->db->where('pd.exam_city_id', $cityId);
        }
        $this->db->where('pd.deleted', 0);

        $project = $this->db->get()->row();

        if (!$project) {
            show_404();
        }

        $data['project'] = $project;

        $data['project_batches'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->order_by('batch_no')
            ->get('tt_project_batch_detail')
            ->result();

        // ================= PROJECT OVERVIEW STATS =================

        $data['project_stats'] = [];

        // Total Centers
        $data['project_stats']['total_centers'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->count_all_results('tt_send_booking_request');

        // Approved Centers
        $data['project_stats']['approved_centers'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('exam_center_status', 1)
            ->count_all_results('tt_send_booking_request');

        // Pending Centers
        $data['project_stats']['pending_centers'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('exam_center_status', 0)
            ->count_all_results('tt_send_booking_request');

        // Rejected Centers
        $data['project_stats']['rejected_centers'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('exam_center_status', 2)
            ->count_all_results('tt_send_booking_request');

        // Hold Centers
        $data['project_stats']['hold_centers'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 3)
            ->count_all_results('tt_send_booking_request');

        // Negotiation Requests
        $data['project_stats']['negotiation_requests'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('exam_center_status', 3)
            ->count_all_results('tt_send_booking_request');


        // ================= BOOKING SUMMARY =================

        $data['booking_summary'] = [];

        $data['booking_summary']['total_requests'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->count_all_results('tt_send_booking_request');

        $data['booking_summary']['approved'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 1)
            ->count_all_results('tt_send_booking_request');

        $data['booking_summary']['pending'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 0)
            ->count_all_results('tt_send_booking_request');

        $data['booking_summary']['rejected'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 2)
            ->count_all_results('tt_send_booking_request');

        $data['booking_summary']['hold'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 3)
            ->count_all_results('tt_send_booking_request');


        // ================= ASSIGNED CENTERS =================

        $this->db
            ->select("
                sbr.*,
                tc.center_name,
                tc.capacity,
                tc.city_id,
                tc.owner_user_id,
                cm.city_name,
                au.first_name,
                au.last_name,
                au.email as owner_email,
                au.mobile_phone as owner_mobile,
            ")
            ->from('tt_send_booking_request sbr')
            ->join('tt_center tc', 'tc.center_id = sbr.center_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = tc.city_id', 'left')
            ->join('tt_admin_users au', 'au.id = tc.owner_user_id', 'left')
            ->where('sbr.project_id', $projectId)
            ->where('sbr.city_id', $project->exam_city_id);

        $data['assigned_centers'] = $this->db->get()->result();

        // ================= CENTER ALLOCATION TIMELINE =================

        $this->db
            ->select("
                sbr.*,
                tc.center_name,
                tc.capacity,
                cm.city_name
            ")
            ->from('tt_send_booking_request sbr')
            ->join('tt_center tc', 'tc.center_id = sbr.center_id', 'left')
            ->join('tt_city_master cm', 'cm.city_id = tc.city_id', 'left')
            ->where('sbr.project_id', $projectId)
            ->order_by('sbr.id', 'DESC');

        $data['allocation_timeline'] = $this->db->get()->result();


        // ================= SEAT FULFILLMENT =================
        $allocatedSeats = $this->db
            ->select_sum('center_seat')
            ->from('tt_send_booking_request')
            ->where('project_id', $projectId)
            ->where('city_id', $project->exam_city_id)
            ->where('admin_status', 1)
            ->where('exam_center_status', 1)
            ->where('client_status', 1)
            ->get()
            ->row()
            ->center_seat;

        $allocatedSeats = (int) ($allocatedSeats ?? 0);

        $requiredSeats = (int) $project->number_of_seats;

        /*
        |--------------------------------------------------------------------------
        | Never show booked seats more than required seats
        |--------------------------------------------------------------------------
        */
        $bookedSeats = min($allocatedSeats, $requiredSeats);

        $remainingSeats = max(0, $requiredSeats - $bookedSeats);

        $progress = ($requiredSeats > 0)
            ? min(100, round(($bookedSeats / $requiredSeats) * 100))
            : 0;

        $data['seat_summary'] = [
            'required'  => $requiredSeats,
            'booked'    => $bookedSeats,
            'remaining' => $remainingSeats,
            'progress'  => $progress
        ];

        $data['projId'] = $projId;
        $data['exam_city_id'] = $cityId;
        $data['page_title'] = "Client Project Detail : " . ucwords($project->exam_name);
        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/project-overview', $data);
        $this->load->view('layouts/footer');
    }

    public function viewProjectDetails($projId = null, $cityId = null)
    {
        if (empty($projId)) {
            show_404();
        }

        $projectId = base64_decode($projId);

        $this->db->select('
            pd.*, 
            c.city_name, 
            s.title as state_name,
            tc.company_name,
            tc.company_type,
            tc.logo,
            tc.address,
        ');
        $this->db->from('tt_project_detail pd');
        $this->db->join('tt_city_master c', 'c.city_id = pd.exam_city_id', 'left');
        $this->db->join('tt_states s', 's.id = pd.state_id', 'left');
        $this->db->join('tt_client tc', 'tc.ac_id = pd.client_id', 'left');
        $this->db->where('pd.project_id', $projectId);
        $this->db->where('pd.deleted', 0);

        $project = $this->db->get()->row();

        if (!$project) {
            show_404();
        }

        $data['project'] = $project;

        $data['project_batches'] = $this->db
            ->where('project_id', $projectId)
            ->where('city_id', $cityId)
            ->order_by('batch_no')
            ->get('tt_project_batch_detail')
            ->result();

        $data['page_title'] = "Project Overview : " . ucwords($project->exam_name);
        $data['admin'] = $this->session->userdata('admin_user');

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project/view-project-detail', $data);
        $this->load->view('layouts/footer');
    }
}
