  <!--js link here -->
<script src="<?= base_url('assets/js/script.js?v=' . time()) ?>"></script>
<script src="<?= base_url('assets/js/custom.js?v=' . time()) ?>"></script>

  <!-- bootstrap script link here -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

<script>
  $(document).ready(function () {

    $('.select2-country').select2({
        placeholder: "Select Country",
        width: '100%'
    });

    $('.select2-state').select2({
        placeholder: "Select State",
        width: '100%'
    });

    $('.select2-city').select2({
        placeholder: "Select City",
        width: '100%'
    });

});
</script>

</html>