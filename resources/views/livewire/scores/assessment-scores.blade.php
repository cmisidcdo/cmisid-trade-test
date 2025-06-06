<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Assessment Scores </h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
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
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'pending')">
                                            <i class="bi bi-person-check"></i> Pending
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
                        <thead style="border-collapse: collapse;">
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Candidate Name</th>
                                <th style="width: 15%">Date Finished</th>
                                <th style="width: 10%">Time Finished</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 5%">Score</th>
                                <th style="width: 5%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessmentscores as $item)
                            <tr>
                                <td >{{$loop->iteration}}</td>
                                <td >{{ $item->candidate->fullname ?? 'N/A' }}</td>
                                <td >{{ $item->date_finished ?? 'N/A' }}</td>
                                <td >{{ $item->time_finished ?? 'N/A' }}</td>
                                <td >
                                    <span class="badge rounded-pill bg-{{ 
                                        $item->status == 'done' ? 'success' : 
                                        ($item->status == 'ongoing' ? 'primary' : 
                                        ($item->status == 'pending' ? 'secondary' : 'secondary')) 
                                    }}">
                                        {{ucfirst( $item->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td >{{ $item->total_score ?? 'N/A' }}</td>
                                <td >
                                    <button class="btn btn-sm btn-primary me-1" wire:click='readAssessmentScore({{$item->id}})' title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No assessment scores found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                

                <div class="modal fade" id="assessmentScoreModal" tabindex="-1" aria-labelledby="assessmentScoreModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-xl"> 
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-body p-4">
                                <h5 class="text-center mb-4 fw-bold text-dark">(Edit) Assessment Test</h5>
                
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
                                    <thead style="border-collapse: collapse;">
                                        <tr>
                                            <th style="width: 5%">#</th>
                                            <th>Skills Assigned</th>
                                            <th style="width: 15%">Competency Level</th>
                                            <th style="width: 5%">Questions</th>
                                            <th style="width: 15%">Candidate Score</th>
                                            <th style="width: 10%">Final Score</th>
                                            <th style="width: 5%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($assessmentscoreskills as $item)
                                            <tr>
                                                <td >{{$loop->iteration}}</td>
                                                <td >{{ $item->skill->title ?? 'N/A' }}</td>
                                                <td >{{ $item->position_skill->competency_level ?? 'N/A' }}</td>
                                                <td >  
                                                    <button class="btn btn-sm btn-dark me-1" wire:click='readSkillQuestions({{$item->id}})' title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></td>
                                                <td >{{ $item->skill_score ?? 'N/A' }}</td>
                                                <td >{{ $item->assessmentscore->total_score ?? 'N/A' }}</td>
                                                <td >
                                                    @canany(['assessor permission', 'update exam'])
                                                    <button class="btn btn-sm btn-primary me-1" wire:click='readSkillScore({{$item->id}})'title="Edit">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>
                                                    @endcanany
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="9" class="text-center py-4 text-muted">
                                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                                    No assessment scores found
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="modal fade" id="assessmentSkillScoreModal" tabindex="-1" aria-labelledby="assessmentSkillScoreModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-l"> 
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-body p-4">
                                <h5 class="text-center mb-4 fw-bold text-dark">(Edit) Assessment Skill Score</h5>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-dark">Skill Name</label>
                                    <input type="text" class="form-control" value="{{ $skill_name }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-semibold text-dark">Skill Score</label>
                                    <input type="number" min="0" max="100" class="form-control" wire:model.defer="skill_score" placeholder="Enter score">
                                </div>

                                <div class="text-end mt-4">
                                    <button type="button" class="btn btn-primary" wire:click="saveSkillScore">Save</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

               <div class="modal fade" id="assessmentSkillQuestionsModal" tabindex="-1" aria-labelledby="assessmentSkillQuestionsModalLabel" aria-hidden="true" wire:ignore.self>
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg"> 
                        <div class="modal-content" style="border-radius: 12px;">
                            <div class="modal-body p-4" style="max-height: 70vh; overflow-y: auto;">
                                <h5 class="text-center mb-4 fw-bold text-dark">(View) Candidate Assessment Skill Questions</h5>

                                @forelse($selectedSkillQuestions as $questionItem)
                                    @php
                                        $selectedAnswerId = $questionItem->answer;
                                        $isCorrect = $questionItem->is_correct;
                                        $question = $questionItem->assessmentQuestion;
                                    @endphp

                                    <div class="mb-4 p-3 border rounded" style="background-color: #f9f9f9;">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <strong>Question:</strong>
                                            <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                                                {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                            </span>
                                        </div>
                                        <p class="mb-3">{{ $question->question ?? 'N/A' }}</p>

                                        <ul class="list-group">
                                            @foreach($question->choices as $choice)
                                                <li class="list-group-item d-flex justify-content-between align-items-center 
                                                    @if($choice->id == $selectedAnswerId) list-group-item-info @endif">
                                                    <span>
                                                        {{ $choice->choice_text }}
                                                        @if($choice->is_answer)
                                                            <span class="badge bg-success ms-2">Correct Answer</span>
                                                        @endif
                                                        @if($choice->id == $selectedAnswerId)
                                                            <span class="badge bg-primary ms-2">Selected</span>
                                                        @endif
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @empty
                                    <p class="text-muted text-center">No skill questions found for this skill.</p>
                                @endforelse

                            </div>
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

    $wire.on('hide-assessmentScoreModal', () => {
        $('#assessmentScoreModal').modal('hide');
    });

    $wire.on('show-assessmentScoreModal', () => {
        $('#assessmentScoreModal').modal('show');
    });

    $wire.on('show-assessmentSkillScoreModal', () => {
        $('#assessmentSkillScoreModal').modal('show');
    });

    $wire.on('show-assessmentSkillQuestionsModal', () => {
        $('#assessmentSkillQuestionsModal').modal('show');
    });

</script>
@endscript

