<div class="tablecalenderContent show">
    <div class="calender-wrapper">
        <div class="container">
            <div class="row">
                <div class='notification-navbar'>
                    <h2 class='m-0 fs-4'>My Calendar</h2>
                    <div>
                        <a href="<?php echo base_url('dashboard') ?>">
                            <button class='create-project-btn createProjectBtn'><img src="<?php echo base_url('assets/icon-folder/project-icons/Plus.png') ?>" alt="">Create Project</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <hr />
        <div class="container">
            <div class="row align-items-center">
                <form id="editProjectForm" method="POST" action="<?= base_url('update-project') ?>">
                    <input type="hidden" name="project_id" value="<?= $project->project_id ?>">
                    <input type="hidden" name="client_name" value="<?= $project->client_name ?>">

                    <div class="container-fluid">

                        <!-- ==================== PROJECT DETAILS SECTION ==================== -->
                        <div class="card mb-4">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">📋 Project Details</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Exam Name *</label>
                                        <input type="text" name="exam_name" class="form-control" value="<?= htmlspecialchars($project->exam_name) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Exam Category *</label>
                                        <select name="exam_category" class="form-control" required>
                                            <option value="government" <?= ($project->exam_type == 'government') ? 'selected' : '' ?>>Government</option>
                                            <option value="private" <?= ($project->exam_type == 'private') ? 'selected' : '' ?>>Private</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Start Date *</label>
                                        <input type="date" name="start_date" class="form-control" value="<?= date('Y-m-d', strtotime($project->start_date)) ?>" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">End Date *</label>
                                        <input type="date" name="end_date" class="form-control" value="<?= date('Y-m-d', strtotime($project->end_date)) ?>" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Price Per Seat *</label>
                                        <input type="number" name="price_per_seat" class="form-control" value="<?= $project->price_per_seat ?>" required>
                                    </div>
                                </div>

                                <!-- Cities Selection -->
                                <div class="row mb-3 mt-4">
                                    <div class="col-md-12">
                                        <label class="form-label">Select Cities *</label>
                                        <select name="city_id[]" id="citySelect" multiple class="form-control" size="5" required>
                                            <?php
                                            $selectedCityIds = array_column($projectCities, 'exam_city_id');
                                            foreach ($city as $row): ?>
                                                <option value="<?= $row['city_id'] ?>"
                                                    <?= in_array($row['city_id'], $selectedCityIds) ? 'selected' : '' ?>>
                                                    <?= $row['city_name'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                        <small class="text-muted">Hold Ctrl to select multiple cities</small>
                                    </div>
                                </div>

                                <div id="cityBatchContainer">

                                    <?php

                                    foreach ($projectCities as $city):

                                        $cityId = $city->exam_city_id;

                                        $batches = $projectBatchData[$cityId] ?? [];

                                    ?>

                                        <div class="card shadow-sm mb-4 city-card"
                                            data-city="<?= $cityId ?>">

                                            <div class="card-header bg-primary text-white">

                                                <strong>

                                                    <?= $city->exam_city_name ?>

                                                </strong>

                                            </div>

                                            <div class="card-body">

                                                <div class="row">

                                                    <div class="col-md-4">

                                                        <label>Total Seats</label>

                                                        <input
                                                            type="number"
                                                            class="form-control city-total-seat"
                                                            name="city_seats[<?= $cityId ?>]"
                                                            value="<?= $city->number_of_seats ?>"
                                                            required>

                                                    </div>

                                                    <div class="col-md-4">

                                                        <label>No Of Batches</label>

                                                        <select
                                                            class="form-control city-batch-count"
                                                            data-city="<?= $cityId ?>"
                                                            name="city_batch_count[<?= $cityId ?>]">

                                                            <?php

                                                            $selected = count($batches);

                                                            ?>

                                                            <?php for ($i = 1; $i <= 5; $i++): ?>

                                                                <option
                                                                    value="<?= $i ?>"
                                                                    <?= $selected == $i ? 'selected' : '' ?>>

                                                                    <?= $i ?>

                                                                </option>

                                                            <?php endfor; ?>

                                                        </select>

                                                    </div>

                                                </div>

                                                <div class="batch-wrapper mt-4">

                                                    <?php

                                                    foreach ($batches as $batch):

                                                    ?>

                                                        <div class="border rounded p-3 mb-3">

                                                            <h6>

                                                                Batch <?= $batch->batch_no ?>

                                                            </h6>

                                                            <div class="row">

                                                                <div class="col-md-4">

                                                                    <label>Start</label>

                                                                    <input
                                                                        type="time"
                                                                        class="form-control"

                                                                        name="batch[<?= $cityId ?>][<?= $batch->batch_no ?>][start]"

                                                                        value="<?= $batch->batch_start ?>">

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <label>End</label>

                                                                    <input
                                                                        type="time"
                                                                        class="form-control"

                                                                        name="batch[<?= $cityId ?>][<?= $batch->batch_no ?>][end]"

                                                                        value="<?= $batch->batch_end ?>">

                                                                </div>

                                                                <div class="col-md-4">

                                                                    <label>Seat</label>

                                                                    <input
                                                                        type="number"
                                                                        class="form-control batch-seat"

                                                                        name="batch[<?= $cityId ?>][<?= $batch->batch_no ?>][seat]"

                                                                        value="<?= $batch->seat ?>">

                                                                </div>

                                                            </div>

                                                        </div>

                                                    <?php endforeach; ?>

                                                </div>

                                            </div>

                                        </div>

                                    <?php endforeach; ?>

                                </div>
                            </div>
                        </div>

                        <!-- ==================== SOFTWARE & HARDWARE SECTION ==================== -->
                        <div class="card mb-4">
                            <div class="card-header bg-info text-white">
                                <h4 class="mb-0">💻 Software & Hardware Requirements</h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Exam Mode *</label>
                                        <select name="exam_mode" class="form-control" required>
                                            <option value="internet_based" <?= $project->exam_mode == 'internet_based' ? 'selected' : '' ?>>Internet Based</option>
                                            <option value="server_based" <?= $project->exam_mode == 'server_based' ? 'selected' : '' ?>>Server Based</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Internet on each device</label>
                                        <select name="internet_on_each_device" class="form-control">
                                            <option value="1" <?= $project->inet_mode_internet_each == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->inet_mode_internet_each == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <h5 class="mt-4 mb-3">Select Computer Configuration</h5>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Operating System</label>
                                        <select name="operating_system" class="form-control">
                                            <option value="Windows11" <?= $project->inet_mode_os == 'Windows11' ? 'selected' : '' ?>>Windows 11</option>
                                            <option value="Windows10" <?= $project->inet_mode_os == 'Windows10' ? 'selected' : '' ?>>Windows 10</option>
                                            <option value="ubuntu" <?= $project->inet_mode_os == 'ubuntu' ? 'selected' : '' ?>>Ubuntu</option>
                                            <option value="linux" <?= $project->inet_mode_os == 'linux' ? 'selected' : '' ?>>Linux</option>
                                            <option value="mac" <?= $project->inet_mode_os == 'mac' ? 'selected' : '' ?>>Mac</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Select RAM</label>
                                        <select name="ram" class="form-control">
                                            <option value="4" <?= $project->inet_mode_ram == '4' ? 'selected' : '' ?>>4GB</option>
                                            <option value="6" <?= $project->inet_mode_ram == '6' ? 'selected' : '' ?>>6GB</option>
                                            <option value="8" <?= $project->inet_mode_ram == '8' ? 'selected' : '' ?>>8GB</option>
                                            <option value="12" <?= $project->inet_mode_ram == '12' ? 'selected' : '' ?>>12GB</option>
                                            <option value="16" <?= $project->inet_mode_ram == '16' ? 'selected' : '' ?>>16GB</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Display Resolution</label>
                                        <select name="display_resolution" class="form-control">
                                            <option value="800x600" <?= $project->inet_mode_display == '800x600' ? 'selected' : '' ?>>800 × 600</option>
                                            <option value="1024x768" <?= $project->inet_mode_display == '1024x768' ? 'selected' : '' ?>>1024 × 768</option>
                                            <option value="1152x864" <?= $project->inet_mode_display == '1152x864' ? 'selected' : '' ?>>1152 × 864</option>
                                            <option value="1280x720" <?= $project->inet_mode_display == '1280x720' ? 'selected' : '' ?>>1280 × 720</option>
                                            <option value="1366x768" <?= $project->inet_mode_display == '1366x768' ? 'selected' : '' ?>>1366 × 768</option>
                                            <option value="1920x1080" <?= $project->inet_mode_display == '1920x1080' ? 'selected' : '' ?>>1920 × 1080</option>
                                            <option value="2560x1440" <?= $project->inet_mode_display == '2560x1440' ? 'selected' : '' ?>>2560 × 1440</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== AMENITY REQUIREMENTS SECTION ==================== -->
                        <div class="card mb-4">
                            <div class="card-header bg-success text-white">
                                <h4 class="mb-0">🏢 Amenity Requirements</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Parking Facility</label>
                                        <select name="parking" class="form-control">
                                            <option value="1" <?= $project->parking_facility == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->parking_facility == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Security Guard</label>
                                        <select name="security_guard" class="form-control">
                                            <option value="male" <?= $project->security_guard == 'male' ? 'selected' : '' ?>>Male</option>
                                            <option value="female" <?= $project->security_guard == 'female' ? 'selected' : '' ?>>Female</option>
                                            <option value="both" <?= $project->security_guard == 'both' ? 'selected' : '' ?>>Both</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Lockers</label>
                                        <select name="lockers" class="form-control">
                                            <option value="1" <?= $project->locker_facility == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->locker_facility == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Waiting Area</label>
                                        <select name="waiting_area" class="form-control">
                                            <option value="1" <?= $project->waiting_area == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->waiting_area == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Power Backup</label>
                                        <select name="power_backup" class="form-control">
                                            <option value="1" <?= $project->power_backup == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->power_backup == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">PH Handicapped</label>
                                        <select name="ph_handicapped" class="form-control">
                                            <option value="1" <?= $project->ph_handicaped == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->ph_handicaped == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Printer</label>
                                        <select name="printer" class="form-control">
                                            <option value="1" <?= $project->printer == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->printer == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Rough Sheet</label>
                                        <select name="rough_sheet" class="form-control">
                                            <option value="1" <?= $project->rough_sheet == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->rough_sheet == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Partition in Lab</label>
                                        <select name="partition" class="form-control">
                                            <option value="1" <?= $project->partition_in_lab == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->partition_in_lab == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">AC in Lab</label>
                                        <select name="ac_in_lab" class="form-control">
                                            <option value="1" <?= $project->ac_in_lab == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->ac_in_lab == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">CCTV Required</label>
                                        <select name="cctv_required" class="form-control">
                                            <option value="1" <?= $project->cctv_required == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->cctv_required == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">CCTV Recording</label>
                                        <select name="cctv_recording" class="form-control">
                                            <option value="1" <?= $project->cctv_recording == 1 ? 'selected' : '' ?>>Yes</option>
                                            <option value="0" <?= $project->cctv_recording == 0 ? 'selected' : '' ?>>No</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ==================== MANPOWER RATIO SECTION ==================== -->
                        <div class="card mb-4">
                            <div class="card-header bg-warning">
                                <h4 class="mb-0">👥 Manpower / Staff Requirements</h4>
                            </div>
                            <div class="card-body">
                                <?php
                                $inv = explode(':', $project->invigilator_ratio);
                                $sec = explode(':', $project->security_guard_ratio);
                                ?>

                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <h5 class="mb-3">Center Superintendent</h5>
                                            <label class="form-label">No. of Center Superintendent</label>
                                            <input type="number" name="center_suptn_count" id="center_suptn_count" class="form-control" value="<?= $project->center_suptn_count ?>" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <h5 class="mb-3">Technical Person</h5>
                                            <label class="form-label">No. of Technical Person</label>
                                            <input type="number" name="tech_person_count" id="tech_person_count" class="form-control" value="<?= $project->tech_person_count ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <h5 class="mb-3">Invigilator</h5>
                                            <label class="form-label">Ratio (Staff : Students)</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="invigilator_ratio_1" id="invigilator_ratio_1" class="form-control" value="<?= $inv[0] ?>" placeholder="Staff" required>
                                                <span class="input-group-text">:</span>
                                                <input type="number" name="invigilator_ratio_2" id="invigilator_ratio_2" class="form-control" value="<?= $inv[1] ?>" placeholder="Students" required>
                                            </div>
                                            <div class="bg-light p-3 rounded">
                                                <h6>Calculated Staff Count:</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Male</label>
                                                        <input type="number" name="invigilator_male" id="invigilator_male" class="form-control" value="<?= $project->invigilator_male ?>" readonly style="background: #e9ecef;">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Female</label>
                                                        <input type="number" name="invigilator_female" id="invigilator_female" class="form-control" value="<?= $project->invigilator_female ?>" readonly style="background: #e9ecef;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="border rounded p-3">
                                            <h5 class="mb-3">Security Guard</h5>
                                            <label class="form-label">Ratio (Staff : Students)</label>
                                            <div class="input-group mb-3">
                                                <input type="number" name="security_guard_ratio_1" id="security_guard_ratio_1" class="form-control" value="<?= $sec[0] ?>" placeholder="Staff" required>
                                                <span class="input-group-text">:</span>
                                                <input type="number" name="security_guard_ratio_2" id="security_guard_ratio_2" class="form-control" value="<?= $sec[1] ?>" placeholder="Students" required>
                                            </div>
                                            <div class="bg-light p-3 rounded">
                                                <h6>Calculated Staff Count:</h6>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <label class="form-label">Male</label>
                                                        <input type="number" name="security_guard_male" id="security_guard_male" class="form-control" value="<?= $project->security_guard_male ?>" readonly style="background: #e9ecef;">
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Female</label>
                                                        <input type="number" name="security_guard_female" id="security_guard_female" class="form-control" value="<?= $project->security_guard_female ?>" readonly style="background: #e9ecef;">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-5">
                            <button type="submit" class="btn btn-primary btn-lg px-5">💾 Update Project</button>
                            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary btn-lg px-5 ms-3">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#editProjectForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    toastr.success(response.message);
                    setTimeout(function() {
                        window.location.href = '<?= base_url("dashboard") ?>';
                    }, 1000);
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(xhr) {
                alert('Error updating project. Please try again.');
                console.log(xhr.responseText);
            }
        });
    });
</script>