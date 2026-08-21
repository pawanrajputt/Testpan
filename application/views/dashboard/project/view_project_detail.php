<form>
    <div class="ps-2">
        <h3><strong>Project Basic Details</strong></h3>
        <div class="form-group">
            <label class="form-label">Exam Name</label>
            <input type="text" class="form-control" name="exam_name"
                value="<?= htmlspecialchars($project->exam_name ?? '') ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Exam Date</label>
            <input type="text" class="form-control" name="exam_date"
                value="<?= !empty($project->start_date) ? date('M d, Y', strtotime($project->start_date)) . ' - ' . date('M d, Y', strtotime($project->end_date)) : '' ?>">
        </div>

        <div class="form-group">
            <label class="form-label">Exam Type</label>
            <input type="text" class="form-control" name="exam_type"
                value="<?= htmlspecialchars($project->exam_type ?? '') ?>">
        </div>


        <div class="form-group">

            <label class="form-label fw-bold mt-3">

                City Wise Batch Details

            </label>

            <?php foreach ($projects as $city): ?>

                <div class="card shadow-sm mt-3">

                    <div class="card-header bg-primary text-white">

                        <div class="d-flex justify-content-between">

                            <strong>

                                <?= $city->city_name ?>

                            </strong>

                            <strong>

                                Total Seat :
                                <?= $city->number_of_seats ?>

                            </strong>

                        </div>

                    </div>

                    <div class="card-body p-0">

                        <table class="table table-bordered mb-0">

                            <thead>

                                <tr>

                                    <th width="80">

                                        Batch

                                    </th>

                                    <th>

                                        Timing

                                    </th>

                                    <th width="120">

                                        Seats

                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <?php

                                foreach ($project_batches as $batch):

                                    if ($batch->city_id != $city->exam_city_id) {

                                        continue;
                                    }

                                ?>

                                    <tr>

                                        <td>

                                            Batch <?= $batch->batch_no ?>

                                        </td>

                                        <td>

                                            <?= date('h:i A', strtotime($batch->batch_start)) ?>

                                            -

                                            <?= date('h:i A', strtotime($batch->batch_end)) ?>

                                        </td>

                                        <td>

                                            <strong>

                                                <?= $batch->seat ?>

                                            </strong>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                </div>

            <?php endforeach; ?>

        </div>


        <div class="form-group">
            <label class="form-label mt-3">Exam Price</label>
            <input type="text" class="form-control" name="exam_price"
                value="<?= !empty($project->price_per_seat) ? 'Rs. ' . number_format($project->price_per_seat, 2) . ' / seat' : '' ?>">
        </div>
    </div>

    <div class="ps-2 mt-2">
        <h3 class=""><strong>Software & Hardware requirements</strong></h3>
        <div class="form-group">
            <label class="form-label">Exam mode</label>
            <input type="text" class="form-control" name="exam_mode"
                value="<?= ucwords(str_replace('_', ' ', htmlspecialchars(trim($project->exam_mode ?? '')))) ?>">
        </div>

        <h3 class="my-3">Computer configuration</h3>

        <div class="config-box bg-light p-2">
            <div class="form-group">
                <label class="form-label">Operating System</label>
                <input type="text" class="form-control" name="os"
                    value="<?= htmlspecialchars($project->inet_mode_os ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label">RAM</label>
                <input type="text" class="form-control" name="ram"
                    value="<?= htmlspecialchars($project->inet_mode_ram ?? '') ?>GB">
            </div>

            <div class="form-group">
                <label class="form-label">Display Resolution</label>
                <input type="text" class="form-control" name="display"
                    value="<?= htmlspecialchars($project->inet_mode_display ?? '') ?>">
            </div>

            <div class="form-group">
                <label class="form-label d-block">Internet on each device</label>

                <div class="d-flex justify-content-between">
                    <div class="border w-50 me-2 px-3 py-2 rounded d-flex align-items-center bg-white">
                        <input type="radio"
                            name="internet"
                            value="1"
                            <?= isset($project->inet_mode_internet_each) && $project->inet_mode_internet_each == 1 ? 'checked' : '' ?>>
                        <span class="ms-2">Yes</span>
                    </div>

                    <div class="border w-50 ms-2 px-3 py-2 rounded d-flex align-items-center bg-white">
                        <input type="radio"
                            name="internet"
                            value="0"
                            <?= isset($project->inet_mode_internet_each) && $project->inet_mode_internet_each == 0 ? 'checked' : '' ?>>
                        <span class="ms-2">No</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="ps-2 mt-2">
        <h3><strong>Amenity Requirements</strong></h3>

        <!-- Radio button fields -->
        <?php
        $amenities = [
            'parking' => ['label' => 'Parking facility', 'field' => 'parking_facility'],
            'security' => ['label' => 'Security Guard', 'field' => 'security_guard'],
            'lockers' => ['label' => 'Lockers', 'field' => 'locker_facility'],
            'waiting' => ['label' => 'Waiting area', 'field' => 'waiting_area'],
            'power' => ['label' => 'Power Backup', 'field' => 'power_backup'],
            'ph' => ['label' => 'PH Handicapped', 'field' => 'ph_handicaped'],
            'printer' => ['label' => 'Printer', 'field' => 'printer'],
            'rough' => ['label' => 'Rough sheet', 'field' => 'rough_sheet'],
            'partition' => ['label' => 'Partition', 'field' => 'partition_in_lab'],
            'ac' => ['label' => 'AC in lab', 'field' => 'ac_in_lab'],
            'cctv' => ['label' => 'CCTV required', 'field' => 'cctv_required'],
            'footage' => ['label' => 'Footage required', 'field' => 'cctv_recording']
        ];

        foreach ($amenities as $name => $data):
            $value = $project->{$data['field']} ?? 0;
        ?>
            <div class="form-group">
                <label class="form-label"><?= $data['label'] ?></label>
                <?php
                if ($name === 'security') { ?>
                    <div class="option-container">
                        <label class="option-box">
                            <input type="radio" name="<?= $name ?>" value="1" <?= $value == 'male' ? 'checked' : '' ?>>
                            Yes
                        </label>
                        <label class="option-box">
                            <input type="radio" name="<?= $name ?>" value="0" <?= $value == 'female' ? 'checked' : '' ?>>
                            No
                        </label>
                        <label class="option-box">
                            <input type="radio" name="<?= $name ?>" value="2" <?= $value == 'both' ? 'checked' : '' ?>>
                            Both
                        </label>
                    </div>
                <?php
                } else { ?>
                    <div class="option-container">
                        <label class="option-box">
                            <input type="radio" name="<?= $name ?>" value="1" <?= $value == 1 ? 'checked' : '' ?>>
                            Yes
                        </label>
                        <label class="option-box">
                            <input type="radio" name="<?= $name ?>" value="0" <?= $value == 0 ? 'checked' : '' ?>>
                            No
                        </label>
                        <?php if ($name === 'security'): ?>
                            <label class="option-box">
                                <input type="radio" name="<?= $name ?>" value="2" <?= $value == 2 ? 'checked' : '' ?>>
                                Both
                            </label>
                        <?php endif; ?>
                    </div>
                <?php } ?>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="ps-2 mt-2">
        <h3><strong>Manpower Requirements</strong></h3>

        <!-- Center Superintendent -->
        <div class="title text-start mb-2">Center Superintendent</div>
        <div class="requirement-card d-flex justify-content-between align-items-center mb-2">
            <label class="m-0">No. of Center Superintendent</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($project->center_suptn_count ?? 1) ?>" readonly>
        </div>

        <!-- Technical Person -->
        <div class="title text-start mb-2">IT/Technical Support</div>
        <div class="requirement-card d-flex justify-content-between align-items-center mb-2">
            <label class="m-0">No. of IT/Technical Support</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($project->tech_person_count ?? 1) ?>" readonly>
        </div>

        <!-- Invigilator -->
        <div class="title text-start mb-2">Invigilator Ratio</div>
        <div class="requirement-card d-flex justify-content-between align-items-center mb-2">
            <label class="m-0">Ratio</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($project->invigilator_ratio ?? '') ?>" readonly>
        </div>
        <div class="d-flex gap-3 mb-3">
            <div><label>Male:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($project->invigilator_male ?? '') ?>" readonly>
            </div>
            <div><label>Female:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($project->invigilator_female ?? '') ?>" readonly>
            </div>
        </div>

        <!-- Security Guard -->
        <div class="title text-start mb-2">Security Guard Ratio</div>
        <div class="requirement-card d-flex justify-content-between align-items-center mb-2">
            <label class="m-0">Ratio</label>
            <input type="text" class="form-control" value="<?= htmlspecialchars($project->security_guard_ratio ?? '') ?>" readonly>
        </div>
        <div class="d-flex gap-3 mb-3">
            <div><label>Male:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($project->security_guard_male ?? '') ?>" readonly>
            </div>
            <div><label>Female:</label>
                <input type="text" class="form-control" value="<?= htmlspecialchars($project->security_guard_female ?? '') ?>" readonly>
            </div>
        </div>
    </div>
</form>