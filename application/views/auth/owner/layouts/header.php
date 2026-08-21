<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Listing</title>
    <link rel="stylesheet" href="<?= base_url('assets/bootstrap/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth_owner_pages.css')?>">
    <link rel="icon" href="<?= base_url('assets/asserts/logo.png')?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- jQuery (Required for DataTables & Toastr) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        var base_url = "<?= base_url(); ?>";
    </script>
    
    <style>
        /* Custom DataTables Styling */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 0.75rem;
        }
        
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 0.375rem 2rem 0.375rem 0.75rem;
        }
        
        .dt-buttons .btn {
            border-radius: 0.375rem;
        }
        
        .table.dataTable {
            margin-top: 10px !important;
            margin-bottom: 10px !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 0.375rem !important;
            margin: 0 2px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: #0d6efd !important;
            color: white !important;
            border: 1px solid #0d6efd !important;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #e9ecef !important;
            border: 1px solid #dee2e6 !important;
        }
        
        .location-cell {
            min-width: 200px;
            white-space: nowrap;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dt-buttons {
                margin-bottom: 10px;
            }
            
            .dataTables_length,
            .dataTables_filter {
                margin-bottom: 10px;
            }
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
            box-shadow: 0 6px 15px rgba(63,81,181,0.15);
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
        span#select2-centerSelect-container {
            line-height: 40px;
        }
        span.select2-selection.select2-selection--single {
            height: 43px;
            border-radius: 10px;
        }
        span.select2-selection__arrow {
            margin-top: 8px;
        }
        button.select2-selection__clear span{
            font-size: 30px !important;
            color: red;
            line-height: 40px;
        }
        select{
            cursor: pointer;
        }
    </style>
</head>

<body>