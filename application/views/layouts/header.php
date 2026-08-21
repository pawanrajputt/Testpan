<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>TestCenter Project</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <!-- Toastr -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css"
        rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet"
        href="<?= base_url('assets/css/style.css') ?>">

    <!-- Favicon -->
    <link rel="icon"
        href="<?= base_url('assets/asserts/logo.png') ?>">


    <script>
        var base_url = "<?= base_url(); ?>";
    </script>


    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        /* =================================
           GLOBAL
        ================================= */

        * {
            box-sizing: border-box;
        }



        .main-wrapper {
            min-height: 100vh;
        }


        /* =================================
           SIDEBAR
        ================================= */

        .aside-section {
            min-height: 100vh;
            height: 100vh;
            background: #111827;
            color: #fff;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
        }

        .aside-heading {
            padding: 24px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .aside-list {
            padding: 20px 15px;
            margin: 0;
            flex: 1;
        }

        .menu-title {
            color: #9ca3af;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin: 18px 12px 8px;
        }

        .aside-list li {
            margin-bottom: 6px;
        }

        .aside-list .link {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 12px 15px;
            color: #d1d5db;
            text-decoration: none;
            border-radius: 10px;
            transition: 0.25s ease;
        }

        .aside-list .link i {
            font-size: 18px;
            width: 22px;
        }

        .aside-list .link:hover,
        .aside-list .link.active {
            background: #2563eb;
            color: #fff;
        }

        .company-wrapper {
            padding: 20px;
            color: #9ca3af;
            font-size: 12px;
        }


        /* =================================
           MOBILE TOP BAR
        ================================= */

        .mobile-topbar {
            min-height: 62px;
            background: #111827;
            padding: 10px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }


        /* =================================
           DASHBOARD HEADER
        ================================= */

        .dashboard-header {
            background: #111827;
            color: #fff;
            padding: 22px 30px;
            width: 100%;
        }

        .dashboard-header h2 {
            margin: 0;
            font-size: clamp(20px, 2vw, 30px);
            display: inline-block;
        }

        .dashboard-header p {
            color: #9ca3af;
            margin: 5px 0 0;
            font-size: 14px;
        }


        /* =================================
           TABS
        ================================= */

        .my-booking-tab {
            background: #fff;
            padding: 15px 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .tabs-scroll {
            display: flex;
            gap: 8px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .tabs-scroll::-webkit-scrollbar {
            display: none;
        }

        .booking-tab {
            white-space: nowrap;
            padding: 10px 16px;
            border-radius: 8px;
            color: #6b7280;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .booking-tab:hover,
        .booking-tab.active {
            padding: 10px 10px;
            background: #2563eb;
            color: #fff !important;
        }


        /* =================================
           MATRIX CARDS
        ================================= */



        /* =================================
           BUTTONS
        ================================= */

        .custom-btn,
        .center-profile-btn {
            width: 100%;
            min-height: 44px;
            border: 0;
            border-radius: 8px;
            transition: 0.2s ease;
        }

        .custom-btn {
            background: #2563eb;
            color: #fff;
        }

        .custom-btn:hover {
            background: #1d4ed8;
        }

        .center-profile-btn {
            background: #f3f4f6;
            color: #111827;
        }

        .center-profile-btn:hover {
            background: #e5e7eb;
        }


        /* =================================
           TABLE
        ================================= */

        .table-wrapper {
            padding: 0 24px 24px;
        }

        .table-container {
            background: #fff;
            border-radius: 16px;
            padding: 20px;
            overflow: hidden;
        }

        .table-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 20px;
        }

        .table-input {
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 450px;
            width: 100%;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 0 12px;
            border-color: #2563eb;
        }

        .table-input input {
            width: 100%;
            border: 0;
            outline: 0;
            padding: 11px 0;
        }

        .table-responsive {
            overflow-x: auto;
        }


        /* =================================
           PAGINATION
        ================================= */

        .pagination {
            background: #f5f7fb;
        }

        .pageBox {
            font-weight: 600;
            color: #374151;
        }


        /* =================================
           MOBILE
        ================================= */

        @media (max-width: 767.98px) {
            .dashboard-header {
                padding: 18px 15px;
            }

            .my-booking-tab {
                padding: 12px 15px;
            }

            .matrix-wrapper {
                padding: 15px;
            }

            .table-wrapper {
                padding: 0 15px 15px;
            }

            .table-container {
                padding: 12px;
                border-radius: 12px;
            }

            .table-header {
                flex-direction: column;
                align-items: stretch;
            }

            .table-input {
                max-width: 100%;
            }

            .pagination {
                flex-direction: column;
                gap: 12px;
            }
        }
    </style>
</head>

<body>
    <div class="ajax-loader d-none">
        <div class="spinner-border text-light"></div>
    </div>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- =================================
             MOBILE TOPBAR
            ================================= -->
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
            <div class="mobile-topbar d-md-none">
                <button class="btn text-white"
                    type="button"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileSidebar">
                    <i class="bi bi-list fs-3"></i>
                </button>
                <h5 class="text-white mb-0">
                    <?php echo $pageTitle; ?>
                </h5>
                <button class="btn text-white">
                    <i class="bi bi-bell fs-5"></i>
                </button>
            </div>