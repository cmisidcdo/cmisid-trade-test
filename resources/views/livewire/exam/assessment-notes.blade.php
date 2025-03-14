<div>
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-primary text-white text-center">
            <h3 class="fw-bold m-0">Assessment Notes Form</h3>
        </div>
        <div class="card-body">
            <!-- Select Candidate -->
            <div class="mb-4">
                <label for="candidate" class="form-label">Select Candidate</label>
                <div class="input-group">
                    <input type="text" id="candidate" class="form-control" wire:model="candidate">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                </div>
            </div>

            <!-- Assessor Details -->
            <div class="mb-4">
                <h5 class="fw-bold">Assessor Details</h5>
                <div class="row">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" wire:model="name" placeholder="Autofill when candidate is selected">
                    </div>
                    <div class="col-md-6">
                        <label for="date" class="form-label">Date</label>
                        <div class="input-group">
                            <input type="text" id="date" class="form-control" wire:model="date" placeholder="mm/dd/yyyy (autofill; editable)">
                            <span class="input-group-text">
                                <i class="fas fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assessment Notes -->
            <div>
                <h5 class="fw-bold">Assessment Notes</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="observations" class="form-label">Observations</label>
                        <textarea id="observations" class="form-control" wire:model="observations" placeholder="Enter observations..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="areas_for_improvement" class="form-label">Areas for Improvement</label>
                        <textarea id="areas_for_improvement" class="form-control" wire:model="areas_for_improvement" placeholder="Enter areas for improvement..."></textarea>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="strengths" class="form-label">Strengths</label>
                        <textarea id="strengths" class="form-control" wire:model="strengths" placeholder="Enter strengths..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label for="comments" class="form-label">Comments</label>
                        <textarea id="comments" class="form-control" wire:model="comments" placeholder="Enter comments..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
