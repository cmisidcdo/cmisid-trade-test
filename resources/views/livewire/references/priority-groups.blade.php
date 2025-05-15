<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Priority Groups</h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary" wire:click="showAddEditModal">
                            <i class="bi bi-plus"></i> Add Priority Group
                        </button>
                
                        <div class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                    placeholder="Search priority groups..."
                                    wire:model.live.debounce.300ms="search"
                                    aria-label="Search priority groups">
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
                                            <i class="bi bi-list"></i> All Priority Groups
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                            <i class="bi bi-person-check"></i> Active Priority Groups
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                            <i class="bi bi-person-x"></i> Inactive Priority Groups
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
                                <th>Title</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($prioritygroups as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                <td>{{$item->title}}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $isUsed = $item->candidates_count > 0;
                                    @endphp
                                    
                                    @can('update reference')
                                        <button 
                                            class="btn btn-sm {{ $isUsed ? 'btn-secondary' : 'btn-primary' }} rounded-2 px-2 py-1 me-2"
                                            title="{{ $isUsed ? 'Edit disabled: group in use' : 'Edit priority group' }}"
                                            @if (!$isUsed)
                                                wire:click='readPriorityGroup({{ $item->id }})'
                                            @else
                                                disabled
                                            @endif
                                        >
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                    @endcan                                
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No prioritygroups found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$prioritygroups->links(data: ['scrollTo' => false])}}
                    </div>
                </div>


                {{-- <div class="d-flex justify-content-center mt-4">
                    {{$prioritygroups->links()}}
                </div> --}}

                
            </div>
        </div>

        <div class="modal fade" id="prioritygroupModal" tabindex="-1" aria-labelledby="prioritygroupModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fs-6" id="prioritygroupModalLabel">
                            {{$editMode ? 'Update Priority Group' : 'Add Priority Group'}}
                        </h5>
                        <button type="button" class="btn-close btn-sm btn-close-white" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-3">
                        <form class="needs-validation" wire:submit="{{$editMode ? 'updatePriorityGroup' : 'createPriorityGroup'}}">
                            <div class="mb-3">
                                <label for="prioritygroupTitle" class="form-label small fw-medium">Priority Group Title</label>
                                <input type="text" class="form-control {{$errors->has('title') ? 'is-invalid' : ''}}"
                                    id="prioritygroupTitle"
                                    wire:model="title"
                                    placeholder="Enter title"
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
                                        <input class="form-check-input" type="radio" wire:model="status" value="yes" id="statusActive" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="statusActive">Yes</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" wire:model="status" value="no" id="statusInactive" {{ $status === 'no' ? 'checked' : '' }}>
                                        <label class="form-check-label small" for="statusInactive">No</label>
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

    $wire.on('hide-prioritygroupModal', () => {
        console.log('Hiding prioritygroup modal');
        $('#prioritygroupModal').modal('hide');

    });

    $wire.on('show-prioritygroupModal', () => {
        console.log('Showing prioritygroup modal');
        $('#prioritygroupModal').modal('show');
    });

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
            } else {
                suggestionsDiv.classList.add('d-none');
            }
        });
    }
</script>
@endscript