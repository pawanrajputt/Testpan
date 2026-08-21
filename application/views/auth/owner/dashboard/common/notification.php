<!-- Notification Section -->
<div class="notification-wrapper position-relative me-4">

    <div class="notification-bell position-relative" id="notificationToggle">
        <i class="bi bi-bell fs-4 cursor-pointer text-white"></i>

        <?php if($unread_count > 0): ?>
            <span class="notification-count badge bg-danger">
                <?= $unread_count ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="notification-dropdown shadow-lg" id="notificationDropdown">

        <div class="dropdown-header d-flex justify-content-between align-items-center">
            <h6 class="m-0">Notifications</h6>
        </div>

        <div class="dropdown-divider"></div>

        <div class="notification-list">

            <?php if(!empty($notifications)): ?>
                <?php foreach($notifications as $row): ?>
                    <div class="notification-item <?= $row->is_read ? 'read' : 'unread' ?>">

                        <span class="dot"></span>

                        <div class="notification-content">
                            <p class="mb-0 fw-semibold">
                                <?= $row->title ?>
                            </p>

                            <!-- Center Name -->
                            <?php if(!empty($row->center_name)): ?>
                                <small class="text-primary fw-semibold">
                                    <strong class="center-name">Center Name : </strong><?= $row->center_name ?>
                                </small>
                                <br>
                            <?php endif; ?>

                            <p class="mb-1 small">
                                <?= $row->message ?>
                            </p>
                            <small class="text-muted">
                                <?= date('d M Y h:i A', strtotime($row->created_at)) ?>
                            </small>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center p-3 text-muted">
                    No notifications
                </div>
            <?php endif; ?>

        </div>

        <?php if($total_notifications > 20): ?>
            <div class="dropdown-divider"></div>
            <div class="text-center p-2">
                <a href="<?= base_url('owner-all-notifications') ?>" 
                   class="btn btn-sm btn-primary w-100 view-all">
                    View All
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>