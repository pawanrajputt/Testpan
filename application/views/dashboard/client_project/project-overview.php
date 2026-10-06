<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>

        <!-- ================= PROJECT STATISTICS ================= -->
        <div class="mb-4 mt-2">
            <div class="card-header mb-3">
                <h5 class="mb-0">Project Statistics</h5>
            </div>
            <div class="module-statistics" id="center-project-statistics">

                <!-- Requested Centers -->
                <div class="stat-card stat-primary">

                    <div class="stat-icon">
                        <i class="ti ti-building"></i>
                    </div>

                    <div class="stat-content">
                        <span>Requested Centers</span>
                        <strong><?= $project_stats['total_centers']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Total Requested
                    </div>

                </div>


                <!-- Approved Centers -->
                <div class="stat-card stat-success">

                    <div class="stat-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>

                    <div class="stat-content">
                        <span>Approved Centers</span>
                        <strong><?= $project_stats['approved_centers']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Approved
                    </div>

                </div>


                <!-- Pending Centers -->
                <div class="stat-card stat-warning">

                    <div class="stat-icon">
                        <i class="ti ti-clock"></i>
                    </div>

                    <div class="stat-content">
                        <span>Pending Centers</span>
                        <strong><?= $project_stats['pending_centers']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Awaiting Review
                    </div>

                </div>


                <!-- Rejected Centers -->
                <div class="stat-card stat-danger">

                    <div class="stat-icon">
                        <i class="ti ti-circle-x"></i>
                    </div>

                    <div class="stat-content">
                        <span>Rejected Centers</span>
                        <strong><?= $project_stats['rejected_centers']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Rejected
                    </div>

                </div>


                <!-- Hold Centers -->
                <div class="stat-card stat-purple">

                    <div class="stat-icon">
                        <i class="ti ti-player-pause"></i>
                    </div>

                    <div class="stat-content">
                        <span>Hold Centers</span>
                        <strong><?= $project_stats['hold_centers']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        On Hold
                    </div>

                </div>


                <!-- Negotiation Centers -->
                <div class="stat-card stat-info">

                    <div class="stat-icon">
                        <i class="ti ti-message-dots"></i>
                    </div>

                    <div class="stat-content">
                        <span>Negotiation Centers</span>
                        <strong><?= $project_stats['negotiation_requests']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Negotiation Requests
                    </div>

                </div>

            </div>
        </div>


        <!-- ================= BOOKING SUMMARY ================= -->
        <div class="mb-4 mt-2">
            <div class="card-header mb-3">
                <h5 class="mb-0">Booking Status Summary</h5>
            </div>
            <div class="module-statistics" id="booking-status-statistics">

                <!-- Total Assign Centers -->
                <div class="stat-card stat-primary">

                    <div class="stat-icon">
                        <i class="ti ti-building"></i>
                    </div>

                    <div class="stat-content">
                        <span>Total Assign Centers</span>
                        <strong><?= $booking_summary['total_requests']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        All Assignments
                    </div>

                </div>


                <!-- Admin Approved -->
                <div class="stat-card stat-success">

                    <div class="stat-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Approved</span>
                        <strong><?= $booking_summary['approved']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Approved
                    </div>

                </div>


                <!-- Admin Pending -->
                <div class="stat-card stat-warning">

                    <div class="stat-icon">
                        <i class="ti ti-clock"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Pending</span>
                        <strong><?= $booking_summary['pending']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Awaiting Review
                    </div>

                </div>


                <!-- Admin Rejected -->
                <div class="stat-card stat-danger">

                    <div class="stat-icon">
                        <i class="ti ti-circle-x"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Rejected</span>
                        <strong><?= $booking_summary['rejected']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        Rejected
                    </div>

                </div>


                <!-- Admin Hold -->
                <div class="stat-card stat-purple">

                    <div class="stat-icon">
                        <i class="ti ti-player-pause"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Hold</span>
                        <strong><?= $booking_summary['hold']; ?></strong>
                    </div>

                    <div class="stat-footer">
                        On Hold
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= Seat Fulfillment ================= -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5 class="mb-4">Seat Fulfillment</h5>

                <div class="row text-center">

                    <div class="col-md-3">
                        <h3><?= $seat_summary['required'] ?></h3>
                        <small>Required Seats</small>
                    </div>

                    <div class="col-md-3">
                        <h3 class="text-success">
                            <?= $seat_summary['booked'] ?>
                        </h3>
                        <small>Booked Seats</small>
                    </div>

                    <div class="col-md-3">
                        <h3 class="text-danger">
                            <?= $seat_summary['remaining'] ?>
                        </h3>
                        <small>Remaining Seats</small>
                    </div>

                    <div class="col-md-3">
                        <h3 class="text-primary">
                            <?= $seat_summary['progress'] ?>%
                        </h3>
                        <small>Completion</small>
                    </div>

                </div>

                <hr>

                <div class="progress" style="height:20px;">
                    <div class="progress-bar bg-success"
                        role="progressbar"
                        style="width:<?= $seat_summary['progress'] ?>%">
                        <?= $seat_summary['progress'] ?>%
                    </div>
                </div>

            </div>
        </div>

        <!-- ================= Manpower Requirement Overview ================= -->


        <!-- ================= ASSIGNED CENTERS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Assigned Centers</h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-primary-custom">
                            <tr>
                                <th>Center</th>
                                <th>City</th>
                                <th>Capacity</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Last Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($assigned_centers)) { ?>

                                <?php foreach ($assigned_centers as $row) { ?>

                                    <tr>

                                        <td>
                                            <?= $row->center_name ?>
                                        </td>

                                        <td>
                                            <?= $row->city_name ?>
                                        </td>

                                        <td>
                                            Capacity : <?= $row->capacity ?>
                                            <br>
                                            Requested : <?= $row->center_seat ?>
                                        </td>

                                        <td>
                                            <?= trim($row->first_name . ' ' . $row->last_name) ?>
                                            <br>
                                            <?= $row->owner_email ?>
                                            <br>
                                            <?= $row->owner_mobile ?>
                                        </td>

                                        <td>

                                            <?php if ($row->admin_status == 1) { ?>
                                                <span class="badge bg-success">
                                                    Approved
                                                </span>

                                            <?php } elseif ($row->admin_status == 2) { ?>

                                                <span class="badge bg-danger">
                                                    Rejected
                                                </span>

                                            <?php } elseif ($row->admin_status == 3) { ?>

                                                <span class="badge bg-secondary">
                                                    Hold
                                                </span>

                                            <?php } else { ?>

                                                <span class="badge bg-warning">
                                                    Pending
                                                </span>

                                            <?php } ?>

                                        </td>

                                        <td>
                                            <?= !empty($row->admin_action_date)
                                                ? date('d M Y', strtotime($row->admin_action_date))
                                                : '-' ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="6" class="text-center">
                                        No Centers Assigned Yet
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

        <!-- ================= Center Allocation ================= -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <h5 class="mb-3">
                    Center Allocation Timeline
                </h5>

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-primary-custom">
                            <tr>
                                <th>Date</th>
                                <th>Center</th>
                                <th>City</th>
                                <th>Seats</th>
                                <th>Center Status</th>
                                <th>Admin Status</th>
                                <th>Center Response</th>
                                <th>Admin Action</th>
                                <th>Remark</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (!empty($allocation_timeline)) { ?>

                                <?php foreach ($allocation_timeline as $row) { ?>

                                    <tr>

                                        <td>
                                            <?= !empty($row->created_at)
                                                ? date('d M Y', strtotime($row->created_at))
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($row->center_name)
                                                ? $row->center_name
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($row->city_name)
                                                ? $row->city_name
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= (int)$row->center_seat ?>
                                        </td>

                                        <td>

                                            <?php

                                            switch ($row->exam_center_status) {

                                                case 1:
                                                    echo '<span class="badge bg-success">Approved</span>';
                                                    break;

                                                case 2:
                                                    echo '<span class="badge bg-danger">Rejected</span>';
                                                    break;

                                                case 3:
                                                    echo '<span class="badge bg-info">Negotiation</span>';
                                                    break;

                                                default:
                                                    echo '<span class="badge bg-warning">Pending</span>';
                                            }

                                            ?>

                                        </td>

                                        <td>

                                            <?php

                                            switch ($row->admin_status) {

                                                case 1:
                                                    echo '<span class="badge bg-success">Approved</span>';
                                                    break;

                                                case 2:
                                                    echo '<span class="badge bg-danger">Rejected</span>';
                                                    break;

                                                case 3:
                                                    echo '<span class="badge bg-warning">Hold</span>';
                                                    break;

                                                case 4:
                                                    echo '<span class="badge bg-info">Not Required</span>';
                                                    break;

                                                default:
                                                    echo '<span class="badge bg-secondary">Pending</span>';
                                            }

                                            ?>

                                        </td>

                                        <td>
                                            <?= !empty($row->center_response_date)
                                                ? date('d M Y', strtotime($row->center_response_date))
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($row->admin_action_date)
                                                ? date('d M Y', strtotime($row->admin_action_date))
                                                : '-' ?>
                                        </td>

                                        <td>
                                            <?= !empty($row->admin_remark)
                                                ? $row->admin_remark
                                                : '-' ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="8" class="text-center">
                                        No Timeline Available
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>
        </div>

        <!-- ================= Project Overview ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Project Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Project ID :</strong> <?= $project->project_id ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>City :</strong> <?= $project->city_name; ?>
                    </div>

                    <?php

                    $projectStatus = getProjectStatusBadge($project);
                    $projectRemark = isHaveAnyRemark($project->project_remark);

                    ?>

                    <div class="col-md-4 mb-3">
                        <strong>Status :</strong>
                        <?= $projectStatus ?>
                        <?= $projectRemark ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Client Name :</strong> <?= $project->client_name ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Exam Name :</strong> <?= $project->exam_name ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Start Date :</strong> <?= date('d-m-Y', strtotime($project->start_date)) ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>End Date :</strong> <?= date('d-m-Y', strtotime($project->end_date)) ?>
                    </div>


                    <div class="mt-3">
                        <a target="_blank" href="<?= base_url('admin/booking-request-status/' . $projId . '/' . $exam_city_id) ?>"
                            class="btn btn-info btn-sm">
                            Booking Status
                        </a>

                    </div>

                </div>
            </div>
        </div>

        <!-- ================= Company Overview ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Company Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Company Name :</strong> <?= $project->company_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Company Type :</strong> <?= $project->company_type ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Address :</strong> <?= $project->address ?>
                    </div>

                    <?php if (!empty($project->logo)) { ?>
                        <div class="col-md-2 mb-3">
                            <strong>Company Logo :</strong>
                            <div class="card-body text-center">
                                <img src="<?= CLIENT_URL . '/uploads/client_logo/' . $project->logo ?>"
                                    class="img-fluid rounded"
                                    style="max-height:100px;">
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>

        <!-- ================= Location ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Location Details</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <strong>State :</strong> <?= $project->state_name ?>
                    </div>
                    <div class="col-md-6 mb-3">
                        <strong>City :</strong> <?= $project->city_name ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= Exam Details ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Exam Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Exam Type :</strong> <?= $project->exam_type ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Exam Mode :</strong>
                        <?= ucwords(strtolower(str_replace('_', ' ', $project->exam_mode))) ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Required Seats :</strong> <?= $project->exam_required_seat ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>OS :</strong> <?= $project->inet_mode_os ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>RAM :</strong> <?= $project->inet_mode_ram ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Display :</strong> <?= $project->inet_mode_display ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Internet Each :</strong> <?= $project->inet_mode_internet_each == 1 ?  'Yes' : 'No' ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= Batch Timings ================= -->
        <div class="card mb-4">

            <div class="card-header">

                <h5 class="mb-0">

                    City Wise Batch Details

                </h5>

            </div>

            <div class="card-body">

                <div class="mb-3">

                    <strong>Total Seats :</strong>

                    <?= $project->number_of_seats; ?>

                </div>

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th width="120">

                                Batch

                            </th>

                            <th>

                                Timing

                            </th>

                            <th width="150">

                                Seats

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if (!empty($project_batches)) { ?>

                            <?php foreach ($project_batches as $batch) { ?>

                                <tr>

                                    <td>

                                        Batch <?= $batch->batch_no; ?>

                                    </td>

                                    <td>

                                        <?= date('h:i A', strtotime($batch->batch_start)); ?>

                                        -

                                        <?= date('h:i A', strtotime($batch->batch_end)); ?>

                                    </td>

                                    <td>

                                        <?= $batch->seat; ?>

                                    </td>

                                </tr>

                            <?php } ?>

                        <?php } else { ?>

                            <tr>

                                <td colspan="3" class="text-center">

                                    No Batch Found

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

        <!-- ================= Facilities ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Facilities</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <?php
                    $facilities = [
                        'Parking Facility' => $project->parking_facility,
                        'Locker Facility' => $project->locker_facility,
                        'Waiting Area' => $project->waiting_area,
                        'Power Backup' => $project->power_backup,
                        'Printer' => $project->printer,
                        'Rough Sheet' => $project->rough_sheet,
                        'AC in Lab' => $project->ac_in_lab,
                        'CCTV Required' => $project->cctv_required,
                    ];

                    foreach ($facilities as $key => $value) { ?>
                        <div class="col-md-4 mb-2">
                            <strong><?= $key ?> :</strong>
                            <?= $value ? '<span class="text-success">Yes</span>' : '<span class="text-danger">No</span>' ?>
                        </div>
                    <?php } ?>

                    <div class="col-md-4 mb-2">
                        <strong>Security Guard :</strong>
                        <?= $project->security_guard ?>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= Staff Requirement ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Staff Requirement</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Center Superintendent Count :</strong> <?= $project->center_suptn_count ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Technical Person Count :</strong> <?= $project->tech_person_count ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Invigilator Ratio :</strong> <?= $project->invigilator_ratio ?>
                        <br>
                        <span>Male : <?= $project->invigilator_male ?></span> And <span>Female : <?= $project->invigilator_female ?></span>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Security Guard Ratio :</strong> <?= $project->security_guard_ratio ?>
                        <br>
                        <span>Male : <?= $project->security_guard_male ?></span> And <span>Female : <?= $project->security_guard_female ?></span>
                    </div>

                </div>
            </div>
        </div>

        <!-- ================= Pricing ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Pricing Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Client Price Per Seat :</strong>
                        ₹ <?= number_format($project->price_per_seat, 2) ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Admin Price Per Seat :</strong>
                        ₹ <?= number_format($project->admin_price_per_seat, 2) ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Total Seats :</strong>
                        <?= $project->number_of_seats ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Total Estimated Amount :</strong>
                        ₹ <?= number_format($project->number_of_seats * $project->admin_price_per_seat, 2) ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>