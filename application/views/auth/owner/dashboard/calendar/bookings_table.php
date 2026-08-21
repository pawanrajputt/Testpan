<?php if (!empty($bookings)): ?>
    <div class="card-datatable table-responsive">
        <table class="table table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Booking Type</th>
                    <th>Center Name</th>
                    <th>Client Name</th>
                    <th>Exam Name</th>
                    <th>Date Range</th>
                    <th>Seats</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($bookings as $booking): ?>
                    <tr>
                        <td><?= ucfirst(str_replace('_', ' ', $booking['type'])) ?></td>
                        <td><?= htmlspecialchars($booking['center_name']) ?></td>
                        <td><?= htmlspecialchars($booking['client_name']) ?></td>
                        <td><?= htmlspecialchars($booking['exam_name']) ?></td>
                        <td>
                            <?= date('d M Y', strtotime($booking['start_date'])) ?> - 
                            <?= date('d M Y', strtotime($booking['end_date'])) ?>
                        </td>
                        <td><?= $booking['seats_booked'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-warning">No bookings found for this date</div>
<?php endif; ?>