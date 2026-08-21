<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="<?=base_url('admin/dashboard')?>">Dashbaord</a> / <a href="<?=base_url('admin/cms')?>">CMS</a> /
                  </span>
                  <?=$page_title?>
                </h4>
            </div>
        </div>

        <div class="card">
            <?= form_open_multipart(base_url('admin/cms/update/'.$result->id)); ?>

            <!-- ================= SITE INFO ================= -->
            <div class="card mb-4">
                <div class="card-body row g-3">

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter Title..." value="<?=$result->title?>" required>
                    </div>

                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="description" name="description" class="form-control" placeholder="Enter Description..." rows="5"><?=$result->description?></textarea>
                    </div>

                </div>
            </div>

            <!-- ================= SAVE ================= -->
            <div class="text-center mb-4">
                <button type="submit" class="btn btn-success px-4">Update</button>
            </div>

            <?= form_close(); ?>
        </div>


    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->