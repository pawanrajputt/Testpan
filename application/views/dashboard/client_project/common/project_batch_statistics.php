<?php foreach ($batchStatistics as $city): ?>

    <div class="city-statistics-card mb-4">

        <!-- City Header -->
        <div class="city-statistics-header">

            <div class="city-title">
                <i class="ti ti-map-pin"></i>
                <span><?= strtoupper($city['city_name']); ?></span>
            </div>

            <div class="city-summary-label">
                City Overview
            </div>

        </div>


        <!-- City Summary -->
        <div class="module-statistics city-summary-statistics">

            <!-- Required -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-armchair"></i>
                </div>

                <div class="stat-content">
                    <span>Required</span>
                    <strong><?= $city['summary']['required']; ?></strong>
                </div>

                <div class="stat-footer">
                    Total Required
                </div>

            </div>


            <!-- Requested -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-send"></i>
                </div>

                <div class="stat-content">
                    <span>Requested</span>
                    <strong><?= $city['summary']['requested']; ?></strong>
                </div>

                <div class="stat-footer">
                    Requested Seats
                </div>

            </div>


            <!-- Approved -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Approved</span>
                    <strong><?= $city['summary']['approved']; ?></strong>
                </div>

                <div class="stat-footer">
                    Approved Seats
                </div>

            </div>


            <!-- Remaining -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-hourglass"></i>
                </div>

                <div class="stat-content">
                    <span>Remaining</span>
                    <strong><?= $city['summary']['remaining']; ?></strong>
                </div>

                <div class="stat-footer">
                    Seats Remaining
                </div>

            </div>

        </div>


        <!-- Center Request Status -->
        <div class="city-request-status">

            <div class="city-section-title">
                <i class="ti ti-building"></i>
                Center Request Status
            </div>

            <div class="request-status-grid">

                <!-- Request -->
                <div class="request-status-item status-info">
                    <div class="request-status-icon">
                        <i class="ti ti-send"></i>
                    </div>

                    <div>
                        <span>Request</span>
                        <strong><?= $city['summary']['total_requests']; ?></strong>
                    </div>
                </div>


                <!-- Pending -->
                <div class="request-status-item status-warning">
                    <div class="request-status-icon">
                        <i class="ti ti-clock"></i>
                    </div>

                    <div>
                        <span>Pending</span>
                        <strong><?= $city['summary']['pending']; ?></strong>
                    </div>
                </div>


                <!-- Approved -->
                <div class="request-status-item status-success">
                    <div class="request-status-icon">
                        <i class="ti ti-circle-check"></i>
                    </div>

                    <div>
                        <span>Approved</span>
                        <strong><?= $city['summary']['approved_centers']; ?></strong>
                    </div>
                </div>


                <!-- Rejected -->
                <div class="request-status-item status-danger">
                    <div class="request-status-icon">
                        <i class="ti ti-circle-x"></i>
                    </div>

                    <div>
                        <span>Rejected</span>
                        <strong><?= $city['summary']['rejected']; ?></strong>
                    </div>
                </div>


                <!-- Hold -->
                <div class="request-status-item status-purple">
                    <div class="request-status-icon">
                        <i class="ti ti-player-pause"></i>
                    </div>

                    <div>
                        <span>Hold</span>
                        <strong><?= $city['summary']['hold']; ?></strong>
                    </div>
                </div>


                <!-- Negotiation -->
                <div class="request-status-item status-primary">
                    <div class="request-status-icon">
                        <i class="ti ti-message-dots"></i>
                    </div>

                    <div>
                        <span>Negotiation</span>
                        <strong><?= $city['summary']['negotiation']; ?></strong>
                    </div>
                </div>

            </div>

        </div>


        <!-- Batch Details -->
        <div class="city-batch-section">

            <div class="city-section-title">
                <i class="ti ti-layers-intersect"></i>
                Batch Details
            </div>

            <div class="table-responsive">

                <table class="table city-batch-table mb-0">

                    <thead>
                        <tr>
                            <th>Batch</th>
                            <th>Timing</th>
                            <th>Required</th>
                            <th>Requested</th>
                            <th>Approved</th>
                            <th>Remaining</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($city['batches'] as $batch): ?>

                            <tr>

                                <td>
                                    <span class="batch-name">
                                        Batch <?= $batch['batch_no']; ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="batch-time">
                                        <i class="ti ti-clock"></i>

                                        <?= date('h:i A', strtotime($batch['batch_start'])); ?>

                                        <span>→</span>

                                        <?= date('h:i A', strtotime($batch['batch_end'])); ?>
                                    </span>
                                </td>

                                <td>
                                    <strong>
                                        <?= $batch['required_seat']; ?>
                                    </strong>
                                </td>

                                <td>
                                    <strong>
                                        <?= $batch['requested_seat']; ?>
                                    </strong>
                                </td>

                                <td>
                                    <span class="approved-seat">
                                        <?= $batch['approved_seat']; ?>
                                    </span>
                                </td>

                                <td>
                                    <?php if ($batch['remaining_seat'] > 0): ?>

                                        <span class="remaining-seat">
                                            <?= $batch['remaining_seat']; ?>
                                        </span>

                                    <?php else: ?>

                                        <span class="remaining-complete">
                                            0
                                        </span>

                                    <?php endif; ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

<?php endforeach; ?>