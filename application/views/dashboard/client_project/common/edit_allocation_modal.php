<div class="modal-header">

    <h5>

        Update Batch Allocation

    </h5>

    <button

        class="btn-close"

        data-bs-dismiss="modal">

    </button>

</div>

<div class="modal-body">

    <?php foreach ($batchStatistics as $city) { ?>

        <div class="card mb-3">

            <div class="card-header bg-primary text-white">

                <strong>

                    <?= $city['city_name']; ?>

                </strong>

            </div>

            <div class="card-body p-0">

                <table class="table table-bordered mb-0">

                    <thead>

                        <tr>

                            <th>Batch</th>

                            <th>Required</th>

                            <th>Requested</th>

                            <th>Approved</th>

                            <th width="180">

                                Current Center

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php foreach ($city['batches'] as $batch) { ?>

                            <tr>

                                <td>

                                    Batch <?= $batch['batch_no']; ?>

                                </td>

                                <td>

                                    <input

                                        class="form-control required-seat"

                                        readonly

                                        value="<?= $batch['required_seat']; ?>">

                                </td>

                                <td>

                                    <input

                                        class="form-control"

                                        readonly

                                        value="<?= $batch['requested_seat']; ?>">

                                </td>

                                <td>

                                    <input

                                        class="form-control"

                                        readonly

                                        value="<?= $batch['approved_seat']; ?>">

                                </td>

                                <td>

                                    <?php

                                    $current = 0;

                                    foreach ($allocatedBatch as $a) {

                                        if ($a['batch_no'] == $batch['batch_no']) {

                                            $current = $a['center_seat'];

                                            break;
                                        }
                                    }

                                    ?>

                                    <?php

                                    $current = 0;

                                    foreach ($allocatedBatch as $a) {

                                        if ($a['batch_no'] == $batch['batch_no']) {

                                            $current = $a['center_seat'];

                                            break;
                                        }
                                    }

                                    $otherRequested = max(
                                        0,
                                        $batch['requested_seat'] - $current
                                    );

                                    ?>

                                    <input
                                        type="number"
                                        class="form-control allocation-seat"

                                        name="seat[<?= $batch['batch_no']; ?>]"

                                        value="<?= $current; ?>"

                                        data-required="<?= $batch['required_seat']; ?>"

                                        data-requested="<?= $batch['requested_seat']; ?>"

                                        data-current="<?= $current; ?>"

                                        data-other="<?= $otherRequested; ?>">

                                </td>

                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    <?php } ?>

</div>

<div class="modal-footer">

    <button

        class="btn btn-secondary"

        data-bs-dismiss="modal">

        Close

    </button>

    <button

        class="btn btn-success"

        id="saveAllocation"

        data-request="<?= $request->id ?>">

        Update Allocation

    </button>

</div>