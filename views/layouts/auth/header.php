<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../../assets/admin-assets/"
  data-template="vertical-menu-template-no-customizer"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login | BookMyTestCenter</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/admin-assets/img/favicon/favicon.ico')?>" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
      rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/fontawesome.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/tabler-icons.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/fonts/flag-icons.css')?>" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/rtl/core.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/rtl/theme-default.css')?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/css/demo.css')?>" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/node-waves/node-waves.css')?>" />

    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/typeahead-js/typeahead.css')?>" />
    <!-- Vendor -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/libs/@form-validation/form-validation.css')?>" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin-assets/vendor/css/pages/page-auth.css')?>" />

    <!-- Helpers -->
    <script src="<?php echo base_url('assets/admin-assets/vendor/js/helpers.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/js/config.js')?>"></script>

    <!-- =================Custom================ -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
  </head>

  <body>

  <style>
    /*=====================================
      LOGIN PAGE
    ======================================*/

    body {
        background: #f4f6fb;
    }

    /* Hide Sneat background shapes */

    .authentication-wrapper::before,
    .authentication-wrapper::after,
    .authentication-basic::before,
    .authentication-basic::after{
        display:none !important;
    }

    /* Login Box */

    .authentication-inner .card{

        border:none;

        border-radius:18px;

        box-shadow:0 15px 40px rgba(17,40,75,.12);

        overflow:hidden;
    }

    /* Top Blue Border */

    .authentication-inner .card::before{

        content:"";

        display:block;

        width:100%;

        height:5px;

        background:#1d4f91;
    }

    /* Card Padding */

    .authentication-inner .card-body{

        padding:40px 35px;
    }

    /* Logo */

    .app-brand-link img{
      max-height: 80px !important;
      border: none !important;
      background: transparent !important;
      padding: 0 !important;
      box-shadow: none !important;
      width: 130px !important;
      object-fit: cover;
    }

    /* Heading */

    .card-body h4{

        text-align:center;

        font-size:28px;

        font-weight:700;

        color:#1d4f91;

        margin-bottom:30px;
    }

    /* Labels */

    .form-label{

        font-weight:600;

        color:#495057;

        margin-bottom:8px;
    }

    /* Inputs */

    .form-control{

        height:50px;

        border-radius:10px;

        border:1px solid #d5dce6;

        font-size:15px;

        transition:.25s;
    }

    .form-control:focus{

        border-color:#1d4f91;

        box-shadow:0 0 0 .18rem rgba(29,79,145,.15);
    }

    /* Password Icon */

    .input-group-text{

        background:#fff;

        border:1px solid #d5dce6;

        border-left:none;

        border-radius:0 10px 10px 0;
    }

    /* Login Button */

    .btn-primary{

        height:50px;

        background:#1d4f91;

        border-color:#1d4f91;

        border-radius:10px;

        font-size:16px;

        font-weight:600;

        letter-spacing:.5px;

        transition:.25s;
    }

    .btn-primary:hover{

        background:#1d4f91 !important;

        border-color:#143a6c!important;

        transform:translateY(-1px);

        box-shadow:0 8px 20px rgba(29,79,145,.25);
    }

    /* Footer Links */

    .text-center.mt-3{

        margin-top:25px !important;

        padding-top:20px;

        border-top:1px solid #edf1f7;
    }

    .text-center.mt-3 a{

        color:#1d4f91;

        font-size:13px;

        font-weight:500;

        text-decoration:none;

        transition:.2s;
    }

    .text-center.mt-3 a:hover{

        color:#0d6efd;

        text-decoration:underline;
    }

    /* Mobile */

    @media(max-width:576px){

      .authentication-inner{

          padding:20px;
      }

      .authentication-inner .card-body{

          padding:30px 22px;
      }

      .card-body h4{

          font-size:24px;
      }

      .app-brand img{

          max-height:70px !important;
      }

    }
  </style>