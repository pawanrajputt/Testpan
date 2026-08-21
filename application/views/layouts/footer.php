</div>
</div>
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= base_url('assets/js/script.js?v=' . time()) ?>"></script>
<script src="<?= base_url('assets/js/custom.js?v=' . time()) ?>"></script>
</body>
<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Include jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function() {

        $('#citySelect').select2({
            placeholder: "Select Cities",
            width: '100%'
        });

        $("#citySelect").on("change", renderCityCards);

        $("#invigilator_ratio_1").val(24);
        $("#invigilator_ratio_2").val(1);

        $("#security_guard_ratio_1").val(24);
        $("#security_guard_ratio_2").val(1);

        calculateStaff();

    });


    function renderCityCards() {

        let container = $("#cityBatchContainer");

        let oldCards = {};

        $(".city-card").each(function() {

            oldCards[$(this).data("city")] = $(this).prop("outerHTML");

        });

        container.html('');

        $("#citySelect option:selected").each(function() {

            let cityId = $(this).val();
            let cityName = $(this).text();

            if (oldCards[cityId]) {

                container.append(oldCards[cityId]);

                return;
            }

            container.append(`

        <div class="card shadow-sm mb-4 city-card" data-city="${cityId}">

            <div class="card-header bg-primary text-white">

                <strong>${cityName}</strong>

            </div>

            <div class="card-body">

                <div class="row">

                    <div class="col-md-4">

                        <label>Total Seats</label>

                        <input
                        type="number"
                        class="form-control city-total-seat seat-input"
                        name="city_seats[${cityId}]"
                        data-city="${cityId}"
                        required>

                    </div>

                    <div class="col-md-4">

                        <label>No. Of Batches</label>

                        <select
                        class="form-control city-batch-count"
                        data-city="${cityId}"
                        name="city_batch_count[${cityId}]"
                        required>

                            <option value="">Select</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>

                        </select>

                    </div>

                </div>

                <div class="batch-wrapper mt-4">

                </div>

            </div>

        </div>

        `);

        });

    }



    $(document).on("change", ".city-batch-count", function() {

        let batchCount = parseInt($(this).val()) || 0;

        let cityId = $(this).data("city");

        let wrapper = $(this)
            .closest(".city-card")
            .find(".batch-wrapper");

        let currentBatch = wrapper.find(".border").length;

        if (batchCount > currentBatch) {

            for (let i = currentBatch + 1; i <= batchCount; i++) {

                wrapper.append(`

            <div class="border rounded p-3 mb-3">

                <h6>

                    Batch ${i}

                </h6>

                <div class="row">

                    <div class="col-md-4">

                        <label>Start Time</label>

                        <input
                        type="time"
                        class="form-control"
                        name="batch[${cityId}][${i}][start]"
                        required>

                    </div>

                    <div class="col-md-4">

                        <label>End Time</label>

                        <input
                        type="time"
                        class="form-control"
                        name="batch[${cityId}][${i}][end]"
                        required>

                    </div>

                    <div class="col-md-4">

                        <label>Seat</label>

                        <input
                        type="number"
                        class="form-control batch-seat"
                        name="batch[${cityId}][${i}][seat]"
                        required>

                    </div>

                </div>

            </div>

            `);

            }

        } else if (batchCount < currentBatch) {

            wrapper.find(".border").slice(batchCount).remove();

        }

    });



    $(document).on("input", ".batch-seat,.city-total-seat", function() {

        $(".city-card").each(function() {

            let total = parseInt(
                $(this).find(".city-total-seat").val()
            ) || 0;

            let batchTotal = 0;

            $(this).find(".batch-seat").each(function() {

                batchTotal += parseInt($(this).val()) || 0;

            });

            $(this).find(".seat-error").remove();

            if (total > 0 && batchTotal != total) {

                $(this).find(".batch-wrapper").append(

                    `<div class="text-danger mt-2 seat-error">

                    Batch Total (${batchTotal})

                    should equal

                    City Seat (${total})

                </div>`

                );

            }

        });

        calculateStaff();

    });

    function calculateStaff() {

        let totalSeats = 0;

        $(".city-total-seat").each(function() {

            totalSeats += parseInt($(this).val()) || 0;

        });

        let invRatio1 = parseInt($("#invigilator_ratio_1").val()) || 24;
        let invRatio2 = parseInt($("#invigilator_ratio_2").val()) || 1;

        let secRatio1 = parseInt($("#security_guard_ratio_1").val()) || 24;
        let secRatio2 = parseInt($("#security_guard_ratio_2").val()) || 1;

        let invStaff = Math.ceil((totalSeats * invRatio2) / invRatio1);
        let secStaff = Math.ceil((totalSeats * secRatio2) / secRatio1);

        $("#invigilator_male").val(Math.ceil(invStaff / 2));
        $("#invigilator_female").val(Math.floor(invStaff / 2));

        $("[name='security_guard_male']").val(Math.ceil(secStaff / 2));
        $("[name='security_guard_female']").val(Math.floor(secStaff / 2));

    }



    $(document).on("input",

        "#invigilator_ratio_1,#invigilator_ratio_2,#security_guard_ratio_1,#security_guard_ratio_2",

        calculateStaff

    );

    $(document).on(
        "input",
        ".city-total-seat",
        calculateStaff
    );

    $(document).on(
        "keyup change",
        "#invigilator_ratio_1,#invigilator_ratio_2,#security_guard_ratio_1,#security_guard_ratio_2",
        calculateStaff
    );
</script>


<script>
    function isNumberKey(evt) {
        let charCode = evt.which ? evt.which : evt.keyCode;

        // Allow only numbers (0-9)
        if (charCode < 48 || charCode > 57) {
            return false;
        }

        return true;
    }
</script>

<script>
    document.querySelectorAll('.border').forEach(box => {
        box.addEventListener('click', function() {
            let radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
                radio.dispatchEvent(new Event('change'));
            }
        });
    });
</script>

<script>
    function editProject(projectId) {
        window.location.href = '<?= base_url("edit-project") ?>/' + projectId;
    }
</script>

</html>