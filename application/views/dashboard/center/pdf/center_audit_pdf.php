<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Audit Report - <?= htmlspecialchars($center->center_name ?? 'N/A') ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 10px;
            line-height: 1.4;
            color: #333;
            padding: 20px;
        }
        
        .container {
            max-width: 100%;
            margin: 0 auto;
        }
        
        /* Header Styles */
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }
        
        .header h1 {
            font-size: 20px;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        
        .header h3 {
            font-size: 14px;
            color: #7f8c8d;
        }
        
        /* Section Styles */
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        
        .section-title {
            background-color: #3498db;
            color: white;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        
        .subsection-title {
            background-color: #ecf0f1;
            color: #2c3e50;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: bold;
            margin: 15px 0 10px 0;
            border-left: 3px solid #3498db;
        }
        
        /* Info Grid */
        .info-grid {
            display: table;
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-label {
            display: table-cell;
            padding: 6px 10px;
            font-weight: bold;
            width: 35%;
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .info-value {
            display: table-cell;
            padding: 6px 10px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        /* Two Column Layout */
        .two-column {
            display: table;
            width: 100%;
            border-collapse: collapse;
        }
        
        .column {
            display: table-cell;
            width: 50%;
            padding: 0 5px;
            vertical-align: top;
        }
        
        /* Lab Cards */
        .lab-card {
            border: 1px solid #ddd;
            margin-bottom: 15px;
            page-break-inside: avoid;
        }
        
        .lab-header {
            background-color: #34495e;
            color: white;
            padding: 8px 12px;
            font-weight: bold;
        }
        
        .lab-details {
            padding: 10px;
        }
        
        /* Image Section */
        .image-section {
            margin-top: 15px;
            page-break-inside: avoid;
        }
        
        .image-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
        }
        
        .image-item {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }
        
        .image-item img {
            max-width: 100%;
            height: auto;
            max-height: 150px;
        }
        
        /* Radio/Checkbox Display */
        .radio-value {
            display: inline-block;
            padding: 2px 8px;
            background-color: #ecf0f1;
            border-radius: 3px;
        }
        
        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #7f8c8d;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        
        /* Page Break */
        .page-break {
            page-break-before: always;
        }
        
        /* Status Badge */
        .status-yes {
            color: #27ae60;
            font-weight: bold;
        }
        
        .status-no {
            color: #e74c3c;
            font-weight: bold;
        }

        .section-title {
            background: #3c8dbc;
            color: #fff;
            padding: 6px;
            font-weight: bold;
            margin-top: 10px;
        }

        .audit-table {
            width: 100%;
            border-collapse: collapse;
        }

        .audit-table td {
            border: 1px solid #ccc;
            padding: 6px;
        }

        .text-center { text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Center Audit Report</h1>
        </div>

        <?php if($type == 'audit'): ?>
            <div class="section">
                <div class="section-title">Audit Information</div>

                <div class="field">
                    <span class="label">Invigilator Name:</span>
                    <span class="value">_________________________________________________</span>
                </div>

                <div class="field">
                    <span class="label">Email:</span>
                    <span class="value">_________________________________________________</span>
                </div>

                <div class="field">
                    <span class="label">Contact No:</span>
                    <span class="value">_________________________________________________</span>
                </div>

                <div class="field">
                    <span class="label">Date of Audit:</span>
                    <span class="value">_________________________________________________</span>
                </div>

                <div class="field">
                    <span class="label">In Time:</span>
                    <span class="value">_________________________________________________</span>
                </div>

                <div class="field">
                    <span class="label">Out Time:</span>
                    <span class="value">_________________________________________________</span>
                </div>
            </div>

            <div style="page-break-after:10px;"></div>
        <?php endif; ?>
        
        <?php
           $isAudit = ($type == 'audit');
        ?>

        <?php
            function box() { return '☐'; }
        ?>

        <!-- ================= CENTER DETAILS ================= -->

        <div class="section-title">Center Details</div>

        <?php if($isAudit): ?>
        <table class="audit-table">

        <tr>
            <td width="30%"><strong>Field</strong></td>
            <td width="50%"><strong>Details</strong></td>
            <td width="10%" class="text-center"><strong>Yes</strong></td>
            <td width="10%" class="text-center"><strong>No</strong></td>
        </tr>

        <tr><td>Center Name</td><td><?= $center->center_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Center Description</td><td><?= $center->center_description ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Center Capacity</td><td><?= $center->capacity ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Postal Address</td><td><?= $center->address ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Center Type</td><td><?= $center->center_type ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Location</td><td><?= $center->address_lat ?>, <?= $center->address_long ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Country</td><td><?= $center->country ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>State</td><td><?= $center->state ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>City</td><td><?= $center->city ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Local Area</td><td><?= $center->local_area_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Pin Code</td><td><?= $center->pin_code ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Type of Center</td><td><?= $center->type_of_center ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Landmark</td><td><?= $center->landmark ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Lift for PH</td><td><?= $center->for_ph_candidate ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        </table>

        <?php else: ?>

        <!-- NORMAL VIEW -->
        <div><?= $center->center_name ?></div>

        <?php endif; ?>


        <!-- ================= TRANSPORT ================= -->

        <div class="section-title">Transportation</div>

        <?php if($isAudit): ?>
        <table class="audit-table">

        <tr><td>Railway Station</td><td><?= $center->nearest_railway_station ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Distance Railway</td><td><?= formatDistance($center->distance_from_station) ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Bus Stop</td><td><?= $center->nearest_bus_stop ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Distance Bus</td><td><?= formatDistance($center->distance_from_bus_stop) ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Metro</td><td><?= $center->nearest_metro_station ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Distance Metro</td><td><?= formatDistance($center->distance_from_metro) ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Airport</td><td><?= $center->nearest_airport ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Distance Airport</td><td><?= formatDistance($center->distance_from_airport) ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        </table>
        <?php endif; ?>


        <!-- ================= ADMIN ================= -->

        <div class="section-title">Admin Details</div>

        <?php if($isAudit): ?>
        <table class="audit-table">

        <tr><td>Owner Name</td><td><?= $center->owner_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Owner Email</td><td><?= $center->owner_email ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Owner Mobile</td><td><?= $center->owner_mobile ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        <tr><td>POC Name</td><td><?= $center->poc_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>POC Contact</td><td><?= $center->poc_contact_no ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>POC Email</td><td><?= $center->poc_email ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        <tr><td>CS Name</td><td><?= $center->cs_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>CS Contact</td><td><?= $center->cs_contact_number ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>CS Email</td><td><?= $center->cs_email ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        </table>
        <?php endif; ?>


        <!-- ================= INFRA ================= -->

        <div class="section-title">Infrastructure</div>

        <?php if($isAudit): ?>
        <table class="audit-table">

        <tr><td>Total Labs</td><td><?= $center->total_no_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Total Systems</td><td><?= $center->total_no_system ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Single Network</td><td><?= $center->connected_single_network ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Total Networks</td><td><?= $center->how_many_network ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Partition</td><td><?= $center->partitaion_each_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>AC</td><td><?= $center->ac_in_each_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Printer</td><td><?= $center->network_printer ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Projector</td><td><?= $center->is_there_projector_in_each_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Sound</td><td><?= $center->is_there_sound_sytem_in_each_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Fire Extinguishers</td><td><?= $center->how_many_fire_extinguisher_in_each_lab ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Locker</td><td><?= $center->locker_facility ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Water</td><td><?= $center->drinking_water_facility ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        </table>
        <?php endif; ?>


        <div class="section-title">Lab Details</div>

        <?php if($isAudit): ?>

        <table class="audit-table">

        <tr>
            <td width="30%"><strong>Field</strong></td>
            <td width="50%"><strong>Details</strong></td>
            <td width="10%" class="text-center"><strong>Yes</strong></td>
            <td width="10%" class="text-center"><strong>No</strong></td>
        </tr>

        <?php if (!empty($labs)): ?>
            <?php foreach ($labs as $index => $lab): ?>

                <!-- LAB HEADER -->
                <tr style="background:#eee;">
                    <td colspan="4"><strong>Lab <?= $index + 1 ?></strong></td>
                </tr>

                <tr>
                    <td>Floor Number</td>
                    <td>
                        <?php 
                            $floor = $lab['floor_name'] ?? 'N/A';
                            if ($floor === '0') echo 'Ground';
                            elseif ($floor === 'basement') echo 'Basement';
                            else echo $floor;
                        ?>
                    </td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Total Computers</td>
                    <td><?= $lab['no_of_computer'] ?? '0' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Processor</td>
                    <td><?= $lab['window_generation'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Monitor Type</td>
                    <td><?= $lab['monitor_type'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Operating System</td>
                    <td><?= $lab['operating_system'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>RAM</td>
                    <td><?= $lab['ram'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Hard Disk</td>
                    <td><?= $lab['hard_disk'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Ethernet Switch Company</td>
                    <td>
                        <?php 
                            if (($lab['ehternet_swtch_company'] ?? '') == 'other') {
                                echo $lab['ethernet_company_other'] ?? 'N/A';
                            } else {
                                echo $lab['ehternet_swtch_company'] ?? 'N/A';
                            }
                        ?>
                    </td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Switch Category</td>
                    <td><?= $lab['switch_category'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

                <tr>
                    <td>Ethernet Ports</td>
                    <td><?= $lab['no_of_port_eth_switch'] ?? 'N/A' ?></td>
                    <td><?= box() ?></td>
                    <td><?= box() ?></td>
                </tr>

            <?php endforeach; ?>

        <?php else: ?>

        <tr>
            <td colspan="4">No Lab Data Available</td>
        </tr>

        <?php endif; ?>

        </table>

        <?php else: ?>

        <!-- NORMAL VIEW -->

        <?php if (!empty($labs)): ?>
            <?php foreach ($labs as $index => $lab): ?>

                <div style="margin-bottom:10px;">
                    <strong>Lab <?= $index + 1 ?></strong><br>

                    Floor: <?= $lab['floor_name'] ?><br>
                    Computers: <?= $lab['no_of_computer'] ?><br>
                    Processor: <?= $lab['window_generation'] ?><br>
                    RAM: <?= $lab['ram'] ?><br>
                    HDD: <?= $lab['hard_disk'] ?><br>

                </div>

            <?php endforeach; ?>
        <?php else: ?>
            No Lab Data
        <?php endif; ?>

        <?php endif; ?>


        <!-- ================= BANK ================= -->

        <div class="section-title">Bank Details</div>

        <?php if($isAudit): ?>
        <table class="audit-table">

        <tr><td>Beneficiary</td><td><?= $center->beneficiary_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Bank</td><td><?= $center->bank_name ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>Account</td><td><?= $center->bank_account_number ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>IFSC</td><td><?= $center->bank_ifsc_code ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>PAN</td><td><?= $center->pan_no ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>GST</td><td><?= $center->has_gst ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>
        <tr><td>MSME</td><td><?= $center->has_msme ?></td><td><?= box() ?></td><td><?= box() ?></td></tr>

        </table>
        <?php endif; ?>
        
        <!-- Footer -->
        <div class="footer">
            <p>This is a system generated report. Generated on <?= date('d-m-Y H:i:s') ?></p>
        </div>
    </div>
</body>
</html>