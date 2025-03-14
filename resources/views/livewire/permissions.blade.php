<div>
    <div class="globalheader">
        <h3 style="font-weight: bold; margin: 0;">Permissions</h3>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <!-- Search and Action Buttons Row -->
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <button type="button" class="btn btn-primary"
                            wire:click='clear'
                            data-bs-toggle="modal"
                            data-bs-target="#permissionModal">
                            <i class="bi bi-plus-lg me-1"></i> Add Permission
                        </button>
                    </div>
                </div>

                <!-- Table with enhanced styling -->
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col" class="sortable" wire:click="sortBy('name')">
                                    Name
                                    <i class="bi bi-arrow-down-up text-muted ms-1"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($permissions as $item)
                            <tr>
                                <td scope="row">{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No permissions found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                
                <!-- Pagination with enhanced styling -->

                <div>
                    {{-- {{$permissions->links()}} --}}
                </div>
            </div>
        </div>

        <!-- Enhanced Modal -->
        <div class="modal fade" id="permissionModal" tabindex="-1" aria-labelledby="permissionModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="permissionModalLabel">
                            <i class="bi bi-plus-circle me-2"></i>
                            Add New Permission
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" wire:submit="createPermission">
                            <div class="mb-4">
                                <label for="permissionName" class="form-label fw-medium">Permission Name</label>
                                <input type="text" class="form-control form-control-lg {{$errors->has('permission_name') ? 'is-invalid' : ''}}"
                                    id="permission_name"
                                    wire:model="permission_name"
                                    placeholder="Enter permission permission_name"
                                    autocomplete="off">
                                @error('permission_name')
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
                                    <span wire:loading.remove wire:target="createPermission">
                                        Save
                                    </span>
                                    <span wire:loading wire:target="createPermission">
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

    document.addEventListener("DOMContentLoaded", function() {
            console.log(@json($permissions));
        });
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
    $wire.on('hide-permissionModal', () => {
        console.log('Hiding permission modal');
        $('#permissionModal').modal('hide');

        // Show success toast
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Permission saved successfully!';
        toast.show();
    });

    $wire.on('show-permissionModal', () => {
        console.log('Showing permission modal');
        $('#permissionModal').modal('show');
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