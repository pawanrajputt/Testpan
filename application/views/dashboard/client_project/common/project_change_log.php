<?php if (!empty($changeLogs)) { ?>

<div class="requirement-changes">

    <div class="requirement-changes-header">

        <div class="requirement-changes-title">
            <i class="ti ti-alert-triangle"></i>
            <strong>Client Requirement Changes</strong>
        </div>

        <span class="requirement-changes-count">
            <?= count($changeLogs) ?>
            Update<?= count($changeLogs) > 1 ? 's' : '' ?>
        </span>

    </div>


    <div class="requirement-changes-list">

        <?php foreach ($changeLogs as $log) {

            $old = json_decode($log->old_value, true);
            $new = json_decode($log->new_value, true);

        ?>

            <div class="requirement-change-item">

                <div class="requirement-change-top">

                    <span class="requirement-change-city">
                        <i class="ti ti-map-pin"></i>
                        <?= strtoupper($log->city_name ?? '-') ?>
                    </span>

                    <span class="requirement-change-date">
                        <i class="ti ti-clock"></i>
                        <?= date('d M Y h:i A', strtotime($log->created_at)) ?>
                    </span>

                </div>


                <div class="requirement-change-content">

                    <?php switch ($log->change_type) {

                        case 'CITY_ADDED':
                    ?>

                        <div class="change-detail change-success">

                            <span class="change-icon">
                                <i class="ti ti-map-plus"></i>
                            </span>

                            <span class="change-label">
                                New City Added
                            </span>

                            <strong>
                                <?= $new['city']; ?>
                            </strong>

                        </div>

                    <?php
                            break;

                        case 'CITY_REMOVED':
                    ?>

                        <div class="change-detail change-danger">

                            <span class="change-icon">
                                <i class="ti ti-trash"></i>
                            </span>

                            <span class="change-label">
                                City Removed
                            </span>

                            <strong>
                                <?= $old['city']; ?>
                            </strong>

                        </div>

                    <?php
                            break;

                        case 'SEAT_UPDATED':
                    ?>

                        <div class="change-detail change-primary">

                            <span class="change-icon">
                                <i class="ti ti-armchair"></i>
                            </span>

                            <span class="change-label">
                                Seat Requirement
                            </span>

                            <strong>
                                <?= $old['seat']; ?>
                            </strong>

                            <span class="change-arrow">
                                →
                            </span>

                            <strong class="change-new-value">
                                <?= $new['seat']; ?>
                            </strong>

                        </div>

                    <?php
                            break;

                        case 'BATCH_UPDATED':
                    ?>

                        <div class="change-detail change-info">

                            <span class="change-icon">
                                <i class="ti ti-layers-intersect"></i>
                            </span>

                            <span class="change-label">
                                Total Batches
                            </span>

                            <strong>
                                <?= $old['batch']; ?>
                            </strong>

                            <span class="change-arrow">
                                →
                            </span>

                            <strong class="change-new-value">
                                <?= $new['batch']; ?>
                            </strong>

                        </div>

                    <?php
                            break;

                        case 'BATCH_SEAT_UPDATED':
                    ?>

                        <div class="change-detail change-warning">

                            <span class="change-icon">
                                <i class="ti ti-edit"></i>
                            </span>

                            <span class="change-label">
                                Batch <?= $old['batch']; ?> Seat
                            </span>

                            <strong>
                                <?= $old['seat']; ?>
                            </strong>

                            <span class="change-arrow">
                                →
                            </span>

                            <strong class="change-new-value">
                                <?= $new['seat']; ?>
                            </strong>

                        </div>

                    <?php
                            break;
                    } ?>

                </div>

            </div>

        <?php } ?>

    </div>

</div>

<?php } ?>