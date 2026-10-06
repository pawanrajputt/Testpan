<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4">
            <span class="text-muted fw-light">
                <a href="<?=base_url('admin/dashboard')?>">Dashboard</a> /
            </span>
            <?= $page_title ?> (<?=$booking->center_name?>)
        </h4>

        <!-- ================= CLIENT INFO ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Client Information</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Name :</strong><br>
                        <?= htmlspecialchars($booking->client_name ?? '--') ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Email :</strong><br>
                        <?= htmlspecialchars($booking->client_email ?? '--') ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Phone :</strong><br>
                        <?= htmlspecialchars($booking->client_phone ?? '--') ?>
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= EXAM INFO ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Exam Information</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Exam Name :</strong><br>
                        <?= htmlspecialchars($booking->exam_name ?? '--') ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Exam Type :</strong><br>
                        <?= htmlspecialchars($booking->exam_type ?? '--') ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Location :</strong><br>
                        <?= htmlspecialchars($booking->exam_location ?? '--') ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Exam Date :</strong><br>
                        <?= date('d M Y', strtotime($booking->start_date)) ?>
                        -
                        <?= date('d M Y', strtotime($booking->end_date)) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Exam Time :</strong><br>
                        <?= date('h:i A', strtotime($booking->exam_time)) ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Duration :</strong><br>
                        <?= $booking->exam_duration ?> Days
                    </div>

                </div>
            </div>
        </div>


        <!-- ================= SEATS & BATCH ================= -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Seat & Batch Details</h5>
            </div>
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4 mb-3">
                        <strong>Seats Booked :</strong><br>
                        <span class="badge bg-label-primary">
                            <?= $booking->seats_booked ?>
                        </span>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Total Batch :</strong><br>
                        <?= $booking->total_batch ?? '--' ?>
                    </div>

                    <div class="col-md-4 mb-3">
                        <strong>Labs Assigned :</strong><br>
                        <?= htmlspecialchars($booking->labs_assigned ?? '--') ?>
                    </div>

                    <?php for($i=1; $i<=5; $i++): ?>

                        <?php 
                            $start = 'batch'.$i.'_start';
                            $end   = 'batch'.$i.'_end';
                        ?>

                        <?php if(!empty($booking->$start) && !empty($booking->$end)): ?>
                            <div class="col-md-4 mb-3">
                                <strong>Batch <?= $i ?> :</strong><br>
                                <?= date('h:i A', strtotime($booking->$start)) ?>
                                -
                                <?= date('h:i A', strtotime($booking->$end)) ?>
                            </div>
                        <?php endif; ?>

                    <?php endfor; ?>

                </div>
            </div>
        </div>

    </div>
</div>