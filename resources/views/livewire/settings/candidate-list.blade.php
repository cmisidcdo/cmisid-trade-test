<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Candidate List</h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary" wire:click="showAddEditModal">
                            <i class="bi bi-plus"></i> Add Candidate
                        </button>
                
                        <div class="d-flex gap-2">
                            <div class="input-group">
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
                                            <i class="bi bi-list"></i> All Candidates
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                            <i class="bi bi-person-check"></i> Active Candidates
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                            <i class="bi bi-person-x"></i> Inactive Candidates
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
                    <table class="table table-hover align-middle table-bordered global-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center" width="5%">#</th>
                                <th scope="col">Full Name</th>
                                <th scope="col" width="15%">Office Applied</th>
                                <th scope="col" width="15%">Position Applied</th>
                                <th scope="col" width="10%">Priority Group</th>
                                <th scope="col" class="text-center" width="5%">Status</th>
                                <th scope="col" class="text-center" width="5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidates as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                <td>{{ $item->first_name }} {{ $item->middle_initial ? $item->middle_initial . '.' : '' }} {{ $item->family_name }} {{ $item->extension }}</td>
                                <td>{{$item->office->title}}</td>
                                <td>{{$item->position->title}}</td>
                                <td>{{$item->prioritygroup->title}}</td>
                                <td>
                                    <span class="badge rounded-3 {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                      {{$item->deleted_at == Null ? 'Active' : 'Inactive'}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Candidate actions">
                                        <button class="btn btn-icon btn-info me-1" 
                                            wire:click='viewCandidate({{ $item->id }})'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @can('update candidate')
                                            @php
                                                $isUsed = $item->assignedAssessments->isNotEmpty() || $item->assignedPracticals->isNotEmpty() || $item->assignedOrals->isNotEmpty();
                                            @endphp
                                            <button class="btn btn-icon me-1 {{ $isUsed ? 'btn-secondary' : 'btn-primary' }}"
                                                wire:click='readCandidate({{$item->id}})'
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Edit"
                                                @if($isUsed) disabled @endif>
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No candidates found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div>
                    {{$candidates->links(data: ['scrollTo' => false])}}
                </div>

                <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
                    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                <i class="bi bi-check-circle me-2"></i>
                                <span id="successMessage">Operation completed successfully!</span>
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                   
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewModalLabel">Candidate Details</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-3">
                        <table class="table table-sm table-borderless mb-0">
                            <tr>
                                <th width="35%">Full Name:</th>
                                <td>{{ $candidate?->fullname }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $candidate?->email }}</td>
                            </tr>
                            <tr>
                                <th>Contact No:</th>
                                <td>{{ $candidate?->contactno }}</td>
                            </tr>
                            <tr>
                                <th>Position Applied:</th>
                                <td>{{ $candidate?->position?->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Office Applied:</th>
                                <td>{{ $candidate?->office?->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Priority Group:</th>
                                <td>{{ $candidate?->priorityGroup?->title ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Endorsement Date:</th>
                                <td>{{ $candidate?->endorsement_date }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="status-indicator {{$candidate?->deleted_at == Null ? 'status-active': 'status-inactive'}}"></div>
                                        <span class="ms-2">{{$candidate?->deleted_at == Null ? 'Active': 'Inactive'}}</span>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>Remarks:</th>
                                <td>{{ $candidate?->remarks }}</td>
                            </tr>

                            <tr>
                                <th>Attachments:</th>
                                <td>
                                    @if (!empty($attachments))
                                        <ul class="mt-1 small">
                                            @foreach ($attachments as $filePath)
                                                <li>
                                                    <a href="{{ asset('storage/' . $filePath) }}" target="_blank" download title="{{ basename($filePath) }}">
                                                        <span class="truncate-filename">{{ basename($filePath) }}</span>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>

                            <style>
                                .truncate-filename {
                                    max-width: 150px;
                                    white-space: nowrap;
                                    overflow: hidden;
                                    text-overflow: ellipsis;
                                    display: inline-block;
                                    vertical-align: bottom;
                                    }
                            </style>
                        </table>
                    </div>

                    <div class="modal-footer bg-light py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-light py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="candidateModalLabel">
                            {{$editMode ? 'Update Candidate' : 'Add New Candidate'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-3">
                        <form class="needs-validation" wire:submit.prevent="{{$editMode ? 'updateCandidate' : 'createCandidate'}}">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="first_name" class="form-label small">First Name</label>
                                    <input type="text" class="form-control form-control-sm" id="first_name" wire:model="first_name" required>
                                    @error('first_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="middle_initial" class="form-label small">M.I.</label>
                                    <input type="text" class="form-control form-control-sm" id="middle_initial" wire:model="middle_initial" maxlength="1">
                                    @error('middle_initial') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-3">
                                    <label for="extension" class="form-label small">Extension</label>
                                    <input type="text" class="form-control form-control-sm" id="extension" wire:model="extension">
                                    @error('extension') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6">
                                    <label for="family_name" class="form-label small mt-2">Family Name</label>
                                    <input type="text" class="form-control form-control-sm" id="family_name" wire:model="family_name" required>
                                    @error('family_name') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                <div class="col-md-6 mt-2">
                                    <label for="email" class="form-label small mt-2">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="email" wire:model="email" required>
                                    @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <label for="contactno" class="form-label small">Contact No</label>
                                    <input type="text" class="form-control form-control-sm" id="contactno" wire:model="contactno" required>
                                    @error('contactno') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="position_id" class="form-label small">Position</label>
                                    <select class="form-select form-select-sm" id="position_id" wire:model="position_id" required>
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position)
                                            <option value="{{ $position->id }}">{{ $position->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('position_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <label for="office_id" class="form-label small">Office</label>
                                    <select class="form-select form-select-sm" id="office_id" wire:model="office_id" required>
                                        <option value="">Select Office</option>
                                        @foreach($offices as $office)
                                            <option value="{{ $office->id }}">{{ $office->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('office_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="priority_group_id" class="form-label small">Priority Group</label>
                                    <select class="form-select form-select-sm" id="priority_group_id" wire:model="priority_group_id" required>
                                        <option value="">Select Priority Group</option>
                                        @foreach($priorityGroups as $priorityGroup)
                                            <option value="{{ $priorityGroup->id }}">{{ $priorityGroup->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('priority_group_id') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <label class="form-label small">Status</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="status" value="yes" id="statusActive" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="statusActive">Active</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="status" value="no" id="statusInactive" {{ $status === 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="statusInactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="endorsement_date" class="form-label small">Endorsement Date</label>
                                    <input type="date" class="form-control form-control-sm" id="endorsement_date" wire:model="endorsement_date" required>
                                    @error('endorsement_date') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-12">
                                    <label for="remarks" class="form-label small">Remarks</label>
                                    <textarea class="form-control form-control-sm" id="remarks" wire:model="remarks" rows="2"></textarea>
                                    @error('remarks') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-2 mt-2">
                                <div class="col-md-12">
                                    <label for="attachments" class="form-label small">Attachments (PDF, JPG, PNG; max 5 files)</label>
                                    <input type="file" class="form-control form-control-sm" id="attachments" wire:model="attachments" multiple>
                                    @error('attachments') <span class="text-danger small">{{ $message }}</span> @enderror
                                    @error('attachments.*') <span class="text-danger small">{{ $message }}</span> @enderror

                                    @if($editMode)
                                        @if (!empty($attachments) && count($attachments) > 0)
                                            <p class="text-muted mt-2">
                                                <strong>{{ count($attachments) }}</strong> file(s) attached.
                                            </p>
                                            <ul class="list-unstyled small">
                                                @foreach ($attachments as $index => $filePath)
                                                    <li class="mb-1">
                                                        {{ basename($filePath) }} ({{ strtoupper(pathinfo($filePath, PATHINFO_EXTENSION)) }})
                                                        <div class="btn-group btn-group-sm ms-2" role="group">
                                                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank" class="btn btn-outline-primary" title="View File">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="{{ asset('storage/' . $filePath) }}" download class="btn btn-outline-secondary" title="Download File">
                                                                <i class="bi bi-download"></i>
                                                            </a>
                                                            <button type="button" class="btn btn-outline-danger" wire:click="removeFile({{ $index }})" title="Remove File">
                                                                <i class="bi bi-trash3"></i>
                                                            </button>
                                                        </div>

                                                        @if(!empty($replaceFileVisibility[$index]) && $replaceFileVisibility[$index])
                                                            <input type="file" 
                                                                class="form-control form-control-sm mt-1" 
                                                                wire:model="replacementFiles.{{ $index }}" 
                                                                accept=".pdf,.png,.jpg,.jpeg">
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </div>
                            </div>

                            <div class="mt-3 text-end">
                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Cancel</button>
                                <button type="submit" class="btn btn-sm btn-primary px-3">
                                    <span wire:loading.remove wire:target="{{$editMode ? 'updateCandidate' : 'createCandidate'}}">
                                        {{$editMode ? 'Update' : 'Save'}}
                                    </span>
                                    <span wire:loading wire:target="{{$editMode ? 'updateCandidate' : 'createCandidate'}}">
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Processing...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</div>

@push('styles')
<style>
    .status-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
    }
    
    .status-active {
        background-color: #28a745;
        box-shadow: 0 0 5px rgba(40, 167, 69, 0.5);
    }
    
    .status-inactive {
        background-color: #dc3545;
        box-shadow: 0 0 5px rgba(220, 53, 69, 0.5);
    }
    
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 4px;
    }

    .table {
        font-size: 0.9rem;
    }
    
    .table th {
        font-weight: 600;
    }
    
    .table tr {
        border-bottom: 1px solid #e9ecef;
    }
    
    .modal-header {
        padding: 0.6rem 1rem;
    }
    
    .modal-footer {
        padding: 0.5rem 1rem;
    }
    
    .form-label {
        margin-bottom: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.25rem;
        }
        
        .btn-icon {
            width: 28px;
            height: 28px;
        }
    }
</style>
@endpush

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

    $wire.on('hide-candidateModal', () => {
        $('#candidateModal').modal('hide');
    });

    $wire.on('show-candidateModal', () => {
        $('#candidateModal').modal('show');
    });

    $wire.on('hide-viewModal', () => {
        $('#viewModal').modal('hide');
    });

    $wire.on('show-viewModal', () => {
        $('#viewModal').modal('show');
    });
</script>
@endscript