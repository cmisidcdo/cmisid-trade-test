<div>
    <div class="globalheader">
        <h3 style="font-weight: bold; margin: 0;">Candidates List</h3>
    </div>

    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                
                <!-- Search and Action Buttons Row -->
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
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
                        <div id="searchSuggestions" class="position-absolute bg-white shadow-sm rounded p-2 d-none">
                            <!-- Dynamic search suggestions would appear here -->
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-outline-secondary me-2" 
                            wire:click="toggleArchive"
                            aria-label="{{ $archive ? 'View general candidates' : 'View archived candidates' }}">
                            <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                            {{ $archive ? 'View Active' : 'View Archive' }}
                            <span class="badge bg-secondary ms-1 rounded-pill" wire:loading wire:target="toggleArchive">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            </span>
                        </button>
                        <button type="button" class="btn btn-primary" 
                            wire:click='clear' 
                            data-bs-toggle="modal" 
                            data-bs-target="#candidateModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Candidate
                        </button>
                    </div>
                </div>
  
                <!-- Table with enhanced styling -->
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle border-bottom">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="sortable" wire:click="sortBy('fullname')">
                                    Full Name
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" wire:click="sortBy('fullname')">
                                    Office Applied
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" wire:click="sortBy('fullname')">
                                    Position Applied
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                                <th scope="col" class="sortable" wire:click="sortBy('fullname')">
                                    Priority Group
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($candidates as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$item->id}}</td>
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
                                        <button class="btn btn-sm btn-outline-primary" 
                                            wire:click='readCandidate({{$item->id}})'
                                            data-bs-toggle="tooltip" 
                                            data-bs-title="Edit candidate">
                                            <i class="bi bi-pencil"></i>
                                            <span class="d-none d-md-inline ms-1">Edit</span>
                                        </button>
  
                                        <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-outline-danger': 'btn-outline-success'}}" 
                                            wire:click='{{$item->deleted_at == Null ? 'deleteCandidate('.$item->id.')': 'restoreCandidate('.$item->id.')'}}'
                                            data-bs-toggle="tooltip" 
                                            data-bs-title="{{$item->deleted_at == Null ? 'Delete candidate': 'Restore candidate'}}">
                                            <i class="bi {{$item->deleted_at == Null ? 'bi-trash': 'bi-arrow-counterclockwise'}}"></i>
                                            <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Delete': 'Restore'}}</span>
                                        </button>
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
                
                <!-- Pagination with enhanced styling -->
                <div class="d-flex justify-content-center mt-4">
                    {{$candidates->links('pagination::bootstrap-5')}}
                </div>
                
                <!-- Success/Error feedback toast -->
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
  
        <!-- Enhanced Modal -->
        <div class="modal fade" id="candidateModal" tabindex="-1" aria-labelledby="candidateModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
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
                            <div class="mb-4">
                                <label for="candidateTitle" class="form-label fw-medium">Candidate Title</label>
                                <input type="text" class="form-control form-control-lg {{$errors->has('title') ? 'is-invalid' : ''}}" 
                                    id="candidateTitle" 
                                    wire:model="title" 
                                    placeholder="Enter candidate title"
                                    autocomplete="off">
                                @error('title')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click='clear'>
                                    Cancel
                                </button>
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
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .card-title {
            font-size: 1.25rem;
        }
        
        .table th, .table td {
            padding: 0.5rem;
        }
    }
  </style>
  @endpush
  
  @script
  <script>
    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        
        // Reinitialize tooltips when Livewire updates the DOM
        window.addEventListener('livewire:update', function() {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    });
  
    // Modal handling
    $wire.on('hide-candidateModal', () => {
        console.log('Hiding candidate modal');
        $('#candidateModal').modal('hide');
        
        // Show success toast
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Candidate saved successfully!';
        toast.show();
    });
  
    $wire.on('show-candidateModal', () => {
        console.log('Showing candidate modal');
        $('#candidateModal').modal('show');
    });
    
    // candidate operations feedback
    $wire.on('candidate-deleted', () => {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Candidate deleted successfully!';
        toast.show();
    });
    
    $wire.on('candidate-restored', () => {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Candidate restored successfully!';
        toast.show();
    });
    
    // Search suggestions handling
    const searchInput = document.querySelector('[wire:model\\.live\\.debounce\\.300ms="search"]');
    const suggestionsDiv = document.getElementById('searchSuggestions');
    
    if (searchInput && suggestionsDiv) {
        searchInput.addEventListener('focus', function() {
            if (this.value.length > 1) {
                suggestionsDiv.classList.remove('d-none');
            }
        });
        
        searchInput.addEventListener('blur', function() {
            setTimeout(() => {
                suggestionsDiv.classList.add('d-none');
            }, 200);
        });
        
        searchInput.addEventListener('input', function() {
            if (this.value.length > 1) {
                suggestionsDiv.classList.remove('d-none');
                // In a real implementation, you would fetch suggestions from the server here
            } else {
                suggestionsDiv.classList.add('d-none');
            }
        });
    }
  </script>
  @endscript