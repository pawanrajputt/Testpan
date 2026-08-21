<style>
    /* Table container - responsive wrapper */
    .table-responsive-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
        margin-bottom: 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    /* Table styling */
    #dataTable {
        width: 100%;
        min-width: 1000px;
        /* Minimum width to maintain structure */
        border-collapse: collapse;
        font-size: 14px;
        background: #fff;
    }

    #dataTable thead th {
        background: #f8f9fa;
        color: #333;
        font-weight: 600;
        padding: 12px 10px;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
        position: sticky;
        top: 0;
        z-index: 10;
        background: #f8f9fa;
    }

    #dataTable tbody td {
        padding: 10px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
        word-wrap: break-word;
        max-width: 200px;
    }

    /* Status badges */
    .bg-success {
        background: #28a745;
        color: #fff;
    }

    .bg-danger {
        background: #dc3545;
        color: #fff;
    }

    .bg-warning {
        background: #ffc107;
        color: #212529;
    }

    .bg-info {
        background: #17a2b8;
        color: #fff;
    }

    .bg-secondary {
        background: #6c757d;
        color: #fff;
    }

    /* View button */
    .View-btn {
        background: #007bff;
        color: #fff;
        padding: 5px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-size: 12px;
        display: inline-block;
        white-space: nowrap;
        transition: 0.3s;
        border: none;
        cursor: pointer;
    }

    .View-btn:hover {
        background: #0056b3;
        color: #fff;
        text-decoration: none;
    }

    /* Checkbox styling */
    #dataTable input[type="checkbox"] {
        width: 16px;
        height: 16px;
        cursor: pointer;
        margin-right: 6px;
        flex-shrink: 0;
    }

    /* No data row */
    .text-center {
        text-align: center !important;
    }

    /* Responsive adjustments */
    @media screen and (max-width: 768px) {
        #dataTable {
            font-size: 12px;
            min-width: 800px;
        }

        #dataTable thead th,
        #dataTable tbody td {
            padding: 8px 6px;
        }

        .badge {
            font-size: 10px;
            padding: 3px 8px;
        }

        .View-btn {
            font-size: 10px;
            padding: 3px 10px;
        }

        .table-responsive-wrapper {
            border-radius: 4px;
            margin: 0 -10px;
            /* Full width on mobile */
            border: none;
        }
    }

    @media screen and (max-width: 480px) {
        #dataTable {
            font-size: 11px;
            min-width: 700px;
        }

        #dataTable thead th,
        #dataTable tbody td {
            padding: 6px 4px;
        }
    }
</style>

<!-- Responsive Wrapper -->
<div class="table-responsive-wrapper">
    <table id="dataTable" class="dataTable">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" class="me-2">Exam name
                </th>
                <th>From</th>
                <th>Duration</th>
                <th>Exam Date</th>
                <th>Seats</th>
                <th>Pricing </th>
                <th>My Status</th>
                <th>Client Status</th>
                <th>Admin Status</th>
                <th>Booking Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($bookings) > 0) {
                foreach ($bookings as $row) { ?>
                    <tr>
                        <td>
                            <input type="checkbox" data-id="<?= $row['project_id'] ?>" class="me-2">
                            <?= $row['exam_name'] ?>
                            <br>
                            <strong>Project ID: </strong><?= $row['project_id'] ?>
                        </td>
                        <td><?= $row['client_name'] ?></td>
                        <td>
                            <?php
                            if (!empty($row['start_date']) && !empty($row['end_date'])) {
                                $start = new DateTime($row['start_date']);
                                $end = new DateTime($row['end_date']);
                                $diff = $start->diff($end)->days + 1; // Add 1 to include the start day
                                echo $diff . ' day' . ($diff > 1 ? 's' : '');
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td><?= date('M d, Y', strtotime($row['start_date'])) ?> - <?= date('M d, Y', strtotime($row['end_date'])) ?></td>
                        <td><?= $row['center_seat'] ?></td>
                        <td>Rs. <?= $row['admin_center_final_price'] ?>/seat</td>
                        <td>

                            <?php

                            switch ($row['exam_center_status']) {

                                case 1:
                                    echo '<span class="badge bg-success">Approved</span>';
                                    break;

                                case 2:
                                    echo '<span class="badge bg-danger">Rejected</span>';
                                    break;

                                case 3:
                                    echo '<span class="badge bg-info">Negotiation</span>';
                                    break;

                                default:
                                    echo '<span class="badge bg-warning">Pending</span>';
                            }

                            ?>

                        </td>
                        <td>

                            <?php

                            switch ($row['client_status']) {

                                case 1:
                                    echo '<span class="badge bg-success">Approved</span>';
                                    break;

                                case 2:
                                    echo '<span class="badge bg-danger">Rejected</span>';
                                    break;

                                default:
                                    echo '<span class="badge bg-warning">Pending</span>';
                            }

                            ?>

                        </td>
                        <td>

                            <?php

                            switch ($row['admin_status']) {

                                case 1:
                                    echo '<span class="badge bg-success">Approved</span>';
                                    break;

                                case 2:
                                    echo '<span class="badge bg-danger">Rejected</span>';
                                    break;

                                case 3:
                                    echo '<span class="badge bg-info">Hold</span>';
                                    break;

                                case 4:
                                    echo '<span class="badge bg-secondary">Not Required</span>';
                                    break;

                                default:
                                    echo '<span class="badge bg-warning">Pending</span>';
                            }

                            ?>

                        </td>
                        <td>
                            <?php $statusBadge = getProjectStatusBadge($row); ?>
                            <?php $statusText = getProjectStatusText($row); ?>
                            <?= $statusBadge ?>

                            <?php if (!empty($row['project_remark'])) { ?>
                                <br>
                                <small class="text-danger">
                                    <strong>Remark:</strong> <?= $row['project_remark']; ?>
                                </small>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            if ($statusText != 'Postponed') { ?>
                                <a href="javascript:void(0);"
                                    onclick="showProjectDetail('<?= $row['project_id'] ?>','<?= $row['id'] ?>')"
                                    class="View-btn">View
                                </a>
                            <?php } else { ?>
                                --
                            <?php } ?>
                        </td>
                    </tr>
                <?php }
            } else { ?>
                <tr>
                    <td class="text-center" colspan="11">No Booking Found...</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>