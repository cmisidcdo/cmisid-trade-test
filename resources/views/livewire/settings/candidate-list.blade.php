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
                    <table class="table table-hover align-middle border">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center" width="5%">#</th>
                                <th scope="col" width="20%">Full Name</th>
                                <th scope="col" width="18%">Office Applied</th>
                                <th scope="col" width="18%">Position Applied</th>
                                <th scope="col" width="18%">Priority Group</th>
                                <th scope="col" class="text-center" width="6%">Status</th>
                                <th scope="col" class="text-center" width="15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidates as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                <td>{{$item->fullname}}</td>
                                <td>{{$item->office->title}}</td>
                                <td>{{$item->position->title}}</td>
                                <td>{{$item->prioritygroup->title}}</td>
                                <td class="text-center">
                                    <div class="status-indicator {{$item->deleted_at == Null ? 'status-active': 'status-inactive'}}" 
                                        title="{{$item->deleted_at == Null ? 'Active': 'Inactive'}}">
                                    </div>
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
                                        <button class="btn btn-icon btn-primary me-1" 
                                            wire:click='readCandidate({{$item->id}})'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Edit">
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

                <div class="d-flex justify-content-center mt-4">
                    {{$candidates->links()}}
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
                        <form class="needs-validation" wire:submit="{{$editMode ? 'updateCandidate' : 'createCandidate'}}">
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <label for="fullname" class="form-label small">Full Name</label>
                                    <input type="text" class="form-control form-control-sm" id="fullname" wire:model="fullname" required>
                                    @error('fullname') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label small">Email</label>
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
        console.log('Hiding candidate modal');
        $('candidateModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Candidate saved successfully!';
        toast.show();
    });

    $wire.on('show-candidateModal', () => {
        console.log('Showing candidate modal');
        $('#candidateModal').modal('show');
    });

    $wire.on('hide-viewModal', () => {
        console.log('Hiding view modal');
        $('#viewModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'view saved successfully!';
        toast.show();
    });

    $wire.on('show-viewModal', () => {
        console.log('Showing view modal');
        $('#viewModal').modal('show');
    });
</script>
@endscript