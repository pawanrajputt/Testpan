</main>
</div>
<!-- Main Content End -->

</div>
<!-- Main Row End -->

</div>
<!-- Main Container End -->


<!-- =========================================
     GLOBAL PAGE FOOTER
========================================= -->



<!-- =========================================
     NOTIFICATION DROPDOWN
========================================= -->

<div id="notificationDropdown"
    class="notification-dropdown d-none">

    <!-- Existing notification content can remain here -->

</div>


<!-- =========================================
     JAVASCRIPT FILES
========================================= -->

<!-- Bootstrap -->
<script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- Toastr -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Main Script -->
<script src="<?= base_url('assets/js/script.js?v=' . filemtime(FCPATH . 'assets/js/script.js')) ?>"></script>

<!-- Custom Script -->
<script src="<?= base_url('assets/js/custom.js?v=' . filemtime(FCPATH . 'assets/js/custom.js')) ?>"></script>


<!-- =========================================
     NOTIFICATION SCRIPT
========================================= -->

<script>
    $(document).ready(function() {

        $("#notificationToggle").on("click", function(e) {

            e.stopPropagation();

            $("#notificationDropdown").toggle();

        });


        $(document).on("click", function() {

            $("#notificationDropdown").hide();

        });


        $("#notificationDropdown").on("click", function(e) {

            e.stopPropagation();

        });

    });
</script>


<!-- =========================================
     SELECT2 INITIALIZATION
========================================= -->

<script>
    $(document).ready(function() {


        /*
        ===============================
        COUNTRY
        ===============================
        */

        $('select[name="country_id"]').select2({

            placeholder: "Select Country",

            allowClear: true,

            width: '100%'

        });


        /*
        ===============================
        STATE
        ===============================
        */

        $('select[name="state_id"]').select2({

            placeholder: "Select State",

            allowClear: true,

            width: '100%'

        });


        /*
        ===============================
        CITY
        ===============================
        */

        $('select[name="city_id"]').select2({

            placeholder: "Select City",

            allowClear: true,

            width: '100%'

        });


        /*
        ===============================
        BANK
        ===============================
        */

        $('select[name="bank_name"]').select2({

            placeholder: "Select Bank",

            allowClear: true,

            width: '100%'

        });


    });
</script>


<!-- =========================================
     FOOTER STYLE
========================================= -->

<style>
    /* ======================================
       FOOTER
    ====================================== */

    .app-footer {

        width: 100%;

        background: #ffffff;

        border-top: 1px solid #e5e7eb;

        padding: 16px 24px;

        box-shadow: 0 -4px 20px rgba(15, 23, 42, 0.04);

    }


    /* ======================================
       COPYRIGHT
    ====================================== */

    .footer-copyright {

        display: inline-flex;

        align-items: center;

        gap: 10px;

        color: #6b7280;

        font-size: 13px;

    }


    .footer-icon {

        width: 32px;

        height: 32px;

        display: inline-flex;

        align-items: center;

        justify-content: center;

        background: #eff6ff;

        color: #2563eb;

        border-radius: 8px;

        font-size: 16px;

    }


    /* ======================================
       FOOTER LINKS
    ====================================== */

    .footer-links a {

        color: #6b7280;

        font-size: 13px;

        text-decoration: none;

        transition: all 0.25s ease;

    }


    .footer-links a:hover {

        color: #2563eb;

    }


    .footer-links i {

        font-size: 14px;

    }


    .footer-divider {

        width: 1px;

        height: 18px;

        background: #d1d5db;

    }


    /* ======================================
       NOTIFICATION DROPDOWN
    ====================================== */

    .notification-dropdown {

        position: absolute;

        top: 70px;

        right: 20px;

        width: min(360px, calc(100vw - 30px));

        max-height: 420px;

        overflow-y: auto;

        background: #ffffff;

        border: 1px solid #e5e7eb;

        border-radius: 14px;

        box-shadow:
            0 15px 40px rgba(15, 23, 42, 0.15);

        z-index: 1050;

    }


    /* ======================================
       MOBILE
    ====================================== */

    @media (max-width: 767.98px) {

        .app-footer {

            padding: 15px;

        }


        .footer-copyright {

            justify-content: center;

            width: 100%;

            text-align: center;

        }


        .footer-links {

            width: 100%;

            flex-wrap: wrap;

        }


        .footer-divider {

            display: none;

        }

    }
</style>


</body>

</html>