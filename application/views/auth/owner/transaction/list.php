<style>
    .empty-history-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        gap: 1.25rem;
        padding: 3rem 2rem;
        margin: 10% auto;
        width: 100%;
        max-width: 640px;
        background: #EFF6FF;
        border-radius: 2rem;
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06), 0 4px 10px rgba(0, 0, 0, 0.02);
    }

    .empty-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        background: #f0f5fe;
        border-radius: 50%;
        color: #2c6bff;
        font-size: 2.8rem;
        flex-shrink: 0;
    }

    .empty-title {
        font-size: 1.6rem;
        font-weight: 600;
        color: #1e293b;
        margin: 0;
        line-height: 1.2;
    }

    .empty-sub {
        font-size: 1rem;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }

    /* Responsive */
    @media (max-width: 480px) {
        .empty-history-state {
            padding: 2.5rem 1.5rem;
        }

        .empty-icon {
            width: 68px;
            height: 68px;
            font-size: 2.4rem;
        }

        .empty-title {
            font-size: 1.4rem;
        }
    }
</style>
<div class="col-10 p-0 ">
    <div class="booking-center active">
        <!-- ///////////// Header section start -->
        <div class="my-booking-wrapper d-flex justify-content-between align-items-center py-3 border-bottom">

            <div class="my-booking-header ps-4">
                <h2 class="m-0 fs-3 text-white">Transaction History</h2>

            </div>

            <?php $this->load->view('auth/owner/dashboard/common/notification'); ?>

        </div>

        <!-- Table section -->
        <div class="main-contant mt-0">
            <div class="mt-0">
                <?php if (empty($history)): ?>
                    <div class="empty-history-state">
                        <div class="empty-icon">
                            <i class="fas fa-receipt"></i>
                        </div>
                        <h3 class="empty-title">No history found</h3>
                        <p class="empty-sub">Transactions you make will appear here</p>
                    </div>
                <?php else: ?>
                    <div class="border-0 shadow-sm">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table id="historyTable" class="table table-hover table-striped align-middle w-100">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>#</th>
                                            <th>Order ID</th>
                                            <th>Package</th>
                                            <th>Amount</th>
                                            <th>GST</th>
                                            <th>Total</th>
                                            <th>Gateway</th>
                                            <th>Payment Status</th>
                                            <th>Subscription</th>
                                            <th>Start Date</th>
                                            <th>Expiry Date</th>
                                            <th>Remaining Days</th>
                                            <th>Created At</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-group-divider">
                                        <?php foreach ($history as $key => $row) { ?>

                                            <tr>

                                                <td><?= $key + 1 ?></td>

                                                <td><?= $row->order_id ?></td>

                                                <td><?= $row->package_name ?></td>

                                                <td>₹<?= $row->amount ?></td>

                                                <td>₹<?= $row->gst_amount ?></td>

                                                <td><strong>₹<?= $row->total_amount ?></strong></td>

                                                <td><?= ucfirst($row->payment_gateway) ?></td>

                                                <td>
                                                    <?php if ($row->payment_status == 'success') { ?>
                                                        <span class="badge bg-success">Success</span>
                                                    <?php } elseif ($row->payment_status == 'pending') { ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                    <?php } else { ?>
                                                        <span class="badge bg-danger">Failed</span>
                                                    <?php } ?>
                                                </td>

                                                <td><?= ucfirst($row->subscription_status) ?></td>

                                                <td>
                                                    <?= !empty($row->start_date) ? date('d M Y', strtotime($row->start_date)) : '-' ?>
                                                </td>

                                                <td>
                                                    <?= !empty($row->expiry_date) ? date('d M Y', strtotime($row->expiry_date)) : '-' ?>
                                                </td>

                                                <td>
                                                    <?= $row->remaining_days !== null ? $row->remaining_days . ' Days' : '-' ?>
                                                </td>

                                                <td>
                                                    <?= date('d M Y h:i A', strtotime($row->created_at)) ?>
                                                </td>

                                            </tr>

                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>