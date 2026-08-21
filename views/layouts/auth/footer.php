    <!-- Core JS -->
    <!-- build:js assets/admin-assets/vendor/js/core.js')?> -->

    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/jquery/jquery.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/popper/popper.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/js/bootstrap.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/node-waves/node-waves.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/hammer/hammer.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/i18n/i18n.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/typeahead-js/typeahead.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/js/menu.js')?>"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/@form-validation/popular.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/@form-validation/bootstrap5.js')?>"></script>
    <script src="<?php echo base_url('assets/admin-assets/vendor/libs/@form-validation/auto-focus.js')?>"></script>

    <!-- Main JS -->
    <script src="<?php echo base_url('assets/admin-assets/js/main.js')?>"></script>

    <!-- Page JS -->
    <script src="<?php echo base_url('assets/admin-assets/js/pages-auth.js')?>"></script>


    <!-- =====================Custom================== -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <!-- Base URL for JS -->
    <script>
        var base_url = "<?= base_url(); ?>";
        // Initialize toastr with proper settings
        toastr.options = {
            "closeButton": true,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "timeOut": "5000",
            "extendedTimeOut": "1000"
        };
    </script>
  </body>
</html>