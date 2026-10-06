<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TransactionPackage extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();

        // Auth Guard (industry standard)
        if (!$this->session->userdata('is_admin_logged_in')) {
            redirect('login');
        }

        $this->load->model('Common_model');
    }

    /* =================================
       LISTING
    ================================= */

    public function index()
    {
        $data['page_title'] = 'Subscription Transactions';

        /*
        |--------------------------------------------------------------------------
        | Filter Dropdown Data
        |--------------------------------------------------------------------------
        */

        $data['packages'] = $this->db
            ->where('status', 1)
            ->order_by('name', 'ASC')
            ->get('subscription_packages')
            ->result();

        $data['admins'] = $this->db
            ->select('id,username,email')
            ->where('role_id', 9)
            ->order_by('username', 'ASC')
            ->get('tt_admin_users')
            ->result();


        /*
        |--------------------------------------------------------------------------
        | Transaction Statistics
        |--------------------------------------------------------------------------
        */

        // Total transaction attempts
        $data['total_transactions'] = $this->db
            ->count_all('subscription_transactions');


        // Successful transactions
        $data['successful_transactions'] = $this->db
            ->where('payment_status', 'success')
            ->count_all_results('subscription_transactions');


        // Failed transactions
        $data['failed_transactions'] = $this->db
            ->where('payment_status', 'failed')
            ->count_all_results('subscription_transactions');


        /*
        |--------------------------------------------------------------------------
        | Total Revenue
        |--------------------------------------------------------------------------
        |
        | Revenue should only include successful payments.
        | total_amount = package amount + GST
        |
        */

        $revenue = $this->db
            ->select_sum('total_amount')
            ->where('payment_status', 'success')
            ->get('subscription_transactions')
            ->row();

        $data['total_revenue'] = $revenue->total_amount ?? 0;


        /*
        |--------------------------------------------------------------------------
        | GST Collected
        |--------------------------------------------------------------------------
        */

        $gst = $this->db
            ->select_sum('gst_amount')
            ->where('payment_status', 'success')
            ->get('subscription_transactions')
            ->row();

        $data['total_gst'] = $gst->gst_amount ?? 0;


        /*
        |--------------------------------------------------------------------------
        | Unique Subscribed Owners
        |--------------------------------------------------------------------------
        */

        $owners = $this->db
            ->select('COUNT(DISTINCT center_owner_id) AS total_owners', false)
            ->where('payment_status', 'success')
            ->get('subscription_transactions')
            ->row();

        $data['subscribed_owners'] = $owners->total_owners ?? 0;


        /*
        |--------------------------------------------------------------------------
        | Package Wise Performance
        |--------------------------------------------------------------------------
        */

        $data['package_statistics'] = $this->db
            ->select('
            st.package_id,
            sp.name AS package_name,
            COUNT(st.id) AS purchase_count,
            SUM(st.total_amount) AS total_revenue,
            SUM(st.gst_amount) AS total_gst
        ')
            ->from('subscription_transactions st')
            ->join(
                'subscription_packages sp',
                'sp.id = st.package_id',
                'left'
            )
            ->where('st.payment_status', 'success')
            ->group_by('st.package_id')
            ->order_by('purchase_count', 'DESC')
            ->get()
            ->result();


        /*
    |--------------------------------------------------------------------------
    | Load Views
    |--------------------------------------------------------------------------
    */

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/transaction/index', $data);
        $this->load->view('layouts/footer');
    }


    public function ajaxList()
    {
        $post = $this->input->post();

        $columns = [
            0 => 'st.id',
            1 => 'au.username',
            2 => 'sp.name',
            3 => 'st.total_amount',
            4 => 'st.payment_status',
            5 => 'st.gateway_transaction_id',
            6 => 'st.created_at'
        ];

        $this->db->select("
            st.*,

            sp.name as package_name,
            sp.max_centers,
            sp.duration,
            sp.duration_type,

            us.subscription_type,
            us.start_date,
            us.expiry_date,

            au.username,
            au.email,
            au.mobile_phone
        ");

        $this->db->from('subscription_transactions st');

        $this->db->join(
            'user_subscriptions us',
            'us.transaction_id = st.id',
            'left'
        );

        $this->db->join(
            'subscription_packages sp',
            'sp.id = st.package_id',
            'left'
        );

        // Direct owner join
        $this->db->join(
            'tt_admin_users au',
            'au.id = st.center_owner_id',
            'left'
        );


    /*
    |--------------------------------------------------------------------------
    | Filters
    |--------------------------------------------------------------------------
    */

        // Package
        if (!empty($post['package_id'])) {
            $this->db->where(
                'st.package_id',
                $post['package_id']
            );
        }

        // Owner
        if (!empty($post['admin_id'])) {
            $this->db->where(
                'st.center_owner_id',
                $post['admin_id']
            );
        }

        // Payment Status
        if (!empty($post['payment_status'])) {
            $this->db->where(
                'st.payment_status',
                $post['payment_status']
            );
        }

        // From Date
        if (!empty($post['from_date'])) {
            $this->db->where(
                'DATE(st.created_at) >=',
                $post['from_date']
            );
        }

        // To Date
        if (!empty($post['to_date'])) {
            $this->db->where(
                'DATE(st.created_at) <=',
                $post['to_date']
            );
        }


    /*
    |--------------------------------------------------------------------------
    | Filtered Count
    |--------------------------------------------------------------------------
    */

        $totalFiltered = $this->db->count_all_results('', false);


    /*
    |--------------------------------------------------------------------------
    | Ordering
    |--------------------------------------------------------------------------
    */

        if (isset($post['order'])) {

            $columnIndex = $post['order'][0]['column'];
            $direction   = $post['order'][0]['dir'];

            if (isset($columns[$columnIndex])) {
                $this->db->order_by(
                    $columns[$columnIndex],
                    $direction
                );
            }
        } else {

            $this->db->order_by(
                'st.id',
                'DESC'
            );
        }


    /*
    |--------------------------------------------------------------------------
    | Pagination
    |--------------------------------------------------------------------------
    */

        if ($post['length'] != -1) {

            $this->db->limit(
                $post['length'],
                $post['start']
            );
        }


    /*
    |--------------------------------------------------------------------------
    | Result
    |--------------------------------------------------------------------------
    */

        $result = $this->db
            ->get()
            ->result();


        $data = [];

        foreach ($result as $row) {

            $data[] = [

                'id' => $row->id,

                'user' => '
                <strong>' . htmlspecialchars($row->username) . '</strong><br>
                ' . htmlspecialchars($row->email) . '<br>
                ' . htmlspecialchars($row->mobile_phone),

                'package' => '
                <strong>' . htmlspecialchars($row->package_name) . '</strong><br>
                Duration : ' . $row->duration . ' ' .
                    ucfirst($row->duration_type) . '<br>
                Center Limit : ' .
                    ($row->max_centers == -1
                        ? 'Unlimited'
                        : $row->max_centers),

                'amount' => '₹ ' .
                    number_format($row->total_amount, 2),

                'payment_status' =>
                $row->payment_status == 'success'
                    ? '<span class="badge bg-success">Success</span>'
                    : '<span class="badge bg-danger">' .
                    htmlspecialchars($row->payment_status) .
                    '</span>',

                'transaction_id' =>
                !empty($row->gateway_transaction_id)
                    ? htmlspecialchars($row->gateway_transaction_id)
                    : '--',

                // Transaction date should come from transaction itself
                'date' =>
                !empty($row->created_at)
                    ? date(
                        'd M Y h:i A',
                        strtotime($row->created_at)
                    )
                    : '--',

                'expiry_date' =>
                !empty($row->expiry_date)
                    ? date(
                        'd M Y h:i A',
                        strtotime($row->expiry_date)
                    )
                    : '--',

                'action' => '
                <a target="_blank"
                   href="' .
                    base_url(
                        'admin/transaction-package/view/' . $row->id
                    ) .
                    '"
                   class="btn btn-sm btn-primary">
                    <i class="ti ti-eye"></i>
                </a>'
            ];
        }


    /*
    |--------------------------------------------------------------------------
    | Total Records
    |--------------------------------------------------------------------------
    */

        $totalRecords = $this->db
            ->count_all('subscription_transactions');


        echo json_encode([

            'draw'            => intval($post['draw']),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data

        ]);
    }


    public function view($id)
    {
        $transaction = $this->db
            ->select("
                st.*,

                sp.name as package_name,
                sp.duration,
                sp.duration_type,
                sp.price,
                sp.max_centers,
                sp.max_bookings,
                sp.support_type,
                sp.free_user_limit,
                sp.verified_badge,

                us.subscription_type,
                us.start_date,
                us.expiry_date,
                us.is_active,
                us.status as subscription_status,

                au.username,
                au.email,
                au.mobile_phone
            ")
            ->from('subscription_transactions st')

            ->join(
                'subscription_packages sp',
                'sp.id = st.package_id',
                'left'
            )

            ->join(
                'user_subscriptions us',
                'us.transaction_id = st.id',
                'left'
            )

            ->join(
                'tt_admin_users au',
                'au.id = st.center_owner_id',
                'left'
            )

            ->where('st.id', $id)
            ->get()
            ->row();

        if (!$transaction) {
            show_404();
        }
        $data['page_title'] = 'Detail';
        $data['transaction'] = $transaction;

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar');
        $this->load->view('dashboard/transaction/view');
        $this->load->view('layouts/footer');
    }
}
