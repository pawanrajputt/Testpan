<div class="content-page">
    <div class="content">

        <div class="container-fluid">

            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Center Logs</h4>
                    </div>
                </div>
            </div>

            <!-- Center Info -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5>
                                Center Name: 
                                <strong><?= $center->center_name ?? '-' ?></strong>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Logs Table -->
            <div class="row mt-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="header-title mb-3">Change History</h4>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="table-primary-custom">
                                        <tr>
                                            <th>#</th>
                                            <th>Field</th>
                                            <th>Old Value</th>
                                            <th>New Value</th>
                                            <th>Changed By</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($logs)) { 
                                            $i = 1;
                                            foreach ($logs as $log) { ?>
                                                <?php 
                                                    $distanceFields = [
                                                        'distance_from_station',
                                                        'distance_from_bus_stop',
                                                        'distance_from_metro',
                                                        'distance_from_airport'
                                                    ];
                                                    ?>

                                                    <tr>
                                                        <td><?= $i++ ?></td>

                                                        <td>
                                                            <span class="badge bg-info">
                                                                <?= ucfirst(str_replace('_', ' ', $log->field_name)) ?>
                                                            </span>
                                                        </td>

                                                        <!-- OLD VALUE -->
                                                        <td>
                                                            <span class="text-danger">
                                                                <?php 
                                                                if (in_array($log->field_name, $distanceFields)) {
                                                                    echo formatDistance($log->old_value);
                                                                } else {
                                                                    echo $log->old_value ?: '-';
                                                                }
                                                                ?>
                                                            </span>
                                                        </td>

                                                        <!-- NEW VALUE -->
                                                        <td>
                                                            <span class="text-success">
                                                                <?php 
                                                                if (in_array($log->field_name, $distanceFields)) {
                                                                    echo formatDistance($log->new_value);
                                                                } else {
                                                                    echo $log->new_value ?: '-';
                                                                }
                                                                ?>
                                                            </span>
                                                             <br>
                                                            <?php if ($log->old_value != $log->new_value) { ?>
                                                                <span class="badge bg-warning">Changed</span>
                                                            <?php } ?>
                                                        </td>

                                                        <td>
                                                            <?= $log->admin_name ?? 'Center User' ?>
                                                        </td>

                                                        <td>
                                                            <?= date('d M Y, h:i A', strtotime($log->changed_on)) ?>
                                                        </td>
                                                    </tr>
                                        <?php } 
                                        } else { ?>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">No logs found</td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</div>
<script>
    $(document).ready(function() {
        $('table').DataTable({
            "order": [[5, "desc"]]
        });
    });
</script>