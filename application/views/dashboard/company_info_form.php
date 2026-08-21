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

    .save-btn {
        background-color: #CAFFBD;
        ;
        border: none;
        color: #3F892C;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 8px;
        transition: 0.3s;
    }

    .save-btn:hover {
        background-color: #b5eebb;
    }
</style>

<div class="tablecalenderContent show">
    <!--/////////////////////// Setting Page my-profile ///////////////////-->
    <div class="setting-my-profile-container">
        <div class="form-container">
            <?php if ($this->session->flashdata('success')): ?>
                <div class="alert alert-success">
                    <?= $this->session->flashdata('success') ?>
                </div>
                <?php $this->session->set_flashdata('success', ''); ?>
            <?php endif; ?>

            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
                <?php $this->session->set_flashdata('error',''); ?>
            <?php endif; ?>
            
            <form method="POST" action="<?= base_url('update-company-information') ?>" id="updateSettingForm">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="m-0 fw-bold">Company Information</h6>
                    <button type="submit" class="save-btn">Save</button>
                </div>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Company name</label>
                        <input type="text" name="company_name" class="form-control" value="<?= htmlspecialchars($result->company_name ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" value="<?= htmlspecialchars($result->address ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company type</label>
                        <select name="company_type" class="form-control" required>
                            <option value="LLP" <?= ($result->company_type ?? '') == 'LLP' ? 'selected' : '' ?>>LLP</option>
                            <option value="PVT_LTD" <?= ($result->company_type ?? '') == 'PVT_LTD' ? 'selected' : '' ?>>PVT LTD.</option>
                            <option value="Sole_Proprietorship" <?= ($result->company_type ?? '') == 'Sole_Proprietorship' ? 'selected' : '' ?>>Sole Proprietorship</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <select name="city" class="form-control" required>
                            <?php if(!empty($city)): ?>
                                <?php foreach($city as $each): ?>
                                    <option value="<?= $each['city_id'] ?>" <?= ($result->city ?? '') == $each['city_id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($each['city_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No cities available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <select name="state" class="form-control" required>
                            <?php if(!empty($state)): ?>
                                <?php foreach($state as $each): ?>
                                    <option value="<?= $each['id'] ?>" <?= ($result->state ?? '') == $each['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($each['title']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="">No states available</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Pin code</label>
                        <input type="text" name="pincode" class="form-control" value="<?= htmlspecialchars($result->pincode ?? '') ?>" required>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>