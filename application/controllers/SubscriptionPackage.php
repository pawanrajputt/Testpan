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
        | Current Subscription
        |--------------------------------------------------------------------------
        */

        $current_subscription = $this->db
            ->where('center_owner_id', $owner_id)
            ->where('status', 'active')
            ->where('expiry_date >=', date('Y-m-d H:i:s'))
            ->order_by('id', 'DESC')
            ->get('user_subscriptions')
            ->row();

        $data['packages'] = $packages;
        $data['current_subscription'] = $current_subscription;

        $this->load->view('auth/owner/layouts/header');
        $this->load->view('auth/owner/layouts/sidebar');
        $this->load->view('auth/owner/subscription/plans', $data);
        $this->load->view('auth/owner/layouts/footer');
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

        /*
        |--------------------------------------------------------------------------
        | Package
        |--------------------------------------------------------------------------
        */

        $package = $this->db
            ->where('id', $package_id)
            ->where('status', 1)
            ->get('subscription_packages')
            ->row();

        if (empty($package)) {

            show_error('Invalid Package');
        }

        /*
        |--------------------------------------------------------------------------
        | Amount Calculation
        |--------------------------------------------------------------------------
        */

        $amount = $package->price;

        $gst_amount = (
            $amount * $package->gst_percent
        ) / 100;

        $total_amount = $amount + $gst_amount;

        /*
        |--------------------------------------------------------------------------
        | Order ID
        |--------------------------------------------------------------------------
        */

        $order_id = 'TRN' . time();

        /*
        |--------------------------------------------------------------------------
        | Payload
        |--------------------------------------------------------------------------
        */

        $payload = [

            'merchant_txnid'
            => $order_id,

            'customer_name'   => !empty($owner->name) ? $owner->name : 'Test User',

            'customer_mobile' => !empty($owner->mobile) ? $owner->mobile : '9876543210',

            'customer_email'
            => $owner->email,

            'amount'
            => number_format($total_amount, 2, '.', ''),

            'pay_mode'
            => 'CARD',

            'return_url'
            => base_url('payment-success'),

            'remark'
            => 'Subscription Payment',



        ];

        /*
        |--------------------------------------------------------------------------
        | Hash
        |--------------------------------------------------------------------------
        */

        $payload['hash']
            = $this->generateHash($payload);

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
        | JWT
        |--------------------------------------------------------------------------
        */

        $payment_config = $this->config->item('mmadpay');

        $jwt = $this->generateJWT();

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $jwt
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $payment_config['create_order_url'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_CONNECTTIMEOUT => 60,
            CURLOPT_HTTPHEADER => $headers
        ]);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        curl_close($ch);

        if ($error) {
            die($error);
        }

        $response_data = json_decode($response, true);


        /*
        |--------------------------------------------------------------------------
        | Save Response
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('order_id', $order_id)
            ->update('subscription_transactions', [

                'payment_response'
                => $response,

                'gateway_transaction_id'
                => $response_data['data']['gateway_txnid']
                    ?? null

            ]);

        /*
        |--------------------------------------------------------------------------
        | Redirect To Payment URL
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
        } else {

            $this->session->set_flashdata(
                'error',
                'Unable to initiate payment'
            );

            echo "<pre>";
            print_r($response);
            print_r($response_data);
            die();

            redirect('subscription-plans');
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

        $merchantTxnId = $decodedData['merchant_txnid'];

        // ==========
        $transaction = $this->db
            ->where('order_id', $merchantTxnId)
            ->get('subscription_transactions')
            ->row();

        if (!$transaction) {
            show_error('Transaction not found');
        }

        $owner = $this->db
            ->where('id', $transaction->center_owner_id)
            ->get('tt_admin_users')
            ->row();

        $this->session->set_userdata([
            'owner_id' => $owner->id,
            'is_owner_logged_in' => true
        ]);

        //   ==============

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
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        if (
            !isset($decodedData['status_code']) ||
            $decodedData['status_code'] != '0' ||
            strtolower($decodedData['txn_status']) != 'success'
        ) {

            $this->db
                ->where('id', $transaction->id)
                ->update('subscription_transactions', [

                    'payment_status' => 'failed',

                    'txn_status' => 'FAILED',

                    'gateway_transaction_id'
                    => $decodedData['gateway_txnid'] ?? null,

                    'transaction_status_message'
                    => $decodedData['message'] ?? 'Payment Failed',

                    'payment_response'
                    => json_encode($decodedData)

                ]);

            redirect('payment-failed');
        }

        /*
        |--------------------------------------------------------------------------
        | Update Transaction Success
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('id', $transaction->id)
            ->update('subscription_transactions', [

                'payment_status' => 'success',

                'txn_status' => 'SUCCESS',

                'gateway_transaction_id'
                => $decodedData['gateway_txnid'] ?? null,

                'transaction_status_message'
                => $decodedData['message'] ?? 'Payment Successful',

                'payment_response'
                => json_encode($decodedData)

            ]);

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Subscription
        |--------------------------------------------------------------------------
        */

        $existingSubscription = $this->db
            ->where('transaction_id', $transaction->id)
            ->get('user_subscriptions')
            ->row();

        if ($existingSubscription) {

            $this->session->set_flashdata(
                'success',
                'Subscription Already Activated'
            );

            redirect('subscription-plans');
        }

        /*
        |--------------------------------------------------------------------------
        | Package Snapshot
        |--------------------------------------------------------------------------
        */

        $package = json_decode(
            $transaction->package_snapshot
        );

        /*
        |--------------------------------------------------------------------------
        | Calculate Expiry
        |--------------------------------------------------------------------------
        */

        $start_date = date('Y-m-d H:i:s');

        if ($package->duration_type == 'month') {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime('+' . $package->duration . ' months')
            );
        } else {

            $expiry_date = date(
                'Y-m-d H:i:s',
                strtotime('+' . $package->duration . ' years')
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
            ->update('user_subscriptions', [

                'is_active' => 0,

                'status' => 'expired'

            ]);

        /*
        |--------------------------------------------------------------------------
        | Create New Subscription
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
