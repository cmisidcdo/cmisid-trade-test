<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Interview List </h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary" wire:click="showAddEditModal">
                            <i class="bi bi-plus"></i> Create Schedule
                        </button>
                
                        <div class="d-flex gap-2">
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
                    <table class="table table-hover table-bordered text-center global-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Candidate Name</th>
                                <th style="width: 8%">Access Code</th>
                                <th style="width: 8%">Date</th>
                                <th style="width: 5%">Time</th>
                                <th style="width: 20%">Venue</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 8%">Aging Days</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignedOrals as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{ $item->candidate->fullname ?? 'N/A' }}</td>
                                <td>{{ $item->access_code ?? 'N/A' }}</td>
                                <td>{{ $item->assigned_date ?? 'N/A' }}</td>
                                <td>{{ $item->assigned_time ?? 'N/A' }}</td>
                                <td>{{ $item->venue->name ?? 'N/A' }}, {{ $item->venue->location ?? 'N/A' }}</td>
                                <td>{{ $item->draft_status ?? 'N/A' }}</td>
                                <td>{{ $item->aging_days ?? 'N/A' }}</td>
                                <td>
                                    <button class="btn btn-sm btn-outline-dark me-1" data-bs-toggle="modal" data-bs-target="#viewModal" data-bs-placement="top" title="View">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary me-1" wire:click="edit(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">Edit</span> -->
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="delete(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive">
                                        <i class="bi bi-archive-fill"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">Archive</span> -->
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No assigned Orals found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{ $assignedOrals->links(data: ['scrollTo' => false])}} 
                    </div>     
                </div>
                

                        <div class="modal fade" id="assignedOralModal" tabindex="-1" aria-labelledby="assignedOralModalLabel" aria-hidden="true"  wire:ignore.self>
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content" style="border-radius: 12px;">
                                    <div class="modal-body p-4">
                                        <h5 class="text-center mb-4 fw-bold text-dark">{{$editMode ? 'Update Oral Exam Schedule' : 'Add Schedule for Oral Test'}}</h5>
                                        <form wire:submit.prevent="{{$editMode ? 'updateAssignedOral' : 'createAssignedOral'}}">
                                            <div class="row g-3">
                        
                                                <div class="col-md-6">
                                                    <div class="input-group">
                                                        <input type="text" id="selectedCandidate" class="form-control border-dark rounded-start-3" wire:model="{{$editMode ? 'selected_candidate_name' : 'selectedcandidate.fullname'}}" placeholder="Candidate Name" readonly>
                                                        <button type="button" class="btn btn-outline-primary rounded-end-3 px-3" wire:click='selectCandidates' @if($editMode) disabled @endif>
                                                            Select
                                                        </button>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <select class="form-select border-dark rounded-3" wire:model="draft_status" id="status">
                                                        <option value="draft" selected>Draft</option>
                                                        <option value="published">Publish</option>
                                                    </select>
                                                </div>
                        
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control border-dark rounded-3" wire:model="assigned_date" id="selectDate">
                                                </div>
                        
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control border-dark rounded-3" wire:model="assigned_time" id="selectTime">
                                                </div>
                                                
                                                <div class="col-md-12">
                                                    <label for="venue_id" class="form-label small">Venue</label>
                                                    <select class="form-select border-dark rounded-3" id="venue_id" wire:model="venue_id" required>
                                                        <option value="">Select Venue</option>
                                                        @foreach($venues as $venue)
                                                        <option value="{{ $venue->id }}">{{ $venue->name }}, {{ $venue->location }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('venue_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                        
                                            <hr class="my-4 border-dark">

                                            <div class="d-flex justify-content-between">

                                                <button type="button" class="btn btn-outline-secondary btn-sm d-flex align-items-center px-3" data-bs-dismiss="modal">
                                                    <i class="bi bi-arrow-left me-2"></i> Back
                                                </button>

                                                @if($editMode)
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center px-3" wire:click='updateOralQuestion({{$assignedoralId}})'>
                                                    <i class="bi bi-check-circle me-2"></i> Update Questions
                                                </button>
                                                @endif

                                                <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center px-3">
                                                    <i class="bi bi-check-circle me-2"></i> {{$editMode ? 'Save Changes' : 'Create and Proceed to Questions'}}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="modal fade" id="candidatesModal" tabindex="-1" aria-labelledby="candidatesModalLabel" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content shadow">
                                <div class="modal-header bg-primary text-white py-2">
                                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="candidatesModalLabel">
                                        <i class="bi bi-list-check me-1"></i> Select candidates
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border">
                                                <i class="bi bi-search"></i>
                                            </span>
                                            <input
                                                type="text"
                                                class="form-control"
                                                placeholder="Search candidates..."
                                                wire:model.live="candidateSearch"
                                                aria-label="Search candidates">
                                            <span wire:loading wire:target="candidateSearch" class="input-group-text bg-light border">
                                                <div class="spinner-border spinner-border-sm text-primary" role="status">
                                                    <span class="visually-hidden">Searching...</span>
                                                </div>
                                            </span>
                                        </div>
                                    </div>
            
                                    <div class="table-responsive">
                                        <table class="table table-hover table-bordered text-center global-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="fw-semibold">#</th>
                                                    <th class="fw-semibold">candidate name</th>
                                                    <th class="fw-semibold text-center">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse($candidates as $item)
                                                    <tr>
                                                        <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="fw-medium">{{ $item->fullname }}</td>
                                                        <td class="text-center">
                                                            <button
                                                                class="btn btn-success btn-sm"
                                                                wire:click="addCandidate({{ $item->id }})"
                                                            >
                                                                <i class="bi bi-plus-circle me-1"></i>Add
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center py-4 text-muted">
                                                            <i class="bi bi-info-circle me-1"></i> No candidates available.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                            
                                        </table>
            
                                        <div class="mt-3">
                                            {{ $candidates->links() }}
                                        </div>
                                    </div>
            
                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button
                                            type="button"
                                            class="btn btn-primary"
                                            wire:click="backToPosition">
                                            <i class="bi bi-arrow-left me-1"></i> Back to Oral 
                                        </button>
                                    </div>
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

    $wire.on('hide-assignedOralModal', () => {
        $('#assignedOralModal').modal('hide');
    });

    $wire.on('show-assignedOralModal', () => {
        $('#assignedOralModal').modal('show');
    });

    $wire.on('show-candidatesModal', () => {
        bootstrap.Modal.getInstance(document.getElementById('assignedOralModal')).hide();
        new bootstrap.Modal(document.getElementById('candidatesModal')).show();
    });

    $wire.on('hide-candidatesModal', () => {
        new bootstrap.Modal(document.getElementById('assignedOralModal')).show();
        bootstrap.Modal.getInstance(document.getElementById('candidatesModal')).hide();
    });

</script>
@endscript

