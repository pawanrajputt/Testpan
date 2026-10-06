<!DOCTYPE html>
<html>

<head>

    <meta charset="UTF-8">

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            color: #222;
        }

        h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        h2 {
            font-size: 13px;
            margin-top: 18px;
            margin-bottom: 8px;
        }

        .filters {
            margin-bottom: 15px;
        }

        .info-table,
        .project-table,
        .analytics-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table td,
        .analytics-table td,
        .project-table th,
        .project-table td {
            border: 1px solid #ddd;
            padding: 6px;
        }

        .info-label {
            font-weight: bold;
            width: 18%;
        }

        .project-table th {
            background: #1f4e8c;
            color: #fff;
            font-weight: bold;
        }

        .analytics-table td:first-child {
            font-weight: bold;
            width: 25%;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            font-size: 9px;
            color: #777;
        }
    </style>

</head>

<body>

    <h1>
        Exam Center History - <?= html_escape($center->center_name) ?>
    </h1>

    <div class="filters">

        <strong>Applied Filters:</strong>

        Year:
        <?= !empty($year) ? html_escape($year) : 'All Years' ?>

        &nbsp;&nbsp;

        Month:
        <?= !empty($month)
            ? date('F', mktime(0, 0, 0, $month, 1))
            : 'All Months'
        ?>

        &nbsp;&nbsp;

        Date Range:
        <?= !empty($dateRange)
            ? html_escape($dateRange)
            : 'All Dates'
        ?>

    </div>


    <h2>Center Information</h2>

    <table class="info-table">

        <tr>
            <td class="info-label">Center Name</td>
            <td><?= html_escape($center->center_name) ?></td>

            <td class="info-label">Center ID</td>
            <td><?= html_escape($center->center_id) ?></td>
        </tr>

        <tr>
            <td class="info-label">Country</td>
            <td><?= html_escape($center->country_name) ?></td>

            <td class="info-label">State</td>
            <td><?= html_escape($center->state_name) ?></td>
        </tr>

        <tr>
            <td class="info-label">City</td>
            <td><?= html_escape($center->city_name) ?></td>

            <td class="info-label">Capacity</td>
            <td><?= html_escape($center->capacity) ?></td>
        </tr>

        <tr>
            <td class="info-label">Owner Name</td>
            <td><?= html_escape($center->username) ?></td>

            <td class="info-label">Owner Email</td>
            <td><?= html_escape($center->useremail) ?></td>
        </tr>

        <tr>
            <td class="info-label">Owner Phone</td>
            <td><?= html_escape($center->userphone) ?></td>

            <td class="info-label">Created At</td>
            <td><?= html_escape($center->created_on) ?></td>
        </tr>

    </table>


    <h2>Revenue & Performance Analytics</h2>

    <table class="analytics-table">

        <tr>
            <td>Total Seats Delivered</td>
            <td><?= number_format($totalSeats) ?></td>

            <td>Total Revenue</td>
            <td>₹<?= number_format($totalRevenue, 2) ?></td>
        </tr>

        <tr>
            <td>Average Price / Seat</td>
            <td>₹<?= number_format($avgPrice, 2) ?></td>

            <td>Highest Seats Booked</td>
            <td><?= number_format($highestBooking) ?></td>
        </tr>

    </table>


    <h2>Project Booking History</h2>

    <table class="project-table">

        <thead>

            <tr>
                <th>Exam</th>
                <th>Client</th>
                <th>City</th>
                <th>Seats</th>
                <th>Booking Date</th>
                <th>Booking Status</th>
                <th>Project Status</th>
                <th>Price / Seat</th>
                <th>Revenue</th>
            </tr>

        </thead>

        <tbody>

            <?php if (!empty($projects)): ?>

                <?php foreach ($projects as $project): ?>

                    <?php

                    $seats = min(
                        (int)$project->center_seat,
                        (int)$project->number_of_seats
                    );

                    $price = !empty($project->admin_center_final_price)
                        ? $project->admin_center_final_price
                        : $project->admin_price_per_seat;

                    $revenue = ((int)$project->admin_status == 1)
                        ? $seats * (float)$price
                        : 0;

                    ?>

                    <tr>

                        <td>
                            <?= html_escape($project->exam_name) ?>
                        </td>

                        <td>
                            <?= html_escape($project->company_name) ?>
                        </td>

                        <td>
                            <?= html_escape($project->city_name) ?>
                        </td>

                        <td>
                            <?= number_format($seats) ?>
                        </td>

                        <td>
                            <?= !empty($project->created_at)
                                ? date('d M Y', strtotime($project->created_at))
                                : ''
                            ?>
                        </td>

                        <td>
                            <?= html_escape($project->exam_center_status) ?>
                        </td>

                        <td>
                            <?= html_escape($project->status) ?>
                        </td>

                        <td>
                            ₹<?= number_format($price, 2) ?>
                        </td>

                        <td>
                            ₹<?= number_format($revenue, 2) ?>
                        </td>

                    </tr>

                <?php endforeach; ?>

            <?php else: ?>

                <tr>
                    <td colspan="9" style="text-align:center;">
                        No project data found.
                    </td>
                </tr>

            <?php endif; ?>

        </tbody>

    </table>


    <div class="footer">
        Generated on <?= date('d M Y h:i A') ?>
    </div>

</body>

</html>