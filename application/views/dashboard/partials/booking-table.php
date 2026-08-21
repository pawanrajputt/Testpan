<table class="mytable paginated-table">
    <thead>
        <tr>
            <th scope="col"><input type="checkbox" class='me-2' />Project name
            </th>
            <th scope="col">Creation date</th>
            <th scope="col">Seats</th>
            <th scope="col">Exam date</th>
            <th scope="col">Total City</th>
            <th scope="col">Centers</th>
            <th scope="col">Project Status</th>
            <th scope="col">Negotiation</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($projects) > 0) {
            foreach ($projects as $each) { ?>
                <tr>
                    <th scope="row">
                        <div class="examCenterBtn" onclick="showProjectDetail('<?= $each['project_id'] ?>')">
                            <input type="checkbox" class='me-2' id="<?= $each['project_id'] ?>" />
                            <label for="<?= $each['id'] ?>" class="exam-name"><?= $each['exam_name'] ?></label>
                        </div>
                        <strong>Project ID:</strong> <?= $each['project_id'] ?>
                    </th>
                    <td><?= date('M d, Y', strtotime($each['created_on'])) ?></td>
                    <td><?= $each['total_seats'] ?></td>
                    <td><?= date('M d, Y', strtotime($each['start_date'])) ?> - <?= date('M d, Y', strtotime($each['end_date'])) ?></td>
                    <td><?= $each['total_cities'] ?></td>
                    <td>
                        <?php
                        $sql = "SELECT * FROM tt_send_booking_request WHERE project_id = ? AND exam_center_status = 1";
                        $centerCount = $this->db->query($sql, array($each['project_id']))->num_rows();
                        echo $centerCount;
                        ?>
                    </td>
                    <td>
                        <?php
                        $current_date = date('Y-m-d');
                        $start_date = date('Y-m-d', strtotime($each['start_date']));
                        $end_date = date('Y-m-d', strtotime($each['end_date']));
                        $is_action_column_show = true;

                        if ($current_date < $start_date) {
                            $is_action_column_show = true;
                        ?>
                        <?php
                        } elseif ($current_date >= $start_date && $current_date <= $end_date) {
                            $is_action_column_show = false;
                        ?>
                        <?php
                        } else {
                            $is_action_column_show = false;
                        ?>
                        <?php
                        }
                        $project_status = getProjectStatusBadge($each);
                        $projectRemark = isHaveAnyRemark($each['project_remark']);
                        echo $project_status . ' ' . $projectRemark;
                        ?>

                        <?php
                        // Completed project me badge nahi dikhana
                        if (
                            $each['status'] != 1 &&
                            !empty($each['book_flag']) &&
                            $each['book_flag'] == 1
                        ) { ?>

                            <br>
                            <span class="badge bg-warning text-dark mt-2">
                                Work In Progress
                            </span>

                        <?php } ?>
                    </td>
                    <td>

                        <?php

                        $status = (int)$each['client_negotiation_status'];

                        if ($status == 0) {
                            echo '<span class="badge bg-secondary">
                            No Negotiation
                          </span>';
                        } elseif ($status == 1) {
                            echo '<span class="badge bg-warning">
                            Client Requested
                          </span>
                          <br><br>

                          <button
                              class="btn btn-sm btn-warning openNegotiation"
                              data-project="' . $each['project_id'] . '">
                              Update
                          </button>';
                        } elseif ($status == 2) {
                            echo '<span class="badge bg-info">
                            Admin Counter Offer
                          </span>
                          <br><br>

                          <button
                              class="btn btn-sm btn-primary openNegotiation"
                              data-project="' . $each['project_id'] . '">
                              Update
                          </button>';
                        } elseif ($status == 3) {
                            echo '<span class="badge bg-success">
                            Finalized
                          </span>
                          <br><br>

                          <button
                              class="btn btn-sm btn-success openNegotiation"
                              data-project="' . $each['project_id'] . '">
                              View
                          </button>';
                        } else {
                            echo '<span class="badge bg-danger">
                            Cancelled
                          </span>';
                        }

                        ?>

                    </td>
                    <td>
                        <?php
                        if ($is_action_column_show) { ?>
                            <i class="fa fa-edit link-icon text-primary" onclick="editProject('<?= $each['project_id'] ?>')" style="cursor: pointer; margin-left: 10px;"></i>
                        <?php } ?>

                        <i class="fa fa-eye link-icon" onclick="viewProjectDetail('<?= $each['project_id'] ?>')"></i>

                        <i class="fa fa-trash link-icon text-danger deleteProjectBtn"
                            title="Delete Project"
                            data-project-id="<?= $each['project_id'] ?>"
                            data-project-name="<?= htmlspecialchars($each['exam_name'], ENT_QUOTES) ?>">
                        </i>
                    </td>
                </tr>
        <?php }
        } else {
            echo '<td class"text-center" colspan="9">No Project Found</td>';
        } ?>
    </tbody>
</table>