<style>
    .calendar-table td{

        position:relative;

        vertical-align:top;

    }

    .day-number{

        position:absolute;

        top:5px;

        right:8px;

        font-weight:600;

        font-size:13px;

    }

    .booking-count{

        margin-top:18px;

        margin-left:5px;

        font-size:11px;

        font-weight:600;

    }

    .self-count{

        color:#16a34a;

    }

    .assigned-count{

        color:#dc2626;

    }

    .dot{

        display:inline-block;

        width:6px;

        height:6px;

        border-radius:50%;

        margin-right:4px;

    }

    .green{

        background:#16a34a;

    }

    .red{

        background:#dc2626;

    }

    .card:hover{
        transform: translateY(-3px);
        transition:.25s ease;
    }

    .card{
        transition:.25s ease;
    }

    .fs-2{
        font-size:28px;
    }

    .rounded-circle{
        width:60px;
        height:60px;
        display:flex;
        align-items:center;
        justify-content:center;
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
                    <a href="<?=base_url('admin/dashboard')?>">Dashbaord</a> / <a href="<?=base_url('admin/centers')?>">Center Lists</a> /
                  </span>
                  <?=$page_title?>
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
                </div>
            </div>
        </div>

        <!-- Booking Summary -->
        <div id="summaryContainer">
            <?php 
                $this->load->view(
                    'dashboard/calendar/view/calendar-summary-partial',
                    ['summary' => $summary]
                ); 
            ?>
        </div>


        <!-- Calendar -->
        <div class="card">
            <div class="card-body">
                <div id="calendarContainer">
                    <?php 
                     $this->load->view('dashboard/calendar/view/calendar-partial', [
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

<script>
    const csrf_token = "<?php echo $this->security->get_csrf_hash()?>";
    const center_id = "<?=$center_id?>";

    $(document).ready(function() {

        var tooltipTriggerList = [].slice.call(
            document.querySelectorAll('[data-bs-toggle="tooltip"]')
        );

        tooltipTriggerList.map(function(el){

            return new bootstrap.Tooltip(el);

        });

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
        $('#monthSelect, #yearSelect').change(function() {

            const month = $('#monthSelect').val();
            const year  = $('#yearSelect').val();

            $.ajax({
                url: base_url + 'admin/view-get-center-calendar',
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


                    var tooltipTriggerList = [].slice.call(
                        document.querySelectorAll('[data-bs-toggle="tooltip"]')
                    );

                    tooltipTriggerList.map(function(el){

                        return new bootstrap.Tooltip(el);

                    });
                },
                error: function(xhr, status, error) {
                    console.error("Error loading calendar:", error);
                }
            });

        });

        
        // Load bookings for a date
        function loadBookings(date) {
            $.ajax({
                url: base_url + 'admin/view-get-center-bookings-by-date',
                method: 'POST',
                data: { 
                    date: date,
                    center_id: center_id
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