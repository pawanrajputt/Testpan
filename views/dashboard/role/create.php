<!-- Content wrapper -->
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?=base_url('admin/dashboard')?>">Dashboard</a> /
                        <a href="<?=base_url('admin/roles')?>">Roles</a> /
                    </span>
                    <?=$page_title?>
                </h4>
            </div>
        </div>

        <div class="card">
            <?= form_open(base_url('admin/role/store')); ?>

            <div class="card-body">

                <!-- Role Name -->
                <div class="mb-4">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control"
                        placeholder="Enter Role Name..." required>
                </div>

                <hr>

                <!-- ================= PERMISSIONS ================= -->
                <h5 class="mb-3">Assign Permissions</h5>

                <!-- Global Select All -->
                <div class="global-select mb-3">
                    <input type="checkbox" class="form-check-input" id="selectAll">
                    <label class="form-check-label fw-bold" for="selectAll">
                        Select All Permissions
                    </label>
                </div>

                <div class="row">

                    <?php
                    // Group permissions by module
                    $grouped = [];
                    foreach ($permissions as $permission) {
                        $module = $permission->module ?? 'General';
                        $grouped[$module][] = $permission;
                    }
                    ?>

                    <?php foreach ($grouped as $module => $module_permissions): ?>

                        <div class="col-md-4 mb-4">
                            <div class="card permission-card">
                                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                    <strong><?= ucfirst($module) ?></strong>

                                    <div class="form-check">
                                        <input type="checkbox"
                                            class="form-check-input module-select"
                                            data-module="<?= md5($module) ?>">
                                        <label class="form-check-label small">
                                            All
                                        </label>
                                    </div>
                                </div>

                                <div class="card-body">

                                    <?php foreach ($module_permissions as $permission): ?>

                                        <div class="form-check mb-2">
                                            <input class="form-check-input permission-checkbox module-<?= md5($module) ?>"
                                                type="checkbox"
                                                name="permissions[]"
                                                value="<?= $permission->id ?>"
                                                id="perm<?= $permission->id ?>">

                                            <label class="form-check-label"
                                                for="perm<?= $permission->id ?>">
                                                <?= $permission->name ?>
                                            </label>
                                        </div>

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>

                <!-- Save Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        Save Role
                    </button>
                </div>

            </div>

            <?= form_close(); ?>
        </div>

    </div>
</div>
<script>
    $(document).ready(function(){

        // Global Select All
        $('#selectAll').on('change', function(){
            $('.permission-checkbox').prop('checked', this.checked);
            $('.module-select').prop('checked', this.checked);
        });

        // Module Select
        $('.module-select').on('change', function(){
            let moduleClass = '.module-' + $(this).data('module');
            $(moduleClass).prop('checked', this.checked);
        });

    });
</script>