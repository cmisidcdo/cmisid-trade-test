<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Candidate Competency </h2>
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
                
                            <div>
                                @if($filterStatus !== 'all')
                                    <span class="badge bg-secondary">
                                        <i class="bi bi-funnel"></i> 
                                        {{ $filterStatus === 'yes' ? 'Active' : 'Inactive' }}
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
                                <th class="text-center" width="5%">#</th>
                                <th>Candidate Name</th>
                                <th class="text-center" width="15%">Assessment Test</th>
                                <th class="text-center" width="15%">Practical Exam</th>
                                <th class="text-center" width="15%">Oral Interview</th>
                                <th class="text-center" width="8%">See Result</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assessmentScores as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $item->assignedassessment->candidate->fullname ?? 'N/A' }}</td>
                                @php
                                    $statusClasses = [
                                        'N/A' => 'bg-danger',
                                        'pending' => 'bg-secondary',
                                        'ongoing' => 'bg-primary',
                                        'done' => 'bg-success',
                                    ];
                                @endphp

                                <td>
                                    <span class="badge rounded-pill {{ $statusClasses[$item->assessmentstatus ?? 'N/A'] }}">
                                        {{ ucfirst($item->assessmentstatus ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $statusClasses[$item->practicalstatus ?? 'N/A'] }}">
                                        {{ ucfirst($item->practicalstatus ?? 'N/A') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{ $statusClasses[$item->oralstatus ?? 'N/A'] }}">
                                        {{ ucfirst($item->oralstatus ?? 'N/A') }}
                                    </span>
                                </td>
                                
                                <td>
                                    <button class="btn btn-sm btn-primary me-1" wire:click='seeResults({{$item->candidate_id}})' title="Edit">
                                        <i class="bi bi-bar-chart"></i>
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
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-center" width="5%">#</th>
                                            <th>Skills Assigned</th>
                                            <th>Competency Level</th>
                                            <th>Questions</th>
                                            <th>Candidate Score</th>
                                            <th>Final Score</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($assessmentscoreskills as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $item->skill->title ?? 'N/A' }}</td>
                                                <td>{{ $item->position_skill->competency_level ?? 'N/A' }}</td>
                                                <td>  
                                                    <button class="btn btn-sm btn-dark me-1" data-bs-toggle="modal" data-bs-target="#viewModal" data-bs-placement="top" title="View">
                                                        <i class="bi bi-eye-fill"></i>
                                                    </button></td>
                                                <td>{{ $item->skill_score ?? 'N/A' }}</td>
                                                <td>{{ $item->assessmentscore->total_score ?? 'N/A' }}</td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary me-1" data-bs-toggle="modal" data-bs-target="#assessmentScoreModal" title="Edit">
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

</script>
@endscript

