<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Interview Scores </h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                
                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#criteriaModal">
                                <i class="bi bi-card-list me-1"></i> View Criteria
                            </button>
                        </div>
                
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
                                <button class="btn btn-primary dropdown-toggle" type="button" id="filterDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-funnel"></i> Filter
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'all')">
                                            <i class="bi bi-list"></i> All Status
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'ongoing')">
                                            <i class="bi bi-person-check"></i> Ongoing
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'done')">
                                            <i class="bi bi-person-x"></i> Done
                                        </button>
                                    </li>
                                </ul>
                            </div>
                
                            <div>
                                @if($filterStatus !== 'all')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-funnel"></i> 
                                        {{ $filterStatus }}
                                        <button class="btn btn-sm btn-light border-0 ms-1" wire:click="$set('filterStatus', 'all')">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center global-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 5%">
                                    Note
                                </th>
                                <th>Candidate Name</th>
                                <th style="width: 15%">Date Finished</th>
                                <th style="width: 10%">Time Finished</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 5%">Score</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($oralscores as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" wire:click="readNote({{ $item->id }})">
                                        <i class="bi bi-stickies"></i>
                                    </button>
                                </td>
                                <td>{{ $item->candidate->fullname ?? 'N/A' }}</td>
                                <td>{{ $item->date_finished ?? 'N/A' }}</td>
                                <td>{{ $item->time_finished ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge rounded-pill bg-{{ 
                                        $item->status == 'done' ? 'success' : 
                                        ($item->status == 'ongoing' ? 'primary' : 
                                        ($item->status == 'pending' ? 'secondary' : 'secondary')) 
                                    }}">
                                        {{ ucfirst($item->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>{{ $item->total_score ?? 'N/A' }}</td>
                                <td>
                                    @canany(['assessor permission', 'update exam'])
                                    <button 
                                         class="btn btn-sm me-1 {{ optional($item->assigned_oral)->draft_status === 'draft' ? 'btn-secondary' : 'btn-primary' }}"
                                        wire:click='readOralScore({{$item->id}})' title="Edit"
                                        @if(optional($item->assigned_oral)->draft_status === 'draft') disabled @endif>
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    @endcanany
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No oral exam scores found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                

                <div class="modal fade" id="oralScoreModal" tabindex="-1" aria-labelledby="oralScoreModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-xl"> 
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-body p-4">
                                <h5 class="text-center mb-4 fw-bold text-dark">(Edit) oral Exam</h5>
                
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
                
                                <table class="table table-hover table-bordered text-center global-table">
                                    <thead>
                                        <tr>
                                            <th width="5%">#</th>
                                            <th>Skills Assigned</th>
                                            <th>Competency Level</th>
                                            <th>Questions</th>
                                            <th>Knowledge and Understanding</th>
                                            <th>Completeness and Relevance of Responses</th>
                                            <th>Problem Solving and Troubleshooting</th>
                                            <th>Final Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($oralscoreskills as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $item->skill->title ?? 'N/A' }}</td>
                                                <td>{{ $item->position_skill->competency_level ?? 'N/A' }}</td>
                                                <td>  
                                                    <button class="btn btn-sm btn-dark me-1" wire:click='showQuestions({{$item->id}})' title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></td>
                                                <td>{{ $item->knowledge ?? 'N/A' }}</td>
                                                <td>{{ $item->completeness ?? 'N/A' }}</td>
                                                <td>{{ $item->problem_solving ?? 'N/A' }}</td>
                                                <td>{{ $item->score ?? 'N/A' }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary me-1" wire:click='evaluateSkill({{$item->id}})' title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">
                                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                    No oral interview scores found
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
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Knowledge & Understanding</label>
                                                <input type="number" class="form-control" wire:model="evaluation.knowledge" min="1" max="10">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Completeness & Relevance of Responses</label>
                                                <input type="number" class="form-control" wire:model="evaluation.completeness" min="1" max="10">
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <label class="form-label me-3 mb-0" style="min-width: 180px;">Problem Solving & Troubleshooting</label>
                                                <input type="number" class="form-control" wire:model="evaluation.problem_solving" min="1" max="10">
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

    <div class="modal fade" id="criteriaModal" tabindex="-1" aria-labelledby="criteriaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content ">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title fw-bold text-center" id="criteriaModalLabel">View oral Exam Criteria</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-center align-middle">
                            <thead class="text-white" style="background-color: #0D0D4C;">
                                <tr>
                                    <th>Criteria Name</th>
                                    <th>Description</th>
                                    <th>Percent</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="fw-bold">Knowledge and Understanding</td>
                                    <td>Evaluates the candidate’s grasp of the subject matter, technical knowledge, or job-specific expertise.</td>
                                    <td class="fw-bold">30%</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Completeness and Relevance of Responses</td>
                                    <td>Assess whether the candidate provides comprehensive answers that directly address the interview questions.</td>
                                    <td class="fw-bold">30%</td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Accuracy</td>
                                    <td>Measures the correctness of the candidate’s answers, particularly for technical or factual questions.</td>
                                    <td class="fw-bold">40%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="modal-footer justify-content-start">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-arrow-left"></i> Go Back
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center fw-bold" id="noteModalLabel">View Note</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    @if ($oralscore && $oralscore->oralScoreSkills->isNotEmpty())
                        @foreach ($oralscore->oralScoreSkills as $oralScoreSkill)
                            <div class="mb-4">
                                @php
                                    $positionSkill = $oralScoreSkill->position_skill;
                                    $skillTitle = $positionSkill ? $positionSkill->skill->title : 'N/A';
                                @endphp
    
                                <h6 class="fw-bold">Skill Title: {{ $skillTitle }}</h6>
    
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Recommendation/s</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $oralScoreSkill->recommendation }}</textarea>
                                </div>
    
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Comment/s</label>
                                    <textarea class="form-control" rows="4" readonly>{{ $oralScoreSkill->comment }}</textarea>
                                </div>
                            </div>
                            <hr>
                        @endforeach
                    @else
                        <p>No oral score skills available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="questionModal" tabindex="-1" aria-labelledby="questionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header justify-content-center position-relative">
                    <h5 class="modal-title text-center fw-bold" id="questionModalLabel">View Questions</h5>
                    <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                    @if ($oralscoreskill) 
                        <div class="mb-4">
                            @php
                                $positionSkill = $oralscoreskill->position_skill;
                                $skillTitle = $positionSkill ? $positionSkill->skill->title : 'N/A';
                            @endphp
                
                            <h6 class="fw-bold">Skill Title: {{ $skillTitle }}</h6>
                
                            @if ($oralscoreskill->oralscoreskillQuestions->isNotEmpty())
                                <div class="mt-4">
                                    <h6 class="fw-bold">Questions:</h6>
                                    <table class="table table-bordered global-table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Question</th>
                                                <th>Description</th>
                                                <th style="width: 20%;">Attachment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($oralscoreskill->oralScoreSkillQuestions as $index => $skillQuestion)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $skillQuestion->oral_questions->question ?? 'N/A' }}</td>
                                                    <td>{{ $skillQuestion->oral_questions->description ?? 'No description' }}</td>
                                                    <td>
                                                        @if ($skillQuestion->oral_questions->file_path)
                                                            <a href="{{ Storage::url($skillQuestion->oral_questions->file_path) }}" download class="btn btn-sm btn-secondary ms-2">
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                        @else
                                                            No attachment
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">No questions available for this skill.</p>
                            @endif
                        </div>
                    @else
                        <p>No oral score skills available.</p>
                    @endif
                </div>                
            </div>
        </div>
    </div>
    
    
    
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

    $wire.on('hide-oralScoreModal', () => {
        $('#oralScoreModal').modal('hide');
    });

    $wire.on('show-oralScoreModal', () => {
        $('#oralScoreModal').modal('show');
    });

    $wire.on('hide-noteModal', () => {
        $('#noteModal').modal('hide');
    });

    $wire.on('show-noteModal', () => {
        $('#noteModal').modal('show');
    });

    $wire.on('show-evaluationModal', () => {
        bootstrap.Modal.getInstance(document.getElementById('oralScoreModal')).hide();
        new bootstrap.Modal(document.getElementById('evaluationModal')).show();
    });

    $wire.on('hide-evaluationModal', () => {
        new bootstrap.Modal(document.getElementById('oralScoreModal')).show();
        bootstrap.Modal.getInstance(document.getElementById('evaluationModal')).hide();
    });

    $wire.on('show-questionModal', () => {
        new bootstrap.Modal(document.getElementById('questionModal')).show();
    });

    $wire.on('hide-questionModal', () => {
        bootstrap.Modal.getInstance(document.getElementById('questionModal')).hide();
    });

</script>
@endscript

