<div class="modal-body">
    <p>Client details.</p>
    <!-- Client Details -->
    <div class="Client-detail-box">
        <input type="hidden" name="id" value="<?=$result->id?>">
        <p>
            <label>Client name</label>
            <input type="text" class="form-control mb-2" value="<?=$result->client_name?>" placeholder="..." name="client_name" required>
        </p>
        <p>
            <label for="">Client email</label>
            <input type="email" class="form-control mb-2" value="<?=$result->client_email?>" placeholder="..." name="client_email" required>
        </p>
        <p>
            <label for="">Client Phone number</label>
            <input type="text" class="form-control mb-3" value="<?=$result->client_phone?>" placeholder="..." name="client_phone" required>
        </p>
    </div>
    <!-- Exam Details -->
    <p class="mt-3">Exam details.</p>
    <div class="Client-detail-box">
        <p>
            <label for="">Exam name</label>
            <input type="text" class="form-control mb-2" value="<?=$result->exam_name?>" placeholder="..." name="exam_name" required>
        </p>
        <p>
            <label>Exam type</label>
            <select class="form-select mb-2" name="exam_type" required>
                <option value="online" <?=$result->exam_type == 'online' ? 'selected' : ''?>>Online</option>
                <option value="offline" <?=$result->exam_type == 'offline' ? 'selected' : ''?>>Offline</option>
            </select>
        </p>
        <p>
            <label for="">Exam location</label>
            <input type="text" class="form-control mb-2" value="<?=$result->exam_location?>" placeholder="..." name="exam_location" required>
        </p>
        <p>
            <label for="">Exam Start Date</label>
            <input type="date" id="edit_start_date" class="form-control mb-2" value="<?=$result->start_date?>" name="start_date" required>
        </p>
        <p>
            <label for="">Exam End Date</label>
            <input type="date" id="edit_end_date" class="form-control mb-2" value="<?=$result->end_date?>" name="end_date" required>
        </p>
        <p>
            <label for="">Exam duration (in days)</label>
            <input type="number" id="edit_exam_duration" class="form-control mb-2" value="<?=$result->exam_duration?>" placeholder="Exam duration in days" name="exam_duration" readonly required>
        </p>
        <p>
            <label for="">Exam Batch</label>
            <select name="exam_batch" id="changeBatch" class='w-100 border rounded py-2 px-3' onchange="toggleBatchFields(this.value)">
                <option value="">Select</option>
                <?php for($i=1; $i<=5; $i++): ?>
                    <option value="<?=$i?>" <?=$result->total_batch == $i ? 'selected' : ''?>><?=$i?></option>
                <?php endfor; ?>
            </select>
        </p>
        
        <?php for($i=1; $i<=5; $i++): ?>

        <div class="row align-items-center mt-3 batch-div" id="divexambatch<?=$i?>" style="display: <?=$result->total_batch >= $i ? 'block' : 'none'?>">

            <div class="row">

                <div class="col-12">
                    <strong>Timing for batch <?=$i?></strong>
                </div>

                <div class="col-md-6">
                    <label>Start Time</label>
                    <input type="time"
                           name="batch<?=$i?>_start"
                           class="form-control"
                           value="<?= $result->{'batch'.$i.'_start'} ?>">
                </div>

                <div class="col-md-6">
                    <label>End Time</label>
                    <input type="time"
                           name="batch<?=$i?>_end"
                           class="form-control"
                           value="<?= $result->{'batch'.$i.'_end'} ?>">
                </div>
                
            </div>

        </div>

        <?php endfor; ?>
    </div>
    <!-- Booking Details -->
    <p class="mt-3">Booking details</p>
    <div class="Client-detail-box">
        <p>
            <label for="">Seats booked</label>
            <input type="number" class="form-control mb-2" value="<?=$result->seats_booked?>" placeholder="Seats booked" name="seats_booked" required>
        </p>
        <p>
            <label for="">Labs assigned</label>
            <select class="form-select mb-3" name="labs_assigned">
                <option value="">Select labs</option>
                <?php
                if(count($labs) > 0) {
                    foreach($labs as $lab): 
                        $selected = $result->labs_assigned == $lab['id'] ? 'selected' : '';
                ?>
                    <option value="<?= $lab['id'] ?>" <?=$selected?>><?= $lab['floor_name'] ?> (<?= $lab['no_of_computer'] ?>)</option>
                <?php 
                    endforeach;
                } 
                ?>
            </select>
        </p>
    </div>
</div>

<script>
function toggleBatchFields(selectedBatch) {
    // Hide all batch fields first
    for(let i=1; i<=5; i++) {
        document.getElementById('divexambatch'+i).style.display = 'none';
    }
    
    // Show only the selected number of batches
    for(let i=1; i<=selectedBatch; i++) {
        document.getElementById('divexambatch'+i).style.display = 'block';
    }
}
</script>