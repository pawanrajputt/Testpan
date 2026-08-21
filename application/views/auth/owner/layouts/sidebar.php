<?php
// Determine current page
$current_url = current_url();
$current_page = '';

if (strpos($current_url, 'center-owner-dashboard') !== false) {
    $current_page = 'dashboard';
} elseif (strpos($current_url, 'owner-profile') !== false) {
    $current_page = 'profile';
} elseif (strpos($current_url, 'owner-help-support') !== false) {
    $current_page = 'help';
} elseif (strpos($current_url, 'owner-center-calendar') !== false) {
    $current_page = 'calendar';
} elseif (strpos($current_url, 'subscription-plans') !== false) {
    $current_page = 'subscription';
} elseif (strpos($current_url, 'subscription-history') !== false) {
    $current_page = 'history';
}
?>
<div class="my-dashbaord-section">
    <div class="container-fluid">
        <div class="row">
            <!-- ////////////// Aside section start ////////////////// -->
            <div class="col-12 col-lg-2 p-0">
                <aside class="aside-section">

                    <!-- Logo -->
                    <div class="aside-heading text-center py-4">
                        <img src="<?= base_url()?>assets/asserts/BMTC Logo.png" alt="BMTC Logo" class="img-fluid">
                    </div>

                    <!-- General Menu -->
                    <div class="px-3 py-2 mb-4">
                        <ul class="aside-list list-unstyled m-0">

                            <li class="mb-2">
                                <a href="<?= base_url('center-owner-dashboard') ?>" class="link d-flex align-items-center py-2 px-3 rounded-4 <?= ($current_page == 'dashboard') ? 'active' : '' ?>">
                                    <i class="bi bi-grid-1x2 me-3 fs-5"></i>
                                    <span>Dashboard</span>
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="<?= base_url('owner-center-calendar') ?>" class="link d-flex align-items-center py-2  px-3 rounded-4 <?= ($current_page == 'calendar') ? 'active' : '' ?>">
                                    <i class="bi bi-calendar me-3 fs-5"></i>
                                    <span>Calendar</span>
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="<?= base_url('owner-profile') ?>" class="link d-flex align-items-center py-2 px-3 rounded-4 <?= ($current_page == 'profile') ? 'active' : '' ?>">
                                    <i class="bi bi-person-circle me-3 fs-5"></i>
                                    <span>Profile</span>
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="<?= base_url('owner-help-support') ?>" class="link d-flex align-items-center py-2 px-3 rounded-4 <?= ($current_page == 'help') ? 'active' : '' ?>">
                                    <i class="bi bi-headset me-3 fs-5"></i>
                                    <span>Help & Support</span>
                                </a>
                            </li>

                            <li class="mb-2">
                                <a href="<?= base_url('subscription-plans') ?>" class="link d-flex align-items-center py-2 px-3 rounded-4 <?= ($current_page == 'subscription') ? 'active' : '' ?>">
                                    <i class="bi bi-credit-card me-3 fs-5"></i>
                                    <span>Subscription</span>
                                </a>
                            </li>

                            <li>
                                <a href="<?= base_url('subscription-history') ?>" class="link d-flex align-items-center py-2 px-3 rounded-4 <?= ($current_page == 'history') ? 'active' : '' ?>">
                                    <i class="bi bi-receipt me-3 fs-5"></i>
                                    <span>Subscription History</span>
                                </a>
                            </li>

                        </ul>
                    </div>

                    <hr class="mx-3 my-3">

                    <!-- Account -->
                    <div class="px-3">
                        <p class="text-uppercase text-secondary small fw-bold mb-3 ps-2">Account</p>

                        <ul class="aside-list list-unstyled m-0">

                            <li class="mb-2">
                                <a href="#" class="link d-flex align-items-center py-2 px-3 rounded-4" onclick="logoutExamCenter()">
                                    <i class="bi bi-box-arrow-right me-3 fs-5"></i>
                                    <span>Logout</span>
                                </a>
                            </li>

                            <li>
                                <a href="#" class="link d-flex align-items-center py-2 px-3 rounded-4 text-danger" onclick="deleteOnwerAccount()">
                                    <i class="bi bi-trash me-3 fs-5"></i>
                                    <span>Delete Account</span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </aside>
            </div>
            <!-- ////////////// Aside section end ////////////////// -->