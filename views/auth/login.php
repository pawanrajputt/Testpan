<!-- Content -->
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner py-6">
      <!-- Login -->
      <div class="card">
        <div class="card-body">
            <!-- Logo -->
            <div class="app-brand justify-content-center mb-6">
                <a href="#" class="app-brand-link">
                    <img
                        src="<?=$settings['admin_url'].'uploads/settings/' . ($settings['header_logo'] ?? 'default-logo.png') ?>"
                        alt="Logo"
                        class="img-thumbnail">
                </a>
            </div>
            <!-- /Logo -->
            <h4 class="mb-1">Welcome Back!</h4>
            <p class="text-center">Please sign in to continue.</p>
            <form id="loginFormAuthentication" class="mb-4">
                <div class="mb-6">
                  <label for="email" class="form-label">Email</label>
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    autofocus />
                </div>
                <div class="mb-6 form-password-toggle">
                  <label class="form-label" for="password">Password</label>
                  <div class="input-group input-group-merge">
                    <input
                      type="password"
                      id="password"
                      class="form-control"
                      name="password"
                      placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                      aria-describedby="password" />
                    <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                  </div>
                </div>
                <div class="mb-6">
                  <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                </div>
            </form>
            <div class="text-center mt-3">
                <?php
                    $links = [];

                    foreach($cmsData as $row){
                        $links[] = '<a href="'.base_url('cms/'.$row['slug']).'" target="_blank">'.$row['title'].'</a>';
                    }

                    echo implode(' | ', $links);
                ?>
            </div>
        </div>
      </div>
      <!-- /Register -->
    </div>
  </div>
</div>
<!-- / Content -->
<script>
    $('#loginFormAuthentication').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "<?= base_url('do-login') ?>",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            beforeSend: function () {
                $('button[type=submit]').prop('disabled', true).text('Logging in...');
            },
            success: function (res) {
                if (res.status) {
                    window.location.href = res.redirect_url;
                } else {
                    toastr.error(res.message);
                }
            },
            complete: function () {
                $('button[type=submit]').prop('disabled', false).text('Login');
            }
        });
    });
</script>
