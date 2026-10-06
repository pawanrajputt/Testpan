<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class ClientProjectPlannerController extends MY_Controller
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
        $data['page_title'] = 'Client Projects Search';
        $data['admin'] = $this->session->userdata('admin_user');

        $data['clientData'] = $this->Common_model->getdata_array('tt_admin_users', array('role_id' => 12));

        $data['cities'] = $this->db
            ->order_by('city_name', 'ASC')
            ->get('tt_city_master')
            ->result();

        $data['states'] = $this->db
            ->order_by('title', 'ASC')
            ->get('tt_states')
            ->result();

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/client_project_planner/index');
        $this->load->view('layouts/footer');
    }

    // Ajax
    public function ajaxPlannerList()
    {
        $today = date('Y-m-d');

        $examName         = trim($this->input->post('exam_name'));
        $clientId         = trim($this->input->post('client_id'));
        $cityId           = trim($this->input->post('city_id'));
        $projectStatus    = trim($this->input->post('project_status'));
        $allocationStatus = trim($this->input->post('allocation_status'));
        $seatRange        = trim($this->input->post('seat_range'));
        $fromDate         = trim($this->input->post('from_date'));
        $toDate           = trim($this->input->post('to_date'));

        /*
    |--------------------------------------------------------------------------
    | Project Wise Query
    |--------------------------------------------------------------------------
    | One project can have multiple cities.
    | So all city rows are combined using project_id.
    */

        $this->db
            ->select("
            pd.project_id,
            pd.client_id,

            COUNT(DISTINCT pd.exam_city_id) AS total_cities,

            MAX(pd.client_name) AS client_name,
            MAX(pd.exam_name) AS exam_name,

            MIN(pd.start_date) AS start_date,
            MAX(pd.end_date) AS end_date,

            SUM(pd.number_of_seats) AS number_of_seats,

            MAX(pd.project_remark) AS project_remark,
            MAX(pd.status) AS status,
            MAX(pd.manual_status) AS manual_status,

            SUM(pd.invigilator_male) AS invigilator_male,
            SUM(pd.invigilator_female) AS invigilator_female,

            SUM(pd.security_guard_male) AS security_guard_male,
            SUM(pd.security_guard_female) AS security_guard_female,

            SUM(pd.tech_person_count) AS tech_person_count,
            SUM(pd.center_suptn_count) AS center_suptn_count,

            MAX(pd.invigilator_ratio) AS invigilator_ratio,

            MAX(tc.company_name) AS company_name,
            MAX(tc.company_type) AS company_type,

            MAX(tau.username) AS username,
            MAX(tau.email) AS email,
            MAX(tau.mobile_phone) AS mobile_phone,

            MIN(pd.exam_city_id) AS action_city_id
        ")
            ->from('tt_project_detail pd')

            ->join(
                'tt_client tc',
                'tc.ac_id = pd.client_id',
                'left'
            )

            ->join(
                'tt_admin_users tau',
                'tau.id = pd.client_id',
                'left'
            )

            ->where('pd.deleted', 0);


        /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

        if (!empty($examName)) {
            $this->db->like('pd.exam_name', $examName);
        }

        if (!empty($clientId)) {
            $this->db->where('pd.client_id', $clientId);
        }

        /*
     * City is only used as a FILTER.
     * We do NOT display/group by city.
     */
        if (!empty($cityId)) {
            $this->db->where('pd.exam_city_id', $cityId);
        }

        if (!empty($fromDate)) {
            $this->db->where('pd.start_date >=', $fromDate);
        }

        if (!empty($toDate)) {
            $this->db->where('pd.end_date <=', $toDate);
        }


        /*
    |--------------------------------------------------------------------------
    | Project Wise Group
    |--------------------------------------------------------------------------
    */

        $this->db->group_by('pd.project_id');


        /*
    |--------------------------------------------------------------------------
    | Seat Range
    |--------------------------------------------------------------------------
    | Since seats are SUM of all cities, filter after grouping.
    |--------------------------------------------------------------------------
    */

        if (!empty($seatRange)) {

            switch ($seatRange) {

                case '1-250':

                    $this->db->having(
                        'SUM(pd.number_of_seats) <=',
                        250
                    );

                    break;


                case '251-500':

                    $this->db->having(
                        'SUM(pd.number_of_seats) >=',
                        251
                    );

                    $this->db->having(
                        'SUM(pd.number_of_seats) <=',
                        500
                    );

                    break;


                case '501-1000':

                    $this->db->having(
                        'SUM(pd.number_of_seats) >=',
                        501
                    );

                    $this->db->having(
                        'SUM(pd.number_of_seats) <=',
                        1000
                    );

                    break;


                case '1000+':

                    $this->db->having(
                        'SUM(pd.number_of_seats) >',
                        1000
                    );

                    break;
            }
        }


        /*
    |--------------------------------------------------------------------------
    | Order
    |--------------------------------------------------------------------------
    */

        $projects = $this->db
            ->order_by('pd.project_id', 'DESC')
            ->get()
            ->result();


        $data = [];


        /*
    |--------------------------------------------------------------------------
    | Project Listing
    |--------------------------------------------------------------------------
    */

        foreach ($projects as $row) {


            /*
        |--------------------------------------------------------------------------
        | ALLOCATED SEATS
        |--------------------------------------------------------------------------
        */

            $allocatedSeats = $this->db
                ->select_sum('center_seat')
                ->where(
                    'project_id',
                    $row->project_id
                )
                ->where(
                    'admin_status',
                    1
                )
                ->get(
                    'tt_send_booking_request'
                )
                ->row()
                ->center_seat ?? 0;


            $requiredSeats = (int) $row->number_of_seats;


            /*
        |--------------------------------------------------------------------------
        | Never allow allocation above project requirement
        |--------------------------------------------------------------------------
        */

            $allocatedSeats = min(
                (int) $allocatedSeats,
                $requiredSeats
            );


            /*
        |--------------------------------------------------------------------------
        | Allocation Status
        |--------------------------------------------------------------------------
        */

            if ($allocatedSeats == 0) {

                $allocationLabel =
                    '<span class="badge bg-danger">Pending</span>';

                $allocationStatusValue = 'Pending';
            } elseif ($allocatedSeats < $requiredSeats) {

                $allocationLabel =
                    '<span class="badge bg-warning">Partial</span>';

                $allocationStatusValue = 'Partial';
            } else {

                $allocationLabel =
                    '<span class="badge bg-success">Completed</span>';

                $allocationStatusValue = 'Completed';
            }


            /*
        |--------------------------------------------------------------------------
        | Allocation Filter
        |--------------------------------------------------------------------------
        */

            if (
                !empty($allocationStatus)
                &&
                $allocationStatus != $allocationStatusValue
            ) {
                continue;
            }


            /*
        |--------------------------------------------------------------------------
        | Project Status
        |--------------------------------------------------------------------------
        */

            $projectBadge =
                getProjectStatusBadge($row);

            $projectBadge .=
                isHaveAnyRemark(
                    $row->project_remark
                );


            /*
        |--------------------------------------------------------------------------
        | Allocation %
        |--------------------------------------------------------------------------
        */

            $allocationPercent = 0;

            if ($requiredSeats > 0) {

                $allocationPercent =
                    round(
                        (
                            $allocatedSeats /
                            $requiredSeats
                        ) * 100
                    );
            }

            $allocationPercent =
                min(
                    100,
                    $allocationPercent
                );


            /*
        |--------------------------------------------------------------------------
        | Manpower
        |--------------------------------------------------------------------------
        */

            $invigilators =
                (int) $row->invigilator_male
                +
                (int) $row->invigilator_female;


            $techStaff =
                (int) $row->tech_person_count;


            $securityGuards =
                (int) $row->security_guard_male
                +
                (int) $row->security_guard_female;


            $superintendents =
                (int) $row->center_suptn_count;


            /*
        |--------------------------------------------------------------------------
        | Encode Project ID
        |--------------------------------------------------------------------------
        */

            $encodedProjectId = rtrim(
                strtr(
                    base64_encode(
                        $row->project_id
                    ),
                    '+/',
                    '-_'
                ),
                '='
            );


            /*
        |--------------------------------------------------------------------------
        | Action Buttons
        |--------------------------------------------------------------------------
        |
        | Existing routes require city_id.
        | We keep the first city ID only for backward compatibility.
        |
        */

            $actionCityId =
                (int) $row->action_city_id;


            $action = '

            <a target="_blank"
                href="' . base_url(
                'admin/client-project-detail-list/' .
                    $encodedProjectId
            ) . '"
                class="btn btn-sm btn-success mb-1 w-100">
                View Details
            </a>

        ';


            /*
        |--------------------------------------------------------------------------
        | Seat Progress
        |--------------------------------------------------------------------------
        */

            $seatProgress = '

            <strong>
                ' . number_format($allocatedSeats) . '
                /
                ' . number_format($requiredSeats) . '
            </strong>

            <br>

            <div
                class="progress mt-1"
                style="height:8px;"
            >

                <div
                    class="progress-bar bg-success"
                    style="width:' .
                $allocationPercent .
                '%"
                >
                </div>

            </div>

            <small>
                ' .
                $allocationPercent .
                '%
            </small>

        ';


            /*
        |--------------------------------------------------------------------------
        | Manpower
        |--------------------------------------------------------------------------
        */

            $manpower = '

            <div>
                Inv : ' .
                $invigilators .
                '</div>

            <div>
                Tech : ' .
                $techStaff .
                '</div>

            <div>
                Sec : ' .
                $securityGuards .
                '</div>

            <div>
                Sup : ' .
                $superintendents .
                '</div>

        ';


            /*
        |--------------------------------------------------------------------------
        | Client Info
        |--------------------------------------------------------------------------
        */

            $clientInfo = '

            <div>
                Name : ' .
                htmlspecialchars(
                    $row->client_name ?? ''
                ) .
                '</div>

            <div>' .
                htmlspecialchars(
                    $row->email ?? ''
                ) .
                '</div>

            <div>' .
                htmlspecialchars(
                    $row->mobile_phone ?? ''
                ) .
                '</div>

        ';


            /*
        |--------------------------------------------------------------------------
        | FINAL PROJECT ROW
        |--------------------------------------------------------------------------
        */

            $data[] = [

                /*
             * Project
             * NO CITY HERE
             */
                'project' => '

                <strong>' .
                    htmlspecialchars(
                        $row->exam_name
                    ) .
                    '</strong>

                <br>

                <a
                    class="mt-2"
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
                        $row->project_id
                    ) . '\',
                        \'' .
                    addslashes(
                        $row->exam_name
                    ) . '\'
                    )"
                >

                    Project ID :
                    <br>

                    <span
                        class="badge bg-label-primary"
                    >
                        ' .
                    htmlspecialchars(
                        $row->project_id
                    ) .
                    '
                    </span>

                    <br>

                    <small>
                        <strong>Cities:</strong> '.(int)$row->total_cities.'
                    </small>

                </a>

            ',


                'client' =>
                $clientInfo,


                'seat_progress' =>
                $seatProgress,


                'manpower' =>
                $manpower,


                'invigilators' =>
                $invigilators,


                'tech' =>
                $techStaff,


                /*
             * Overall project date
             */
                'exam_date' =>

                date(
                    'd M Y',
                    strtotime(
                        $row->start_date
                    )
                )
                    .
                    ' - '
                    .
                    date(
                        'd M Y',
                        strtotime(
                            $row->end_date
                        )
                    ),


                'status' =>
                $projectBadge,


                'allocation_status' =>
                $allocationLabel,


                'action' =>
                $action
            ];
        }


        /*
    |--------------------------------------------------------------------------
    | Response
    |--------------------------------------------------------------------------
    */

        echo json_encode([

            "draw" =>
            intval(
                $_POST['draw'] ?? 0
            ),

            "recordsTotal" =>
            count($data),

            "recordsFiltered" =>
            count($data),

            "data" =>
            $data
        ]);
    }



    public function getPlannerStats()
    {
        $today = date('Y-m-d');

        $examName = trim($this->input->post('exam_name'));
        $clientId = trim($this->input->post('client_id'));
        $cityId   = trim($this->input->post('city_id'));
        $fromDate = trim($this->input->post('from_date'));
        $toDate   = trim($this->input->post('to_date'));

        $this->db
            ->select("
            pd.project_id,
            pd.start_date,
            pd.end_date,
            pd.number_of_seats,
            pd.project_remark,
            pd.status,
            pd.manual_status,

            pd.invigilator_male,
            pd.invigilator_female,

            pd.tech_person_count,

            pd.security_guard_male,
            pd.security_guard_female,

            pd.center_suptn_count
        ")
            ->from('tt_project_detail pd')
            ->where('pd.deleted', 0);

        if (!empty($examName)) {
            $this->db->like('pd.exam_name', $examName);
        }

        if (!empty($clientId)) {
            $this->db->where('pd.client_id', $clientId);
        }

        if (!empty($cityId)) {
            $this->db->where('pd.exam_city_id', $cityId);
        }

        if (!empty($fromDate)) {
            $this->db->where('pd.start_date >=', $fromDate);
        }

        if (!empty($toDate)) {
            $this->db->where('pd.end_date <=', $toDate);
        }

        $projects = $this->db
            ->order_by('pd.project_id', 'ASC')
            ->get()
            ->result();


        /*
    |--------------------------------------------------------------------------
    | Group city rows by Project ID
    |--------------------------------------------------------------------------
    */

        $groupedProjects = [];

        foreach ($projects as $project) {

            $projectId = $project->project_id;

            if (!isset($groupedProjects[$projectId])) {

                $groupedProjects[$projectId] = [
                    'project_id' => $projectId,

                    // Use first city row for project-level status/date
                    'start_date' => $project->start_date,
                    'end_date'   => $project->end_date,
                    'project_remark' => $project->project_remark,
                    'status' => $project->status,
                    'manual_status' => $project->manual_status,

                    'number_of_seats' => 0,

                    'invigilator_male' => 0,
                    'invigilator_female' => 0,

                    'tech_person_count' => 0,

                    'security_guard_male' => 0,
                    'security_guard_female' => 0,

                    'center_suptn_count' => 0
                ];
            }

            /*
        |--------------------------------------------------------------------------
        | City-wise values → Project total
        |--------------------------------------------------------------------------
        */

            $groupedProjects[$projectId]['number_of_seats']
                += (int) $project->number_of_seats;

            $groupedProjects[$projectId]['invigilator_male']
                += (int) $project->invigilator_male;

            $groupedProjects[$projectId]['invigilator_female']
                += (int) $project->invigilator_female;

            $groupedProjects[$projectId]['tech_person_count']
                += (int) $project->tech_person_count;

            $groupedProjects[$projectId]['security_guard_male']
                += (int) $project->security_guard_male;

            $groupedProjects[$projectId]['security_guard_female']
                += (int) $project->security_guard_female;

            $groupedProjects[$projectId]['center_suptn_count']
                += (int) $project->center_suptn_count;
        }


        /*
    |--------------------------------------------------------------------------
    | Stats
    |--------------------------------------------------------------------------
    */

        $stats = [
            'total_projects' => 0,

            'upcoming_projects'  => 0,
            'running_projects'   => 0,
            'completed_projects' => 0,
            'postponed_projects' => 0,

            'required_seats'  => 0,
            'allocated_seats' => 0,

            'pending_allocation' => 0,
            'partial_allocation' => 0,
            'full_allocation'    => 0,

            'total_invigilators' => 0,
            'total_tech_staff' => 0,
            'total_security_guards' => 0,
            'total_center_superintendent' => 0,
            'total_manpower' => 0
        ];


        /*
    |--------------------------------------------------------------------------
    | Process each unique project only once
    |--------------------------------------------------------------------------
    */

        foreach ($groupedProjects as $projectData) {

            $stats['total_projects']++;

            $requiredSeats = (int) $projectData['number_of_seats'];


            $invigilators =
                (int) $projectData['invigilator_male'] +
                (int) $projectData['invigilator_female'];


            $techPersons =
                (int) $projectData['tech_person_count'];


            $securityGuards =
                (int) $projectData['security_guard_male'] +
                (int) $projectData['security_guard_female'];


            $superintendents =
                (int) $projectData['center_suptn_count'];


            /*
        |--------------------------------------------------------------------------
        | Manpower
        |--------------------------------------------------------------------------
        */

            $stats['total_invigilators'] += $invigilators;

            $stats['total_tech_staff'] += $techPersons;

            $stats['total_security_guards'] += $securityGuards;

            $stats['total_center_superintendent'] += $superintendents;


            $stats['total_manpower'] += (
                $invigilators +
                $techPersons +
                $securityGuards +
                $superintendents
            );


            /*
        |--------------------------------------------------------------------------
        | Allocated Seats
        |--------------------------------------------------------------------------
        */

            $allocatedSeats = $this->db
                ->select_sum('center_seat')
                ->where('project_id', $projectData['project_id'])
                ->where('admin_status', 1)
                ->where('exam_center_status', 1)
                ->get('tt_send_booking_request')
                ->row()
                ->center_seat ?? 0;


            $allocatedSeats = min(
                (int) $allocatedSeats,
                $requiredSeats
            );


            $stats['required_seats'] += $requiredSeats;

            $stats['allocated_seats'] += $allocatedSeats;


            /*
        |--------------------------------------------------------------------------
        | Allocation Status
        |--------------------------------------------------------------------------
        */

            if ($allocatedSeats == 0) {

                $stats['pending_allocation']++;
            } elseif ($allocatedSeats < $requiredSeats) {

                $stats['partial_allocation']++;
            } else {

                $stats['full_allocation']++;
            }


            /*
        |--------------------------------------------------------------------------
        | Project Status
        |--------------------------------------------------------------------------
        */

            $project = (object) $projectData;

            $status = getProjectStatusText($project);


            switch ($status) {

                case 'Upcoming':
                    $stats['upcoming_projects']++;
                    break;

                case 'Running':
                    $stats['running_projects']++;
                    break;

                case 'Completed':
                    $stats['completed_projects']++;
                    break;

                case 'Postponed':
                    $stats['postponed_projects']++;
                    break;
            }
        }


        echo json_encode($stats);
    }
}
