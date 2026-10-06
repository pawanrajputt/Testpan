<div class="content-wrapper">

    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="card">
            
            <div class="card-header d-flex justify-content-between">
                <h4 class="mb-0 ">Create Subscription Package</h4>
            </div>

            <div class="card-body">

                <form method="POST" action="<?= base_url('admin/subscription-packages/store') ?>">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Package Name</label>
                            <input type="text" 
                                   name="name" 
                                   class="form-control" 
                                   required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration</label>
                            <input type="number" 
                                   name="duration" 
                                   class="form-control"
                                   min="1"
                                   required>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Duration Type</label>

                            <select name="duration_type" class="form-select" required>
                                <option value="month">Month</option>
                                <option value="year">Year</option>
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Price</label>

                            <input type="number" 
                                   step="0.01"
                                   name="price" 
                                   class="form-control"
                                   required>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">GST %</label>

                            <input type="number" 
                                   step="0.01"
                                   name="gst_percent" 
                                   class="form-control">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="form-label">Package Color</label>

                            <input type="color" 
                                   name="package_color" 
                                   class="form-control form-control-color"
                                   value="#7367F0">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tag Line</label>

                            <input type="text" 
                                   name="tag_line" 
                                   class="form-control"
                                   placeholder="Most Popular">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Free User Limit</label>

                            <input type="number" 
                                   name="free_user_limit" 
                                   class="form-control"
                                   value="0">
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="form-check">

                                <input class="form-check-input"
                                       type="checkbox"
                                       name="is_recommended"
                                       value="1">

                                <label class="form-check-label">
                                    Recommended Package
                                </label>

                            </div>
                        </div>

                        <!-- Max Centers -->

                        <div class="col-md-6 mb-3">

                            <label class="form-label">
                                Total Centers Allowed
                            </label>

                            <input type="number"
                                   name="max_centers"
                                   class="form-control"
                                   value="1"
                                   required>

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
                                   value="0"
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

                                <option value="basic">
                                    Basic Support
                                </option>

                                <option value="priority">
                                    Priority Support
                                </option>

                                <option value="dedicated">
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
                                       value="1">

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
                                      placeholder="Enter one feature per line"
                                      required></textarea>

                            <small class="text-muted">
                                Example:
                                Unlimited Exam Access
                                Priority Support
                                Analytics Dashboard
                            </small>

                        </div>

                        <div class="col-md-12">

                            <button type="submit" class="btn btn-primary">
                                Create Package
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