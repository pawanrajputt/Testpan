<div class="booking-center active">

    <div class="main-contant">
        <div class="container py-4">
            <?php
            // Convert array to key-value pairs for easy access
            $settings = [];
            foreach ($result as $item) {
                $settings[$item['setting_key']] = $item['setting_value'];
            }

            // Check if support settings exist
            $support_title = isset($settings['support_title']) ? $settings['support_title'] : 'Help & Support';
            $support_description = isset($settings['support_description']) ? $settings['support_description'] : 'We are here to help you with your queries';
            $support_phone = isset($settings['support_phone']) ? $settings['support_phone'] : '+91-9228764523';
            $support_email = isset($settings['support_email']) ? $settings['support_email'] : 'support@testpanindia.com';
            ?>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card border-0 shadow-sm" style="background-color: #EFF6FF;">
                        <div class="card-body p-4 p-md-5">
                            <!-- Header -->
                            <div class="text-center mb-5">
                                <h3 class="fw-bold mb-2"><?php echo htmlspecialchars($support_title); ?></h3>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($support_description); ?></p>
                            </div>

                            <!-- Contact Cards -->
                            <div class="row g-4">
                                <!-- Phone Card -->
                                <div class="col-md-6">
                                    <div class="card border h-100">
                                        <div class="card-body text-center p-0">
                                            <div class="mb-3">
                                                <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bi bi-telephone fs-4 text-white"></i>
                                                </div>
                                            </div>
                                            <h5 class="fw-semibold mb-2">Call Us</h5>
                                            <?php if (!empty($support_phone)): ?>
                                                <a href="tel:+91<?php echo preg_replace('/[^0-9]/', '', $support_phone); ?>"
                                                    class="text-decoration-none">
                                                    <div class="fs-5 fw-bold text-dark mt-2">
                                                        +91 <?php echo htmlspecialchars($support_phone); ?>
                                                    </div>
                                                </a>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="bi bi-clock me-1"></i>
                                                    Mon-Sat, 9 AM - 6 PM
                                                </small>
                                            <?php else: ?>
                                                <div class="text-muted mt-2">Not available</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>

                                <!-- Email Card -->
                                <div class="col-md-6">
                                    <div class="card border h-100">
                                        <div class="card-body text-center p-0">
                                            <div class="mb-3">
                                                <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                                    style="width: 60px; height: 60px;">
                                                    <i class="bi bi-envelope fs-4 text-white"></i>
                                                </div>
                                            </div>
                                            <h5 class="fw-semibold mb-2">Email Us</h5>
                                            <?php if (!empty($support_email)): ?>
                                                <a href="mailto:<?php echo htmlspecialchars($support_email); ?>"
                                                    class="text-decoration-none">
                                                    <div class="fs-6 text-dark mt-2">
                                                        <?php echo htmlspecialchars($support_email); ?>
                                                    </div>
                                                </a>
                                                <small class="text-muted d-block mt-1">
                                                    <i class="bi bi-reply me-1"></i>
                                                    Response within 24 hours
                                                </small>
                                            <?php else: ?>
                                                <div class="text-muted mt-2">Not available</div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>