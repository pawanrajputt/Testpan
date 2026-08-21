    <!-- Correct Script Paths -->
    <script src="<?= base_url('assets/bootstrap/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('assets/js/script.js?v=' . time()) ?>"></script>
    <script src="<?= base_url('assets/js/custom.js?v=' . time()) ?>"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('select[name="country_id"]').select2({
                placeholder: "Select Country",
                allowClear: true,
                width: '100%'
            });

            $('select[name="state_id"]').select2({
                placeholder: "Select State",
                allowClear: true,
                width: '100%'
            });

            $('select[name="city_id"]').select2({
                placeholder: "Select City",
                allowClear: true,
                width: '100%'
            });

            $('select[name="bank_name"]').select2({
                placeholder: "Select Bank",
                allowClear: true,
                width: '100%'
            });

        });
    </script>
</body>

</html>
