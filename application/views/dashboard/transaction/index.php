<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>


        <div class="module-statistics" id="subscription-transaction-statistics">

            <!-- Total Transactions -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-receipt"></i>
                </div>

                <div class="stat-content">
                    <span>Total Transactions</span>
                    <strong><?= $total_transactions ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    All Transactions
                </div>

            </div>


            <!-- Successful Transactions -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Successful</span>
                    <strong><?= $successful_transactions ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Successful Payments
                </div>

            </div>


            <!-- Failed Transactions -->
            <div class="stat-card stat-danger">

                <div class="stat-icon">
                    <i class="ti ti-circle-x"></i>
                </div>

                <div class="stat-content">
                    <span>Failed</span>
                    <strong><?= $failed_transactions ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Failed Payments
                </div>

            </div>


            <!-- Total Revenue -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-currency-rupee"></i>
                </div>

                <div class="stat-content">
                    <span>Total Revenue</span>
                    <strong>
                        ₹<?= number_format($total_revenue ?? 0, 2) ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Successful Payments
                </div>

            </div>


            <!-- Subscribed Owners -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-users"></i>
                </div>

                <div class="stat-content">
                    <span>Subscribed Owners</span>
                    <strong><?= $subscribed_owners ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Unique Owners
                </div>

            </div>

        </div>


        <div class="card mt-4 mb-5">

            <div class="card-header">
                <h5 class="mb-0">Package Performance</h5>
            </div>

            <div class="table-responsive">

                <table class="table">

                    <thead>
                        <tr>
                            <th>PACKAGE</th>
                            <th>PURCHASES</th>
                            <th>REVENUE</th>
                            <th>GST COLLECTED</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($package_statistics)) : ?>

                            <?php foreach ($package_statistics as $package) : ?>

                                <tr>

                                    <td>
                                        <strong>
                                            <?= htmlspecialchars($package->package_name) ?>
                                        </strong>
                                    </td>

                                    <td>
                                        <?= $package->purchase_count ?>
                                    </td>

                                    <td>
                                        ₹<?= number_format(
                                                $package->total_revenue ?? 0,
                                                2
                                            ) ?>
                                    </td>

                                    <td>
                                        ₹<?= number_format(
                                                $package->total_gst ?? 0,
                                                2
                                            ) ?>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else : ?>

                            <tr>
                                <td colspan="4" class="text-center">
                                    No successful transactions found.
                                </td>
                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>


        <div class="row mb-5">

            <div class="col-md-3">
                <select id="package_id" class="form-select select2">
                    <option value="">All Packages</option>

                    <?php foreach ($packages as $package) { ?>

                        <option value="<?= $package->id ?>">
                            <?= $package->name ?>
                        </option>

                    <?php } ?>
                </select>
            </div>

            <div class="col-md-3">
                <select id="admin_id" class="form-select select2">
                    <option value="">All Owner</option>

                    <?php foreach ($admins as $admin) { ?>

                        <option value="<?= $admin->id ?>">
                            <?= $admin->username ?>
                        </option>

                    <?php } ?>
                </select>
            </div>

            <div class="col-md-2">
                <input type="date"
                    id="from_date"
                    class="form-control">
            </div>

            <div class="col-md-2">
                <input type="date"
                    id="to_date"
                    class="form-control">
            </div>

            <div class="col-md-2">
                <select id="payment_status" class="form-select select2">

                    <option value="">All Status</option>
                    <option value="SUCCESS">Success</option>
                    <option value="FAILED">Failed</option>
                    <option value="PENDING">Pending</option>

                </select>
            </div>

        </div>


        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="transactionTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>ID</th>
                            <th>Owner</th>
                            <th>Package</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Transaction Id</th>
                            <th>Purchase Date</th>
                            <th>Expiry Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script>
    $(document).ready(function() {
        const table = $('#transactionTable').DataTable({

            processing: true,
            serverSide: true,
            order: [
                [0, 'desc']
            ],
            searching: false,

            ajax: {
                url: "<?= base_url('admin/transaction-package/ajax-list') ?>",
                type: "POST",

                data: function(d) {

                    d.package_id = $('#package_id').val();
                    d.admin_id = $('#admin_id').val();
                    d.payment_status = $('#payment_status').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },

            columns: [{
                    data: 'id'
                },
                {
                    data: 'user'
                },
                {
                    data: 'package'
                },
                {
                    data: 'amount'
                },
                {
                    data: 'payment_status'
                },
                {
                    data: 'transaction_id'
                },
                {
                    data: 'date'
                },
                {
                    data: 'expiry_date'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $('#package_id,#admin_id,#payment_status,#from_date,#to_date')
            .on('change', function() {
                table.ajax.reload();
            });

    });
</script>