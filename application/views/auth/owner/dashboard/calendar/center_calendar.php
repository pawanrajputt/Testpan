<!-- Content wrapper -->
<div class="col-10 p-0">
    <!-- Content -->
    
        <!-- Header section -->
        <div class="my-booking-wrapper d-flex justify-content-between align-items-center py-3 border-bottom">

            <div class="my-booking-header ps-4">
                <h2 class="m-0 fs-3 text-white">Center Calendar</h2>

            </div>

            <?php $this->load->view('auth/owner/dashboard/common/notification'); ?>

        </div>

        <div class="card">
            <!-- Booking Summary -->
            <div id="summaryContainer">
                <?php
                $this->load->view(
                    'auth/owner/dashboard/calendar/calendar-summary-partial',
                    ['summary' => $summary]
                );
                ?>
            </div>
        </div>

        <!-- Filter -->
        <div class="card" style="margin-top: -30px;">
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <select id="monthSelect" class="form-control mr-2 form-select">
                            <?php for ($m = 1; $m <= 12; $m++): ?>
                                <option value="<?= $m ?>" <?= $m == date('n') ? 'selected' : '' ?>>
                                    <?= date('F', mktime(0, 0, 0, $m, 1)) ?>
                                </option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="yearSelect" class="form-control form-select">
                            <?php for ($y = date('Y') - 1; $y <= date('Y') + 2; $y++): ?>
                                <option value="<?= $y ?>" <?= $y == date('Y') ? 'selected' : '' ?>><?= $y ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <select id="centerSelect" class="form-control form-select">
                            <option value="">Select Center</option>
                            <?php foreach ($all_centers as $center): ?>
                                <option value="<?= $center['center_id']; ?>">
                                    <?= $center['center_name']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div id="calendarContainer">
                    <?php
                    $this->load->view('auth/owner/dashboard/calendar/calendar_partial', [
                        'month' => $month,
                        'year' => $year,
                        'booked_dates' => $booked_dates
                    ]);
                    ?>
                </div>
            </div>
        </div>

        <!-- Table -->

        <div class="col-12">
            <div class="card">
                <div class="card-header mb-4">
                    <h3 class="card-title">Booked Centers</h3>
                </div>
                <div class="card-body p-0">
                    <div id="bookingsTableContainer">
                        <div class="alert alert-info">Select a date to view bookings</div>
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
            const center_id = $('#centerSelect').val();

            $.ajax({
                url: base_url + 'owner-get-calendar',
                method: 'POST',
                dataType: 'json',
                data: {
                    month: month,
                    year: year,
                    center_id: center_id
                },
                success: function(response) {

                    // Update calendar
                    $('#calendarContainer').html(response.calendar);

                    // Update summary boxes
                    $('#summaryContainer').html(response.summary);

                    // Re-highlight today's date
                    $('.calendar-table td[data-date="<?= date('Y-m-d') ?>"]').addClass('today');
                },
                error: function(xhr, status, error) {
                    console.error("Error loading calendar:", error);
                }
            });

        });


        // Load bookings for a date
        function loadBookings(date) {
            $.ajax({
                url: base_url + 'owner-get-bookings-by-date',
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