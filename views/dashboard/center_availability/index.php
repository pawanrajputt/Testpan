<!-- Content wrapper -->
<div class="content-wrapper">
    <!-- Content -->
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-md-12">
                <h4 class="py-3 mb-4">
                    <span class="text-muted fw-light">
                        <a href="<?= base_url('admin/dashboard') ?>">Dashbaord</a> /
                    </span>
                    <?= $page_title ?>
                </h4>
            </div>
        </div>


        <div class="module-statistics" id="center-statistics">

            <!-- Total Centers -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-building"></i>
                </div>

                <div class="stat-content">
                    <span>Total Centers</span>
                    <strong id="overview-total-centers">
                        <?= $overview['total_centers'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    All Centers
                </div>

            </div>


            <!-- Countries Covered -->
            <div class="stat-card stat-blue">

                <div class="stat-icon">
                    <i class="ti ti-world"></i>
                </div>

                <div class="stat-content">
                    <span>Countries Covered</span>
                    <strong id="overview-countries">
                        <?= $overview['countries'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique Countries
                </div>

            </div>


            <!-- States Covered -->
            <div class="stat-card stat-info">

                <div class="stat-icon">
                    <i class="ti ti-map"></i>
                </div>

                <div class="stat-content">
                    <span>States Covered</span>
                    <strong id="overview-states">
                        <?= $overview['states'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique States
                </div>

            </div>


            <!-- Cities Covered -->
            <div class="stat-card stat-warning">

                <div class="stat-icon">
                    <i class="ti ti-map-pin"></i>
                </div>

                <div class="stat-content">
                    <span>Cities Covered</span>
                    <strong id="overview-cities">
                        <?= $overview['cities'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Unique Cities
                </div>

            </div>


            <!-- Total Systems -->
            <div class="stat-card stat-purple">

                <div class="stat-icon">
                    <i class="ti ti-device-desktop"></i>
                </div>

                <div class="stat-content">
                    <span>Total Systems</span>
                    <strong id="overview-total-systems">
                        <?= number_format($overview['total_no_system'] ?? 0) ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    All Systems
                </div>

            </div>


            <!-- Available Centers -->
            <div class="stat-card stat-success">

                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Available Centers</span>
                    <strong id="overview-available-centers">
                        <?= $overview['available_centers'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Currently Available
                </div>

            </div>


            <!-- Approved Centers -->
            <div class="stat-card stat-primary">

                <div class="stat-icon">
                    <i class="ti ti-shield-check"></i>
                </div>

                <div class="stat-content">
                    <span>Approved Centers</span>
                    <strong id="overview-approved-centers">
                        <?= $overview['approved_centers'] ?? 0 ?>
                    </strong>
                </div>

                <div class="stat-footer">
                    Approved Centers
                </div>

            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3">

                    <div class="col-md-3">
                        <select id="country_id" class="form-control select2 form-select select-country">
                            <option value="">Select Country</option>
                            <?php
                            foreach ($country_data as $each) { ?>
                                <option value="<?= $each['id'] ?>"><?= $each['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="state_id" class="form-select select2 select-state">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="city" class="form-select select2 select-city">
                            <option value="">Select City</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="center_owner" class="form-select select2">
                            <option value="">Center Owner</option>
                            <?php
                            foreach ($owner_data as $each) { ?>
                                <option value="<?= $each['id'] ?>"><?= $each['username'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label>Date From</label>
                        <input type="date" id="date_from" class="form-control flatpickr-date" placeholder="Select From Date">
                    </div>

                    <div class="col-md-3">
                        <label>Date To</label>
                        <input type="date" id="date_to" class="form-control flatpickr-date" placeholder="Select To Date">
                    </div>

                    <div class="col-md-3">
                        <label>Capacity</label>
                        <input type="number" id="capacity" class="form-control">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button id="filterBtn" class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="availabilityTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Center</th>
                            <th>Location</th>
                            <th>Total Systems</th>
                            <th>Status</th>
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
    $(function() {

        var table = $('#availabilityTable').DataTable({
            processing: true,
            serverSide: true,
            searching: true,
            paging: true,
            pageLength: 10,

            ajax: {
                url: "<?= base_url('admin/center-availability/ajaxList') ?>",
                type: "POST",

                data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.capacity = $('#capacity').val();
                    d.country_id = $('#country_id').val();
                    d.state_id = $('#state_id').val();
                    d.city_id = $('#city').val();
                    d.center_owner = $('#center_owner').val();
                },

                dataSrc: function(json) {

                    // Update Overview
                    if (json.overview) {

                        $('#overview-total-centers').text(
                            json.overview.total_centers ?? 0
                        );

                        $('#overview-countries').text(
                            json.overview.countries ?? 0
                        );

                        $('#overview-states').text(
                            json.overview.states ?? 0
                        );

                        $('#overview-cities').text(
                            json.overview.cities ?? 0
                        );

                        $('#overview-total-systems').text(
                            Number(
                                json.overview.total_no_system ?? 0
                            ).toLocaleString()
                        );

                        $('#overview-available-centers').text(
                            json.overview.available_centers ?? 0
                        );

                        $('#overview-approved-centers').text(
                            json.overview.approved_centers ?? 0
                        );
                    }

                    return json.data;
                }
            },

            columns: [{
                    data: 'center_name'
                },
                {
                    data: 'location'
                },
                {
                    data: 'capacity'
                },
                {
                    data: 'status'
                },
                {
                    data: 'action'
                }
            ]
        });

        // Filter Search
        $('#filterBtn').on('click', function() {
            table.ajax.reload();
        });

    });
</script>
<!-- Search -->
<script>
    $(document).ready(function() {

        let searchTimeout = null;

        // DataTable default search box
        $('#availabilityTable_filter input')
            .off()
            .on('keyup', function() {
                let value = this.value;

                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(function() {
                    $('#availabilityTable').DataTable().search(value).draw();
                }, 500);
            });

    });
</script>