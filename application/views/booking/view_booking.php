<style>
    .border-bottom.pb-2 {
        display: contents;
    }
</style>


<?php if($booking_type == 'self'): ?>

    <div class="modal-body">

    <!-- Summary Cards -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Seats Booked</h6>
                    <h3><?= $result->seats_booked ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Duration</h6>
                    <h3><?= $result->exam_duration ?></h3>
                    <small>Days</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center">
                <div class="card-body">
                    <h6 class="text-muted">Total Batches</h6>
                    <h3><?= $result->total_batch ?></h3>
                </div>
            </div>
        </div>

    </div>

    <!-- Candidate Information -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Candidate Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label><strong>Client Name</strong></label>
                    <div><?= $result->client_name ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Email Address</strong></label>
                    <div><?= $result->client_email ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Phone Number</strong></label>
                    <div><?= $result->client_phone ?></div>
                </div>

            </div>

        </div>
    </div>

    <!-- Exam Information -->
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-info text-white">
            <h5 class="mb-0">Exam Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label><strong>Exam Name</strong></label>
                    <div><?= $result->exam_name ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Exam Type</strong></label>
                    <div><?= $result->exam_type ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Exam Date</strong></label>
                    <div><?= date('d M Y', strtotime($result->exam_date)) ?></div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label><strong>Start Date</strong></label>
                    <div><?= date('d M Y', strtotime($result->start_date)) ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>End Date</strong></label>
                    <div><?= date('d M Y', strtotime($result->end_date)) ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Exam Time</strong></label>
                    <div><?= date('h:i A', strtotime($result->exam_time)) ?></div>
                </div>

            </div>

        </div>

    </div>

    <!-- Center & Lab Information -->
    <div class="card shadow-sm mb-4">

        <div class="card-header bg-success text-white">
            <h5 class="mb-0">Center & Lab Information</h5>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 mb-3">
                    <label><strong>Center Name</strong></label>
                    <div><?= $result->center_name ?></div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Assigned Lab Floor</strong></label>
                    <div>
                        <?php
                        if ($result->floor_name == 'basement') {
                            echo 'Basement';
                        } elseif ($result->floor_name == 0) {
                            echo 'Ground';
                        } elseif ($result->floor_name > 0) {
                            echo 'Floor ' . $result->floor_name;
                        } else {
                            echo 'N/A';
                        }
                        ?>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <label><strong>Total Computers</strong></label>
                    <div><?= $result->no_of_computer ?? 'N/A' ?></div>
                </div>

            </div>

        </div>

    </div>

    <!-- Batch Schedule -->
    <?php if($result->total_batch > 0): ?>

    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Batch Schedule</h5>
        </div>

        <div class="card-body">

            <table class="table table-bordered">

                <thead>
                    <tr>
                        <th>Batch</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                    </tr>
                </thead>

                <tbody>

                <?php for($i=1; $i <= $result->total_batch; $i++): ?>

                    <?php
                        $start_field = 'batch'.$i.'_start';
                        $end_field   = 'batch'.$i.'_end';
                    ?>

                    <tr>
                        <td>Batch <?= $i ?></td>

                        <td>
                            <?= !empty($result->$start_field)
                                ? date('h:i A', strtotime($result->$start_field))
                                : 'N/A'; ?>
                        </td>

                        <td>
                            <?= !empty($result->$end_field)
                                ? date('h:i A', strtotime($result->$end_field))
                                : 'N/A'; ?>
                        </td>
                    </tr>

                <?php endfor; ?>

                </tbody>

            </table>

        </div>

    </div>

    <?php endif; ?>

</div>

<?php else: ?>

    <div class="modal-body">
        <!-- Client Information Section -->
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Name:</label>
                        <div class="border-bottom pb-2">
                            <?= htmlspecialchars($booking_type == 'self' ? $result->client_name : $result->company_name) ?>
                        </div>
                    </div>
                    <?php if($booking_type == 'assigned'): ?>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Coordinator:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->client_name) ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Email:</label>
                        <div class="border-bottom pb-2">
                            <?= htmlspecialchars($booking_type == 'self' ? ($result->client_email ?? 'N/A') : ($result->client_email ?? 'N/A')) ?>
                        </div>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="font-weight-bold">Phone:</label>
                        <div class="border-bottom pb-2">
                            <?= htmlspecialchars($booking_type == 'self' ? ($result->client_phone ?? 'N/A') : ($result->client_phone ?? 'N/A')) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam Information Section -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Exam Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Exam Name:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->exam_name) ?></div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Exam Type:</label>
                        <div class="border-bottom pb-2">
                            <?= htmlspecialchars($booking_type == 'self' ? ($result->exam_type ?? 'N/A') : $result->exam_type) ?>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Location:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->center_name) ?></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Date Range:</label>
                        <div class="border-bottom pb-2">
                            <?= date('d M Y', strtotime($result->start_date)) ?> - <?= date('d M Y', strtotime($result->end_date)) ?>
                        </div>
                    </div>
                    <?php if($booking_type == 'self' && isset($result->exam_time)): ?>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Time:</label>
                        <div class="border-bottom pb-2"><?= date('h:i A', strtotime($result->exam_time)) ?></div>
                    </div>
                    <?php endif; ?>
                    <div class="col-md-4 mb-3">
                        <label class="font-weight-bold">Duration:</label>
                        <div class="border-bottom pb-2">
                            <?php 
                                $start = new DateTime($result->start_date);
                                $end = new DateTime($result->end_date);
                                $interval = $start->diff($end);
                                echo ($interval->days + 1) . ' days';
                            ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Seats Booked:</label>
                        <div class="border-bottom pb-2">
                            <?= $booking_type == 'self' ? $result->seats_booked : $result->number_of_seats ?>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Center Name:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->center_name) ?></div>
                    </div>
                </div>
                <?php if($booking_type == 'assigned'): ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Exam Mode:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->exam_mode) ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Exam Type Detail:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->exam_type_detail) ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Lab Information Section -->
        <?php if(isset($result->lab_name) || isset($result->no_of_computer)): ?>
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">Lab Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <?php if(isset($result->lab_name)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Lab Name:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->lab_name ?? 'N/A') ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($result->floor_name)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Floor:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->floor_name ?? 'N/A') ?></div>
                    </div>
                    <?php endif; ?>
                    <?php if(isset($result->no_of_computer)): ?>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Computers:</label>
                        <div class="border-bottom pb-2"><?= $result->no_of_computer ?? 'N/A' ?></div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php if($booking_type == 'assigned'): ?>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Internet Mode OS:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->inet_mode_os) ?></div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="font-weight-bold">Server Mode OS:</label>
                        <div class="border-bottom pb-2"><?= htmlspecialchars($result->server_mode_os) ?></div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>

<?php endif; ?>