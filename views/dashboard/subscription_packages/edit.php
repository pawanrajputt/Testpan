<!-- application/views/dashboard/subscription_packages/edit.php -->

<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">

            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Edit Subscription Package</h4>
            </div>

            <div class="card-body">

                <form method="POST" 
                      action="<?= base_url('admin/subscription-packages/update') ?>">

                    <input type="hidden" 
                           name="id" 
                           value="<?= $result->id ?>">

                    <div class="row">

                        <!-- Package Name -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Package Name
                            </label>

                            <input type="text"
                                   name="name"
                                   class="form-control"
                                   value="<?= $result->name ?>"
                                   required>

                        </div>

                        <!-- Duration -->
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Duration
                            </label>

                            <input type="number"
                                   name="duration"
                                   class="form-control"
                                   min="1"
                                   value="<?= $result->duration ?>"
                                   required>

                        </div>

                        <!-- Duration Type -->
                        <div class="col-md-3 mb-3">

                            <label class="form-label">
                                Duration Type
                            </label>

                            <select name="duration_type"
                                    class="form-select"
                                    required>

                                <option value="month"
                                    <?= ($result->duration_type == 'month') ? 'selected' : '' ?>>
                                    Month
                                </option>

                                <option value="year"
                                    <?= ($result->duration_type == 'year') ? 'selected' : '' ?>>
                                    Year
                                </option>

                            </select>

                        </div>

                        <!-- Price -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Price
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="price"
                                   class="form-control"
                                   value="<?= $result->price ?>"
                                   required>

                        </div>

                        <!-- GST -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                GST %
                            </label>

                            <input type="number"
                                   step="0.01"
                                   name="gst_percent"
                                   class="form-control"
                                   value="<?= $result->gst_percent ?>">

                        </div>

                        <!-- Color -->
                        <div class="col-md-4 mb-3">

                            <label class="form-label">
                                Package Color
                            </label>

                            <input type="color"
                                   name="package_color"
                                   class="form-control form-control-color"
                                   value="<?= $result->package_color ?>">

                        </div>

                        <!-- Tag Line -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Tag Line
                            </label>

                            <input type="text"
                                   name="tag_line"
                                   class="form-control"
                                   placeholder="Most Popular"
                                   value="<?= $result->tag_line ?>">

                        </div>

                        <!-- Free User Limit -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Free User Limit
                            </label>

                            <input type="number"
                                   name="free_user_limit"
                                   class="form-control"
                                   value="<?= $result->free_user_limit ?>">

                        </div>

                        <!-- Recommended -->
                        <div class="col-md-6 mb-3">

                            <div class="form-check mt-4">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_recommended"
                                       value="1"
                                       <?= ($result->is_recommended == 1) ? 'checked' : '' ?>>

                                <label class="form-check-label">
                                    Recommended Package
                                </label>

                            </div>

                        </div>

                        <!-- Status -->
                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Status
                            </label>

                            <select name="status"
                                    class="form-select">

                                <option value="1"
                                    <?= ($result->status == 1) ? 'selected' : '' ?>>
                                    Active
                                </option>

                                <option value="0"
                                    <?= ($result->status == 0) ? 'selected' : '' ?>>
                                    Inactive
                                </option>

                            </select>

                        </div>


                        <!-- Max Centers -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Total Centers Allowed
                            </label>

                            <input type="number"
                                   name="max_centers"
                                   class="form-control"
                                   value="<?= $result->max_centers ?>"
                                   required >

                            <small class="text-muted">
                                Use -1 for Unlimited
                            </small>

                        </div>



                        <!-- Max Bookings -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Total Bookings Allowed
                            </label>

                            <input type="number"
                                   name="max_bookings"
                                   class="form-control"
                                   value="<?= $result->max_bookings ?>"
                                   required>

                            <small class="text-muted">
                                Use -1 for Unlimited
                            </small>

                        </div>



                        <!-- Support Type -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Support Type
                            </label>

                            <select name="support_type"
                                    class="form-select">

                                <option <?= ($result->support_type == 'basic') ? 'selected' : '' ?> value="basic">
                                    Basic Support
                                </option>

                                <option <?= ($result->support_type == 'priority') ? 'selected' : '' ?> value="priority">
                                    Priority Support
                                </option>

                                <option <?= ($result->support_type == 'dedicated') ? 'selected' : '' ?> value="dedicated">
                                    Dedicated Manager
                                </option>

                            </select>

                        </div>



                        <!-- Verified Badge -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label d-block">
                                Verified Badge
                            </label>

                            <div class="form-check mt-2">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="verified_badge"
                                       value="1" <?= ($result->verified_badge == 1) ? 'checked' : '' ?>>

                                <label class="form-check-label">
                                    Allow Verified Badge
                                </label>

                            </div>

                        </div>

                        <div class="col-md-12 mb-3">

                            <label class="form-label">
                                Package Features
                            </label>

                            <textarea name="key_points"
                                      class="form-control"
                                      rows="6"
                                      required><?= $result->key_points ?></textarea>

                        </div>

                        <!-- Buttons -->
                        <div class="col-md-12">

                            <button type="submit"
                                    class="btn btn-primary">
                                Update Package
                            </button>

                            <a href="<?= base_url('admin/subscription-packages') ?>"
                               class="btn btn-secondary">
                                Back
                            </a>

                        </div>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>