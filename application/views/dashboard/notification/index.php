<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                  <span class="text-muted fw-light">
                    <a href="<?=base_url('admin/dashboard')?>">Dashbaord</a> /
                  </span>
                  <?=$page_title?>
                </h4>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="notificationTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Message</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($notificationData)) { 
                            $i = 1;
                            foreach ($notificationData as $row) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $row['title'] ?></td>
                                    <td><?= $row['message'] ?></td>
                                    <td><?= date('d M Y, h:i A', strtotime($row['created_at'])) ?></td>
                                </tr>
                        <?php } } ?>
                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script>
    $(document).ready(function() {
        $('#notificationTable').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ordering: true,
            searching: true,
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ notifications",
                paginate: {
                    previous: "Prev",
                    next: "Next"
                }
            }
        });
    });
</script>