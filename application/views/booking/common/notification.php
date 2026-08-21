<!-- Notification Section -->
<div class="notification-wrapper position-relative me-4">

    <div class="notification-bell position-relative" id="notificationToggle">
        <i class="bi bi-bell fs-4 cursor-pointer"></i>

        <?php if($unread_count > 0): ?>
            <span class="notification-count badge bg-danger">
                <?= $unread_count ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="notification-dropdown shadow-lg" id="notificationDropdown">

        <div class="dropdown-header d-flex justify-content-between align-items-center">
            <h6 class="m-0">Notifications</h6>
            <a href="<?= base_url('center-notification-mark-all-read') ?>" 
               class="btn btn-sm btn-link p-0 mark-all-read">
                Mark all as read
            </a>
        </div>

        <div class="dropdown-divider"></div>

        <div class="notification-list">

            <?php if(!empty($notifications)): ?>
                <?php foreach($notifications as $row): ?>
                    <div class="notification-item <?= $row->is_read ? 'read' : 'unread' ?> d-flex justify-content-between align-items-start">

                        <div class="d-flex">
                            <span class="dot me-2 mt-2"></span>

                            <div class="notification-content">
                                <p class="mb-0 fw-semibold">
                                    <?= $row->title ?>
                                </p>

                                <p class="mb-1 small">
                                    <?= $row->message ?>
                                </p>

                                <small class="text-muted">
                                    <?= date('d M Y h:i A', strtotime($row->created_at)) ?>
                                </small>
                            </div>
                        </div>

                        <!-- Remove Icon -->
                        <a href="<?= base_url('center-remove-notification/'.$row->id) ?>" 
                           class="text-danger ms-2"
                           onclick="return confirm('Remove this notification?')">
                            <i class="bi bi-x-lg"></i>
                        </a>

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
                <a href="<?= base_url('center-all-notifications') ?>" 
                   class="btn btn-sm btn-primary w-100 view-all">
                    View All
                </a>
            </div>
        <?php endif; ?>

    </div>
</div>