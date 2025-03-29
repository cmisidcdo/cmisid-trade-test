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
                    <table class="table table-hover table-striped align-middle border-bottom">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col">
                                    Full Name
                                </th>
                                <th scope="col">
                                    Office Applied
                                </th>
                                <th scope="col">
                                    Position Applied
                                </th>
                                <th scope="col">
                                    Priority Group
                                </th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
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
                                    <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Candidate actions">

                                        <button class="btn btn-sm btn-info rounded-2 d-flex align-items-center px-2 py-1 me-2"
                                            wire:click='viewCandidate({{ $item->id }})'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="View Candidate">
                                            <i class="bi bi-eye"></i>
                                            <span class="d-none d-md-inline ms-1">View</span>
                                        </button>


                                        @can('update candidate')
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                            wire:click='readCandidate({{$item->id}})'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Edit candidate">
                                            <i class="bi bi-pencil"></i>
                                            <span class="d-none d-md-inline ms-1">Edit</span>
                                        </button>
                                        @endcan

                                        {{-- @can('delete candidate')
                                        <button class="btn btn-sm rounded-2 px-2 py-1 me-2 {{$item->deleted_at == Null ? 'btn-danger' : 'btn-outline-success'}}"
                                            wire:click='{{$item->deleted_at == Null ? 'deleteCandidate('.$item->id.')' : 'restoreCandidate('.$item->id.')'}}'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="{{$item->deleted_at == Null ? 'Delete candidate' : 'Restore candidate'}}">
                                            <i class="bi {{$item->deleted_at == Null ? 'bi-trash' : 'bi-arrow-counterclockwise'}}"></i>
                                            <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Delete' : 'Restore'}}</span>
                                        </button>
                                        @endcan --}}
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
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow-lg rounded-3">
                   
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-semibold" id="viewModalLabel">
                            <i class="bi bi-eye me-2"></i> Candidate Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                   
                    <div class="modal-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Full Name:</strong>
                                <p class="m-0">{{ $candidate?->fullname }}</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Email:</strong>
                                <p class="m-0">{{ $candidate?->email }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Contact No:</strong>
                                <p class="m-0">{{ $candidate?->contactno }}</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Position Applied:</strong>
                                <p class="m-0">{{ $candidate?->position?->title ?? 'N/A' }}</p> 
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Office Applied:</strong>
                                <p class="m-0">{{ $candidate?->office?->title ?? 'N/A' }}</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Priority Group:</strong>
                                <p class="m-0">{{ $candidate?->priorityGroup?->title ?? 'N/A' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Endorsement Date:</strong>
                                <p class="m-0">{{ $candidate?->endorsement_date }}</p>
                            </div>
                            <div class="col-md-6 d-flex align-items-center gap-2">
                                <strong>Status:</strong>
                                <span class="badge rounded-pill {{$candidate?->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                    {{$candidate?->deleted_at == Null ? 'Active': 'Inactive'}}
                                </span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 text-center">
                                <strong class="d-block">Remarks:</strong>
                                <p class="m-0">{{ $candidate?->remarks }}</p>
                            </div>
                        </div>
                    </div>

                   
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="candidateModalLabel">
                            <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                            {{$editMode ? 'Update Candidate' : 'Add New Candidate'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" wire:submit="{{$editMode ? 'updateCandidate' : 'createCandidate'}}">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="fullname" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="fullname" wire:model="fullname" required>
                                    @error('fullname') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" wire:model="email" required>
                                    @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label for="contactno" class="form-label">Contact No</label>
                                    <input type="text" class="form-control" id="contactno" wire:model="contactno" required>
                                    @error('contactno') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="position_id" class="form-label">Position</label>
                                    <select class="form-select" id="position_id" wire:model="position_id" required>
                                        <option value="">Select Position</option>
                                        @foreach($positions as $position)
                                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('position_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label for="office_id" class="form-label">Office</label>
                                    <select class="form-select" id="office_id" wire:model="office_id" required>
                                        <option value="">Select Office</option>
                                        @foreach($offices as $office)
                                        <option value="{{ $office->id }}">{{ $office->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('office_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="priority_group_id" class="form-label">Priority Group</label>
                                    <select class="form-select" id="priority_group_id" wire:model="priority_group_id" required>
                                        <option value="">Select Priority Group</option>
                                        @foreach($priorityGroups as $priorityGroup)
                                        <option value="{{ $priorityGroup->id }}">{{ $priorityGroup->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('priority_group_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-6">
                                    <label class="form-label">Is Active?</label>
                                    <div>
                                        <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                                        <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="endorsement_date" class="form-label">Endorsement Date</label>
                                    <input type="date" class="form-control" id="endorsement_date" wire:model="endorsement_date" required>
                                    @error('endorsement_date') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="row g-3 mt-1">
                                <div class="col-md-12">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <textarea class="form-control" id="remarks" wire:model="remarks" rows="3"></textarea>
                                    @error('remarks') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="mt-4 text-end">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Cancel</button>
                                <button type="submit" class="btn btn-primary px-4">
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
    .custom-invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }

    .sortable {
        cursor: pointer;
    }

    .sortable:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    @media (max-width: 768px) {
        .card-title {
            font-size: 1.25rem;
        }

        .table th,
        .table td {
            padding: 0.5rem;
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
        $('#candidateModal').modal('hide');

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