<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exam Scores </h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex gap-2 ms-auto">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                    placeholder="Search candidates..."
                                    wire:model.live.debounce.300ms="search"
                                    aria-label="Search candidates">
                                <button class="btn btn-outline-secondary border-start-0 bg-light" type="button"
                                    wire:loading.class="d-none" wire:target="search"
                                    wire:click="$set('search', '')">
                                    <i class="bi bi-x"></i>
                                </button>
                                <span wire:loading wire:target="search" class="input-group-text bg-light border-start-0">
                                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                                        <span class="visually-hidden">Searching...</span>
                                    </div>
                                </span>
                            </div>
                
                            <div class="dropdown">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'all')">
                                            <i class="bi bi-list"></i> All candidates
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                            <i class="bi bi-person-check"></i> Active candidates
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                            <i class="bi bi-person-x"></i> Inactive candidates
                                        </button>
                                    </li>
                                </ul>
                            </div>
                
                            <div>
                                @if($filterStatus !== 'all')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-funnel"></i> 
                                        {{ $filterStatus === 'yes' ? 'Active' : 'Inactive' }}
                                        <button class="btn btn-sm btn-outline-light border-0 ms-1" wire:click="$set('filterStatus', 'all')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-hover align-middle border global-table">
                        <thead style="border-collapse: collapse;">
                            <tr>
                                <th scope="col" class="text-center" width="5%">#</th>
                                <th>Candidate Name</th>
                                <th>Date Finished</th>
                                <th>Time Finished</th>
                                <th>Status</th>
                                <th>Score</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid #ccc; border-collapse: collapse;">
                            @forelse($practicalscores as $item)
                            <tr>
                                <td style="border: 1px solid black;">{{$loop->iteration}}</td>
                                <td style="border: 1px solid black;">{{ $item->candidate->fullname ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">{{ $item->date_finished ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">{{ $item->time_finished ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">{{ $item->status ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">{{ $item->total_score ?? 'N/A' }}</td>
                                <td style="border: 1px solid black;">
                                    <button class="btn btn-sm btn-outline-primary me-1" wire:click='readPracticalScore({{$item->id}})' title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No practical exam scores found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                

                <div class="modal fade" id="practicalScoreModal" tabindex="-1" aria-labelledby="practicalScoreModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-xl"> 
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-body p-4">
                                <h5 class="text-center mb-4 fw-bold text-dark">(Edit) Practical Exam</h5>
                
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="candidate" class="form-label fw-semibold fs-6">Candidate</label>
                                        <input type="text" class="form-control form-control-sm" id="candidate" wire:model="candidateName" readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="assessor" class="form-label fw-semibold fs-6">Assessor</label>
                                        <input type="text" class="form-control form-control-sm" id="assessor" wire:model="assessorName" readonly>
                                    </div>
                                </div>
                
                                <div class="row mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold fs-6">Date Finished</label>
                                        <input type="text" class="form-control form-control-sm" wire:model="dateFinished" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold fs-6">Time Finished</label>
                                        <input type="text" class="form-control form-control-sm" wire:model="timeFinished" readonly>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold fs-6">Status</label>
                                        <input type="text" class="form-control form-control-sm" wire:model="status" readonly>
                                    </div>
                                </div>
                
                                <table class="table table-hover align-middle border global-table">
                                    <thead style="border-collapse: collapse;">
                                        <tr>
                                            <th scope="col" class="text-center" width="5%">#</th>
                                            <th>Skills Assigned</th>
                                            <th>Competency Level</th>
                                            <th>Scenarios</th>
                                            <th>Completion</th>
                                            <th>Accuracy</th>
                                            <th>Problem Solving</th>
                                            <th>Efficiency</th>
                                            <th>Final Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody style="border: 1px solid #ccc; border-collapse: collapse;">
                                        @forelse($practicalscoreskills as $item)
                                            <tr>
                                                <td style="border: 1px solid black;">{{$loop->iteration}}</td>
                                                <td style="border: 1px solid black;">{{ $item->skill->title ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">{{ $item->position_skill->competency_level ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">  
                                                    <button class="btn btn-sm btn-outline-dark me-1" data-bs-toggle="modal" data-bs-target="#viewModal" data-bs-placement="top" title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></td>
                                                <td style="border: 1px solid black;">{{ $item->task_completion ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">{{ $item->accuracy ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">{{ $item->problem_solving ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">{{ $item->efficiency ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">{{ $item->score ?? 'N/A' }}</td>
                                                <td style="border: 1px solid black;">
                                                    <button class="btn btn-sm btn-outline-primary me-1" wire:click='evaluateSkill({{$item->id}})' title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">
                                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                    No practical exam scores found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true" wire:ignore.self>>
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="evaluationModalLabel">{{ $skillname }} Score</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form wire:submit.prevent="submitEvaluation">
                                <div class="modal-body">
                                    <div class="row g-4">
                                        <div class="col-md-6 d-flex flex-column gap-3">
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Task Completion</label>
                                                <input type="number" class="form-control" wire:model="evaluation.task_completion" min="1" max="10">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Problem Solving and TroubleShooting</label>
                                                <input type="number" class="form-control" wire:model="evaluation.problem_solving" min="1" max="10">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Accuracy & Precision</label>
                                                <input type="number" class="form-control" wire:model="evaluation.accuracy_precision" min="1" max="10">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Efficiency & Time Management</label>
                                                <input type="number" class="form-control" wire:model="evaluation.efficiency_time" min="1" max="10">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Recommendation</label>
                                                <textarea class="form-control" rows="4" wire:model.live.debounce.500ms="evaluation.recommendation" maxlength="255"></textarea>
                                                <div class="text-end small text-muted">
                                                    <span>{{ strlen($evaluation['recommendation'] ?? '') }}</span> / 255
                                                </div>
                                            </div>
                                            <div>
                                                <label class="form-label">Comment</label>
                                                <textarea class="form-control" rows="4" wire:model.live.debounce.500ms="evaluation.comment" maxlength="255"></textarea>
                                                <div class="text-end small text-muted">
                                                    <span>{{ strlen($evaluation['comment'] ?? '') }}</span> / 255
                                                </div>
                                            </div>
                                        </div>                        
                                    </div>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" wire:click="submitEvaluation">Submit Evaluation</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
               
            </div>
        </div>
    </section>
</div>

@script
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        window.addEventListener('livewire:update', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    });

    $wire.on('hide-practicalScoreModal', () => {
        $('#practicalScoreModal').modal('hide');
    });

    $wire.on('show-practicalScoreModal', () => {
        $('#practicalScoreModal').modal('show');
    });

    $wire.on('show-evaluationModal', () => {
        bootstrap.Modal.getInstance(document.getElementById('practicalScoreModal')).hide();
        new bootstrap.Modal(document.getElementById('evaluationModal')).show();
    });

    $wire.on('hide-evaluationModal', () => {
        new bootstrap.Modal(document.getElementById('practicalScoreModal')).show();
        bootstrap.Modal.getInstance(document.getElementById('evaluationModal')).hide();
    });

</script>
@endscript

