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

        <div class="module-statistics" id="project-statistics">

            <!-- 1 -->
            <div class="stat-card stat-blue">
                <div class="stat-icon">
                    <i class="ti ti-briefcase"></i>
                </div>

                <div class="stat-content">
                    <span>Total Projects</span>
                    <strong id="total_projects">0</strong>
                </div>

                <div class="stat-footer">
                    All Projects
                </div>
            </div>

            <!-- 2 -->
            <div class="stat-card stat-primary">
                <div class="stat-icon">
                    <i class="ti ti-run"></i>
                </div>

                <div class="stat-content">
                    <span>Running</span>
                    <strong id="running_projects">0</strong>
                </div>

                <div class="stat-footer">
                    Active Projects
                </div>
            </div>

            <!-- 3 -->
            <div class="stat-card stat-info">
                <div class="stat-icon">
                    <i class="ti ti-calendar-event"></i>
                </div>

                <div class="stat-content">
                    <span>Upcoming</span>
                    <strong id="upcoming_projects">0</strong>
                </div>

                <div class="stat-footer">
                    Starting Soon
                </div>
            </div>

            <!-- 4 -->
            <div class="stat-card stat-success">
                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Completed</span>
                    <strong id="completed_projects">0</strong>
                </div>

                <div class="stat-footer">
                    Finished
                </div>
            </div>

            <!-- 5 -->
            <div class="stat-card stat-danger">
                <div class="stat-icon">
                    <i class="ti ti-clock-exclamation"></i>
                </div>

                <div class="stat-content">
                    <span>Postponed</span>
                    <strong id="postponed_projects">0</strong>
                </div>

                <div class="stat-footer">
                    Delayed
                </div>
            </div>

            <!-- 6 -->
            <div class="stat-card stat-purple">
                <div class="stat-icon">
                    <i class="ti ti-users"></i>
                </div>

                <div class="stat-content">
                    <span>Required Seats</span>
                    <strong id="required_seats">0</strong>
                </div>

                <div class="stat-footer">
                    Total Required
                </div>
            </div>

            <!-- 7 -->
            <div class="stat-card stat-cyan">
                <div class="stat-icon">
                    <i class="ti ti-circle-check"></i>
                </div>

                <div class="stat-content">
                    <span>Allocation Complete</span>
                    <strong id="allocated_seats">0</strong>
                </div>

                <div class="stat-footer">
                    Fully Allocated
                </div>
            </div>

            <!-- 8 -->
            <div class="stat-card stat-warning">
                <div class="stat-icon">
                    <i class="ti ti-clock"></i>
                </div>

                <div class="stat-content">
                    <span>Allocation Pending</span>
                    <strong id="pending_allocation">0</strong>
                </div>

                <div class="stat-footer">
                    Pending Allocation
                </div>
            </div>

            <!-- 9 -->
            <div class="stat-card stat-orange">
                <div class="stat-icon">
                    <i class="ti ti-chart-pie"></i>
                </div>

                <div class="stat-content">
                    <span>Allocation Partial</span>
                    <strong id="partial_allocation">0</strong>
                </div>

                <div class="stat-footer">
                    Partially Allocated
                </div>
            </div>

            <!-- 10 -->
            <div class="stat-card stat-lime">
                <div class="stat-icon">
                    <i class="ti ti-user"></i>
                </div>

                <div class="stat-content">
                    <span>Manpower</span>
                    <strong id="total_manpower">0</strong>
                </div>

                <div class="stat-footer">
                    Total Assigned
                </div>
            </div>

        </div>

        <div class="card mb-4">
            <div class="card-body">

                <div class="row">

                    <div class="col-md-3">
                        <input type="text"
                            id="exam_name"
                            class="form-control"
                            placeholder="Exam Name">
                    </div>

                    <div class="col-md-3">
                        <select id="client_id"
                            class="form-select select2">

                            <option value="">
                                All Clients
                            </option>

                            <?php foreach ($clientData as $client) { ?>

                                <option value="<?= $client['id'] ?>">
                                    <?= $client['username'] ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="city_id"
                            class="form-select select2">

                            <option value="">
                                All Cities
                            </option>

                            <?php foreach ($cities as $city) { ?>

                                <option value="<?= $city->city_id ?>">
                                    <?= $city->city_name ?>
                                </option>

                            <?php } ?>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <select id="project_status"
                            class="form-select">

                            <option value="">
                                Project Status
                            </option>

                            <option value="Upcoming">
                                Upcoming
                            </option>

                            <option value="Running">
                                Running
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                        </select>
                    </div>

                </div>

                <br>

                <div class="row">

                    <div class="col-md-3 mb-4">
                        <input type="date"
                            id="from_date"
                            class="form-control">
                    </div>

                    <div class="col-md-3 mb-4">
                        <input type="date"
                            id="to_date"
                            class="form-control">
                    </div>

                    <div class="col-md-3 mb-4">
                        <select id="allocation_status"
                            class="form-select">

                            <option value="">
                                Allocation Status
                            </option>

                            <option value="Pending">
                                Pending
                            </option>

                            <option value="Partial">
                                Partial
                            </option>

                            <option value="Completed">
                                Completed
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3 mb-4">
                        <select id="seat_range"
                            class="form-select">

                            <option value="">
                                Seat Requirement
                            </option>

                            <option value="1-250">
                                1-250
                            </option>

                            <option value="251-500">
                                251-500
                            </option>

                            <option value="501-1000">
                                501-1000
                            </option>

                            <option value="1000+">
                                1000+
                            </option>

                        </select>
                    </div>

                    <div class="col-md-3">
                        <input type="number"
                            id="min_invigilators"
                            class="form-control"
                            placeholder="Min Invigilators">
                    </div>

                    <div class="col-md-3">
                        <input type="number"
                            id="min_tech_staff"
                            class="form-control"
                            placeholder="Min Tech Staff">
                    </div>

                </div>

            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table id="projectTable" class="table table-striped">
                    <thead class="table-primary-custom">
                        <tr>
                            <th>Project</th>
                            <th>Client Info</th>
                            <th>Seat Progress</th>
                            <th>Manpower</th>
                            <th>Exam Date</th>
                            <th>Project Status</th>
                            <th>Allocation Status</th>
                            <th width="15%">Action</th>
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
    function loadPlannerStats() {
        $.ajax({
            url: "<?= base_url('admin/project-planner/stats') ?>",
            type: "POST",

            data: {

                exam_name: $('#exam_name').val(),
                client_id: $('#client_id').val(),
                city_id: $('#city_id').val(),
                from_date: $('#from_date').val(),
                to_date: $('#to_date').val()

            },

            success: function(response) {
                let data = JSON.parse(response);

                $('#total_projects').html(data.total_projects);

                $('#running_projects').html(data.running_projects);

                $('#upcoming_projects').html(data.upcoming_projects);

                $('#completed_projects').html(data.completed_projects);

                $('#postponed_projects').html(data.postponed_projects);

                $('#required_seats').html(
                    Number(data.required_seats)
                    .toLocaleString()
                );

                $('#allocated_seats').html(
                    Number(data.allocated_seats)
                    .toLocaleString()
                );

                $('#pending_allocation').html(
                    data.pending_allocation
                );

                $('#partial_allocation').html(
                    data.partial_allocation
                );

                $('#full_allocation').html(
                    data.full_allocation
                );

                $('#total_invigilators').html(
                    Number(data.total_invigilators || 0).toLocaleString()
                );

                $('#total_tech_staff').html(
                    Number(data.total_tech_staff || 0).toLocaleString()
                );

                $('#total_security_guards').html(
                    Number(data.total_security_guards || 0).toLocaleString()
                );

                $('#total_center_superintendent').html(
                    Number(data.total_center_superintendent || 0).toLocaleString()
                );

                $('#total_manpower').html(
                    Number(data.total_manpower || 0).toLocaleString()
                );
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        const table = $('#projectTable').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            pageLength: 10,
            order: [
                [7, 'desc']
            ],

            ajax: {
                url: "<?= base_url('admin/project-planner/ajax-list') ?>",
                type: "POST",
                data: function(d) {
                    d.exam_name = $('#exam_name').val();
                    d.client_id = $('#client_id').val();
                    d.city_id = $('#city_id').val();
                    d.project_status = $('#project_status').val();
                    d.allocation_status = $('#allocation_status').val();
                    d.seat_range = $('#seat_range').val();
                    d.from_date = $('#from_date').val();
                    d.to_date = $('#to_date').val();
                }
            },

            columns: [

                {
                    data: 'project'
                },

                {
                    data: 'client'
                },

                {
                    data: 'seat_progress'
                },

                {
                    data: 'manpower'
                },

                {
                    data: 'exam_date'
                },

                {
                    data: 'status'
                },

                {
                    data: 'allocation_status'
                },

                {
                    data: 'action'
                }

            ]
        });


        $('#exam_name,#client_id,#city_id,#project_status,#allocation_status,#seat_range,#from_date,#to_date').on('change keyup', function() {

            table.ajax.reload();
            loadPlannerStats();

        });

        loadPlannerStats();
    });
</script>