<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">

    <style>
        @page {
            margin: 20px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        h2 {
            text-align: center;
            margin: 0 0 15px 0;
            font-size: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #eeeeee;
            color: #000000;
            border: 1px solid #999999;
            padding: 6px 4px;
            text-align: center;
            font-size: 7px;
        }

        td {
            border: 1px solid #999999;
            padding: 5px 4px;
            font-size: 7px;
            vertical-align: top;
            word-wrap: break-word;
        }

        .text-center {
            text-align: center;
        }

        .no-data {
            text-align: center;
            padding: 15px;
        }
    </style>
</head>

<body>

    <h2>Client List</h2>

    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Company Type</th>
                <th>Website</th>
                <th>Address</th>
                <th>Pincode</th>
                <th>City</th>
                <th>State</th>
                <th>Country</th>
                <th>Coordinator Name</th>
                <th>Coordinator Email</th>
                <th>Coordinator Mobile</th>
                <th>Coordinator Alternate Mobile</th>
                <th>GST State Code</th>
                <th>GST Number</th>
                <th>Bank Name</th>
                <th>Bank Account No</th>
                <th>Bank IFSC Code</th>
                <th>Bank Beneficiary Name</th>
                <th>PAN Number</th>
                <th>Udyam Number</th>
                <th>Agreement Start Date</th>
                <th>Agreement End Date</th>
                <th>Created Date</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>

            <?php if (!empty($clients)) { ?>

                <?php foreach ($clients as $row) { ?>

                    <?php
                    $status = ($row['deleted'] == 0) ? 'Active' : 'Inactive';

                    $agreement_start_date = !empty($row['agreement_start_date'])
                        ? date('d-m-Y', strtotime($row['agreement_start_date']))
                        : '';

                    $agreement_end_date = !empty($row['agreement_end_date'])
                        ? date('d-m-Y', strtotime($row['agreement_end_date']))
                        : '';

                    $created_date = !empty($row['created_on'])
                        ? date('d-m-Y', strtotime($row['created_on']))
                        : '';
                    ?>

                    <tr>

                        <td>
                            <?= htmlspecialchars($row['company_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['company_type'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['website'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['address'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['pincode'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['city_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['state_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['country_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['co_ordinator_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['coordinator_email'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['coordinator_mobile_number'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['coordinator_alternative_number'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['gst_state_code'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['gst_number'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['bank_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['bank_account_no'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['bank_ifsc_code'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['bank_beneficial_name'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['pan_number'] ?? '') ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($row['udyam_number'] ?? '') ?>
                        </td>

                        <td class="text-center">
                            <?= $agreement_start_date ?>
                        </td>

                        <td class="text-center">
                            <?= $agreement_end_date ?>
                        </td>

                        <td class="text-center">
                            <?= $created_date ?>
                        </td>

                        <td class="text-center">
                            <?= $status ?>
                        </td>

                    </tr>

                <?php } ?>

            <?php } else { ?>

                <tr>
                    <td colspan="24" class="no-data">
                        No clients found.
                    </td>
                </tr>

            <?php } ?>

        </tbody>
    </table>

</body>

</html>