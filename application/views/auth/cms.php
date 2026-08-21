<div class="container-lg py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">

        <!-- Logo -->
        <div>
            <img src="<?= base_url('assets/asserts/footer-logo.png') ?>" 
                 alt="BookMyTestCenter" 
                 style="height:50px;">
        </div>

        <!-- Back to Website -->
        <div>
            <a href="https://www.bookmytestcenter.com/" 
               target="_blank" 
               class="btn btn-outline-primary d-flex align-items-center gap-2">

                Back to Website

                <img src="<?= base_url('assets/asserts/Line 204.png') ?>" 
                     alt="arrow" 
                     style="height:12px;">
            </a>
        </div>

    </div>


    <!-- CMS Content -->
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <?php if(!empty($cmsData)) : ?>

                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body">

                        <h1 class="fw-bold mb-4">
                            <?= htmlspecialchars($cmsData->title) ?>
                        </h1>

                        <div class="fs-6 text-muted" style="line-height:1.8;">
                            <?= $cmsData->description ?>
                        </div>

                    </div>

                </div>

            <?php else : ?>

                <div class="alert alert-warning text-center">
                    Page not found.
                </div>

            <?php endif; ?>

        </div>
    </div>

</div>