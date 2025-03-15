<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Evaluation Criteria</h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0"
                                placeholder="Search criterias..."
                                wire:model.live.debounce.300ms="search"
                                aria-label="Search criterias">
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
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                            <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                            {{ $archive ? 'General' : 'View Archive' }}
                        </button>
                        @can('create reference')
                        <button type="button" class="btn btn-primary"
                            wire:click='clear'
                            data-bs-toggle="modal"
                            data-bs-target="#criteriaModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Criteria
                        </button>
                        @endcan
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped align-middle border-bottom">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="sortable" wire:click="sortBy('title')">
                                    Title
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($criterias as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$item->id}}</td>
                                <td>{{$item->title}}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Criteria actions">
                                        @can('update reference')
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                            wire:click='readCriteria({{$item->id}})'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="Edit criteria">
                                            <i class="bi bi-pencil-square me-1"></i>
                                            <span class="d-none d-md-inline ms-1">Edit</span>
                                        </button>
                                        @endcan

                                        @can('delete reference')
                                        <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger' : 'btn-outline-success'}} rounded-2 px-2 py-1"
                                            wire:click='{{$item->deleted_at == Null ? 'deleteCriteria('.$item->id.')': 'restoreCriteria('.$item->id.')'}}'
                                            data-bs-toggle="tooltip"
                                            data-bs-title="{{$item->deleted_at == Null ? 'Move to archive': 'Restore criteria'}}">
                                            <i class="bi {{$item->deleted_at == Null ? 'bi bi-archive-fill': 'bi-arrow-counterclockwise'}}"></i>
                                            <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Active': 'Restore'}}</span>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No criterias found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <div class="d-flex justify-content-center mt-4">
                    {{$criterias->links()}}
                </div>

            </div>
        </div>

        <div class="modal fade" id="criteriaModal" tabindex="-1" aria-labelledby="criteriaModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="criteriaModalLabel">
                            <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-2"></i>
                            {{$editMode ? 'Update Criteria' : 'Add New Criteria'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" wire:submit="{{$editMode ? 'updateCriteria' : 'createCriteria'}}">
                            <div class="mb-4">
                                <label for="criteriaTitle" class="form-label fw-medium">Criteria Title</label>
                                <input type="text" class="form-control form-control-lg {{$errors->has('title') ? 'is-invalid' : ''}}"
                                    id="criteriaTitle"
                                    wire:model="title"
                                    placeholder="Enter criteria title"
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
                                    <span wire:loading.remove wire:target="{{$editMode ? 'updateCriteria' : 'createCriteria'}}">
                                        {{$editMode ? 'Update' : 'Save'}}
                                    </span>
                                    <span wire:loading wire:target="{{$editMode ? 'updateCriteria' : 'createCriteria'}}">
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

        .table th,
        .table td {
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
    $wire.on('hide-criteriaModal', () => {
        console.log('Hiding criteria modal');
        $('#criteriaModal').modal('hide');

        // Show success toast
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Criteria saved successfully!';
        toast.show();
    });

    $wire.on('show-criteriaModal', () => {
        console.log('Showing criteria modal');
        $('#criteriaModal').modal('show');
    });

    // criteria operations feedback
    $wire.on('criteria-deleted', () => {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Criteria deleted successfully!';
        toast.show();
    });

    $wire.on('criteria-restored', () => {
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Criteria restored successfully!';
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