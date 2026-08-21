<style>
    .calendar-table td {
        position: relative;
        vertical-align: top;
    }

    .day-number {
        position: absolute;
        top: 5px;
        right: 8px;
        font-size: 13px;
        font-weight: 600;
    }

    .booking-count {

        font-size: 11px;
        line-height: 16px;
        margin-top: 18px;
        margin-left: 5px;
        text-align: left;

    }

    .self-count {

        color: #16a34a;
        font-weight: 600;

    }

    .assigned-count {

        color: #dc2626;
        font-weight: 600;

    }

    .dot {

        display: inline-block;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        margin-right: 4px;

    }

    .green {

        background: #16a34a;

    }

    .red {

        background: #dc2626;

    }

    /*month box*/
    .month-stepper {

        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;

    }

    .month-box {

        flex: 1;

        border: 1px solid #dfe4ea;

        border-radius: 10px;

        text-align: center;

        padding: 12px 8px;

        cursor: pointer;

        transition: .25s;

        background: #fff;

        position: relative;

    }

    .month-box:hover {

        transform: translateY(-3px);

        box-shadow: 0 4px 15px rgba(0, 0, 0, .08);

    }

    .month-box.active {

        border: 2px solid #4f7cff;

        background: #eef5ff;

    }

    .month-name {

        font-size: 13px;

        color: #777;

        font-weight: 600;

    }

    .month-count {

        font-size: 28px;

        font-weight: 700;

        color: #2d3748;

        line-height: 1.2;

    }

    .month-box:not(:last-child):after {

        content: '';

        position: absolute;

        right: -12px;

        top: 50%;

        width: 12px;

        height: 2px;

        background: #dcdcdc;

    }

    span#yearSelfBookingLabel,
    span#yearAssignedBookingLabel,
    span#yearTotalBookingLabel {
        margin-right: 2px;
    }

    /* =========================================================
   BOOKING SUMMARY
   ========================================================= */

    .booking-stat-groups {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }

    .booking-stat-group {
        background: #ffffff;
        border-radius: 14px;
        padding: 14px;

        box-shadow: 0 6px 20px rgba(31, 56, 100, 0.08);
        border: 1px solid #edf0f5;
    }

    .booking-stat-group-title {
        display: flex;
        align-items: center;
        gap: 7px;

        color: #1f4f8f;
        font-size: 14px;
        font-weight: 700;

        padding: 2px 4px 12px;
    }

    .booking-stat-group-title i {
        font-size: 18px;
    }

    .booking-stat-group-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }


    /* Mini Card */

    .booking-mini-card {
        position: relative;
        min-width: 0;

        min-height: 105px;
        padding: 12px;

        border-radius: 11px;

        display: flex;
        align-items: center;
        gap: 10px;

        color: #ffffff;

        overflow: hidden;

        display: inline-grid;
    }

    .booking-mini-card::after {
        content: "";

        position: absolute;
        width: 75px;
        height: 75px;

        right: -25px;
        top: -25px;

        background: rgba(255, 255, 255, 0.10);

        border-radius: 50%;
    }


    /* Icon */

    .booking-mini-icon {
        width: 25px;
        height: 25px;
        min-width: 25px;

        border-radius: 50%;

        background: rgba(255, 255, 255, 0.95);

        display: flex;
        align-items: center;
        justify-content: center;

        position: relative;
        z-index: 2;
    }

    .booking-mini-icon i {
        font-size: 19px;
    }


    /* Content */

    .booking-mini-content {
        position: relative;
        z-index: 2;

        min-width: 0;
    }

    .booking-mini-content span {
        display: block;

        font-size: 10px;
        font-weight: 700;

        text-transform: uppercase;

        line-height: 1.2;
    }

    .booking-mini-content strong {
        display: block;

        margin-top: 4px;

        font-size: 24px;
        line-height: 1;

        font-weight: 700;
    }


    /* Colors */

    .booking-self {
        background: linear-gradient(135deg, #2ecc71, #16a34a);
    }

    .booking-self .booking-mini-icon i {
        color: #16a34a;
    }

    .booking-assigned {
        background: linear-gradient(135deg, #ff5252, #e53935);
    }

    .booking-assigned .booking-mini-icon i {
        color: #e53935;
    }

    .booking-total {
        background: linear-gradient(135deg, #2979ff, #1557d6);
    }

    .booking-total .booking-mini-icon i {
        color: #1557d6;
    }


    /* Responsive */

    @media (max-width: 1200px) {

        .booking-stat-groups {
            grid-template-columns: 1fr;
        }

    }

    @media (max-width: 600px) {

        .booking-stat-group-cards {
            grid-template-columns: 1fr;
        }

    }
</style>
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

        <!-- Filter -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select id="monthSelect" class="form-control mr-2">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>>
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="yearSelect" class="form-control">
                            <?php for ($y = date('Y') - 1; $y <= date('Y') + 2; $y++): ?>
                                <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="centerSelect" class="form-control select2">
                            <option value="">Select Center</option>
                            <?php foreach ($all_centers as $center): ?>
                                <option value="<?= $center['center_id']; ?>">
                                    <?= $center['center_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Box -->
        <div class="booking-stat-groups" id="bookingSummary">

            <!-- Current Month -->
            <div class="booking-stat-group">

                <div class="booking-stat-group-title">
                    <i class="ti ti-calendar-month"></i>
                    <span>Current Month</span>
                </div>

                <div class="booking-stat-group-cards">

                    <div class="booking-mini-card booking-self">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-check"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Self Booking</span>
                            <strong id="selfBookingCount">
                                <?= $summary['self_booking']; ?>
                            </strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-assigned">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-share"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Assigned Booking</span>
                            <strong id="assignedBookingCount">
                                <?= $summary['assigned_booking']; ?>
                            </strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-total">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-event"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Total Booking</span>
                            <strong id="totalBookingCount">
                                <?= $summary['total_booking']; ?>
                            </strong>
                        </div>
                    </div>

                </div>
            </div>


            <!-- This Year -->
            <div class="booking-stat-group">

                <div class="booking-stat-group-title">
                    <i class="ti ti-calendar-stats"></i>
                    <span id="yearBookingTitle"><?= date('Y'); ?></span>
                </div>

                <div class="booking-stat-group-cards">

                    <div class="booking-mini-card booking-self">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-check"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Self Booking</span>
                            <strong id="yearSelfBookingCount">0</strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-assigned">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-share"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Assigned Booking</span>
                            <strong id="yearAssignedBookingCount">0</strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-total">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-event"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Total Booking</span>
                            <strong id="yearTotalBookingCount">0</strong>
                        </div>
                    </div>

                </div>
            </div>


            <!-- Overall -->
            <div class="booking-stat-group">

                <div class="booking-stat-group-title">
                    <i class="ti ti-chart-bar"></i>
                    <span>Overall</span>
                </div>

                <div class="booking-stat-group-cards">

                    <div class="booking-mini-card booking-self">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-check"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Self Booking</span>
                            <strong id="overallSelfBookingCount">0</strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-assigned">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-share"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Assigned Booking</span>
                            <strong id="overallAssignedBookingCount">0</strong>
                        </div>
                    </div>


                    <div class="booking-mini-card booking-total">
                        <div class="booking-mini-icon">
                            <i class="ti ti-calendar-event"></i>
                        </div>

                        <div class="booking-mini-content">
                            <span>Total Booking</span>
                            <strong id="overallTotalBookingCount">0</strong>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <!-- Month Box -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-center mb-3">

                    <div>
                        <h5 class="mb-0">
                            Monthly Assigned Booking
                            (<span id="selectedYear"><?= $year ?></span>)
                        </h5>
                    </div>

                    <small class="text-danger">
                        ● Counts are for Assigned Bookings Only
                    </small>

                </div>

                <div class="month-stepper">

                    <?php

                    $months = [
                        1 => "Jan",
                        2 => "Feb",
                        3 => "Mar",
                        4 => "Apr",
                        5 => "May",
                        6 => "Jun",
                        7 => "Jul",
                        8 => "Aug",
                        9 => "Sep",
                        10 => "Oct",
                        11 => "Nov",
                        12 => "Dec"
                    ];

                    foreach ($months as $key => $value):

                    ?>

                        <div
                            class="month-box <?= ($key == $month) ? 'active' : ''; ?>"
                            data-month="<?= $key ?>">

                            <div class="month-name">
                                <?= $value ?>
                            </div>

                            <div
                                class="month-count"
                                id="monthCount<?= $key ?>">

                                <?= isset($month_counts[$key]) ? $month_counts[$key] : 0 ?>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>
        </div>

        <!-- Calendar -->
        <div class="card">
            <div class="card-body">
                <div id="calendarContainer">
                    <?php
                    $this->load->view('dashboard/calendar/calendar_partial', [
                        'month' => $month,
                        'year' => $year,
                        'booked_dates' => $booked_dates
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Booked Centers</h3>
                    </div>
                    <div class="card-body">
                        <div id="bookingsTableContainer">
                            <div class="alert alert-info">Select a date to view bookings</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->


<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    const csrf_token = "<?php echo $this->security->get_csrf_hash() ?>";

    $(document).ready(function() {
        // Automatically load today's bookings on page load
        loadBookingSummary();
        loadMonthCounts();
        loadBookingStatistics();
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

        tooltipTriggerList.map(function(tooltipTriggerEl) {

            return new bootstrap.Tooltip(tooltipTriggerEl);

        });
        loadBookings('<?= date('Y-m-d') ?>');

        // Highlight today's date in calendar
        $('.calendar-table td[data-date="<?= date('Y-m-d') ?>"]').addClass('today');

        // Handle date selection
        $(document).on('click', '.calendar-table td[data-date]', function() {
            const date = $(this).data('date');
            // Remove previous highlights
            $('.calendar-table td').removeClass('selected-date');
            // Add highlight to selected date
            $(this).addClass('selected-date');
            loadBookings(date);
        });

        // Handle month/year change
        $('#monthSelect, #yearSelect, #centerSelect').change(function() {
            const month = $('#monthSelect').val();
            const year = $('#yearSelect').val();
            const center_id = $('#centerSelect').val(); // NEW

            $.ajax({
                url: base_url + 'admin/get-calendar',
                method: 'POST',
                data: {
                    month: month,
                    year: year,
                    center_id: center_id
                },
                success: function(response) {
                    $('#calendarContainer').html(response);

                    // Re-highlight today's date after calendar refresh
                    $('.calendar-table td[data-date="<?= date('Y-m-d') ?>"]').addClass('today');

                    loadBookingSummary();
                    loadMonthCounts();
                    loadBookingStatistics();


                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));

                    tooltipTriggerList.map(function(tooltipTriggerEl) {

                        return new bootstrap.Tooltip(tooltipTriggerEl);

                    });


                    $('.month-box').removeClass('active');

                    $('.month-box[data-month="' + $('#monthSelect').val() + '"]').addClass('active');
                },
                error: function(xhr, status, error) {
                    console.error("Error loading calendar:", error);
                }
            });
        });


        // Load bookings for a date
        function loadBookings(date) {
            $.ajax({
                url: base_url + 'admin/get-bookings-by-date',
                method: 'POST',
                data: {
                    date: date
                },
                success: function(response) {
                    $('#bookingsTableContainer').html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error loading bookings:", error);
                    $('#bookingsTableContainer').html('<div class="alert alert-danger">Error loading bookings</div>');
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        $('#centerSelect').select2({
            placeholder: "Search Center",
            allowClear: true,
            width: "100%"
        });
    });
</script>

<script>
    $(document).on('click', '.calendar-table td[data-date]', function() {
        if ($(this).hasClass('other-month')) return;

        $('.calendar-table td').removeClass('selected-date');
        $(this).addClass('selected-date');
    });
</script>

<script>
    function loadBookingSummary() {

        $.ajax({

            url: base_url + "admin/get-calendar-summary",

            type: "POST",

            dataType: "json",

            data: {

                month: $('#monthSelect').val(),
                year: $('#yearSelect').val(),
                center_id: $('#centerSelect').val()

            },

            success: function(res) {

                $('#selfBookingCount').text(res.self_booking);
                $('#assignedBookingCount').text(res.assigned_booking);
                $('#totalBookingCount').text(res.total_booking);

            }

        });

    }
</script>

<script>
    $(document).on('click', '.month-box', function() {

        $('.month-box').removeClass('active');

        $(this).addClass('active');

        $('#monthSelect').val($(this).data('month')).trigger('change');

    });
</script>

<script>
    function loadMonthCounts() {

        $.ajax({

            url: base_url + 'admin/get-month-counts',

            type: 'POST',

            dataType: 'json',

            data: {

                year: $('#yearSelect').val(),

                center_id: $('#centerSelect').val()

            },

            success: function(res) {

                $('#selectedYear').text($('#yearSelect').val());

                for (let i = 1; i <= 12; i++) {

                    $('#monthCount' + i).text(res[i]);

                }

            }

        });

    }
</script>

<script>
    function loadBookingStatistics() {

        $.ajax({

            url: base_url + 'admin/get-booking-statistics',

            type: 'POST',

            dataType: 'json',

            data: {

                year: $('#yearSelect').val(),
                center_id: $('#centerSelect').val()

            },

            success: function(res) {

                let year = $('#yearSelect').val();

                // =========================
                // SELECTED YEAR
                // =========================

                $('#yearSelfBookingCount')
                    .text(res.year_self_booking);

                $('#yearAssignedBookingCount')
                    .text(res.year_assigned_booking);

                $('#yearTotalBookingCount')
                    .text(res.year_total_booking);


                $('#yearSelfBookingLabel')
                    .text(year);

                $('#yearAssignedBookingLabel')
                    .text(year);

                $('#yearTotalBookingLabel')
                    .text(year);


                // =========================
                // OVERALL
                // =========================

                $('#overallSelfBookingCount')
                    .text(res.overall_self_booking);

                $('#overallAssignedBookingCount')
                    .text(res.overall_assigned_booking);

                $('#overallTotalBookingCount')
                    .text(res.overall_total_booking);

            }

        });

    }
</script>