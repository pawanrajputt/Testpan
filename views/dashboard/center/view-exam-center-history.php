<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="<?= base_url('admin/dashboard') ?>">Dashboard</a> /
            </span>
            <?= $page_title ?>
        </h4>


        <div class="d-flex justify-content-end gap-2 mb-3">

            <a href="<?= base_url('center-history-export-excel/' . $center->center_id) ?>"
                id="exportExcelBtn"
                class="btn btn-success">
                <i class="ti ti-file-spreadsheet me-1"></i>
                Export Excel
            </a>

            <a href="<?= base_url('center-history-export-pdf/' . $center->center_id) ?>"
                id="exportPdfBtn"
                class="btn btn-danger">
                <i class="ti ti-file-type-pdf me-1"></i>
                Export PDF
            </a>

        </div>

        <!-- ================= Filters ================= -->
        <form method="GET" action="<?= current_url() ?>" class="card mb-5">

            <div class="row align-items-end mb-3 mt-3 card-body">

                <div class="col-md-2">
                    <label>Year</label>
                    <select class="form-select select2" name="year">
                        <option value="">All Years</option>

                        <?php foreach ($years as $y) { ?>
                            <option value="<?= $y->year ?>"
                                <?= ($this->input->get('year') == $y->year) ? 'selected' : '' ?>>
                                <?= $y->year ?>
                            </option>
                        <?php } ?>

                    </select>
                </div>

                <div class="col-md-2">
                    <label>Month</label>
                    <select class="form-select select2" name="month">

                        <option value="">All Months</option>

                        <?php foreach ($months as $key => $value) { ?>

                            <option value="<?= $key ?>"
                                <?= ($this->input->get('month') == $key) ? 'selected' : '' ?>>

                                <?= $value ?>

                            </option>

                        <?php } ?>

                    </select>
                </div>

                <div class="col-md-4">
                    <label>Date Range</label>
                    <input
                        type="text"
                        class="form-control"
                        id="daterange"
                        name="daterange"
                        value="<?= $this->input->get('daterange') ?>">
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bx bx-filter-alt"></i> Filter
                    </button>
                </div>

                <div class="col-md-2">
                    <a href="<?= current_url() ?>" class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>

            </div>

        </form>

        <!-- ================= Overview ================= -->
        <div class="mb-5">
            <div class="card-header mb-3">
                <h5 class="mb-0">Center Information</h5>
            </div>
            <div class="module-statistics" id="center-overview-statistics">

                <!-- Total Projects -->
                <div class="stat-card stat-primary">

                    <div class="stat-icon">
                        <i class="ti ti-briefcase"></i>
                    </div>

                    <div class="stat-content">
                        <span>Total Projects</span>
                        <strong><?= $center_stats['total_projects'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        All Projects
                    </div>

                </div>


                <!-- Admin Approved -->
                <div class="stat-card stat-success">

                    <div class="stat-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Approved</span>
                        <strong><?= $center_stats['approved_projects'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Approved Projects
                    </div>

                </div>


                <!-- Admin Rejected -->
                <div class="stat-card stat-danger">

                    <div class="stat-icon">
                        <i class="ti ti-circle-x"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Rejected</span>
                        <strong><?= $center_stats['rejected_projects'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Rejected Projects
                    </div>

                </div>

                <!-- Hold -->
                <div class="stat-card stat-purple">

                    <div class="stat-icon">
                        <i class="ti ti-player-pause"></i>
                    </div>

                    <div class="stat-content">
                        <span>Admin Hold</span>
                        <strong><?= $booking_summary['hold'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        On Hold
                    </div>

                </div>


                <!-- Seats Delivered -->
                <div class="stat-card stat-info">

                    <div class="stat-icon">
                        <i class="ti ti-armchair"></i>
                    </div>

                    <div class="stat-content">
                        <span>Seats Delivered</span>
                        <strong><?= number_format($center_stats['total_seats']) ?></strong>
                    </div>

                    <div class="stat-footer">
                        Total Seats
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= Booking Status ================= -->
        <div class="mb-5">
            <div class="card-header mb-3">
                <h5 class="mb-0">Booking Status Summary (Center Action)</h5>
            </div>
            <div class="module-statistics" id="booking-summary-statistics">

                <!-- Total Requests -->
                <div class="stat-card stat-primary">

                    <div class="stat-icon">
                        <i class="ti ti-building"></i>
                    </div>

                    <div class="stat-content">
                        <span>Total Requests</span>
                        <strong><?= $booking_summary['total_requests'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        All Requests
                    </div>

                </div>


                <!-- Approved -->
                <div class="stat-card stat-success">

                    <div class="stat-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>

                    <div class="stat-content">
                        <span>Approved</span>
                        <strong><?= $booking_summary['approved'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Approved Requests
                    </div>

                </div>


                <!-- Pending -->
                <div class="stat-card stat-warning">

                    <div class="stat-icon">
                        <i class="ti ti-clock"></i>
                    </div>

                    <div class="stat-content">
                        <span>Pending</span>
                        <strong><?= $booking_summary['pending'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Awaiting Review
                    </div>

                </div>


                <!-- Rejected -->
                <div class="stat-card stat-danger">

                    <div class="stat-icon">
                        <i class="ti ti-circle-x"></i>
                    </div>

                    <div class="stat-content">
                        <span>Rejected</span>
                        <strong><?= $booking_summary['rejected'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Rejected Requests
                    </div>

                </div>


                <!-- Negotiation -->
                <div class="stat-card stat-info">

                    <div class="stat-icon">
                        <i class="ti ti-message-dots"></i>
                    </div>

                    <div class="stat-content">
                        <span>Negotiation</span>
                        <strong><?= $booking_summary['negotiation'] ?></strong>
                    </div>

                    <div class="stat-footer">
                        Negotiation Requests
                    </div>

                </div>

            </div>
        </div>

        <!-- ================= Project Booking History ================= -->
        <div class="card mb-4">

            <div class="card-header">
                <h5 class="mb-0">
                    Project Booking History
                </h5>
            </div>

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-bordered">

                        <thead class="table-primary-custom">

                            <tr>

                                <th>Exam</th>

                                <th>Client</th>

                                <th>Seats</th>

                                <th>Booking Date</th>

                                <th>Booking Status</th>

                                <th>Project Status</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($project_history)) { ?>

                                <?php foreach ($project_history as $row) {

                                    // =====================================================
                                    // CITY-WISE SEAT ALLOCATION
                                    // =====================================================

                                    $seat = getProjectSeatAllocation(
                                        $row->project_id,
                                        $row->exam_city_id
                                    );


                                    $requiredSeats =
                                        $seat['required'];

                                    $allocatedSeats =
                                        $seat['allocated'];

                                    // =====================================================
                                    // SEAT PROGRESS
                                    // =====================================================

                                    $seatProgress =
                                        getSeatProgressHtml($seat);


                                    // =====================================================
                                    // ALLOCATION / REQUIREMENT STATUS
                                    // =====================================================

                                    $allocationStatus =
                                        $seat['badge'];

                                ?>

                                    <tr>

                                        <td>

                                            <strong>
                                                <?= $row->exam_name ?>
                                            </strong>

                                            <br>

                                            Project :
                                            <?= $row->project_id ?>

                                            <br>

                                            Exam Date :
                                            <?= date(
                                                'd M',
                                                strtotime(
                                                    $row->start_date
                                                )
                                            ) ?>

                                            -

                                            <?= date(
                                                'd M Y',
                                                strtotime(
                                                    $row->end_date
                                                )
                                            ) ?>

                                            <br>

                                            City :
                                            <?= $row->city_name ?>

                                        </td>

                                        <td>
                                            <?= $row->company_name ?>
                                        </td>

                                        <td>

                                            <?= $seatProgress ?>
                                            <br>
                                            <?= $allocationStatus ?>

                                        </td>

                                        <td>

                                            <?= date(
                                                'd M Y',
                                                strtotime($row->created_at)
                                            ) ?>

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

                                                default:

                                                    echo '<span class="badge bg-secondary">Pending</span>';
                                            }

                                            ?>

                                        </td>

                                        <td>
                                            <?php
                                            $project_status = getProjectStatusBadge($row);
                                            $projectRemark = isHaveAnyRemark($row->project_remark);
                                            echo $project_status . ' ' . $projectRemark;
                                            ?>
                                        </td>

                                        <td>

                                            <?php

                                            $encodedProjectId =
                                                rtrim(
                                                    strtr(
                                                        base64_encode($row->project_id),
                                                        '+/',
                                                        '-_'
                                                    ),
                                                    '='
                                                );

                                            ?>

                                            <a
                                                href="<?= base_url(
                                                            'admin/project-overview/' .
                                                                $encodedProjectId .
                                                                '/' .
                                                                $row->city_id
                                                        ) ?>"
                                                class="btn btn-success btn-sm"
                                                target="_blank">
                                                Project Overview
                                            </a>

                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>

                                    <td colspan="7" class="text-center">

                                        No Project History Found

                                    </td>

                                </tr>

                            <?php } ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- ================= Revenue & Performance Analytics ================= -->
        <div class="card mb-4">

            <div class="card-header">
                <h5 class="mb-0">
                    Revenue & Performance Analytics
                </h5>
            </div>

            <div class="card-body">

                <div class="row text-center">

                    <div class="col-md-3">

                        <h3 class="text-primary">
                            <?= number_format(
                                $revenue_stats['total_seats']
                            ) ?>
                        </h3>

                        <small>
                            Seats Delivered
                        </small>

                    </div>

                    <div class="col-md-3">

                        <h3 class="text-success">

                            ₹<?= number_format(
                                    $revenue_stats['total_revenue']
                                ) ?>

                        </h3>

                        <small>
                            Total Revenue
                        </small>

                    </div>

                    <div class="col-md-3">

                        <h3 class="text-info">

                            ₹<?= number_format(
                                    $revenue_stats['avg_price']
                                ) ?>

                        </h3>

                        <small>
                            Avg Price / Seat
                        </small>

                    </div>

                    <div class="col-md-3">

                        <h3 class="text-warning">

                            <?= number_format(
                                $revenue_stats['highest_booking']
                            ) ?>

                        </h3>

                        <small>
                            Highest Seats Booked
                        </small>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-12 text-center">

                        <strong>
                            Latest Booking :
                        </strong>

                        <?= !empty($revenue_stats['latest_booking'])
                            ? date(
                                'd M Y h:i A',
                                strtotime(
                                    $revenue_stats['latest_booking']
                                )
                            )
                            : 'N/A'
                        ?>

                    </div>

                </div>

            </div>

        </div>

        <!-- ================= BASIC INFO ================= -->
        <div class="card mb-5">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="mb-0">Center Information</h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-12 mb-3">
                        <strong>Center Name :</strong> <?= $center->center_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Country :</strong> <?= $center->country_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>State :</strong> <?= $center->state_name ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>City :</strong> <?= $center->city_name ?>
                    </div>


                    <div class="col-md-4 mb-3">
                        <strong>Owner Name :</strong> <?= $center->username ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Owner Email :</strong> <?= $center->useremail ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Owner Phone :</strong> <?= $center->userphone ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Local Area Name :</strong> <?= $center->local_area_name ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Pincode :</strong> <?= $center->pin_code ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Landmark :</strong> <?= $center->landmark ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Capacity :</strong> <?= $center->capacity ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Center ID :</strong> <?= $center->id ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Type Of Center :</strong> <?= $center->type_of_center ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Status :</strong>
                        <?php if ($center->approved == 1) { ?>
                            <span class="badge bg-success">Approved</span>
                        <?php } else { ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php } ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Created At :</strong> <?= date('Y-m-d', strtotime($center->created_on)) ?? '--' ?>
                    </div>

                    <div class="col-md-12 mb-3">
                        <strong>Description :</strong> <?= $center->center_description ?? '--' ?>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
<script>
    $('#daterange').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    var oldValue = "<?= $this->input->get('daterange'); ?>";

    if (oldValue != '') {
        $('#daterange').val(oldValue);
    }

    $('#daterange').on('apply.daterangepicker', function(ev, picker) {

        $(this).val(
            picker.startDate.format('YYYY-MM-DD') +
            ' - ' +
            picker.endDate.format('YYYY-MM-DD')
        );

    });

    $('#daterange').on('cancel.daterangepicker', function() {
        $(this).val('');
    });
</script>

<!-- Export Data -->
<script>
    function updateExportLinks() {

        let year = $('select[name="year"]').val() || '';
        let month = $('select[name="month"]').val() || '';
        let dateRange = $('input[name="daterange"]').val() || '';

        let params = new URLSearchParams();

        if (year) {
            params.append('year', year);
        }

        if (month) {
            params.append('month', month);
        }

        if (dateRange) {
            params.append('daterange', dateRange);
        }

        let queryString = params.toString();

        let excelUrl = "<?= base_url('admin/center-history-export-excel/' . $center->center_id) ?>";
        let pdfUrl = "<?= base_url('admin/center-history-export-pdf/' . $center->center_id) ?>";

        if (queryString) {
            excelUrl += '?' + queryString;
            pdfUrl += '?' + queryString;
        }

        $('#exportExcelBtn').attr('href', excelUrl);
        $('#exportPdfBtn').attr('href', pdfUrl);
    }

    $(document).ready(function() {

        updateExportLinks();

        $('select[name="year"], select[name="month"], input[name="daterange"]')
            .on('change keyup', function() {
                updateExportLinks();
            });

    });
</script>