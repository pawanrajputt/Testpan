<div class="content-wrapper">

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="py-3 mb-4">

        <span class="text-muted fw-light">

            <a href="<?= base_url('admin/dashboard') ?>">
                Dashboard
            </a> /

            <a href="<?= base_url('admin/transaction-package') ?>">
                Transactions
            </a> /

        </span>

        <?=$page_title?>

    </h4>

    <div class="row">

        <div class="col-md-12">

            <div class="card mb-4">

                <div class="card-header">
                    <h5>Owner Information</h5>
                </div>

                <div class="card-body">

                    <table class="table">

                        <tr>
                            <th>Name</th>
                            <td><?= $transaction->username ?></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><?= $transaction->email ?></td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td><?= $transaction->mobile_phone ?></td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

        <div class="col-md-12">

            <div class="card mb-4">

                <div class="card-header">
                    <h5>Package Information</h5>
                </div>

                <div class="card-body">

                    <table class="table">

                        <tr>
                            <th>Package</th>
                            <td><?= $transaction->package_name ?></td>
                        </tr>

                        <tr>
                            <th>Center Limit</th>
                            <td>
                                <?= $transaction->max_centers == -1 ? 'Unlimited' : $transaction->max_centers ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Booking Limit</th>
                            <td>
                                <?= $transaction->max_bookings == -1 ? 'Unlimited' : $transaction->max_bookings ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Duration</th>
                            <td>
                                <?= $transaction->duration .' '. ucfirst($transaction->duration_type) ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Support</th>
                            <td><?= $transaction->support_type ?></td>
                        </tr>

                        <tr>
                            <th>Verified Badge</th>
                            <td>
                                <?= $transaction->verified_badge ? 'Yes' : 'No' ?>
                            </td>
                        </tr>

                        <tr>
                            <th>Free User Limit</th>
                            <td>
                                <?= $transaction->free_user_limit ?: 'Unlimited' ?>
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <h5>Transaction Details</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">

                    <label>Subscription Type</label>

                    <h6><?= ucfirst($transaction->subscription_type) ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Gateway</label>

                    <h6><?= $transaction->payment_gateway ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Amount</label>

                    <h6>₹ <?= number_format($transaction->amount,2) ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>GST</label>

                    <h6>₹ <?= number_format($transaction->gst_amount,2) ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Total Amount</label>

                    <h6>₹ <?= number_format($transaction->total_amount,2) ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Transaction ID</label>

                    <h6><?= $transaction->gateway_transaction_id ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Bank Ref No</label>

                    <h6><?= $transaction->bank_refno ?? '--' ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Status</label>

                    <h6>

                        <?php

                        $statusClass = 'bg-secondary';

                        switch (strtoupper($transaction->payment_status)) {
                        
                            case 'SUCCESS':
                                $statusClass = 'bg-success';
                                break;
                        
                            case 'PENDING':
                                $statusClass = 'bg-warning';
                                break;
                        
                            case 'FAILED':
                                $statusClass = 'bg-danger';
                                break;
                        }
                        ?>

                        <span class="badge <?= $statusClass ?>">
                            <?= strtoupper($transaction->payment_status) ?>
                        </span>

                    </h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Subscription Status</label>

                    <h6>

                        <?php if($transaction->is_active == 1){ ?>

                            <span class="badge bg-success">
                                Active
                            </span>

                        <?php } else { ?>

                            <span class="badge bg-danger">
                                Inactive
                            </span>

                        <?php } ?>

                    </h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Start Date</label>

                    <h6><?= !empty($transaction->start_date)
                        ? date('d M Y',strtotime($transaction->start_date))
                        : '--' ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Expiry Date</label>

                    <h6><?= !empty($transaction->expiry_date)
                        ? date('d M Y',strtotime($transaction->expiry_date))
                        : '--' ?></h6>

                </div>

                <div class="col-md-4 mb-3">

                    <label>Created At</label>

                    <h6><?= date('d M Y h:i A',strtotime($transaction->created_at)) ?></h6>

                </div>

            </div>

        </div>

    </div>

</div>

</div>