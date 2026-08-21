<?php
defined('BASEPATH') or exit('No direct script access allowed');

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

class SubscriptionPackage extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        header("Content-Type: application/json");

        $this->load->model('Common_model');
        $this->load->library('session');
        
         $this->config->load('payment');
    }


    public function fetchSubscriptionPackages()
    {

        $result = $this->Common_model->getdata_array('subscription_packages', array('status' => 1));

        echo json_encode([
            'status' => true,
            'data' => $result
        ]);
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


    private function generateJWT()
    {
        $payment_config = $this->config->item('mmadpay');

        $payload = [

            'mid'
            => trim($payment_config['merchant_id']),

            'sub'
            => trim($payment_config['merchant_id']),

            'jti'
            => uniqid('', true),

            'iat'
            => time(),

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


    private function generateHash(array $payload)
    {
        $payment_config = $this->config->item('mmadpay');

        // Remove existing hash if present
        unset($payload['hash']);

        // Sort payload alphabetically by key
        ksort($payload);

        $hashData = [];

        foreach ($payload as $key => $value) {

            // Convert null values to empty string
            if ($value === null) {
                $value = '';
            }

            $hashData[] = $key . '=' . trim((string)$value);
        }

        $hashString = implode('|', $hashData);

        return strtoupper(
            hash_hmac(
                'sha256',
                $hashString,
                trim($payment_config['payin_api_key'])
            )
        );
    }


    public function getPackages()
    {
        $owner = $this->authenticateOwner();

        $packages = $this->db
            ->select("
                id,
                name,
                slug,
                duration,
                duration_type,
                price,
                gst_percent,
                package_color,
                tag_line,
                key_points,
                free_user_limit,
                max_centers,
                max_bookings,
                support_type,
                verified_badge,
                is_recommended,
                status
                ")
            ->from('subscription_packages')
            ->where('status', 1)
            ->order_by('price', 'ASC')
            ->get()
            ->result();

        if (empty($packages)) {

            echo json_encode([
                'status'  => false,
                'message' => 'No subscription package found.',
                'data'    => []
            ]);

            return;
        }

        foreach ($packages as &$package) {

            $package->price = number_format($package->price, 2, '.', '');

            $gst_amount = ($package->price * $package->gst_percent) / 100;

            $package->gst_amount = number_format(
                $gst_amount,
                2,
                '.',
                ''
            );

            $package->total_amount = number_format(
                $package->price + $gst_amount,
                2,
                '.',
                ''
            );
        }

        echo json_encode([

            'status'  => true,

            'message' => 'Subscription packages fetched successfully.',

            'data'    => $packages

        ]);
    }



    public function createOrder()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        $package_id = (int)$this->input->post('package_id');

        if (empty($package_id)) {

            echo json_encode([
                'status' => false,
                'message' => 'Package id is required.'
            ]);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Owner Details
        |--------------------------------------------------------------------------
        */

        $user = $this->db
            ->where('id', $owner_id)
            ->where('role_id', 9)
            ->get('tt_admin_users')
            ->row();

        if (!$user) {

            echo json_encode([
                'status' => false,
                'message' => 'Owner not found.'
            ]);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Package Details
        |--------------------------------------------------------------------------
        */

        $package = $this->db
            ->where('id', $package_id)
            ->where('status', 1)
            ->get('subscription_packages')
            ->row();

        if (!$package) {

            echo json_encode([
                'status' => false,
                'message' => 'Invalid subscription package.'
            ]);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Prevent Duplicate Active Subscription
        |--------------------------------------------------------------------------
        */

        $activeSubscription = $this->db
            ->where('center_owner_id', $owner_id)
            ->where('package_id', $package_id)
            ->where('is_active', 1)
            ->get('user_subscriptions')
            ->row();

        if ($activeSubscription) {

            echo json_encode([
                'status' => false,
                'message' => 'You already have an active subscription for this package.'
            ]);
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Amount Calculation
        |--------------------------------------------------------------------------
        */

        $amount = (float)$package->price;

        $gst_amount = ($amount * $package->gst_percent) / 100;

        $total_amount = $amount + $gst_amount;

        /*
        |--------------------------------------------------------------------------
        | Order Id
        |--------------------------------------------------------------------------
        */

        $order_id = 'TRN' . time() . rand(100, 999);

        /*
        |--------------------------------------------------------------------------
        | MMAD Payload
        |--------------------------------------------------------------------------
        */

        $payload = [

            'merchant_txnid' => $order_id,

            'customer_name' => !empty($user->username)
                ? $user->username
                : 'Test User',

            'customer_mobile' => !empty($user->mobile_phone)
                ? $user->mobile_phone
                : '9876543210',

            'customer_email' => $user->email,

            'amount' => number_format(
                $total_amount,
                2,
                '.',
                ''
            ),

            'pay_mode' => 'CARD',

            'return_url' => base_url('payment-success'),

            'remark' => 'Subscription Payment'

        ];

        $payload['hash'] = $this->generateHash($payload);

        /*
        |--------------------------------------------------------------------------
        | Save Pending Transaction
        |--------------------------------------------------------------------------
        */

        $transactionData = [

            'center_owner_id' => $owner_id,

            'package_id' => $package->id,

            'order_id' => $order_id,

            'payment_gateway' => 'MMADPAY',

            'amount' => $amount,

            'gst_amount' => $gst_amount,

            'total_amount' => $total_amount,

            'payment_status' => 'pending',

            'txn_status' => 'PENDING',

            'transaction_status_message' => 'Payment Initiated',

            'package_snapshot' => json_encode($package),

            'created_at' => date('Y-m-d H:i:s')

        ];

        $this->db->insert(
            'subscription_transactions',
            $transactionData
        );

        /*
        |--------------------------------------------------------------------------
        | MMADPAY Request
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

            CURLOPT_HTTPHEADER => $headers,

            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_SSL_VERIFYHOST => false,

            CURLOPT_TIMEOUT => 60,

            CURLOPT_CONNECTTIMEOUT => 60

        ]);

        $response = curl_exec($ch);

        $error = curl_error($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($error) {

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status' => 'failed',

                        'txn_status' => 'FAILED',

                        'transaction_status_message' => $error

                    ]
                );

            echo json_encode([

                'status' => false,

                'message' => $error

            ]);

            return;
        }

        if ($httpCode != 200) {

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status' => 'failed',

                        'txn_status' => 'FAILED',

                        'transaction_status_message' => 'HTTP Error : ' . $httpCode,

                        'payment_response' => $response

                    ]
                );

            echo json_encode([

                'status' => false,

                'message' => 'Unable to connect payment gateway.'

            ]);

            return;
        }

        $response = json_decode($response, true);

        /*
        |--------------------------------------------------------------------------
        | Invalid Response
        |--------------------------------------------------------------------------
        */

        if (!is_array($response)) {

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status' => 'failed',

                        'txn_status' => 'FAILED',

                        'transaction_status_message' => 'Invalid gateway response',

                        'payment_response' => json_encode($response)

                    ]
                );

            echo json_encode([

                'status' => false,

                'message' => 'Invalid response received from payment gateway.'

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Link Generated Successfully
        |--------------------------------------------------------------------------
        */

        if (
            isset($response['respCode']) &&
            $response['respCode'] == '0'
        ) {

            $this->db
                ->where('order_id', $order_id)
                ->update(
                    'subscription_transactions',
                    [

                        'gateway_transaction_id'
                        => $response['data']['gateway_txnid'] ?? null,

                        'payment_response'
                        => json_encode($response),

                        'transaction_status_message'
                        => $response['respMessage'] ?? 'Payment Link Generated'

                    ]
                );

            echo json_encode([

                'status' => true,

                'message' => 'Payment link generated successfully.',

                'data' => [

                    'order_id' => $order_id,

                    'payment_link'
                    => $response['data']['payment_link'] ?? '',

                    'gateway_transaction_id'
                    => $response['data']['gateway_txnid'] ?? ''

                ]

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Gateway Failed
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('order_id', $order_id)
            ->update(
                'subscription_transactions',
                [

                    'payment_status' => 'failed',

                    'txn_status' => 'FAILED',

                    'gateway_transaction_id'
                    => $response['data']['gateway_txnid'] ?? null,

                    'transaction_status_message'
                    => $response['respMessage'] ?? 'Payment Failed',

                    'payment_response'
                    => json_encode($response)

                ]
            );

        echo json_encode([

            'status' => false,

            'message'
            => $response['respMessage']
                ?? 'Unable to generate payment link.'

        ]);

        return;
    }



    private function activateSubscription($transaction, $paymentData = [])
    {
        /*
        |--------------------------------------------------------------------------
        | Update Transaction
        |--------------------------------------------------------------------------
        */

        $this->db->trans_start();

        $this->db
            ->where('id', $transaction->id)
            ->update('subscription_transactions', [

                'payment_status' => 'success',

                'txn_status' => 'SUCCESS',

                'gateway_transaction_id'
                => $paymentData['gateway_txnid'] ?? $transaction->gateway_transaction_id,

               'transaction_status_message'
                    => !empty($paymentData['message'])
                        ? $paymentData['message']
                        : 'Payment Successful',


                'payment_id'
                    => $paymentData['payment_id'] ?? null,

                'bank_refno'
                    => $paymentData['bank_refno'] ?? null,

                'status_code'
                    => $paymentData['status_code'] ?? null,

                'callback_response'
                    => json_encode($paymentData),

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

            $this->db->trans_complete();

            return $this->db->trans_status();
        }

        /*
        |--------------------------------------------------------------------------
        | Package Details
        |--------------------------------------------------------------------------
        */

        $package = json_decode($transaction->package_snapshot);

        if (!$package) {

            $this->db->trans_complete();

            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Subscription Dates
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
        | Expire Previous Subscription
        |--------------------------------------------------------------------------
        */

        $this->db
            ->where('center_owner_id', $transaction->center_owner_id)
            ->where('is_active', 1)
            ->update('user_subscriptions', [

                'is_active' => 0,

                'status' => 'expired'

            ]);

        /*
        |--------------------------------------------------------------------------
        | Create Subscription
        |--------------------------------------------------------------------------
        */

        $subscriptionData = [

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
            $subscriptionData
        );

        $this->db->trans_complete();

        return $this->db->trans_status();

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

        /*
        |--------------------------------------------------------------------------
        | Get Transaction
        |--------------------------------------------------------------------------
        */

        $transaction = $this->db
            ->where(
                'order_id',
                $decodedData['merchant_txnid']
            )
            ->get('subscription_transactions')
            ->row();

        if (!$transaction) {
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
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status' => 'failed',

                        'txn_status' => 'FAILED',

                        'gateway_transaction_id'
                        => $decodedData['gateway_txnid'] ?? null,

                        'transaction_status_message'
                        => $decodedData['message'] ?? 'Payment Failed',

                        'payment_response'
                        => json_encode($decodedData),

                        'status_code'
                            => $decodedData['status_code'] ?? null,

                        'bank_refno'
                            => $decodedData['bank_refno'] ?? null,

                        'callback_response'
                            => json_encode($decodedData),

                    ]
                );

            redirect('payment-failed');
        }

        /*
        |--------------------------------------------------------------------------
        | Activate Subscription
        |--------------------------------------------------------------------------
        */

        if(
            !$this->activateSubscription(
                $transaction,
                $decodedData
            )
        ){
            show_error('Unable to activate subscription.');
        }

        $this->session->set_flashdata(
            'success',
            'Subscription Activated Successfully.'
        );

        redirect('subscription-plans');
    }


    public function checkPaymentStatus()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        $order_id = trim($this->input->post('order_id'));

        if (empty($order_id)) {

            echo json_encode([
                'status' => false,
                'message' => 'Order id is required.'
            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Get Transaction
        |--------------------------------------------------------------------------
        */

        $transaction = $this->db
            ->where('order_id', $order_id)
            ->where('center_owner_id', $owner_id)
            ->get('subscription_transactions')
            ->row();

        if (!$transaction) {

            echo json_encode([
                'status' => false,
                'message' => 'Transaction not found.'
            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Already Success
        |--------------------------------------------------------------------------
        */

        if ($transaction->payment_status == 'success') {

            $subscription = $this->db
                ->where('transaction_id', $transaction->id)
                ->where('is_active', 1)
                ->get('user_subscriptions')
                ->row();

            echo json_encode([

                'status' => true,

                'payment_status' => 'success',

                'subscription_status'
                => $subscription->status ?? 'active',

                'message' => 'Payment successful.'

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | MMADPay Status API
        |--------------------------------------------------------------------------
        */

        $payment_config = $this->config->item('mmadpay');

        $payload = [

            'merchant_txnid' => $order_id

        ];

        $payload['hash'] = $this->generateHash($payload);

        $jwt = $this->generateJWT();

        $headers = [

            'Content-Type: application/json',

            'Authorization: Bearer ' . $jwt

        ];

        $ch = curl_init();

        curl_setopt_array($ch, [

            CURLOPT_URL => $payment_config['status_url'],

            CURLOPT_RETURNTRANSFER => true,

            CURLOPT_POST => true,

            CURLOPT_POSTFIELDS => json_encode($payload),

            CURLOPT_HTTPHEADER => $headers,

            CURLOPT_SSL_VERIFYPEER => false,

            CURLOPT_SSL_VERIFYHOST => false,

            CURLOPT_TIMEOUT => 60,

            CURLOPT_CONNECTTIMEOUT => 60

        ]);

        $response = curl_exec($ch);

        $error = curl_error($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($error) {

            echo json_encode([

                'status' => false,

                'message' => $error

            ]);

            return;
        }

        if ($httpCode != 200) {

            echo json_encode([

                'status' => false,

                'message' => 'Unable to connect payment gateway.'

            ]);

            return;
        }

        $response = json_decode($response, true);

        /*
        |--------------------------------------------------------------------------
        | Payment Success
        |--------------------------------------------------------------------------
        */

        if (
            isset($response['status_code']) &&
            $response['status_code'] == '0' &&
            strtolower($response['txn_status']) == 'success'
        ) {

            $result = $this->activateSubscription(
                $transaction,
                $response
            );

            if (!$result) {

                echo json_encode([

                    'status' => false,

                    'message' => 'Unable to activate subscription.'

                ]);

                return;
            }

            echo json_encode([

                'status' => true,

                'payment_status' => 'success',

                'subscription_status' => 'active',

                'message' => 'Payment successful.'

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */

        if (
            isset($response['txn_status']) &&
            in_array(
                strtolower($response['txn_status']),
                ['failed', 'failure', 'cancelled', 'expired']
            )
        ) {

            $this->db
                ->where('id', $transaction->id)
                ->update(
                    'subscription_transactions',
                    [

                        'payment_status' => 'failed',

                        'txn_status'
                        => strtoupper($response['txn_status']),

                        'transaction_status_message'
                        => $response['message'] ?? 'Payment Failed',

                        'payment_response'
                        => json_encode($response),

                        'bank_refno'
                            => $response['bank_refno'] ?? null,

                        'status_code'
                            => $response['status_code'] ?? null,

                        'callback_response'
                            => json_encode($response),

                    ]
                );

            echo json_encode([

                'status' => false,

                'payment_status' => 'failed',

                'message'
                => $response['message'] ?? 'Payment failed.'

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Pending
        |--------------------------------------------------------------------------
        */

        echo json_encode([

            'status' => true,

            'payment_status' => 'pending',

            'message' => 'Payment is still pending.'

        ]);
    }


    public function mySubscription()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        $subscription = $this->db
            ->select("
            us.*,

            sp.name,
            sp.tag_line,
            sp.key_points,
            sp.package_color,
            sp.slug,
            sp.is_recommended,
            sp.duration,
            sp.duration_type,
            sp.price,
            sp.gst_percent,
            sp.max_centers,
            sp.max_bookings,
            sp.support_type,
            sp.free_user_limit,
            sp.verified_badge
        ")
            ->from('user_subscriptions us')

            ->join(
                'subscription_packages sp',
                'sp.id = us.package_id',
                'left'
            )

            ->where('us.center_owner_id', $owner_id)
            ->where('us.is_active', 1)

            ->order_by('us.id', 'DESC')

            ->get()
            ->row();

        if (!$subscription) {

            echo json_encode([

                'status' => false,

                'message' => 'No active subscription found.',

                'data' => (object)[]

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Remaining Days
        |--------------------------------------------------------------------------
        */

        $today = strtotime(date('Y-m-d'));

        $expiry = strtotime(
            date(
                'Y-m-d',
                strtotime($subscription->expiry_date)
            )
        );

        $remaining_days = ceil(
            ($expiry - $today) / 86400
        );

        if ($remaining_days < 0) {
            $remaining_days = 0;
        }

        $subscription->remaining_days = $remaining_days;

        $subscription->is_expired = (
            strtotime($subscription->expiry_date) < time()
        ) ? 1 : 0;

        $subscription->can_purchase = 1;

        echo json_encode([

            'status' => true,

            'message' => 'Subscription fetched successfully.',

            'data' => $subscription

        ]);
    }


    public function subscriptionHistory()
    {
        $owner = $this->authenticateOwner();
        $owner_id = $owner->id;

        /*
        |--------------------------------------------------------------------------
        | Get History
        |--------------------------------------------------------------------------
        */

        $history = $this->db
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

        if (empty($history)) {

            echo json_encode([

                'status' => false,

                'message' => 'No transaction history found.',

                'data' => []

            ]);

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Format Data
        |--------------------------------------------------------------------------
        */

        foreach ($history as &$row) {

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

        echo json_encode([

            'status' => true,

            'message' => 'Subscription history fetched successfully.',

            'data' => $history

        ]);
    }
}