<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-6">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
            <div class="col-md-6">
                <div class="table-btn-css">
                    <a href="<?= base_url('admin/subscription-packages/create') ?>"><button class="btn btn-custom waves-effect waves-light"><span class="ti-xs ti ti-plus me-1"></span>
                            Add Package</button></a>
                </div>
            </div>
        </div>

        <div class="module-statistics" id="subscription-package-statistics">

            <!-- Total Packages -->
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="ti ti-package"></i>
                </div>

                <div class="stat-content">
                    <span>Total Packages</span>
                    <strong><?= $total_packages ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    All Packages
                </div>
            </div>

            <!-- Active Packages -->
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Active Packages</span>
                    <strong><?= $active_packages ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Active
                </div>
            </div>

            <!-- Inactive Packages -->
            <div class="stat-card stat-danger">
                <div class="stat-icon">
                    <i class="ti ti-circle-x"></i>
                </div>

                <div class="stat-content">
                    <span>Inactive Packages</span>
                    <strong><?= $inactive_packages ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Currently Inactive
                </div>
            </div>

        </div>

        <div class="card">
            <div class="card-datatable">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead class="table-primary-custom">
                            <tr>

                                <th>ID</th>

                                <th>Package</th>

                                <th>Price</th>

                                <th>Validity</th>

                                <th>Centers</th>

                                <th>Bookings</th>

                                <th>Support</th>

                                <th>Badge</th>

                                <th>GST</th>

                                <th>Status</th>

                                <th width="180">Action</th>

                            </tr>
                        </thead>
                        <tbody>

                            <?php if (!empty($packages)) { ?>

                                <?php foreach ($packages as $row) { ?>

                                    <tr>

                                        <!-- ID -->

                                        <td>
                                            #<?= $row->id ?>
                                        </td>



                                        <!-- Package -->

                                        <td>

                                            <div class="d-flex flex-column">

                                                <span class="badge mb-1"
                                                    style="
                                                        background: <?= $row->package_color ?>;
                                                        color:#fff;
                                                        width:fit-content;
                                                        padding:8px 12px;
                                                        font-size:13px;
                                                      ">

                                                    <?= $row->name ?>

                                                </span>

                                                <?php if ($row->is_recommended == 1) { ?>

                                                    <small class="text-warning fw-bold">

                                                        <?= !empty($row->tag_line)
                                                            ? $row->tag_line
                                                            : 'Recommended'
                                                        ?>

                                                    </small>

                                                <?php } ?>

                                            </div>

                                        </td>



                                        <!-- Price -->

                                        <td>

                                            <strong>
                                                ₹<?= number_format($row->price, 0) ?>
                                            </strong>

                                        </td>



                                        <!-- Duration -->

                                        <td>

                                            <?= $row->duration ?>
                                            <?= ucfirst($row->duration_type) ?>

                                        </td>



                                        <!-- Centers -->

                                        <td>

                                            <?php if ($row->max_centers == -1) { ?>

                                                <span class="badge bg-success">

                                                    Unlimited

                                                </span>

                                            <?php } else { ?>

                                                <?= $row->max_centers ?>

                                            <?php } ?>

                                        </td>



                                        <!-- Bookings -->

                                        <td>

                                            <?php if ($row->max_bookings == -1) { ?>

                                                <span class="badge bg-primary">

                                                    Unlimited

                                                </span>

                                            <?php } else { ?>

                                                <?= number_format($row->max_bookings) ?>

                                            <?php } ?>

                                        </td>



                                        <!-- Support -->

                                        <td>

                                            <?php

                                            $support_badge = 'secondary';

                                            if ($row->support_type == 'priority') {
                                                $support_badge = 'warning';
                                            }

                                            if ($row->support_type == 'dedicated') {
                                                $support_badge = 'dark';
                                            }

                                            ?>

                                            <span class="badge bg-<?= $support_badge ?>">

                                                <?= ucfirst($row->support_type) ?>

                                            </span>

                                        </td>



                                        <!-- Verified Badge -->

                                        <td>

                                            <?php if ($row->verified_badge == 1) { ?>

                                                <span class="badge bg-success">

                                                    Yes

                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-secondary">

                                                    No

                                                </span>

                                            <?php } ?>

                                        </td>



                                        <!-- GST -->

                                        <td>

                                            <?= $row->gst_percent ?>%

                                        </td>



                                        <!-- Status -->

                                        <td>

                                            <?php if ($row->status == 1) { ?>

                                                <span class="badge bg-success">

                                                    Active

                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-danger">

                                                    Inactive

                                                </span>

                                            <?php } ?>

                                        </td>



                                        <!-- Action -->

                                        <td>

                                            <div class="d-flex gap-1">

                                                <a href="<?= base_url('admin/subscription-packages/edit/' . $row->id) ?>"
                                                    class="btn btn-sm btn-primary">

                                                    Edit

                                                </a>

                                                <a href="javascript:void(0);"
                                                    class="btn btn-sm btn-danger delete-package-btn"
                                                    data-url="<?= base_url('admin/subscription-packages/delete/' . $row->id) ?>">

                                                    Delete

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="11" class="text-center">

                                        No Record Found...

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    $(document).on('click', '.delete-package-btn', function() {

        let deleteUrl = $(this).data('url');

        Swal.fire({
            title: 'Are you sure?',
            text: "This package will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete It',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }

        });

    });
</script>