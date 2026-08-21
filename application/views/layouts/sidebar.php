<!-- =================================
             DESKTOP SIDEBAR
        ================================= -->

<aside class="col-md-3 col-lg-2 d-none d-md-block p-0">

    <div class="aside-section">

        <div class="aside-heading">

            <img src="<?= base_url('assets/asserts/BMTC Logo.png') ?>"
                alt="BMTC Logo"
                class="img-fluid">

        </div>
        <ul class="aside-list list-unstyled">

            <li class="menu-title">
                General
            </li>
            <li>
                <a href="<?= base_url('dashboard') ?>"
                    class="link <?= ($this->uri->segment(1) == 'dashboard' || $this->uri->segment(1) == '') ? 'active' : '' ?>">

                    <i class="bi bi-grid-1x2-fill"></i>

                    <span>
                        My Bookings
                    </span>

                </a>
            </li>
            <li>
                <a href="<?= base_url('my-center') ?>"
                    class="link <?= $this->uri->segment(1) == 'my-center' ? 'active' : '' ?>">

                    <i class="bi bi-building"></i>

                    <span>
                        My Centers
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('my-calendar') ?>"
                    class="link <?= $this->uri->segment(1) == 'my-calendar' ? 'active' : '' ?>">

                    <i class="bi bi-calendar3"></i>

                    <span>
                        My Calendar
                    </span>
                </a>
            </li>
            <li>
                <a href="<?= base_url('my-self-booking') ?>"
                    class="link <?= $this->uri->segment(1) == 'my-self-booking' ? 'active' : '' ?>">
                    <i class="bi bi-calendar-plus"></i>

                    <span>
                        Self Bookings
                    </span>
                </a>
            </li>
            <li class="menu-title mt-4">
                Support
            </li>
            <li>
                <a href="<?= base_url('settings') ?>"
                    class="link <?= $this->uri->segment(1) == 'settings' ? 'active' : '' ?>">
                    <i class="bi bi-gear"></i>
                    <span>
                        Settings
                    </span>
                </a>
            </li>

            <li>

                <a href="<?= site_url('center-logout') ?>"
                    class="link">

                    <i class="bi bi-box-arrow-right"></i>

                    <span>
                        Logout
                    </span>

                </a>

            </li>

        </ul>


        <?php

        $site_settings =
            $this->session->userdata('site_settings');

        $site_title =
            isset($site_settings['site_title'])
            ? $site_settings['site_title']
            : 'Bookmetestcenter';

        ?>

    </div>

</aside>


<!-- =================================
             MOBILE SIDEBAR
        ================================= -->

<div class="offcanvas offcanvas-start"
    tabindex="-1"
    id="mobileSidebar">

    <div class="offcanvas-header">

        <img src="<?= base_url('assets/asserts/BMTC Logo.png') ?>"
            width="150"
            alt="BMTC Logo">

        <button type="button"
            class="btn-close"
            data-bs-dismiss="offcanvas">
        </button>

    </div>


    <div class="offcanvas-body p-0">

        <div class="aside-section">

            <ul class="aside-list list-unstyled">

                <li class="menu-title">
                    General
                </li>


                <li>

                    <a href="<?= base_url('dashboard') ?>"
                        class="link">

                        <i class="bi bi-grid-1x2-fill"></i>

                        My Bookings

                    </a>

                </li>


                <li>

                    <a href="<?= base_url('my-center') ?>"
                        class="link">

                        <i class="bi bi-building"></i>

                        My Centers

                    </a>

                </li>


                <li>

                    <a href="<?= base_url('my-calendar') ?>"
                        class="link">

                        <i class="bi bi-calendar3"></i>

                        My Calendar

                    </a>

                </li>


                <li>

                    <a href="<?= base_url('my-self-booking') ?>"
                        class="link">

                        <i class="bi bi-calendar-plus"></i>

                        Self Bookings

                    </a>

                </li>


                <li class="menu-title mt-4">
                    Support
                </li>


                <li>

                    <a href="<?= base_url('settings') ?>"
                        class="link">

                        <i class="bi bi-gear"></i>

                        Settings

                    </a>

                </li>


                <li>

                    <a href="<?= base_url('help-support') ?>"
                        class="link">

                        <i class="bi bi-question-circle"></i>

                        Help & Support

                    </a>

                </li>


                <li>

                    <a href="<?= site_url('center-logout') ?>"
                        class="link">

                        <i class="bi bi-box-arrow-right"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</div>
<main class="col-12 col-md-9 col-lg-10">
    <?php
    $segment = $this->uri->segment(1);

    switch ($segment) {
        case 'dashboard':
            $pageTitle = 'My Dashboard';
            break;

        case 'my-center':
            $pageTitle = 'My Center';
            break;

        case 'my-calendar':
            $pageTitle = 'My Calendar';
            break;

        case 'my-self-booking':
            $pageTitle = 'My Self Booking';
            break;

        case 'settings':
            $pageTitle = 'Settings';
            break;

        default:
            $pageTitle = 'Dashboard';
            break;
    }
    ?>
    <div class="dashboard-header">
        <h2 class="text-white">
            <?php echo $pageTitle; ?>
        </h2>
        <?php $this->load->view('booking/common/notification'); ?>
    </div>