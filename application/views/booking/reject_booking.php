<div class="modal-dialog">
    <div class="modal-content p-4">
        <div class="modal-header border-0">
            <h5 class="modal-title">Please give us a reason for rejection</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p class="text-muted">We use your responses to understand what went wrong from our end, so that we can fix it the next time.</p>
            <p class="fw-bold">Select all that apply</p>
            <div class="form-check">
                <input class="form-check-input rejection-reason" type="checkbox" name="rejection_reasons[]" id="reason1" value="The center was already booked for the same date">
                <label class="form-check-label" for="reason1">
                    The center was already booked for the same date
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input rejection-reason" type="checkbox" name="rejection_reasons[]" id="reason2" value="The required system configuration was not available at the center">
                <label class="form-check-label" for="reason2">
                    The required system configuration was not available at the center
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input rejection-reason" type="checkbox" name="rejection_reasons[]" id="reason3" value="The commercial terms did not match">
                <label class="form-check-label" for="reason3">
                    The commercial terms did not match
                </label>
            </div>

            <div class="form-check">
                <input class="form-check-input rejection-reason" type="checkbox" name="rejection_reasons[]" id="reason4" value="The center was not available">
                <label class="form-check-label" for="reason4">
                    The center was not available
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input rejection-reason" type="checkbox" name="rejection_reasons[]" id="reason5" value="Other reason">
                <label class="form-check-label" for="reason5">Other reason</label>
            </div>
            <textarea class="form-control mt-3 w-100" name="rejection_comment" id="rejection-comment" rows="5" placeholder="Please explain here..." style="display:none;"></textarea>
        </div>
        <div class="modal-footer border-0 d-flex justify-content-between">
            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-dark project-reject-btn" data-project-id="<?= $project_id ?>" data-center-id="<?= $center_id ?>">Submit →</button>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle price negotiation input visibility
        $('#reason1').change(function() {
            if ($(this).is(':checked')) {
                $('#price-negotiate-container').show();
            } else {
                $('#price-negotiate-container').hide();
                $('#price-negotiate-input').val('');
            }
        });

        // Handle other reason checkbox and textarea
        $('#reason5').change(function() {
            if ($(this).is(':checked')) {
                // Uncheck all other checkboxes
                $('.rejection-reason').not(this).prop('checked', false);

                // Hide price negotiation input if it was shown
                $('#price-negotiate-container').hide();
                $('#price-negotiate-input').val('');

                // Show textarea
                $('#rejection-comment').show().focus();
            } else {
                // Hide textarea when "Other reason" is unchecked
                $('#rejection-comment').hide().val('');
            }
        });

        // Handle when any other checkbox is checked (except reason5)
        $('.rejection-reason').not('#reason5').change(function() {
            if ($(this).is(':checked') && $('#reason5').is(':checked')) {
                // If any other checkbox is checked while "Other reason" is checked
                $('#reason5').prop('checked', false);
                $('#rejection-comment').hide().val('');
            }
        });
    });
</script>