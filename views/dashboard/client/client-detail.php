<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a> /
                        <a href="<?= base_url('admin/clients') ?>">Client List</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>


        <!-- =================  Statistics Cards ================= -->
        <div class="module-statistics" id="client-overview-statistics">

            <!-- Total Projects -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-briefcase"></i>
                </div>

                <div class="stat-content">
                    <span>Total Projects</span>
                    <strong><?= $client_stats['total_projects'] ?></strong>
                </div>

                <div class="stat-footer">
                    All Projects
                </div>

            </div>


            <!-- Active Projects -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-player-play"></i>
                </div>

                <div class="stat-content">
                    <span>Active Projects</span>
                    <strong><?= $client_stats['active_projects'] ?></strong>
                </div>

                <div class="stat-footer">
                    Running Projects
                </div>

            </div>


            <!-- Upcoming Projects -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>

                <div class="stat-content">
                    <span>Upcoming</span>
                    <strong><?= $client_stats['upcoming_projects'] ?></strong>
                </div>

                <div class="stat-footer">
                    Starting Soon
                </div>

            </div>


            <!-- Completed Projects -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Completed</span>
                    <strong><?= $client_stats['completed_projects'] ?></strong>
                </div>

                <div class="stat-footer">
                    Finished Projects
                </div>

            </div>


            <!-- Cities Covered -->
            <div class="stat-card stat-info">

                <div class="stat-icon">
                    <i class="ti ti-building-community"></i>
                </div>

                <div class="stat-content">
                    <span>Cities Covered</span>
                    <strong><?= $client_stats['cities_covered'] ?></strong>
                </div>

                <div class="stat-footer">
                    Total Cities
                </div>

            </div>


            <!-- Centers Used -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-building"></i>
                </div>

                <div class="stat-content">
                    <span>Centers Used</span>
                    <strong><?= $client_stats['centers_used'] ?></strong>
                </div>

                <div class="stat-footer">
                    Total Centers
                </div>

            </div>


            <!-- Seats Allocated -->
            <div class="stat-card stat-cyan">

                <div class="stat-icon">
                    <i class="ti ti-armchair"></i>
                </div>

                <div class="stat-content">
                    <span>Seats Allocated</span>
                    <strong><?= $client_stats['seats_allocated'] ?? 0 ?></strong>
                </div>

                <div class="stat-footer">
                    Allocated Seats
                </div>

            </div>

        </div>

        <!-- ================= Client Overview ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Client Overview</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Company Name :</strong> <?= $client->company_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Company Type :</strong> <?= $client->company_type ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Website :</strong> <?= $client->website ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Username :</strong> <?= $client->username ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Email :</strong> <?= $client->email ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Mobile :</strong> <?= $client->mobile_phone ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= LOGO ================= -->
        <?php if (!empty($client->logo)) { ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Company Logo</h5>
                </div>
                <div class="card-body text-center">
                    <img src="<?= CLIENT_URL . '/uploads/client_logo/' . $client->logo ?>"
                        class="img-fluid rounded"
                        style="max-height:150px;">
                </div>
            </div>
        <?php } ?>


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Address Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <strong>Address :</strong> <?= $client->address ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Country Code :</strong> <?= $client->country_code ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Area Code :</strong> <?= $client->area_code ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Landline Number :</strong> <?= $client->landline_number ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>City :</strong> <?= $client->city_name ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>State :</strong> <?= $client->state_name ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Country :</strong> <?= $client->country_name ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Pincode :</strong> <?= $client->pincode ?>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Coordinator Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-3 mb-3">
                        <strong>Name :</strong> <?= $client->co_ordinator_name ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Email :</strong> <?= $client->coordinator_email ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Mobile :</strong> <?= $client->coordinator_mobile_number ?>
                    </div>

                    <div class="col-md-3 mb-3">
                        <strong>Alternative Mobile :</strong> <?= $client->coordinator_alternative_number ?>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Bank Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Bank Name :</strong> <?= $client->bank_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Account No :</strong> <?= $client->bank_account_no ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>IFSC :</strong> <?= $client->bank_ifsc_code ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Gst State Code :</strong> <?= $client->gst_state_code ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Gst Number :</strong> <?= $client->bank_beneficial_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Bank Beneficial Name :</strong> <?= $client->bank_beneficial_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Pan Number :</strong> <?= $client->pan_number ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Udyam Number :</strong> <?= $client->udyam_number ?>
                    </div>

                </div>
            </div>
        </div>


        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Agreement Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-6 mb-3">
                        <strong>Start Date :</strong> <?= $client->agreement_start_date ?>
                    </div>

                    <div class="col-md-6 mb-3">
                        <strong>End Date :</strong> <?= $client->agreement_end_date ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= DOCUMENTS ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Documents</h5>
            </div>
            <div class="card-body">

                <?php

                $documents = [
                    'Agreement Document'        => $client->agreement_doc,
                    'MOU Document'              => $client->mou_doc,
                    'GST Document'              => $client->gst_doc,
                    'Udyam Document'            => $client->udyam_doc,
                    'NDA Document'              => $client->nda_doc,
                    'Canceled Cheque Document'  => $client->canceled_cheque_doc,
                    'PAN Document'              => $client->pan_number_doc,
                ];

                $hasDocument = false;

                ?>

                <ul class="list-group">

                    <?php foreach ($documents as $label => $file): ?>

                        <?php if (!empty($file)): ?>
                            <?php $hasDocument = true; ?>

                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <?= $label ?>

                                <a target="_blank"
                                    href="<?= CLIENT_URL . '/uploads/client_document/' . $file ?>"
                                    class="btn btn-sm btn-primary">
                                    View
                                </a>
                            </li>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </ul>

                <?php if (!$hasDocument): ?>
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> No documents uploaded found.
                    </div>
                <?php endif; ?>

            </div>

        </div>


        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Client Project History</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-bordered">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Exam</th>
                            <th>Dates</th>
                            <th>Seats</th>
                            <th>Centers</th>
                            <th>Booking Status</th>
                            <th>Project Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($projects)) { ?>
                            <?php foreach ($projects as $project) {
                                $encodedProjectId = rtrim(strtr(base64_encode($project->project_id), '+/', '-_'), '=');
                            ?>
                                <tr>
                                    <td><?= $project->exam_name ?>
                                        <br>
                                        Project ID: <strong><?= $project->project_id ?></strong>
                                        <br>
                                        City Name : <strong><?= $project->city_name ?></strong>
                                        <br>
                                        <a target="_blank" href="<?= base_url('admin/view-project-detail/' . $encodedProjectId . '/' . $project->exam_city_id) ?>" class="btn btn-sm btn-info mb-1"> View Detail</a>
                                    </td>

                                    <td>
                                        <?= date('d M Y', strtotime($project->start_date)) ?>
                                        <br>
                                        <?= date('d M Y', strtotime($project->end_date)) ?>
                                    </td>

                                    <td>
                                        <?= $project->number_of_seats ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-info">
                                            <?= $project->center_count ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?php if ($project->booking_status == 'Approved') { ?>
                                            <span class="badge bg-success">Approved</span>
                                        <?php } elseif ($project->booking_status == 'Partial') { ?>
                                            <span class="badge bg-warning">Partial</span>
                                        <?php } else { ?>
                                            <span class="badge bg-secondary">Pending</span>
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?= $project->project_status ?>
                                    </td>

                                    <td>
                                        <a target="_blank" href="<?= base_url('admin/project-overview/' . $encodedProjectId . '/' . $project->exam_city_id) ?>"
                                            class="btn btn-success btn-sm">
                                            Project Overview
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="6" class="text-center">No Projects Found</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <hr>

                <div class="row text-center">

                    <div class="col-md-4">
                        <h5 class="mb-1">
                            <?= $project_summary['total_projects']; ?>
                        </h5>
                        <small class="text-muted">
                            Total Projects
                        </small>
                    </div>

                    <div class="col-md-4">
                        <h5 class="mb-1">
                            <?= $project_summary['total_seats']; ?>
                        </h5>
                        <small class="text-muted">
                            Total Seats Required
                        </small>
                    </div>

                    <div class="col-md-4">
                        <h5 class="mb-1">
                            <?= $project_summary['total_centers']; ?>
                        </h5>
                        <small class="text-muted">
                            Centers Assigned
                        </small>
                    </div>

                </div>
            </div>
        </div>


    </div>
</div>