    <div>
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Offices</h2>
        </div>

        <section class="section dashboard">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    
                    <div class="row align-items-center pt-3 pb-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <button class="btn btn-primary" wire:click="showAddEditModal">
                                <i class="bi bi-plus"></i> Add Office
                            </button>
                    
                            <div class="d-flex gap-2">
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" class="form-control border-start-0 ps-0"
                                        placeholder="Search offices..."
                                        wire:model.live.debounce.300ms="search"
                                        aria-label="Search offices">
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
                                                <i class="bi bi-list"></i> All Offices
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                                <i class="bi bi-person-check"></i> Active Offices
                                            </button>
                                        </li>
                                        <li>
                                            <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                                <i class="bi bi-person-x"></i> Inactive Offices
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
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 5%">#</th>
                                    <th>
                                        Title
                                    </th>
                                    <th style="width: 5%">Status</th>
                                    <th style="width: 5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($offices as $item)
                                <tr>
                                    <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                    <td>{{$item->title}}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                            {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Office actions">
                                            @can('update reference')
                                            <button class="btn btn-sm btn-primary rounded-2 px-2 py-1"
                                                wire:click='readOffice({{$item->id}})'
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Edit office">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No offices found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div>
                        {{ $offices->links(data: ['scrollTo' => false])}}
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

            <div class="modal fade" id="officeModal" tabindex="-1" aria-labelledby="officeModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow">
                        <div class="modal-header bg-primary text-white py-2">
                            <h5 class="modal-title fs-6" id="officeModalLabel">
                                {{$editMode ? 'Update Office' : 'Add Office'}}
                            </h5>
                            <button type="button" class="btn-close btn-sm btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                        </div>
                        <div class="modal-body p-3">
                            <form class="needs-validation" wire:submit="{{$editMode ? 'updateOffice' : 'createOffice'}}">
                                <div class="mb-3">
                                    <label for="officeTitle" class="form-label small fw-medium">Office Title</label>
                                    <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                                        id="officeTitle"
                                        wire:model="title"
                                        placeholder="Enter office title"
                                        autocomplete="off">
                                    @error('title')
                                    <div class="invalid-feedback small">
                                        <i class="bi bi-exclamation-circle me-1"></i>
                                        {{$message}}
                                    </div>
                                    @enderror
                                </div>
            
                                <div class="mb-3">
                                    <label class="form-label small fw-medium">Is Active?</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="status" value="yes" id="statusYes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="statusYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="status" value="no" id="statusNo" {{ $status === 'no' ? 'checked' : '' }}>
                                            <label class="form-check-label small" for="statusNo">No</label>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal" wire:click='clear'>
                                        Cancel
                                    </button>
                                    <button type="submit" class="btn btn-sm btn-primary">
                                        {{ $editMode ? 'Update' : 'Save' }}
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

        /* .sortable {
            cursor: pointer;
        }

        .sortable:hover {
            background-color: rgba(0, 0, 0, 0.05);
        } */

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

        $wire.on('hide-officeModal', () => {
            console.log('Hiding office modal');
            $('#officeModal').modal('hide');

        });

        $wire.on('show-officeModal', () => {
            console.log('Showing office modal');
            $('#officeModal').modal('show');
        });

        
    </script>
    @endscript