<div class="booking-center active">
    <!-- ///////////// Header section start -->
    <div class="my-booking-wrapper d-flex justify-content-between align-items-center">
        
        <div class="my-booking-header ps-4">
            <h2 class="m-0 fs-3">My Dashboard</h2>
            <span>/ Notifications List</span>
        </div>

        <?php $this->load->view('booking/common/notification'); ?>

    </div>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="m-0">All Notifications</h4>
        </div>

        <?php if(!empty($notifications)): ?>

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th width="5%">Status</th>
                            <th>Title</th>
                            <th>Center</th>
                            <th>Message</th>
                            <th width="18%">Date</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach($notifications as $row): ?>

                            <tr>

                                <!-- Read / Unread Dot -->
                                <td>
                                    <?php if(!$row->is_read): ?>
                                        <span class="badge bg-primary">Unread</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Read</span>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <strong><?= $row->title ?></strong>
                                </td>

                                <td>
                                    <?= $row->center_name ?? '-' ?>
                                </td>

                                <td>
                                    <?= $row->message ?>
                                </td>

                                <td>
                                    <?= date('d M Y h:i A', strtotime($row->created_at)) ?>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>
            </div>

            <div class="mt-3">
                <?= $pagination ?>
            </div>

        <?php else: ?>

            <div class="alert alert-info">
                No notifications found.
            </div>

        <?php endif; ?>

    </div>

</div>