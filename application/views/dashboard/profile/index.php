<!-- Content -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <div class="card mb-6">
                <div class="card-body">

                    <form id="profileFormAuthentication" class="mb-4" novalidate>

                        <!-- Username -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Username</label>
                            <input
                                type="text"
                                class="form-control"
                                id="username"
                                name="username"
                                placeholder="Enter your username"
                                required 
                                value="<?=$user['username']?>"/>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                placeholder="Enter your email"
                                required 
                                value="<?=$user['email']?>"/>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>

                        <!-- Mobile Number -->
                        <div class="mb-4">
                            <label for="mobile_phone" class="form-label">Mobile Number</label>
                            <input
                                type="text"
                                class="form-control"
                                id="mobile_phone"
                                name="mobile_phone"
                                placeholder="Enter mobile number"
                                maxlength="10"
                                required 
                                value="<?=$user['mobile_phone']?>"/>
                            <div class="invalid-feedback">
                                Please enter a valid mobile number.
                            </div>
                        </div>

                        <div class="mb-4">
                            <button class="btn btn-primary d-grid w-100" type="submit">
                                Update
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<script>
$('#profileFormAuthentication').on('submit', function (e) {
    e.preventDefault();

    let isValid = true;
    
    const username        = $('#username').val().trim();
    const email        = $('#email').val().trim();
    const mobile       = $('#mobile_phone').val().trim();

    // Regex
    const emailRegex  = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    const mobileRegex = /^[0-9]{10,15}$/;

    // Reset validation
    $('.form-control').removeClass('is-invalid');

    // Email validation
    if (!emailRegex.test(email)) {
        $('#email').addClass('is-invalid');
        isValid = false;
    }

    // Mobile validation (digits only, 10–15 length)
    if (!mobileRegex.test(mobile)) {
        $('#mobile_phone').addClass('is-invalid');
        isValid = false;
    }

    if (!isValid) {
        return false;
    }

    // AJAX submit (valid data only)
    $.ajax({
        url: "<?= base_url('admin/profile-update') ?>",
        type: "POST",
        data: {
            username: username,
            email: email,
            mobile_phone: mobile
        },
        dataType: "json",
        success: function (res) {
            if (res.status) {
                toastr.success(res.message);
            } else {
                toastr.error(res.message);
            }
        }
    });
});
</script>

