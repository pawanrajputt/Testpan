<!doctype html>

<html
    lang="en"
    class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
    dir="ltr"
    data-theme="theme-default"
    data-assets-path="<?php echo base_url('assets/admin-assets/') ?>"
    data-template="vertical-menu-template-no-customizer"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title><?= $page_title ?> - Testpan India</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/admin-assets/img/favicon/favicon.ico') ?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/fontawesome.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/tabler-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/flag-icons.css') ?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/rtl/core.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/rtl/theme-default.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/css/demo.css') ?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/node-waves/node-waves.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/typeahead-js/typeahead.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/apex-charts/apex-charts.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') ?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/flatpickr/flatpickr.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') ?>" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/pages/app-logistics-dashboard.css') ?>" />

    <!-- Table CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/select2/select2.css') ?>" />

    <!-- Helpers -->
    <script src="<?php echo base_url('assets/admin-assets/vendor/js/helpers.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/js/config.js') ?>"></script>

    <!-- =================Custom====================== -->
    <!-- Toastr CSS (should come after Bootstrap) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
</head>

<style>
    .dashboard-brand {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding-left: 12px;
        text-align: center;
        width: 100%;
    }

    .brand-title {

        font-size: 22px;
        font-weight: 700;
        letter-spacing: 2px;
        color: #ffffff;
        line-height: 1.2;

    }

    .brand-subtitle {

        font-size: 13px;
        font-weight: 500;
        color: rgba(255, 255, 255, .80);
        letter-spacing: 1px;
        margin-top: 4px;

    }
</style>
<!-- Dashbaord -->
<style>
    .stat-card {
        border: 0;
        border-radius: 8px;
        overflow: hidden;
        transition: .3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .15);
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, .20);
    }

    .stat-card .card-body {
        padding: 25px 30px;
        max-height: 150px;
        position: relative;
    }

    .stat-card h2 {
        color: #fff;
        font-size: 54px;
        font-weight: 700;
        margin-bottom: 10px;
        line-height: 1;
    }

    .stat-card p {
        color: #fff;
        font-size: 20px;
        font-weight: 500;
        margin: 0;
    }

    .stat-icon {
        position: absolute;
        right: 20px;
        bottom: 10px;
        font-size: 90px;
        color: rgba(255, 255, 255, .35);
        line-height: 1;
        opacity: 1;
    }

    .ti-100px {
        font-size: 80px;
    }

    .stat-card-info {
        background: #17A2B8;
    }

    /* Responsive */

    @media(max-width:768px) {

        .stat-card .card-body {
            min-height: 150px;
        }

        .stat-card h2 {
            font-size: 42px;
        }

        .stat-card p {
            font-size: 18px;
        }

        .stat-icon {
            font-size: 70px;
        }

    }

    /* 1 - Deep Teal */
    .stat-gradient-1 {
        background: linear-gradient(135deg, #0f6c7a, #138496);
    }

    /* 2 - Emerald Green */
    .stat-gradient-2 {
        background: linear-gradient(135deg, #1f7a35, #28a745);
    }

    /* 3 - Burnt Orange */
    .stat-gradient-3 {
        background: linear-gradient(135deg, #d35400, #f57c00);
    }

    /* 4 - Royal Blue */
    .stat-gradient-4 {
        background: linear-gradient(135deg, #1565c0, #1976d2);
    }

    /* 5 - Deep Purple */
    .stat-gradient-5 {
        background: linear-gradient(135deg, #5e35b1, #7b1fa2);
    }

    /* 6 - Wine Red */
    .stat-gradient-6 {
        background: linear-gradient(135deg, #a61d24, #c62828);
    }

    /* 7 - Dark Pink */
    .stat-gradient-7 {
        background: linear-gradient(135deg, #c2185b, #d81b60);
    }

    /* 8 - Chocolate Brown */
    .stat-gradient-8 {
        background: linear-gradient(135deg, #795548, #9c6b5a);
    }

    /* 9 - Indigo */
    .stat-gradient-9 {
        background: linear-gradient(135deg, #303f9f, #3f51b5);
    }

    /* 10 - Ocean Cyan */
    .stat-gradient-10 {
        background: linear-gradient(135deg, #00796b, #0097a7);
    }

    /* 11 - Olive Green */
    .stat-gradient-11 {
        background: linear-gradient(135deg, #4e7d1d, #689f38);
    }

    /* 12 - Slate Grey */
    .stat-gradient-12 {
        background: linear-gradient(135deg, #455a64, #607d8b);
    }

    /* ======================================
     SIDEBAR BACKGROUND
    ====================================== */
    .bg-menu-theme .menu-inner-shadow {
        background: none;
    }

    #layout-menu {
        background-color: #003471 !important;
    }

    /* ======================================
       BRAND (USERNAME / LOGO AREA)
    ====================================== */
    #layout-menu .app-brand {
        background-color: #003471 !important;
        color: #ffffff !important;
        height: 100px;
    }

    #layout-menu .app-brand-text {
        color: #ffffff !important;
    }

    /* ======================================
       MENU LINKS (TEXT + ICON)
    ====================================== */
    #layout-menu .menu-link {
        color: #ffffff !important;
    }

    #layout-menu .menu-icon {
        color: #ffffff !important;
    }

    /* ======================================
       HOVER STATE
    ====================================== */
    #layout-menu .menu-link:hover {
        background-color: #084184 !important;
        color: #ffffff !important;
    }

    #layout-menu .menu-link:hover .menu-icon {
        color: #ffffff !important;
    }

    /* ======================================
       ACTIVE STATE
    ====================================== */
    #layout-menu .menu-item.active>.menu-link {
        background-color: #084184 !important;
        color: #ffffff !important;
    }

    #layout-menu .menu-item.active>.menu-link .menu-icon {
        color: #ffffff !important;
    }

    /* ======================================
       SUB MENU
    ====================================== */
    #layout-menu .menu-sub {
        background-color: #002a5c !important;
    }

    #layout-menu .menu-sub .menu-link {
        color: #ffffff !important;
    }

    #layout-menu .menu-sub .menu-link:hover {
        background-color: #084184 !important;
    }

    /* ======================================
     BADGE STYLE
  ====================================== */
    #layout-menu .badge {
        background-color: #ff4c51 !important;
        color: #ffffff !important;
    }

    /* ======================================
     REMOVE RIGHT BORDER / SHADOW
  ====================================== */
    #layout-menu {
        border-right: none !important;
    }

    /* ======================================
     ACTIVE LEFT INDICATOR (PREMIUM TOUCH)
  ====================================== */
    #layout-menu .menu-item.active>.menu-link::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background-color: #ffffff;
        border-radius: 0 4px 4px 0;
    }

    .bg-menu-theme.menu-vertical .menu-item.active>.menu-link:not(.menu-toggle) {
        background: linear-gradient(270deg, rgb(165 201 71) 0%, #3389c5 100%) !important;
        box-shadow: 0px 2px 6px 0px rgba(115, 103, 240, 0.3) !important;
    }

    .bg-menu-theme .menu-toggle::after {
        color: #fefeff !important;
    }

    .table-btn-css {
        text-align: right;
    }

    .btn-custom {
        background-color: #003471;
        color: white;
        margin-top: 15px;
    }

    .btn-custom:hover {
        background-color: #003471;
        color: white;
    }

    a {
        color: #003471;
    }

    a:hover {
        color: #003471;
    }

    .avatar-online i {
        font-size: 30px;
        color: #8e929a;
    }

    /* Chrome, Safari, Edge, Opera */
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }

    .swal2-container {
        z-index: 20000 !important;
    }

    span.badge.bg-danger.rounded-pill.badge-notifications {
        height: 15px;
        width: 15px;
    }
</style>

<style>
    /* Permission Section Title */
    .permission-title {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 15px;
    }

    /* Permission Card */
    .permission-card {
        border: none;
        border-radius: 12px;
        transition: all 0.25s ease-in-out;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        background: #ffffff;
    }

    .permission-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    /* Card Header */
    .permission-card .card-header {
        background: linear-gradient(45deg, #f8f9fa, #ffffff);
        border-bottom: 1px solid #eee;
        font-weight: 600;
        font-size: 14px;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    /* Card Body */
    .permission-card .card-body {
        max-height: 250px;
        overflow-y: auto;
        padding: 15px;
    }

    /* Custom Checkbox */
    .permission-checkbox,
    .module-select,
    #selectAll {
        cursor: pointer;
        width: 18px;
        height: 18px;
    }

    /* Checkbox + label alignment */
    .form-check {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 10px;
    }

    /* Smooth check animation */
    .permission-checkbox:checked {
        transform: scale(1.1);
        transition: 0.2s;
    }

    /* Global Select All */
    .global-select {
        padding: 10px 15px;
        background: #f1f3f5;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    /* Scrollbar Styling */
    .permission-card .card-body::-webkit-scrollbar {
        width: 5px;
    }

    .permission-card .card-body::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 10px;
    }
</style>

<style>
    /* ===== Calendar Wrapper ===== */
    .calendar-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 8px;
        margin-top: 20px;
    }

    /* ===== Header ===== */
    .calendar-table th {
        padding: 12px 0;
        text-align: center;
        background: linear-gradient(135deg, #3f51b5, #5c6bc0);
        color: #fff;
        border-radius: 6px;
        font-weight: 600;
        border: none;
    }

    /* ===== Cells ===== */
    .calendar-table td {
        height: 90px;
        vertical-align: top;
        text-align: right;
        padding: 8px;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        background: #ffffff;
        cursor: pointer;
        transition: all 0.25s ease;
        font-weight: 500;
        position: relative;
    }

    /* ===== Hover Effect ===== */
    .calendar-table td:hover {
        background: #f4f6ff;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(63, 81, 181, 0.15);
    }

    /* ===== Today ===== */
    .calendar-table td.today {
        background: #e3f2fd !important;
        border: 2px solid #2196f3;
        color: #0d47a1;
        font-weight: 700;
    }

    /* ===== Selected Date ===== */
    .calendar-table td.selected-date {
        border: 2px solid #673ab7;
        background: #ede7f6 !important;
    }

    /* ===== Other Month ===== */
    .calendar-table td.other-month {
        background: #f5f5f5;
        color: #bdbdbd;
        cursor: not-allowed;
    }

    /* ===== Booked Date (Default) ===== */
    .calendar-table td.booked {
        background: #ffebee;
        border-color: #e57373;
        color: #c62828;
        font-weight: 700;
    }

    /* ===== Self Booking ===== */
    .calendar-table td.booked.self_booking {
        background: #e8f5e9;
        border-color: #66bb6a;
        color: #1b5e20;
    }

    /* ===== Assigned Booking ===== */
    .calendar-table td.booked.assigned_booking {
        background: #fff8e1;
        border-color: #ffb300;
        color: #e65100;
    }

    /* ===== Booking Indicator Dot ===== */
    .calendar-table td.booked::after {
        content: "●";
        position: absolute;
        bottom: 6px;
        left: 8px;
        font-size: 12px;
    }

    /* ===== Month / Year Dropdown ===== */
    #monthSelect,
    #yearSelect,
    #centerSelect {
        height: 45px;
        border-radius: 8px;
        border: 1px solid #d1d5db;
        font-weight: 500;
    }
</style>

<style>
    nav#layout-navbar {
        /*background: linear-gradient(90deg, #9cc451, #4593b1, #3d8fb9);*/
        background: #174785 !important;
    }

    @keyframes scroll {
        0% {
            transform: translateX(100%);
        }

        100% {
            transform: translateX(-100%);
        }
    }

    .align-items-center h4 {
        color: white !important;
    }

    i.ti.ti-bell.ti-md {
        color: white !important;
    }
</style>

<!-- Custom -->
<style>
    .bulk-approve-btn {
        float: inline-end;
        margin: 10px 10px;
    }
</style>

<!-- Project planner -->
<style>
    /* Overview Cards Styles */
    .overview-card {
        border: none !important;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
    }

    .overview-card .card-body {
        color: #ffffff !important;
        padding: 1.5rem 1rem;
    }

    .overview-card .card-body h3 {
        color: #ffffff !important;
        font-weight: 600;
        margin-bottom: 0.25rem;
    }

    .overview-card .card-body small {
        color: rgba(255, 255, 255, 0.85) !important;
        font-size: 0.85rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .overview-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
    }

    /* Optional: Add a subtle gradient overlay for better text readability */
    .overview-card .card-body {
        position: relative;
        z-index: 1;
    }

    .overview-card .card-body::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.05);
        z-index: -1;
        border-radius: 0.25rem;
    }
</style>

<!-- Page Modification -->
<style>
    .content-wrapper {
        background: #f5f7fb;
        min-height: 100vh;
    }

    .container-p-y {
        padding-top: 25px !important;
        padding-bottom: 25px !important;
    }

    .content-wrapper h4.py-3 {

        font-size: 25px;

        font-weight: 700;

        color: #1b3764;

        margin-bottom: 10px !important;

    }

    .content-wrapper h4.py-3 .text-muted {

        font-size: 18px;

        color: #6c757d !important;

    }

    .content-wrapper h4.py-3 a {

        text-decoration: none;

        color: #5d7ca6;

    }

    .content-wrapper .card {

        border-radius: 14px;

        box-shadow: 0 8px 24px rgba(0, 0, 0, .08);

    }

    .table-primary-custom {

        background: #174785 !important;
        ;

    }

    .table-primary-custom th {

        color: #fff !important;

        border: none;

        font-size: 15px;

        font-weight: 600;

        padding: 16px;

    }

    .table tbody tr {

        transition: .25s;

    }

    .table tbody tr:hover {

        background: #eef5ff;

    }

    .btn {

        border-radius: 8px;

        font-weight: 600;

        padding: 9px 18px;

        box-shadow: 0 3px 10px rgba(0, 0, 0, .08);

    }

    .btn:hover {

        transform: translateY(-2px);

    }

    .dataTables_filter input {

        border-radius: 25px !important;

        border: 1px solid #d6d6d6;

        padding: 8px 16px;

    }

    .dataTables_length select {

        border-radius: 8px;

    }

    .page-link {

        border-radius: 8px !important;

        margin: 0 3px;

    }

    .page-item.active .page-link {

        background: #6a5cff;

        border-color: #6a5cff;

    }

    .badge {

        border-radius: 20px;

        padding: 8px 14px;

    }

    .form-control {

        border-radius: 8px;

    }

    .form-select {

        border-radius: 8px;

    }

    input[type=checkbox] {

        width: 18px;

        height: 18px;

    }

    .table {

        margin-bottom: 0;

    }

    .table td {

        vertical-align: middle;

    }

    .content-wrapper .d-flex.justify-content-between {

        background: #fff;

        padding: 18px;

        border-radius: 12px;

        box-shadow: 0 5px 15px rgba(0, 0, 0, .06);

    }

    #filterBtn {
        background: #174785;
    }

    #filterBtn:hover {
        background: #174785 !important;
    }

    /*Table summary*/
    .module-summary {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 22px;
        margin: 14px 0 18px;
        font-size: 16px;
        color: #5b6574;
    }

    .summary-title {
        font-weight: 700;
        color: #234f8e;
        margin-right: 10px;
    }

    .summary-item {
        display: flex;
        align-items: center;
        font-weight: 500;
    }

    .summary-item strong {
        margin-left: 5px;
        font-size: 15px;
        color: #1f2937;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        margin-right: 8px;
        display: inline-block;
    }

    .bg-primary {
        background: #2563eb;
    }

    .bg-success {
        background: #22c55e;
    }

    .bg-warning {
        background: #f59e0b;
    }

    .bg-danger {
        background: #ef4444;
    }

    .bg-purple {
        background: #8b5cf6;
    }

    /*Project Planner*/
    .statistics-row {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 18px;
        margin: 12px 0 18px;
        padding: 0;
        font-size: 14px;
    }

    .statistics-title {
        font-weight: 700;
        color: #1d4f91;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-right: 10px;
    }

    .statistics-divider {
        width: 1px;
        height: 18px;
        background: #d9dfe8;
    }

    .statistics-item {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #5d6677;
        white-space: nowrap;
        font-size: 14px;
    }

    .statistics-item strong {
        color: #2d3748;
        font-size: 15px;
        margin-left: 2px;
    }

    .dot {
        width: 9px;
        height: 9px;
        border-radius: 50%;
    }

    .blue .dot {
        background: #3b82f6;
    }

    .success .dot {
        background: #22c55e;
    }

    .info .dot {
        background: #06b6d4;
    }

    .dark .dot {
        background: #64748b;
    }

    .purple .dot {
        background: #8b5cf6;
    }

    .cyan .dot {
        background: #0ea5e9;
    }

    .warning .dot {
        background: #f59e0b;
    }

    .orange .dot {
        background: #fb923c;
    }

    .lime .dot {
        background: #84cc16;
    }

    .primary .dot {
        background: #0451f9
    }

    .danger .dot {
        background: #fd0b29
    }

    @media(max-width:768px) {

        .statistics-row {
            gap: 10px;
            font-size: 13px;
        }

        .statistics-item {
            font-size: 13px;
        }

        .statistics-item strong {
            font-size: 14px;
        }

        .statistics-divider {
            display: none;
        }

    }

    /* Section Statistics CCs */
    /* =========================================================
   COMMON MODULE STATISTICS
   Used by Project Planner, Client Projects, etc.
   ========================================================= */

    .module-statistics {
        width: 100%;
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 16px;
        margin-bottom: 20px;
    }


    /* =========================================================
   STAT CARD
   ========================================================= */

    .module-statistics .stat-card {
        position: relative;
        min-width: 0;
        min-height: 125px;

        border-radius: 12px;
        overflow: hidden;

        color: #ffffff;

        display: flex;
        flex-direction: column;
        justify-content: space-between;

        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.10);

        transition: all 0.25s ease;
    }

    .module-statistics .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 9px 22px rgba(0, 0, 0, 0.15);
    }


    /* =========================================================
   DECORATIVE CIRCLES
   ========================================================= */

    .module-statistics .stat-card::before {
        content: "";

        position: absolute;

        width: 130px;
        height: 130px;

        right: -45px;
        top: -55px;

        background: rgba(255, 255, 255, 0.10);

        border-radius: 50%;

        pointer-events: none;
    }

    .module-statistics .stat-card::after {
        content: "";

        position: absolute;

        width: 90px;
        height: 90px;

        right: -25px;
        bottom: -45px;

        background: rgba(255, 255, 255, 0.07);

        border-radius: 50%;

        pointer-events: none;
    }


    /* =========================================================
   ICON
   ========================================================= */

    .module-statistics .stat-icon {
        position: absolute;

        top: 15px;
        left: 15px;

        width: 48px;
        height: 48px;

        min-width: 48px;

        border-radius: 50%;

        background: rgba(255, 255, 255, 0.95);

        display: flex;
        align-items: center;
        justify-content: center;

        z-index: 2;
    }

    .module-statistics .stat-icon i {
        font-size: 23px;
    }


    /* =========================================================
   CONTENT
   ========================================================= */

    .module-statistics .stat-content {
        position: relative;
        z-index: 2;

        margin-left: 78px;

        padding: 17px 12px 10px 0;

        min-width: 0;
    }


    /*
 * IMPORTANT:
 * Do NOT use nowrap here.
 * Long names like Allocation Complete
 * must be allowed to wrap.
 */

    .module-statistics .stat-content span {
        display: block;

        max-width: 100%;

        font-size: 12px;
        line-height: 1.25;

        font-weight: 600;

        text-transform: uppercase;

        letter-spacing: 0.1px;

        opacity: 0.95;

        white-space: normal;
        overflow-wrap: break-word;
    }

    .module-statistics .stat-content strong {
        display: block;

        margin-top: 4px;

        font-size: 25px;
        line-height: 1;

        font-weight: 700;
    }


    /* =========================================================
   FOOTER
   ========================================================= */

    .module-statistics .stat-footer {
        position: relative;
        z-index: 3;

        min-height: 31px;

        display: flex;
        align-items: center;
        justify-content: center;

        padding: 5px 8px;

        background: rgba(0, 0, 0, 0.10);

        font-size: 11px;
        line-height: 1.2;

        font-weight: 600;

        text-align: center;
    }


    /* =========================================================
   COLORS
   ========================================================= */

    .module-statistics .stat-blue {
        background: linear-gradient(135deg, #2196f3, #1565c0);
    }

    .module-statistics .stat-primary {
        background: linear-gradient(135deg, #2979ff, #1557d6);
    }

    .module-statistics .stat-info {
        background: linear-gradient(135deg, #00bcd4, #008fa3);
    }

    .module-statistics .stat-success {
        background: linear-gradient(135deg, #2ecc71, #16a34a);
    }

    .module-statistics .stat-danger {
        background: linear-gradient(135deg, #ff5252, #e53935);
    }

    .module-statistics .stat-purple {
        background: linear-gradient(135deg, #9b59ff, #673ab7);
    }

    .module-statistics .stat-cyan {
        background: linear-gradient(135deg, #29b6f6, #0288d1);
    }

    .module-statistics .stat-warning {
        background: linear-gradient(135deg, #ffb300, #f57c00);
    }

    .module-statistics .stat-orange {
        background: linear-gradient(135deg, #ff9800, #ef6c00);
    }

    .module-statistics .stat-lime {
        background: linear-gradient(135deg, #8bc34a, #43a047);
    }


    /* =========================================================
   ICON COLORS
   ========================================================= */

    .module-statistics .stat-blue .stat-icon i {
        color: #1976d2;
    }

    .module-statistics .stat-primary .stat-icon i {
        color: #2468e8;
    }

    .module-statistics .stat-info .stat-icon i {
        color: #00a5bb;
    }

    .module-statistics .stat-success .stat-icon i {
        color: #20a957;
    }

    .module-statistics .stat-danger .stat-icon i {
        color: #ef4444;
    }

    .module-statistics .stat-purple .stat-icon i {
        color: #7c3aed;
    }

    .module-statistics .stat-cyan .stat-icon i {
        color: #0288d1;
    }

    .module-statistics .stat-warning .stat-icon i {
        color: #f57c00;
    }

    .module-statistics .stat-orange .stat-icon i {
        color: #ef6c00;
    }

    .module-statistics .stat-lime .stat-icon i {
        color: #4caf50;
    }


    /* =========================================================
   RESPONSIVE
   ========================================================= */

    @media (max-width: 1400px) {

        .module-statistics {
            gap: 12px;
        }

        .module-statistics .stat-content {
            margin-left: 70px;
        }

        .module-statistics .stat-icon {
            width: 43px;
            height: 43px;
            min-width: 43px;
        }

        .module-statistics .stat-icon i {
            font-size: 20px;
        }

        .module-statistics .stat-content span {
            font-size: 11px;
        }

        .module-statistics .stat-content strong {
            font-size: 22px;
        }
    }


    @media (max-width: 1100px) {

        .module-statistics {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

    }


    @media (max-width: 768px) {

        .module-statistics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

    }


    @media (max-width: 480px) {

        .module-statistics {
            grid-template-columns: 1fr;
        }

    }
</style>


/* Project status change css */
<style>
    /* =========================================================
   CLIENT REQUIREMENT CHANGES
   ========================================================= */

    .requirement-changes {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;
        margin-bottom: 20px;
        box-shadow: 0 8px 25px rgba(31, 56, 100, 0.08);
    }


    /* Header */

    .requirement-changes-header {
        min-height: 70px;
        padding: 0 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        background: linear-gradient(135deg, #ff9f43, #ff8c35);

        border-radius: 12px;
        color: #ffffff;
    }

    .requirement-changes-title {
        display: flex;
        align-items: center;
        gap: 10px;

        font-size: 17px;
    }

    .requirement-changes-title i {
        font-size: 21px;
    }

    .requirement-changes-count {
        padding: 8px 16px;

        background: #ff4757;
        color: #ffffff;

        border-radius: 30px;

        font-size: 13px;
        font-weight: 700;
    }


    /* List */

    .requirement-changes-list {
        margin-top: 14px;
    }


    /* Item */

    .requirement-change-item {
        padding: 14px 18px;

        background: #ffffff;

        border-radius: 12px;

        box-shadow: 0 5px 18px rgba(31, 56, 100, 0.06);

        border: 1px solid #eef1f6;

        margin-bottom: 12px;

        transition: all 0.2s ease;
    }

    .requirement-change-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(31, 56, 100, 0.10);
    }


    /* Top */

    .requirement-change-top {
        display: flex;
        align-items: center;
        justify-content: space-between;

        padding-bottom: 11px;

        border-bottom: 1px solid #eef1f6;
    }

    .requirement-change-city {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        padding: 7px 15px;

        background: #7067e8;
        color: #ffffff;

        border-radius: 30px;

        font-size: 12px;
        font-weight: 700;
    }

    .requirement-change-city i {
        font-size: 14px;
    }

    .requirement-change-date {
        display: flex;
        align-items: center;
        gap: 5px;

        color: #a1a5b7;

        font-size: 12px;
    }

    .requirement-change-date i {
        font-size: 14px;
    }


    /* Content */

    .requirement-change-content {
        padding-top: 11px;
    }

    .change-detail {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 7px;

        font-size: 14px;
    }

    .change-icon {
        width: 30px;
        height: 30px;

        border-radius: 8px;

        display: inline-flex;
        align-items: center;
        justify-content: center;

        background: currentColor;

        margin-right: 2px;
    }

    .change-icon i {
        color: #ffffff;
        font-size: 16px;
    }

    .change-label {
        font-weight: 600;
    }

    .change-detail strong {
        font-size: 15px;
        color: #5e6278;
    }

    .change-arrow {
        font-size: 17px;
        font-weight: 700;
        color: #7e8299;
    }

    .change-new-value {
        color: #20b76b !important;
    }


    /* =========================================================
   CHANGE COLORS
   ========================================================= */

    .change-success {
        color: #20b76b;
    }

    .change-danger {
        color: #ef4444;
    }

    .change-primary {
        color: #5b61f6;
    }

    .change-info {
        color: #08a8c4;
    }

    .change-warning {
        color: #f59e0b;
    }


    /* =========================================================
   RESPONSIVE
   ========================================================= */

    @media (max-width: 768px) {

        .requirement-changes {
            padding: 12px;
        }

        .requirement-changes-header {
            padding: 12px 15px;
            min-height: 60px;
        }

        .requirement-changes-title {
            font-size: 14px;
        }

        .requirement-changes-count {
            padding: 6px 11px;
            font-size: 11px;
        }

        .requirement-change-top {
            align-items: flex-start;
            flex-direction: column;
            gap: 8px;
        }

    }
</style>

<!-- Project Batch Statistics Css -->
<style>
    /* =========================================================
   MULTI CITY STATISTICS
   ========================================================= */

    .city-statistics-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 16px;

        box-shadow: 0 8px 25px rgba(31, 56, 100, 0.08);

        border: 1px solid #edf0f5;
    }


    /* =========================================================
   CITY HEADER
   ========================================================= */

    .city-statistics-header {
        min-height: 62px;

        padding: 0 20px;

        display: flex;
        align-items: center;
        justify-content: space-between;

        background: linear-gradient(135deg, #7067e8, #6254d9);

        border-radius: 12px;

        color: #ffffff;

        margin-bottom: 16px;
    }

    .city-title {
        display: flex;
        align-items: center;
        gap: 9px;

        font-size: 18px;
        font-weight: 700;
    }

    .city-title i {
        font-size: 22px;
    }

    .city-summary-label {
        padding: 7px 14px;

        background: rgba(255, 255, 255, 0.16);

        border: 1px solid rgba(255, 255, 255, 0.20);

        border-radius: 20px;

        font-size: 11px;
        font-weight: 600;
    }


    /* =========================================================
   CITY SUMMARY
   Uses the same common .module-statistics CSS
   ========================================================= */

    .city-summary-statistics {
        margin-bottom: 16px;
    }


    /* =========================================================
   SECTION TITLE
   ========================================================= */

    .city-section-title {
        display: flex;
        align-items: center;
        gap: 8px;

        color: #1f4f8f;

        font-size: 15px;
        font-weight: 700;

        margin-bottom: 12px;
    }

    .city-section-title i {
        font-size: 19px;
    }


    /* =========================================================
   REQUEST STATUS
   ========================================================= */

    .city-request-status {
        padding: 16px;

        background: #f8faff;

        border: 1px solid #edf1f7;

        border-radius: 12px;

        margin-bottom: 16px;
    }

    .request-status-grid {
        display: grid;

        grid-template-columns: repeat(6, minmax(0, 1fr));

        gap: 12px;
    }

    .request-status-item {
        min-height: 65px;

        display: flex;
        align-items: center;

        gap: 10px;

        padding: 10px 12px;

        background: #ffffff;

        border-radius: 10px;

        border: 1px solid #edf0f5;

        box-shadow: 0 3px 10px rgba(31, 56, 100, 0.05);

        transition: all 0.2s ease;
    }

    .request-status-item:hover {
        transform: translateY(-2px);

        box-shadow: 0 6px 15px rgba(31, 56, 100, 0.09);
    }

    .request-status-icon {
        width: 38px;
        height: 38px;

        min-width: 38px;

        border-radius: 10px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: currentColor;
    }

    .request-status-icon i {
        color: #ffffff;
        font-size: 18px;
    }

    .request-status-item span {
        display: block;

        color: #7e8299;

        font-size: 11px;
        font-weight: 600;
    }

    .request-status-item strong {
        display: block;

        color: #343a40;

        font-size: 18px;

        line-height: 1.1;

        margin-top: 2px;
    }


    /* Status Colors */

    .status-info {
        color: #08a8c4;
    }

    .status-warning {
        color: #f59e0b;
    }

    .status-success {
        color: #20b76b;
    }

    .status-danger {
        color: #ef4444;
    }

    .status-purple {
        color: #7c3aed;
    }

    .status-primary {
        color: #2979ff;
    }


    /* =========================================================
   BATCH DETAILS
   ========================================================= */

    .city-batch-section {
        padding: 16px;

        background: #ffffff;

        border: 1px solid #edf0f5;

        border-radius: 12px;
    }

    .city-batch-table {
        border-collapse: separate;
        border-spacing: 0;

        overflow: hidden;

        border: 1px solid #e7eaf0;

        border-radius: 10px;
    }

    .city-batch-table thead th {
        background: #f1f3f7;

        color: #4b4f58;

        font-size: 12px;

        font-weight: 700;

        text-transform: uppercase;

        letter-spacing: 0.3px;

        padding: 13px 14px;

        border-bottom: 1px solid #e1e4ea;

        white-space: nowrap;
    }

    .city-batch-table tbody td {
        padding: 13px 14px;

        color: #6b7080;

        font-size: 13px;

        vertical-align: middle;

        border-bottom: 1px solid #edf0f5;
    }

    .city-batch-table tbody tr:last-child td {
        border-bottom: 0;
    }

    .city-batch-table tbody tr {
        transition: background 0.2s ease;
    }

    .city-batch-table tbody tr:hover {
        background: #f8faff;
    }


    /* Batch */

    .batch-name {
        display: inline-flex;
        align-items: center;

        padding: 6px 10px;

        background: #f1efff;

        color: #6658d9;

        border-radius: 7px;

        font-weight: 700;

        font-size: 12px;
    }


    /* Timing */

    .batch-time {
        display: inline-flex;
        align-items: center;
        gap: 6px;

        color: #626778;

        white-space: nowrap;
    }

    .batch-time i {
        color: #7067e8;
        font-size: 16px;
    }

    .batch-time span {
        color: #a1a5b7;
        font-weight: 700;
    }


    /* Seats */

    .city-batch-table tbody td strong {
        color: #4b4f58;

        font-size: 14px;
    }

    .approved-seat {
        display: inline-flex;

        min-width: 35px;

        justify-content: center;

        padding: 5px 9px;

        border-radius: 7px;

        background: #e9f9f0;

        color: #16a34a;

        font-weight: 700;
    }

    .remaining-seat {
        display: inline-flex;

        min-width: 35px;

        justify-content: center;

        padding: 5px 9px;

        border-radius: 7px;

        background: #fff3df;

        color: #f08a00;

        font-weight: 700;
    }

    .remaining-complete {
        display: inline-flex;

        min-width: 35px;

        justify-content: center;

        padding: 5px 9px;

        border-radius: 7px;

        background: #e9f9f0;

        color: #16a34a;

        font-weight: 700;
    }


    /* =========================================================
   RESPONSIVE
   ========================================================= */

    @media (max-width: 1200px) {

        .request-status-grid {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

    }

    @media (max-width: 768px) {

        .city-statistics-card {
            padding: 12px;
        }

        .city-statistics-header {
            padding: 12px 15px;

            align-items: flex-start;

            flex-direction: column;

            gap: 8px;
        }

        .city-summary-statistics {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .request-status-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

    }

    @media (max-width: 480px) {

        .city-summary-statistics {
            grid-template-columns: 1fr;
        }

        .request-status-grid {
            grid-template-columns: 1fr;
        }

    }

    /* body, .content-wrapper{
        background-color: #F4F7FC !important;
    } */
</style>

<body>