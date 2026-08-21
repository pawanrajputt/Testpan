<div class="row">
  <div class="col-4 aside-bg">
    <a href="#" class="aside-heading">BookMyTestCenter</a>
    <div class="aside-tag-wrapper">
      <div class="aside-tag-cnt tab active">
        <div class="icon-box">
          <img src="<?php echo base_url('assets/icon-folder/aside-icon/icon1-grey.png')?>" alt="user-icon-white" class="user-grey" />
          <img src="<?php echo base_url('assets/icon-folder/aside-icon/Active1-white.png')?>" alt="user-icon-grey" class="user-white" />
        </div>
        <div>
          <h3 class="m-0">Reset/Forgit Mpin</h3>
          <p class="m-0">Enter your phone no.</p>
        </div>
      </div>
    </div>
    <p class="company-year">@2016 | Testpan India Private Limited</p>
  </div>
  <div class="col-8 right-section">
    <div class='need-help-otp-cnt'>
        <div class="needHelpWrapper">
          <a href='/'>Need help?</a>
        </div>
    </div>
    <div class="create-account-cnt px-3">
      <form class="form-cnt section tab-content show">
        <div class="form-heading">
          <div class="commom-header-icon">
            <span class="icon-box-form"><img src="<?php echo base_url('assets/icon-folder/aside-icon/login-page-icon.png')?>" alt="" /></span>
          </div>
          <h1 class="mt-3">Reset/Forgot Mpin</h1>
          <p>Enter your registered phone number</p>
        </div>
        <div class="form-input-cnt mt-2">
          <p>
            <label htmlFor="">Phone number*</label><br />
            <span class="input-icon-flag" style="top: 50%;">
              <img src="<?php echo base_url('assets/icon-folder/aside-icon/user-number-login.png')?>"
                alt="flag" />
            </span>
            <input class="form-control" type="number" name="login_mobile_phone" id="forgot_mpin_mobile_phone"/>
          </p>
        </div>
        <div class="form-footer">
          <button type="button" class="proceed-btn" id="SendOtpForResetMpin" data-form-url="<?php echo base_url('send-reset-forgot-mpin-otp')?>" data-base-url="<?php echo base_url()?>">Send Otp
            <img
              src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png')?>" alt="">
          </button>
          <a href="<?php echo base_url('/')?>">
            <button type="button" class="proceed-btn mt-2">Back To Login
              <img
                src="<?php echo base_url('assets/icon-folder/aside-icon/Arrow 3.png')?>" alt="">
            </button>
          </a>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
$("#SendOtpForResetMpin").click(function () {

    let mobile_phone = $('#forgot_mpin_mobile_phone').val().trim();

    // 🔐 JS Validation
    if (!mobile_phone) {
        toastr.error("Mobile number is required");
        return;
    }

    if (!/^[6-9][0-9]{9}$/.test(mobile_phone)) {
        toastr.error("Enter a valid 10 digit mobile number");
        return;
    }

    let form_url = $(this).data('form-url');
    let base_url = $(this).data('base-url');

    $.ajax({
        url: form_url,
        type: "POST",
        data: { mobile_phone: mobile_phone },
        dataType: "json",
        contentType: "application/x-www-form-urlencoded",
        processData: true,
        success: function (response) {
            if (response.status === "success") {
                toastr.success(response.message);
                setTimeout(function () {
                    window.location.href = base_url + "reset-forgot-mpin-otp";
                }, 1000);
            } else {
                toastr.error(response.message);
            }
        }
    });
});
</script>