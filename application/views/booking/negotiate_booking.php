<div class="modal-dialog">
    <div class="modal-content p-4">
        <div class="modal-header border-0">
            <h5 class="modal-title">Please give us a reason for your Negotiate Price</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <label class="fw-bold">Enter your expected price per seat</label>
            <input type="number" class="form-control mt-2"
                   id="negotiate-price"
                   placeholder="Eg: 150">

            <textarea class="form-control mt-3"
                id="negotiate-comment"
                placeholder="Optional comment"></textarea>
        </div>

        <div class="modal-footer border-0">
            <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
            <button class="btn btn-warning submit-negotiate-btn"
                data-project-id="<?=$project_id?>"
                data-center-id="<?=$center_id?>">
                Send Negotiation
            </button>
        </div>
    </div>
</div>