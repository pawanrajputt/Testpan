<!-- Footer -->
<footer class="content-footer footer bg-footer-theme">
    <div class="container-xxl">
        <div class="footer-container d-flex align-items-center justify-content-between py-4 flex-md-row flex-column">
            <div class="text-body">
                ©
                <script>
                    document.write(new Date().getFullYear());
                </script>
            </div>
        </div>
    </div>
</footer>
<!-- / Footer -->

<div class="content-backdrop fade"></div>
</div>
<!-- Content wrapper -->
</div>
<!-- / Layout page -->
</div>

<!-- Overlay -->
<div class="layout-overlay layout-menu-toggle"></div>

<!-- Drag Target Area To SlideIn Menu On Small Screens -->
<div class="drag-target"></div>
</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js')?> -->

<script src="<?php echo base_url('assets/admin-assets/vendor/libs/jquery/jquery.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/popper/popper.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/js/bootstrap.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/node-waves/node-waves.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/hammer/hammer.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/i18n/i18n.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/typeahead-js/typeahead.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/js/menu.js') ?>"></script>

<!-- endbuild -->

<!-- Vendors JS -->
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/apex-charts/apexcharts.js') ?>"></script>
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') ?>"></script>

<script src="<?php echo base_url('assets/admin-assets/vendor/libs/flatpickr/flatpickr.js')?>"></script>

<!-- Main JS -->
<script src="<?php echo base_url('assets/admin-assets/js/main.js') ?>"></script>

<!-- Page JS -->
<script src="<?php echo base_url('assets/admin-assets/js/app-logistics-dashboard.js') ?>"></script>

<!-- Table  JS -->
<script src="<?php echo base_url('assets/admin-assets/vendor/libs/select2/select2.js')?>"></script>

<!-- ======================================Custom============================ -->
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<?php
$success = $this->session->flashdata('success');
$error   = $this->session->flashdata('error');
$warning = $this->session->flashdata('warning');
$info    = $this->session->flashdata('info');
?>

<?php if ($success): ?>
<script>
    toastr.success("<?= addslashes($success) ?>");
</script>
<?php endif; ?>

<?php if ($error): ?>
<script>
    toastr.error("<?= addslashes($error) ?>");
</script>
<?php endif; ?>

<?php if ($warning): ?>
<script>
    toastr.warning("<?= addslashes($warning) ?>");
</script>
<?php endif; ?>

<?php if ($info): ?>
<script>
    toastr.info("<?= addslashes($info) ?>");
</script>
<?php endif; ?>

<?php
// Explicitly unset (extra safety)
$this->session->unset_userdata(['success', 'error', 'warning', 'info']);
?>


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
<script>
    $(document).ready(function() {
        $('.select-center').select2({
            placeholder: "Select Center"
        });

        $('.select-country').select2({
            placeholder: "Select Country"
        });

        $('.select-state').select2({
            placeholder: "Select State"
        });

        $('.select-city').select2({
            placeholder: "Select City"
        });

        $('.select2').select2();

        $(".flatpickr-date").flatpickr({
            enableTime: false,
            dateFormat: 'Y-m-d',
        });

    });
</script>
<script>
    $(document).ready(function () {

        initLocationFilter({
            country: '#country_id',
            state: '#state_id',
            city: '#city'
        });

    });
</script>
<script>
    function initLocationFilter(config) {

        const countrySelector = config.country;
        const stateSelector   = config.state;
        const citySelector    = config.city;

        // COUNTRY CHANGE
        $(document).on('change', countrySelector, function () {

            let country_id = $(this).val();

            $(stateSelector).html('<option value="">Loading...</option>');
            $(citySelector).html('<option value="">Select City</option>');

            if(country_id !== '') {

                $.ajax({
                    url: base_url + 'admin/center/get-states',
                    type: "POST",
                    data: {country_id: country_id},
                    dataType: "json",
                    success: function (response) {

                        let options = '<option value="">Select State</option>';

                        response.forEach(function (state) {
                            options += `<option value="${state.id}">${state.title}</option>`;
                        });

                        $(stateSelector).html(options).trigger('change.select2');
                    }
                });

            } else {
                $(stateSelector).html('<option value="">Select State</option>');
            }
        });


        // STATE CHANGE
        $(document).on('change', stateSelector, function () {

            let state_id = $(this).val();

            $(citySelector).html('<option value="">Loading...</option>');

            if(state_id !== '') {

                $.ajax({
                    url: base_url + 'admin/center/get-cities',
                    type: "POST",
                    data: {state_id: state_id},
                    dataType: "json",
                    success: function (response) {

                        let options = '<option value="">Select City</option>';

                        response.forEach(function (city) {
                            options += `<option value="${city.city_id}">${city.city_name}</option>`;
                        });

                        $(citySelector).html(options);
                    }
                });

            } else {
                $(citySelector).html('<option value="">Select City</option>');
            }
        });
    }
</script>
<script>
    // Mark as read
    $(document).on('click', '.mark-read', function () {

        let id = $(this).data('id');

        $.post("<?= base_url('admin/mark-read') ?>", {id: id}, function () {
            $('#notif_' + id).fadeOut();
        });
    });

    // Remove
    $(document).on('click', '.remove-notification', function () {

        let id = $(this).data('id');

        $.post("<?= base_url('admin/remove') ?>", {id: id}, function () {
            $('#notif_' + id).fadeOut();
        });
    });

    // Mark all
    $('.dropdown-notifications-all').on('click', function () {

        $.post("<?= base_url('admin/mark-all') ?>", function () {
            location.reload();
        });
    });

    // Bell Icon Click Count
    $('.dropdown-notifications .nav-link').on('click', function () {

        // Make badge count zero instantly
        $('.badge-notifications').text(0).hide();

        // Mark all notifications read in DB
        $.post("<?= base_url('admin/mark-all') ?>");

        $('.badge-dot').remove();

    });
</script>

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'), {
            toolbar: [
                'heading',
                '|',
                'bold', 'italic', 'underline',
                '|',
                'link',
                'bulletedList', 'numberedList',
                '|',
                'blockQuote',
                'insertTable',
                '|',
                'undo', 'redo'
            ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
<script>
    function showProjectInfo(company, type, client, projectId, exam_name)
    {
        Swal.fire({
            title: 'Project Information',
            html: `
                <div style="text-align:left">
                    <b class="mb-3">Company Name:</b> ${company}<br>
                    <b class="mb-3">Company Type:</b> ${type}<br>
                    <b class="mb-3">Client Name:</b> ${client}<br>
                    <b class="mb-3">Project ID:</b> ${projectId}<br>
                    <b class="mb-3">Exam Name:</b> ${exam_name}<br>
                </div>
            `,
            icon: 'info',
            confirmButtonText: 'Close'
        });
    }
</script>

</body>

</html>