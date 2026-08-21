<!-- //////////// Welcome back M-pin section start ///////////////// -->
<div class="Welcome_back M-Pin_section">
    <div class="px-4 d-flex justify-content-between align-items-center flex-wrap">
        <img src="<?php echo base_url('assets/asserts/BMTC Logo.png') ?>" alt="" class="img-fluid" style="max-width:70px;">
        <a href="https://www.bookmytestcenter.com/" target="_blank"
            class="btn btn-outline-primary rounded-pill px-4 mt-3 mt-md-0">
            Back to Website
            <img src="<?php echo base_url('assets/asserts/Line 204.png') ?>" alt="">
        </a>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-6 m-auto px-0 mt-5">
                <div class="Create_phone_number  d-flex justify-content-center align-items-center ">
                    <div class="form-container">
                        <div class="text-wrapper">
                            <h2 class="mb-4">Reset/Forgot Mpin</h2>
                            <h5>Enter your registered phone number</h5>
                        </div>
                        <div class="form-group mb-3">
                            <input type="number" placeholder="Enter your phone number" class="p-2 w-100 p-10" name="forgot_mpin_mobile_phone" id="forgot_mpin_mobile_phone">
                        </div>
                        <div class="mt-3">
                            <div class="my-3">
                                <button type="button" class="btn w-100 sign-up-btn text-white mt-3" id="SendOtpForResetMpin" data-form-url="<?php echo base_url('send-reset-forgot-mpin-otp') ?>" data-base-url="<?php echo base_url() ?>">
                                    Send Otp
                                    <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                                </button>
                                <a href="<?php echo base_url('/') ?>">
                                    <button type="button" class="btn w-100 sign-up-btn text-white mt-3">
                                        Back To Login
                                        <img src="<?php echo base_url('assets/asserts/Arrow 3.png') ?>" alt="">
                                    </button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- ////////////// Welcome back M-pin section end ///////////////////////-->

<script>
    $("#SendOtpForResetMpin").click(function() {

        let mobile_phone = $('#forgot_mpin_mobile_phone').val();
        let form_url = $(this).data('form-url');
        let base_url = $(this).data('base-url');

        $.ajax({
            url: form_url,
            type: "POST",
            data: {
                mobile_phone: mobile_phone
            },
            dataType: "json",
            contentType: "application/x-www-form-urlencoded",
            processData: true,
            success: function(response) {
                if (response.status === "success") {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = base_url + "reset-forgot-mpin-otp";
                    }, 1000);
                } else {
                    toastr.error(response.message);
                }
            }
        });
    });
</script>