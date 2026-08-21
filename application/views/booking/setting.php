<style>
    body {
        background-color: #f9fafa;
        font-family: Arial, sans-serif;
    }
    .profile-card,
    .section-card {
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
    }

    .profile-img {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        object-fit: cover;
    }

    .edit-btn {
        background-color: #f9fafa;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .logout-btn {
        background-color: #f63e3e;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .delete-btn {
        background-color: #fff0f0;
        color: #d93025;
        border: none;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 14px;
    }

    .danger-text {
        color: #d93025;
        font-size: 14px;
        margin-top: 5px;
    }

    .info-label {
        font-size: 13px;
        color: gray;
        margin-bottom: 2px;
    }

    .info-value {
        font-weight: 500;
        font-size: 15px;
    }
</style>
<style>
    .form-container {
        background-color: #fff;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.05);
    }

    .form-label {
        font-weight: 500;
        font-size: 14px;
        margin-bottom: 4px;
        color: #737373;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        font-size: 14px;
        padding: 10px;
        color: #000000;


    }

    .save-btn-setting {
        background: #CAFFBD;
        color: #3F892C;
        border: none;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .save-btn-setting:hover {
        background-color: #b5eebb;
    }

    .edit-icon {
        font-size: 13px;
        cursor: pointer;
    }
</style>
<!-- Profile -->
<div class="container my-4">
    <!-- Profile Section -->
    <div class="profile-card d-flex justify-content-between align-items-center flex-wrap">
        <div class="d-flex align-items-center gap-3">
            <img src="<?php echo base_url($center_data->logo); ?>" class="profile-img" id="profilePreview" alt="Profile">
            <div>
                <h6 class="mb-0 fw-bold"><?=$center_data->center_name?></h6>
                <small><?=$result->username?></small><br>
                <small><?=$center_data->local_area_name?></small>
            </div>
        </div>
        <!-- Hidden file input for logo upload -->
        <input type="file" id="logoUpload" accept="image/*" style="display:none">
        <button class="edit-btn" id="editLogoBtn">✏️ Edit logo</button>
    </div>

    <!-- Account Section -->
    <div class="section-card d-flex justify-content-between align-items-center">
        <h6 class="fw-bold mb-0">Account</h6>
        <a href="<?= site_url('center-logout') ?>">
            <button class="logout-btn">🔒 Log out</button>
        </a>
    </div>

    <!-- Delete Account -->
    <div class="section-card d-flex justify-content-between align-items-center">
        <div>
            <h6 class="fw-bold mb-2">Delete account</h6>
            <p class="danger-text">This action cannot be undone</p>
        </div>
        <div>
            <button class="delete-btn" onclick="deleteAcAccount(<?= $result->id ?>)">🗑️ Delete Account</button>
        </div>
    </div>
</div>

<script>
    // 1. Show update profile form, hide personal info
    let logoFile = null; // store selected file
    const editLogoBtn = document.getElementById('editLogoBtn');
    const logoUpload = document.getElementById('logoUpload');
    const profilePreview = document.getElementById('profilePreview');

    editLogoBtn.addEventListener('click', function () {
        if (editLogoBtn.textContent.includes('Edit')) {
            // open file picker
            logoUpload.click();
        } else {
            // Save logo via AJAX
            if (!logoFile) {
                alert('Please select a logo first.');
                return;
            }

            const formData = new FormData();
            formData.append('logo', logoFile);

            fetch('update-center-logo', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert('Logo updated successfully!');
                    editLogoBtn.textContent = '✏️ Edit logo';
                    logoFile = null;
                } else {
                    alert('Failed to update logo!');
                }
            })
            .catch(err => console.error('Error:', err));
        }
    });

    // Preview after selecting file
    logoUpload.addEventListener('change', function (event) {
        const file = event.target.files[0];
        if (file) {
            logoFile = file;
            const reader = new FileReader();
            reader.onload = function (e) {
                profilePreview.src = e.target.result;
                editLogoBtn.textContent = '💾 Save logo'; // change button text
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('editProfileBtn').addEventListener('click', function () {
        document.getElementById('personalInfoSection').style.display = 'none';
        document.getElementById('updateProfileSection').style.display = 'block';
    });


    // 3. Logout function
    function logoutExamCenter() {

        Swal.fire({
            title: 'Logout?',
            text: 'Are you sure you want to log out?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Logout',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Logging out...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                window.location.href = base_url + "logout";
            }

        });
    }

    // 4. Delete Account function (already provided)
    function deleteAcAccount(ac_id) {

        Swal.fire({
            title: 'Delete Account?',
            text: 'Are you sure you want to delete your account? This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {

            if (result.isConfirmed) {

                Swal.fire({
                    title: 'Deleting...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: base_url + 'delete-account',
                    type: 'POST',
                    data: {
                        center_id: ac_id
                    },
                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Account deleted successfully.',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = base_url + 'center-owner-dashboard';
                        });

                    },
                    error: function() {

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Account deletion failed!'
                        });

                    }
                });

            }

        });
    }
</script>
