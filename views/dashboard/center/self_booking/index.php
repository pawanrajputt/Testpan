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
                <table id="selfBookingTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Client Info</th>
                            <th>Exam Name</th>
                            <th>Location</th>
                            <th>Exam Date</th>
                            <th>Seats</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>


    </div>
    <!-- / Content -->
</div>
<!-- Content wrapper -->

<script>
$(function(){

    $('#selfBookingTable').DataTable({
        processing: true,
        serverSide: true,
        searching: true,
        paging: true,
        pageLength: 25,
        scrollX: true,
        order: [],

        ajax: {
            url: "<?= base_url('admin/self-booking/ajax-list') ?>",
            type: "POST",
            data: function (d) {
                d.center_id = "<?= $center_id ?>";
            }
        },

        columns: [
            { data: 'client_info' },
            { data: 'exam_info' },
            { data: 'exam_location' },
            { data: 'exam_date' },
            { data: 'seats_booked' },
            { data: 'action', orderable:false }
        ]
    });

});
</script>