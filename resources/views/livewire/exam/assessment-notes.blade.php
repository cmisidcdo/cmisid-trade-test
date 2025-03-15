<div class="container-fluid py-4">
    <div class="card shadow rounded-4 border-0">
        <div class="card-header text-white text-center py-3" style="background-color: #1A1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Assessment Notes Form</h2>
        </div>
        
        <div class="card-body p-4">
            <div class="mb-4">
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label for="candidate" class="form-label fw-semibold">Select Candidate</label>
                    </div>
                    <div class="col-md-9">
                        <div class="input-group">
                            <input type="text" id="candidate" class="form-control form-control-lg rounded-start" wire:model="candidate">
                            <button class="btn btn-outline-secondary rounded-end" type="button">
                                <i class="fas fa-chevron-down"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-4">
                <h5 class="fw-bold border-bottom pb-2 mb-3">Assessor Details</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" id="name" class="form-control" wire:model="name" placeholder="Autofill when candidate is selected">
                    </div>
                    <div class="col-md-6 mb-3">
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

            <div>
                <h5 class="fw-bold border-bottom pb-2 mb-3">Assessment Notes</h5>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="observations" class="form-label fw-semibold">Observations</label>
                    </div>
                    <div class="col-md-9">
                        <textarea id="observations" class="form-control" wire:model="observations" placeholder="Enter observations..." rows="3"></textarea>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="strengths" class="form-label fw-semibold">Strengths</label>
                    </div>
                    <div class="col-md-9">
                        <textarea id="strengths" class="form-control" wire:model="strengths" placeholder="Enter strengths..." rows="3"></textarea>
                    </div>
                </div>
                
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="areas_for_improvement" class="form-label fw-semibold">Areas for Improvement</label>
                    </div>
                    <div class="col-md-9">
                        <textarea id="areas_for_improvement" class="form-control" wire:model="areas_for_improvement" placeholder="Enter areas for improvement..." rows="3"></textarea>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <label for="comments" class="form-label fw-semibold">Comments & Recommendations</label>
                    </div>
                    <div class="col-md-9">
                        <textarea id="comments" class="form-control" wire:model="comments" placeholder="Enter comments and recommendations..." rows="4"></textarea>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Assessor's Signature</label>
                            <input type="text" class="form-control" wire:model="signature">
                        </div>
                    </div>
                    <div class="col-md-6 text-end d-flex align-items-end justify-content-end">
                        <button class="btn btn-primary btn-lg px-4">Submit Assessment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="text-center mt-4">
        <p class="small text-muted">© Copyright CMISID ACMS. All Rights Reserved</p>
        <p class="small text-muted">Designed by BootstrapMade</p>
    </div>
</div>