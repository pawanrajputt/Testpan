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

        <!-- ================= Project Overview ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Project Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Project ID :</strong> <?= $project->project_id ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Status :</strong>
                        <?php
                        $project_status = getProjectStatusBadge($project);
                        $projectRemark = isHaveAnyRemark($project->project_remark);
                        echo $project_status . ' ' . $projectRemark;
                        ?>
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

                    <div class="col-md-6 mb-3">
                        <strong>Company Name :</strong> <?= $project->company_name ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>Company Type :</strong> <?= $project->company_type ?>
                    </div>

                    <?php if (!empty($project->logo)) { ?>
                        <div class="col-md-6 mb-3">
                            <strong>Company Logo :</strong>
                            <div class="card-body text-center">
                                <img src="<?= CLIENT_URL . '/uploads/client_logo/' . $project->logo ?>"
                                    class="img-fluid rounded"
                                    style="max-height:100px;">
                            </div>
                        </div>
                    <?php } ?>

                    <div class="col-md-6 mb-3">
                        <strong>Address :</strong> <?= $project->logo ?>
                    </div>

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