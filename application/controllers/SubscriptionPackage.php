<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
ini_set('display_errors', 1);

spl_autoload_register(function ($class) {

    $prefix = 'Firebase\\JWT\\';

    $base_dir = APPPATH . 'third_party/php-jwt/';

    $len = strlen($prefix);

    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);

    $file = $base_dir . $relative_class . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

use Firebase\JWT\JWT;

class SubscriptionPackage extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Common_model');
        $this->load->model('Booking_model');
        $this->load->library('session');
        $this->load->helper('email');
        $this->config->load('payment');
    }

    public function subscriptionPlans()
    {
        if (!$this->session->userdata('is_owner_logged_in')) {

            $this->session->set_flashdata(
                'error',
                'Please login to continue.'
            );

            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        /*
    |--------------------------------------------------------------------------
    | Get Active Packages
    |--------------------------------------------------------------------------
    */

        $packages = $this->db
            ->where('status', 1)
            ->order_by('price', 'ASC')
            ->get('subscription_packages')
            ->result();

        /*
    |--------------------------------------------------------------------------
    | Get Free Allocation Count Package Wise
    |--------------------------------------------------------------------------
    |
    | This avoids running a COUNT query for every package.
    |
    */

        $free_allocations = $this->db
            ->select('package_id, COUNT(*) as used_count')
            ->from('subscription_free_allocations')
            ->group_by('package_id')
            ->get()
            ->result();

        $free_used_map = [];

        foreach ($free_allocations as $allocation) {

            $free_used_map[$allocation->package_id]
                = (int)$allocation->used_count;
        }

        /*
    |--------------------------------------------------------------------------
    | Check Packages Already Consumed By Current Owner
    |--------------------------------------------------------------------------
    */

        $owner_free_allocations = $this->db
            ->select('package_id')
            ->where('center_owner_id', $owner_id)
            ->get('subscription_free_allocations')
            ->result();

        $owner_free_package_map = [];

        foreach ($owner_free_allocations as $allocation) {

            $owner_free_package_map[$allocation->package_id] = true;
        }

        /*
    |--------------------------------------------------------------------------
    | Prepare Free Subscription Information
    |--------------------------------------------------------------------------
    */

        foreach ($packages as &$package) {

            $limit = (int)$package->free_user_limit;

            $used = $free_used_map[$package->id] ?? 0;

            /*
        |--------------------------------------------------------------------------
        | Default Values
        |--------------------------------------------------------------------------
        */

            $package->free_used = $used;

            $package->free_remaining = 0;

            $package->free_available = false;

            $package->free_unlimited = false;

            $package->free_already_used = false;

            /*
        |--------------------------------------------------------------------------
        | -1 = Unlimited Free Users
        |--------------------------------------------------------------------------
        */

            if ($limit === -1) {

                $package->free_unlimited = true;

                /*
            | Owner can still only consume one free allocation.
            */

                if (
                    !isset(
                        $owner_free_package_map[$package->id]
                    )
                ) {

                    $package->free_available = true;
                }

                continue;
            }

            /*
        |--------------------------------------------------------------------------
        | 0 = No Free Users
        |--------------------------------------------------------------------------
        */

            if ($limit <= 0) {

                continue;
            }

            /*
        |--------------------------------------------------------------------------
        | Remaining Free Slots
        |--------------------------------------------------------------------------
        */

            $remaining = max(
                0,
                $limit - $used
            );

            $package->free_remaining = $remaining;

            /*
        |--------------------------------------------------------------------------
        | Owner Has Already Used Free Slot
        |--------------------------------------------------------------------------
        */

            if (
                isset(
                    $owner_free_package_map[$package->id]
                )
            ) {

                $package->free_already_used = true;

                continue;
            }

            /*
        |--------------------------------------------------------------------------
        | Free Slot Available
        |--------------------------------------------------------------------------
        */

            if ($remaining > 0) {

                $package->free_available = true;
            }
        }

        unset($package);

        /*
    |--------------------------------------------------------------------------
    | Current Subscription
    |--------------------------------------------------------------------------
    */

        $current_subscription = $this->db
            ->where('center_owner_id', $owner_id)
            ->where('status', 'active')
            ->where(
                'expiry_date >=',
                date('Y-m-d H:i:s')
            )
            ->order_by('id', 'DESC')
            ->get('user_subscriptions')
            ->row();

        /*
    |--------------------------------------------------------------------------
    | Send Data To View
    |--------------------------------------------------------------------------
    */

        $data['packages'] = $packages;

        $data['current_subscription']
            = $current_subscription;

        $this->load->view(
            'auth/owner/layouts/header'
        );

        $this->load->view(
            'auth/owner/layouts/sidebar'
        );

        $this->load->view(
            'auth/owner/subscription/plans',
            $data
        );

        $this->load->view(
            'auth/owner/layouts/footer'
        );
    }


    private function generateJWT()
    {
        $payment_config = $this->config->item('mmadpay');

        $payload = [

            'mid'
            => trim($payment_config['merchant_id']),

            'sub'
            => trim($payment_config['merchant_id']),

            'jti'
            => uniqid(),

            'iat' => time(),

            'exp'
            => time() + 600,

            'iss'
            => 'user-app',

            'aud'
            => 'payin-api'

        ];

        return Firebase\JWT\JWT::encode(

            $payload,

            trim($payment_config['payin_api_key']),

            'HS256'
        );
    }


    private function generateHash($payload)
    {
        $payment_config = $this->config->item('mmadpay');

        unset($payload['hash']);

        ksort($payload);

        $hash_string = [];

        foreach ($payload as $key => $value) {
            $hash_string[] = $key . '=' . $value;
        }

        $final_string = implode('|', $hash_string);

        return strtoupper(
            hash_hmac(
                'sha256',
                $final_string,
                trim($payment_config['payin_api_key'])
            )
        );
    }

    // Helper code
    /**
     * Check whether owner is eligible for a free subscription
     * for the selected package.
     */
    private function getFreeSubscriptionEligibility($package_id, $owner_id)
    {
        /*
    |--------------------------------------------------------------------------
    | Get package with row lock
    |--------------------------------------------------------------------------
    |
    | IMPORTANT:
    | This method should be called inside a DB transaction.
    | FOR UPDATE prevents two owners from consuming the same last slot.
    |
    */

        $package = $this->db
            ->query(
                "SELECT *
             FROM subscription_packages
             WHERE id = ?
             AND status = 1
             FOR UPDATE",
                [$package_id]
            )
            ->row();

        if (empty($package)) {
            return [
                'eligible' => false,
                'package'  => null
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | Check whether this owner has already consumed free allocation
    |--------------------------------------------------------------------------
    */

        $alreadyAllocated = $this->db
            ->where('package_id', $package_id)
            ->where('center_owner_id', $owner_id)
            ->get('subscription_free_allocations')
            ->row();

        if ($alreadyAllocated) {
            return [
                'eligible' => false,
                'package'  => $package
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | -1 = Unlimited Free Users
    |--------------------------------------------------------------------------
    */

        if ((int)$package->free_user_limit === -1) {

            return [
                'eligible' => true,
                'package'  => $package
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | 0 = No Free Users
    |--------------------------------------------------------------------------
    */

        if ((int)$package->free_user_limit <= 0) {

            return [
                'eligible' => false,
                'package'  => $package
            ];
        }

        /*
    |--------------------------------------------------------------------------
    | Count consumed free slots
    |--------------------------------------------------------------------------
    */

        $freeUsed = $this->db
            ->where('package_id', $package_id)
            ->count_all_results('subscription_free_allocations');

        /*
    |--------------------------------------------------------------------------
    | Check remaining quota
    |--------------------------------------------------------------------------
    */

        if ($freeUsed < (int)$package->free_user_limit) {

            return [
                'eligible' => true,
                'package'  => $package
            ];
        }

        return [
            'eligible' => false,
            'package'  => $package
        ];
    }

    // Free Transaction
    /**
     * Create a FREE subscription for an owner.
     *
     * This does NOT involve MMADPay.
     * An internal transaction is created for proper audit/history.
     */
    private function createFreeSubscription($owner_id, $package)
    {
        /*
    |--------------------------------------------------------------------------
    | Calculate Dates
    |--------------------------------------------------------------------------
    */

        $start_date = date('Y-m-d H:i:s');

        if ($package->duration_type == 'month') {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime('+' . (int)$package->duration . ' months')
            );
        } else {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime('+' . (int)$package->duration . ' years')
            );
        }

        /*
    |--------------------------------------------------------------------------
    | Create Internal FREE Transaction
    |--------------------------------------------------------------------------
    |
    | This is NOT a payment gateway transaction.
    | It simply keeps transaction_id/history consistent.
    |
    */

        $order_id = 'FREE' . date('YmdHis') . random_int(1000, 9999);

        $transaction_data = [

            'center_owner_id'
            => $owner_id,

            'package_id'
            => $package->id,

            'order_id'
            => $order_id,

            'payment_id'
            => null,

            'gateway_transaction_id'
            => null,

            'bank_refno'
            => null,

            'payment_gateway'
            => 'FREE',

            'amount'
            => 0,

            'gst_amount'
            => 0,

            'total_amount'
            => 0,

            'payment_response'
            => null,

            'callback_response'
            => null,

            'package_snapshot'
            => json_encode($package),

            'payment_status'
            => 'success',

            'status_code'
            => '0',

            'txn_status'
            => 'SUCCESS',

            'transaction_status_message'
            => 'Free Subscription',

            'created_at'
            => date('Y-m-d H:i:s')
        ];

        $this->db->insert(
            'subscription_transactions',
            $transaction_data
        );

        $transaction_id = $this->db->insert_id();

        if (!$transaction_id) {

            throw new Exception(
                'Unable to create free subscription transaction.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Expire Existing Active Subscription
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('center_owner_id', $owner_id)
            ->where('is_active', 1)
            ->update(
                'user_subscriptions',
                [
                    'is_active' => 0,
                    'status'    => 'expired'
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Create Subscription
        |--------------------------------------------------------------------------
        */

        $subscription_data = [

            'center_owner_id'
            => $owner_id,

            'package_id'
            => $package->id,

            'transaction_id'
            => $transaction_id,

            'subscription_type'
            => 'free',

            'amount'
            => 0,

            'gst_amount'
            => 0,

            'total_amount'
            => 0,

            'start_date'
            => $start_date,

            'expiry_date'
            => $expiry_date,

            'is_active'
            => 1,

            'status'
            => 'active',

            'payment_status'
            => 'success',

            'purchased_package_snapshot'
            => json_encode($package),

            'created_at'
            => date('Y-m-d H:i:s')
        ];

        $this->db->insert(
            'user_subscriptions',
            $subscription_data
        );

        $subscription_id = $this->db->insert_id();

        if (!$subscription_id) {

            throw new Exception(
                'Unable to create free subscription.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Record Free Allocation
        |--------------------------------------------------------------------------
        */

        $allocation_data = [

            'package_id'
            => $package->id,

            'center_owner_id'
            => $owner_id,

            'subscription_id'
            => $subscription_id,

            'allocated_at'
            => date('Y-m-d H:i:s')
        ];

        $this->db->insert(
            'subscription_free_allocations',
            $allocation_data
        );

        if ($this->db->affected_rows() <= 0) {

            throw new Exception(
                'Unable to reserve free subscription slot.'
            );
        }

        return $subscription_id;
    }

    // Purchase Subscription
    public function purchasePackage($package_id)
    {
        if (!$this->session->userdata('is_owner_logged_in')) {

            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        /*
        |--------------------------------------------------------------------------
        | Owner Details
        |--------------------------------------------------------------------------
        */

        $owner = $this->db
            ->where('id', $owner_id)
            ->get('tt_admin_users')
            ->row();

        if (empty($owner)) {

            show_error('Owner not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Start Transaction
        |--------------------------------------------------------------------------
        */

        $this->db->trans_begin();

        try {

            /*
        |--------------------------------------------------------------------------
        | Check Free Eligibility
        |--------------------------------------------------------------------------
        |
        | This locks the package row so concurrent users cannot
        | consume the same final free slot.
        |
        */

            $freeCheck = $this->getFreeSubscriptionEligibility(
                $package_id,
                $owner_id
            );

            if (empty($freeCheck['package'])) {

                throw new Exception('Invalid Package');
            }

            $package = $freeCheck['package'];

            /*
        |--------------------------------------------------------------------------
        | FREE SUBSCRIPTION
        |--------------------------------------------------------------------------
        */

            if ($freeCheck['eligible'] === true) {

                /*
            |--------------------------------------------------------------------------
            | Create Free Subscription
            |--------------------------------------------------------------------------
            */

                $subscription_id = $this->createFreeSubscription(
                    $owner_id,
                    $package
                );

                /*
            |--------------------------------------------------------------------------
            | Commit
            |--------------------------------------------------------------------------
            */

                $this->db->trans_commit();

                $this->session->set_flashdata(
                    'success',
                    'Free Subscription Activated Successfully'
                );

                redirect('subscription-plans');
            }

            /*
        |--------------------------------------------------------------------------
        | PAID SUBSCRIPTION
        |--------------------------------------------------------------------------
        |
        | Free quota is unavailable.
        | Continue with existing MMADPay flow.
        |
        */

            $amount = (float)$package->price;

            $gst_amount = (
                $amount * (float)$package->gst_percent
            ) / 100;

            $total_amount = $amount + $gst_amount;

            /*
        |--------------------------------------------------------------------------
        | Unique Order ID
        |--------------------------------------------------------------------------
        */

            $order_id =
                'TRN' .
                date('YmdHis') .
                random_int(1000, 9999);

            /*
        |--------------------------------------------------------------------------
        | MMADPay Payload
        |--------------------------------------------------------------------------
        */

            $payload = [

                'merchant_txnid'
                => $order_id,

                'customer_name'
                => !empty($owner->name)
                    ? $owner->name
                    : 'Test User',

                'customer_mobile'
                => !empty($owner->mobile)
                    ? $owner->mobile
                    : '9876543210',

                'customer_email'
                => $owner->email,

                'amount'
                => number_format(
                    $total_amount,
                    2,
                    '.',
                    ''
                ),

                'pay_mode'
                => 'CARD',

                'return_url'
                => base_url('payment-success'),

                'remark'
                => 'Subscription Payment'
            ];

            /*
        |--------------------------------------------------------------------------
        | Hash
        |--------------------------------------------------------------------------
        */

            $payload['hash'] =
                $this->generateHash($payload);

            /*
        |--------------------------------------------------------------------------
        | Store Pending Transaction
        |--------------------------------------------------------------------------
        */

            $transaction_data = [

                'center_owner_id'
                => $owner_id,

                'package_id'
                => $package->id,

                'order_id'
                => $order_id,

                'payment_gateway'
                => 'MMADPAY',

                'amount'
                => $amount,

                'gst_amount'
                => $gst_amount,

                'total_amount'
                => $total_amount,

                'payment_status'
                => 'pending',

                'txn_status'
                => 'PENDING',

                'transaction_status_message'
                => 'Payment Initiated',

                'package_snapshot'
                => json_encode($package),

                'created_at'
                => date('Y-m-d H:i:s')
            ];

            $this->db->insert(
                'subscription_transactions',
                $transaction_data
            );

            /*
        |--------------------------------------------------------------------------
        | Commit before external API call
        |--------------------------------------------------------------------------
        */

            $this->db->trans_commit();

            /*
        |--------------------------------------------------------------------------
        | MMADPay Configuration
        |--------------------------------------------------------------------------
        */

            $payment_config =
                $this->config->item('mmadpay');

            $jwt = $this->generateJWT();

            $headers = [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $jwt
            ];

            $ch = curl_init();

            curl_setopt_array($ch, [

                CURLOPT_URL
                => $payment_config['create_order_url'],

                CURLOPT_RETURNTRANSFER
                => true,

                CURLOPT_POST
                => true,

                CURLOPT_POSTFIELDS
                => json_encode($payload),

                CURLOPT_SSL_VERIFYPEER
                => false,

                CURLOPT_SSL_VERIFYHOST
                => false,

                CURLOPT_TIMEOUT
                => 60,

                CURLOPT_CONNECTTIMEOUT
                => 60,

                CURLOPT_HTTPHEADER
                => $headers
            ]);

            $response = curl_exec($ch);

            $error = curl_error($ch);

            curl_close($ch);

            /*
        |--------------------------------------------------------------------------
        | Gateway Error
        |--------------------------------------------------------------------------
        */

            if ($error) {

                $this->db
                    ->where('order_id', $order_id)
                    ->update(
                        'subscription_transactions',
                        [
                            'payment_status' => 'failed',
                            'txn_status' => 'FAILED',
                            'transaction_status_message'
                            => $error
                        ]
                    );

                $this->session->set_flashdata(
                    'error',
                    'Unable to initiate payment.'
                );

                redirect('subscription-plans');
            }

            $response_data =
                json_decode($response, true);

            /*
        |--------------------------------------------------------------------------
        | Save Gateway Response
        |--------------------------------------------------------------------------
        */

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_response'
                        => $response,

                        'gateway_transaction_id'
                        => $response_data['data']['gateway_txnid']
                            ?? null
                    ]
                );

            /*
        |--------------------------------------------------------------------------
        | Payment Link
        |--------------------------------------------------------------------------
        */

            if (
                isset($response_data['respCode'])
                &&
                $response_data['respCode'] == '0'
            ) {

                redirect(
                    $response_data['data']['payment_link']
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Payment Initiation Failed
        |--------------------------------------------------------------------------
        */

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status'
                        => 'failed',

                        'txn_status'
                        => 'FAILED',

                        'transaction_status_message'
                        => 'Unable to initiate payment'
                    ]
                );

            $this->session->set_flashdata(
                'error',
                'Unable to initiate payment'
            );

            redirect('subscription-plans');
        } catch (Exception $e) {

            $this->db->trans_rollback();
            $this->session->set_flashdata(
                'error',
                'Error: ' . $e->getMessage()
            );
        }
    }

    public function paymentSuccess()
    {
        $encodedData = $this->input->post('DATA');

        if (empty($encodedData)) {

            show_error('Invalid payment response');
        }

        $decodedData = json_decode(
            base64_decode($encodedData),
            true
        );

        if (
            empty($decodedData) ||
            empty($decodedData['merchant_txnid'])
        ) {

            show_error('Invalid transaction');
        }

        $merchantTxnId =
            $decodedData['merchant_txnid'];

        /*
        |--------------------------------------------------------------------------
        | Get Transaction
        |--------------------------------------------------------------------------
        */

        $transaction = $this->db
            ->where('order_id', $merchantTxnId)
            ->get('subscription_transactions')
            ->row();

        if (empty($transaction)) {

            show_error('Transaction not found');
        }

        /*
        |--------------------------------------------------------------------------
        | Restore Owner Session
        |--------------------------------------------------------------------------
        */

        $owner = $this->db
            ->where('id', $transaction->center_owner_id)
            ->get('tt_admin_users')
            ->row();

        if (!empty($owner)) {

            $this->session->set_userdata([
                'owner_id' =>
                $owner->id,

                'is_owner_logged_in' =>
                true
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Already Processed
        |--------------------------------------------------------------------------
        */

        $existingSubscription = $this->db
            ->where(
                'transaction_id',
                $transaction->id
            )
            ->get('user_subscriptions')
            ->row();

        if ($existingSubscription) {

            if ($existingSubscription->is_active == 1) {

                $this->session->set_flashdata(
                    'success',
                    'Subscription Already Activated'
                );
            } else {

                $this->session->set_flashdata(
                    'error',
                    'Subscription already processed.'
                );
            }

            redirect('subscription-plans');
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        if (
            !isset($decodedData['status_code']) ||
            $decodedData['status_code'] != '0' ||
            !isset($decodedData['txn_status']) ||
            strtolower($decodedData['txn_status']) != 'success'
        ) {

            $this->db
                ->where('id', $transaction->id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status'
                        => 'failed',

                        'status_code'
                        => $decodedData['status_code']
                            ?? null,

                        'txn_status'
                        => 'FAILED',

                        'gateway_transaction_id'
                        => $decodedData['gateway_txnid']
                            ?? $transaction->gateway_transaction_id,

                        'transaction_status_message'
                        => $decodedData['message']
                            ?? 'Payment Failed',

                        'callback_response'
                        => json_encode($decodedData),

                        'payment_response'
                        => json_encode($decodedData)
                    ]
                );

            redirect('payment-failed');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Successful Transaction
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('id', $transaction->id)
            ->update(
                'subscription_transactions',
                [

                    'payment_status'
                    => 'success',

                    'status_code'
                    => $decodedData['status_code']
                        ?? '0',

                    'txn_status'
                    => 'SUCCESS',

                    'gateway_transaction_id'
                    => $decodedData['gateway_txnid']
                        ?? $transaction->gateway_transaction_id,

                    'transaction_status_message'
                    => $decodedData['message']
                        ?? 'Payment Successful',

                    'callback_response'
                    => json_encode($decodedData),

                    'payment_response'
                    => json_encode($decodedData)
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Package Snapshot
        |--------------------------------------------------------------------------
        */

        $package = json_decode(
            $transaction->package_snapshot
        );

        if (empty($package)) {

            show_error(
                'Package information not found.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Calculate Subscription Dates
        |--------------------------------------------------------------------------
        */

        $start_date =
            date('Y-m-d H:i:s');

        if ($package->duration_type == 'month') {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime(
                    '+' .
                        (int)$package->duration .
                        ' months'
                )
            );
        } else {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime(
                    '+' .
                        (int)$package->duration .
                        ' years'
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Expire Old Subscriptions
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where(
                'center_owner_id',
                $transaction->center_owner_id
            )
            ->where('is_active', 1)
            ->update(
                'user_subscriptions',
                [

                    'is_active' => 0,

                    'status' => 'expired'
                ]
            );

        /*
        |--------------------------------------------------------------------------
        | Create Paid Subscription
        |--------------------------------------------------------------------------
        */

        $subscription_data = [

            'center_owner_id'
            => $transaction->center_owner_id,

            'package_id'
            => $transaction->package_id,

            'transaction_id'
            => $transaction->id,

            'subscription_type'
            => 'paid',

            'amount'
            => $transaction->amount,

            'gst_amount'
            => $transaction->gst_amount,

            'total_amount'
            => $transaction->total_amount,

            'payment_status'
            => 'success',

            'start_date'
            => $start_date,

            'expiry_date'
            => $expiry_date,

            'status'
            => 'active',

            'is_active'
            => 1,

            'purchased_package_snapshot'
            => $transaction->package_snapshot,

            'created_at'
            => date('Y-m-d H:i:s')
        ];

        $this->db->insert(
            'user_subscriptions',
            $subscription_data
        );

        /*
        |--------------------------------------------------------------------------
        | Success
        |--------------------------------------------------------------------------
        */

        $this->session->set_flashdata(
            'success',
            'Subscription Activated Successfully'
        );

        redirect('subscription-plans');
    }

    public function paymentFailed()
    {
        $this->session->set_flashdata(
            'error',
            'Payment Failed'
        );

        redirect('subscription-plans');
    }

    public function subscriptionHistory()
    {
        if (!$this->session->userdata('is_owner_logged_in')) {

            $this->session->set_flashdata(
                'error',
                'Please login to continue.'
            );

            redirect('/');
        }

        $owner_id = $this->session->userdata('owner_id');

        /*
        |--------------------------------------------------------------------------
        | Get History
        |--------------------------------------------------------------------------
        */

        $data['history'] = $this->db
            ->select("
                st.id,
                st.order_id,
                st.gateway_transaction_id,
                st.payment_gateway,
                st.amount,
                st.gst_amount,
                st.total_amount,
                st.payment_status,
                st.status_code,
                st.txn_status,
                st.transaction_status_message,
                st.created_at,

                sp.name as package_name,
                sp.duration,
                sp.duration_type,
                sp.max_centers,
                sp.max_bookings,
                sp.verified_badge,

                us.subscription_type,
                us.start_date,
                us.expiry_date,
                us.status as subscription_status,
                us.is_active
            ")
            ->from('subscription_transactions st')
            ->join(
                'user_subscriptions us',
                'us.transaction_id = st.id',
                'left'
            )
            ->join(
                'subscription_packages sp',
                'sp.id = st.package_id',
                'left'
            )
            ->where('st.center_owner_id', $owner_id)
            ->order_by('st.id', 'DESC')
            ->get()
            ->result();

        foreach ($data['history'] as &$row) {

            $row->amount = number_format((float)$row->amount, 2, '.', '');

            $row->gst_amount = number_format((float)$row->gst_amount, 2, '.', '');

            $row->total_amount = number_format((float)$row->total_amount, 2, '.', '');

            $row->remaining_days = null;

            if (!empty($row->expiry_date)) {

                $remaining = ceil(
                    (strtotime($row->expiry_date) - time()) / 86400
                );

                $row->remaining_days = max(0, $remaining);
            }
        }

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/transaction/list', $data);
        $this->load->view('auth/owner/layouts/footer');
    }
}
