<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Center Data - <?= htmlspecialchars($center->center_name ?? 'N/A') ?></title>
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
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Center Data</h1>
        </div>
        
        <!-- Center Details Section -->
        <div class="section">
            <div class="section-title">Center Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Center Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->center_name ?? 'N/A') ?></div>
                </div>
                 <div class="info-row">
                    <div class="info-label">Center Description:</div>
                    <div class="info-value"><?= htmlspecialchars($center->center_description ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Center Capacity:</div>
                    <div class="info-value"><?= htmlspecialchars($center->capacity ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Postal Address:</div>
                    <div class="info-value"><?= nl2br(htmlspecialchars($center->address ?? 'N/A')) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Center Type:</div>
                    <div class="info-value"><?= ucfirst(htmlspecialchars($center->center_type ?? 'N/A')) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Location (Latitude, Longitude):</div>
                    <div class="info-value"><?= htmlspecialchars($center->address_lat ?? 'N/A') ?>, <?= htmlspecialchars($center->address_long ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Country:</div>
                    <div class="info-value"><?= htmlspecialchars($center->country ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">State:</div>
                    <div class="info-value"><?= htmlspecialchars($center->state ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">City:</div>
                    <div class="info-value"><?= htmlspecialchars($center->city ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Local Area Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->local_area_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Pin Code:</div>
                    <div class="info-value"><?= htmlspecialchars($center->pin_code ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Type of Center:</div>
                    <div class="info-value"><?= htmlspecialchars($center->type_of_center ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nearby Landmark:</div>
                    <div class="info-value"><?= htmlspecialchars($center->landmark ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Lift for Physically Handicapped:</div>
                    <div class="info-value">
                        <span class="<?= ($center->for_ph_candidate ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->for_ph_candidate ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transportation Details -->
        <div class="section">
            <div class="section-title">Transportation Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Nearest Railway Station:</div>
                    <div class="info-value"><?= htmlspecialchars($center->nearest_railway_station ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Distance from Railway Station:</div>
                    <div class="info-value"><?= formatDistance($center->distance_from_station) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nearest Bus Station:</div>
                    <div class="info-value"><?= htmlspecialchars($center->nearest_bus_stop ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Distance from Bus Station:</div>
                    <div class="info-value"><?= formatDistance($center->distance_from_bus_stop) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nearest Metro Station:</div>
                    <div class="info-value"><?= htmlspecialchars($center->nearest_metro_station ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Distance from Metro Station:</div>
                    <div class="info-value"><?= formatDistance($center->distance_from_metro) ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Nearest Airport:</div>
                    <div class="info-value"><?= htmlspecialchars($center->nearest_airport ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Distance from Airport:</div>
                    <div class="info-value"><?= formatDistance($center->distance_from_airport) ?></div>
                </div>
            </div>
        </div>
        
        <!-- Admin Details -->
        <div class="section">
            <div class="section-title">Admin Details</div>
            
            <div class="subsection-title">Owner Information</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Owner Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->owner_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Owner Email:</div>
                    <div class="info-value"><?= htmlspecialchars($center->owner_email ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Owner Mobile:</div>
                    <div class="info-value"><?= htmlspecialchars($center->owner_mobile ?? 'N/A') ?></div>
                </div>
            </div>
            
            <div class="subsection-title">Point of Contact</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">POC Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->poc_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">POC Contact Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->poc_contact_no ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">POC Alternate Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->poc_mobile_alternate ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">POC Email:</div>
                    <div class="info-value"><?= htmlspecialchars($center->poc_email ?? 'N/A') ?></div>
                </div>
            </div>
            
            <div class="subsection-title">Center Superintendent</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">CS Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->cs_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">CS Contact Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->cs_contact_number ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">CS Email:</div>
                    <div class="info-value"><?= htmlspecialchars($center->cs_email ?? 'N/A') ?></div>
                </div>
            </div>
            
            <div class="subsection-title">IT Manager</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">IT Manager Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->am_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">IT Manager Contact:</div>
                    <div class="info-value"><?= htmlspecialchars($center->am_contact_no ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">IT Manager Email:</div>
                    <div class="info-value"><?= htmlspecialchars($center->am_email ?? 'N/A') ?></div>
                </div>
            </div>
            
            <div class="subsection-title">Emergency Contact</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Emergency Contact Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->emergency_contact_no ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Landline Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->landline_number ?? 'N/A') ?></div>
                </div>
            </div>
        </div>
        
        <!-- Infrastructure Details -->
        <div class="section">
            <div class="section-title">Infrastructure Details</div>
            
            <div class="subsection-title">General Lab Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Total Number of Labs:</div>
                    <div class="info-value"><?= htmlspecialchars($center->total_no_lab ?? '0') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Number of Systems:</div>
                    <div class="info-value"><?= htmlspecialchars($center->total_no_system ?? '0') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Connected Through Single Network:</div>
                    <div class="info-value">
                        <span class="<?= ($center->connected_single_network ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->connected_single_network ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Total Networks:</div>
                    <div class="info-value"><?= htmlspecialchars($center->how_many_network ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Partition in Each Lab:</div>
                    <div class="info-value">
                        <span class="<?= ($center->partitaion_each_lab ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->partitaion_each_lab ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">AC in Each Lab:</div>
                    <div class="info-value">
                        <span class="<?= ($center->ac_in_each_lab ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->ac_in_each_lab ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Network Printer Available:</div>
                    <div class="info-value">
                        <span class="<?= ($center->network_printer ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->network_printer ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Projector in Each Lab:</div>
                    <div class="info-value">
                        <span class="<?= ($center->is_there_projector_in_each_lab ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->is_there_projector_in_each_lab ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Sound System in Each Lab:</div>
                    <div class="info-value">
                        <span class="<?= ($center->is_there_sound_sytem_in_each_lab ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->is_there_sound_sytem_in_each_lab ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Fire Extinguishers per Lab:</div>
                    <div class="info-value"><?= htmlspecialchars($center->how_many_fire_extinguisher_in_each_lab ?? '0') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Free Baggage Space:</div>
                    <div class="info-value">
                        <span class="<?= ($center->locker_facility ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->locker_facility ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <div class="info-row">
                    <div class="info-label">Drinking Water Facility:</div>
                    <div class="info-value">
                        <span class="<?= ($center->drinking_water_facility ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->drinking_water_facility ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
            </div>
            
            <div class="subsection-title">Internet & Power Backup</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Primary ISP Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->primary_isp_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Primary ISP Connection Type:</div>
                    <div class="info-value"><?= htmlspecialchars($center->primary_isp_connect_type ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Primary Internet Speed:</div>
                    <div class="info-value"><?= htmlspecialchars($center->primary_isp_speed ?? 'N/A') ?> <?= htmlspecialchars($center->primary_internet_speed_unit ?? '') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Secondary ISP Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->secondary_isp_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Secondary ISP Connection Type:</div>
                    <div class="info-value"><?= htmlspecialchars($center->secondary_isp_connect_type ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Secondary Internet Speed:</div>
                    <div class="info-value"><?= htmlspecialchars($center->secondary_isp_speed ?? 'N/A') ?> <?= htmlspecialchars($center->secondary_internet_speed_unit ?? '') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Generator Available:</div>
                    <div class="info-value">
                        <span class="<?= ($center->is_generator_backup ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->is_generator_backup ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <?php if (($center->is_generator_backup ?? '') == 'yes'): ?>
                <div class="info-row">
                    <div class="info-label">Generator Capacity (KVA):</div>
                    <div class="info-value"><?= htmlspecialchars($center->generator_backup_capacity ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Generator Fuel Tank Capacity:</div>
                    <div class="info-value"><?= htmlspecialchars($center->generator_fuel_tank_capacity ?? 'N/A') ?> Ltr</div>
                </div>
                <?php endif; ?>
                <div class="info-row">
                    <div class="info-label">UPS Backup (KVA):</div>
                    <div class="info-value"><?= htmlspecialchars($center->power_back_ups_kv ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">UPS Backup Time:</div>
                    <div class="info-value"><?= htmlspecialchars($center->ups_backup_time ?? 'N/A') ?> Minutes</div>
                </div>
            </div>
        </div>
        
        <!-- Lab Details Section -->
        <div class="section">
            <div class="section-title">Lab Details</div>
            <?php if (!empty($labs)): ?>
                <?php foreach ($labs as $index => $lab): ?>
                    <div class="lab-card">
                        <div class="lab-header">Lab Number <?= $index + 1 ?></div>
                        <div class="lab-details">
                            <div class="info-grid">
                                <div class="info-row">
                                    <div class="info-label">Floor Number:</div>
                                    <div class="info-value">
                                        <?php 
                                            $floor = $lab['floor_name'] ?? 'N/A';
                                            if ($floor === '0') echo 'Ground';
                                            elseif ($floor === 'basement') echo 'Basement';
                                            else echo htmlspecialchars($floor);
                                        ?>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Total Computers:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['no_of_computer'] ?? '0') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">System Processor:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['window_generation'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Monitor Type:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['monitor_type'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Operating System:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['operating_system'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">RAM:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['ram'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Hard Disk:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['hard_disk'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Ethernet Switch Company:</div>
                                    <div class="info-value">
                                        <?php 
                                            if (($lab['ehternet_swtch_company'] ?? '') == 'other') {
                                                echo htmlspecialchars($lab['ethernet_company_other'] ?? 'N/A');
                                            } else {
                                                echo htmlspecialchars($lab['ehternet_swtch_company'] ?? 'N/A');
                                            }
                                        ?>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Switch Category:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['switch_category'] ?? 'N/A') ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Ethernet Switch Ports:</div>
                                    <div class="info-value"><?= htmlspecialchars($lab['no_of_port_eth_switch'] ?? 'N/A') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="info-value">No lab details available</div>
            <?php endif; ?>
        </div>
        
        <!-- Bank Details -->
        <div class="section">
            <div class="section-title">Bank Details</div>
            <div class="info-grid">
                <div class="info-row">
                    <div class="info-label">Beneficiary Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->beneficiary_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bank Name:</div>
                    <div class="info-value"><?= htmlspecialchars($center->bank_name ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bank Account Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->bank_account_number ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Bank IFSC Code:</div>
                    <div class="info-value"><?= htmlspecialchars($center->bank_ifsc_code ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">PAN Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->pan_no ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">UIDAI Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->uidai_number ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Has GST Number:</div>
                    <div class="info-value">
                        <span class="<?= ($center->has_gst ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->has_gst ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <?php if (($center->has_gst ?? '') == 'yes'): ?>
                <div class="info-row">
                    <div class="info-label">GST Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->gst_no ?? 'N/A') ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">GST State Code:</div>
                    <div class="info-value"><?= htmlspecialchars($center->gst_state_code ?? 'N/A') ?></div>
                </div>
                <?php endif; ?>
                <div class="info-row">
                    <div class="info-label">Has MSME Number:</div>
                    <div class="info-value">
                        <span class="<?= ($center->has_msme ?? '') == 'yes' ? 'status-yes' : 'status-no' ?>">
                            <?= ucfirst(htmlspecialchars($center->has_msme ?? 'N/A')) ?>
                        </span>
                    </div>
                </div>
                <?php if (($center->has_msme ?? '') == 'yes'): ?>
                <div class="info-row">
                    <div class="info-label">MSME Number:</div>
                    <div class="info-value"><?= htmlspecialchars($center->msme_number ?? 'N/A') ?></div>
                </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Footer -->
        <div class="footer">
            <p>This is a system generated report. Generated on <?= date('d-m-Y H:i:s') ?></p>
        </div>
    </div>
</body>
</html>