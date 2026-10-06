<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?=base_url('admin/dashboard')?>">Dashboard</a> /
                        <a href="<?=base_url('admin/subadmins')?>">Subadmin</a> /
                    </span>
                    <?=$page_title?>
                </h4>
            </div>
        </div>

        <div class="card">
            <?= form_open(base_url('admin/subadmin/store')); ?>

            <div class="card-body">

                <div class="row">

                    <!-- Username -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" 
                               name="username" 
                               class="form-control"
                               placeholder="Enter Username"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" 
                               name="email" 
                               class="form-control"
                               placeholder="Enter Email"
                               required>
                    </div>

                    <!-- Mobile -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Mobile Phone</label>
                        <input type="text" 
                               name="mobile_phone" 
                               class="form-control"
                               placeholder="Enter Mobile Number">
                    </div>

                    <!-- Role -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role_id" class="form-select select2" required>
                            <option value="">Select Role</option>
                            <?php foreach($roles as $role): ?>
                                <option value="<?= $role->id ?>">
                                    <?= htmlspecialchars($role->name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Password -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               name="password" 
                               class="form-control"
                               placeholder="Enter Password"
                               required>
                    </div>

                    <!-- Confirm Password -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" 
                               name="confirm_password" 
                               class="form-control"
                               placeholder="Confirm Password"
                               required>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Save Subadmin
                    </button>
                    <a href="<?=base_url('admin/subadmins')?>" 
                       class="btn btn-secondary px-4">
                        Cancel
                    </a>
                </div>

            </div>

            <?= form_close(); ?>
        </div>

    </div>
</div>