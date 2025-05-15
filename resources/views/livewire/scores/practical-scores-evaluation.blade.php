<div>
    <style>
        #timerDisplay {
            font-variant-numeric: tabular-nums;
            letter-spacing: 1px;
        }

        .btn[disabled] {
            opacity: 0.6 !important;
        }

        #timer1 {
            font-size: 4rem;
            border-radius: 0.5rem;
            padding: 0.75rem 1.5rem;
            transition: background-color 0.3s ease, color 0.3s ease;
            display: inline-block;
            min-width: 160px;
            text-align: center;
        }

        .timer-normal {
            background-color: #2eff1b;
            color: #000;
        }

        .timer-warning {
            background-color: #fd7e14;
            color: #000;
        }

        .timer-danger {
            background-color: #dc3545;
            color: #fff;
        }

    </style>

    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Evaluation</h2>
    </div>
    
    <section class="practical score evaluation">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="d-flex gap-2 mb-3">
                    <a href="{{ route('scores.practical') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Practical Scores
                    </a>
                </div>

         <div class="card shadow-sm border-0 rounded-4 p-4">
    <h5 class="fw-bold mb-4 text-center">
        <i class="bi bi-clock-history me-2"></i> Practical Exam Timer
    </h5>

   <div class="d-flex justify-content-center mb-3">
        <h1 class="display-4 fw-semibold text-primary" id="timerDisplay">
            @if($status === 'done')
                <span class="px-4 py-2 rounded d-inline-block bg-success text-white">
                    Complete
                </span>
            @else
                <span id="timer1" class="px-4 py-2 rounded d-inline-block">
                    {{ gmdate('H:i:s', $remainingTime) }}
                </span>
            @endif
        </h1>
    </div>


    <div class="d-flex justify-content-center gap-3 mt-4 flex-wrap">
        <button id="startButton" class="btn btn-success px-4 py-2"
            wire:click="startPractical"
            {{ $status !== 'pending' ? 'disabled' : '' }}>
            <i class="bi bi-play-circle-fill me-1"></i> Start
        </button>

        <button id="completeButton" class="btn btn-danger px-4 py-2"
            wire:click="completePractical"
            {{ $status !== 'ongoing' ? 'disabled' : '' }}>
            <i class="bi bi-check-circle-fill me-1"></i> Complete
        </button>
    </div>

</div>



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

                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center global-table">
                        <thead>
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
                        <tbody>
                            @forelse($practicalscoreskills as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $item->skill->title ?? 'N/A' }}</td>
                                                <td>{{ $item->position_skill->competency_level ?? 'N/A' }}</td>
                                                <td>  
                                                    <button class="btn btn-sm btn-dark me-1" wire:click='showScenarios({{$item->id}})' title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></td>
                                                <td>{{ $item->task_completion ?? 'N/A' }}</td>
                                                <td>{{ $item->accuracy ?? 'N/A' }}</td>
                                                <td>{{ $item->problem_solving ?? 'N/A' }}</td>
                                                <td>{{ $item->efficiency ?? 'N/A' }}</td>
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
                                                    No practical exam scores found
                                                </td>
                                            </tr>
                                        @endforelse
                        </tbody>
                    </table>
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

                <div class="modal fade" id="scenarioModal" tabindex="-1" aria-labelledby="scenarioModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header justify-content-center position-relative">
                                <h5 class="modal-title text-center fw-bold" id="scenarioModalLabel">View Scenarios</h5>
                                <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                
                            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                                @if ($practicalscoreskill) 
                                    <div class="mb-4">
                                        @php
                                            $positionSkill = $practicalscoreskill->position_skill;
                                            $skillTitle = $positionSkill ? $positionSkill->skill->title : 'N/A';
                                        @endphp
                            
                                        <h6 class="fw-bold">Skill Title: {{ $skillTitle }}</h6>
                            
                                        @if ($practicalscoreskill->practicalscoreskillScenarios->isNotEmpty())
                                            <div class="mt-4">
                                                <h6 class="fw-bold">Scenarios:</h6>
                                                <table class="table table-bordered global-table">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Scenario</th>
                                                            <th>Description</th>
                                                            <th style="width: 20%;">Attachment</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($practicalscoreskill->practicalScoreSkillScenarios as $index => $skillScenario)
                                                            <tr>
                                                                <td>{{ $index + 1 }}</td>
                                                                <td>{{ $skillScenario->practical_scenarios->scenario ?? 'N/A' }}</td>
                                                                <td>{{ $skillScenario->practical_scenarios->description ?? 'No description' }}</td>
                                                                <td>
                                                                    @if ($skillScenario->practical_scenarios->file_path)
                                                                        <a href="{{ Storage::url($skillScenario->practical_scenarios->file_path) }}" download class="btn btn-sm btn-secondary ms-2">
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
                                            <p class="text-muted">No scenarios available for this skill.</p>
                                        @endif
                                    </div>
                                @else
                                    <p>No practical score skills available.</p>
                                @endif
                            </div>                
                        </div>
                    </div>
                </div>

    </section>
    
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

        let countdownInterval;

    function initializeCountdownTimer(remainingTime) {
        const timerEl = document.getElementById('timer1');

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function updateTimer() {
            if (remainingTime > 0) {
                timerEl.textContent = formatTime(remainingTime);

                timerEl.classList.remove('timer-normal', 'timer-warning', 'timer-danger');

                if (remainingTime <= 60) {
                    timerEl.classList.add('timer-danger');
                } else if (remainingTime <= 300) {
                    timerEl.classList.add('timer-warning');
                } else {
                    timerEl.classList.add('timer-normal');
                }

                remainingTime--;
            } else {
                clearInterval(countdownInterval);
                timerEl.textContent = '00:00:00';

                timerEl.classList.remove('timer-normal', 'timer-warning');
                timerEl.classList.add('timer-danger');
            }
        }


        clearInterval(countdownInterval);
        updateTimer();
        countdownInterval = setInterval(updateTimer, 1000);
    }

    Livewire.on('startCountdown', () => {
        const remainingTime = @json((int) $remainingTime);
        initializeCountdownTimer(remainingTime);
    });


        $wire.on('hide-noteModal', () => {
            $('#noteModal').modal('hide');
        });

        $wire.on('show-noteModal', () => {
            $('#noteModal').modal('show');
        });

        $wire.on('show-evaluationModal', () => {
            new bootstrap.Modal(document.getElementById('evaluationModal')).show();
        });

        $wire.on('hide-evaluationModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('evaluationModal')).hide();
        });

        $wire.on('show-scenarioModal', () => {
            new bootstrap.Modal(document.getElementById('scenarioModal')).show();
        });

        $wire.on('hide-scenarioModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('scenarioModal')).hide();
        });
    </script>
    @endscript
</div>
