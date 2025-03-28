<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Skills</h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary" wire:click="showAddEditModal">
                            <i class="bi bi-plus"></i> Add Skill
                        </button>
                
                        <div class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                    placeholder="Search skills..."
                                    wire:model.live.debounce.300ms="search"
                                    aria-label="Search skills">
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
                                            <i class="bi bi-list"></i> All Skills
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                            <i class="bi bi-person-check"></i> Active Skills
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                            <i class="bi bi-person-x"></i> Inactive Skills
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
                    <table class="table table-hover table-bordered table-striped text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">
                                    Title
                                </th>
                                <th scope="col" class="fw-semibold">Competency Level</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($skills as $item)
                            <tr>
                                <td scope="row" class="text-center">{{$loop->iteration}}</td>
                                <td>{{$item->title}}</td>
                                <td>
                                    <span class="badge rounded-pill 
                                        {{ $item->competency_level == 'basic' ? 'bg-info' : 
                                        ($item->competency_level == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                        {{ucfirst($item->competency_level)}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-3 {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                
                                <td class="d-flex justify-content-center">
                                    @can('update reference')
                                    <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                        wire:click='readSkill({{$item->id}})'
                                        data-bs-toggle="tooltip"
                                        data-bs-title="Edit skill">
                                        <i class="bi bi-pencil-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </button>
                                    @endcan

                                    {{-- @can('delete reference')
                                    <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger': 'btn-outline-success'}} rounded-2 px-2 py-1"
                                        wire:click='{{$item->deleted_at == Null ? 'confirmDelete('.$item->id.')': 'restoreSkill('.$item->id.')'}}'
                                        data-bs-toggle="tooltip"
                                        data-bs-title="{{$item->deleted_at == Null ? 'Move to archive': 'Restore skill'}}">
                                        <i class="bi {{$item->deleted_at == Null ? 'bi bi-archive-fill': 'bi-arrow-counterclockwise'}}"></i>
                                        <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Archive': 'Restore'}}</span>
                                    </button>
                                    @endcan --}}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No skills found
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div>
                        {{$skills->links()}}
                    </div>
                </div>

                {{-- <div class="d-flex justify-content-center mt-4">
                    {{$skills->links()}}
                </div> --}}

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

        <div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="skillModalLabel">
                            {{$editMode ? 'Update Skill' : 'Add New Skill'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body p-4">
                        <form class="needs-validation" wire:submit="{{$editMode ? 'updateSkill' : 'createSkill'}}">
                            <div class="mb-4">
                                <label for="skillTitle" class="form-label fw-medium">Skill Title<span class="text-danger"> *</span></label>
                                <input type="text" class="form-control form-control-lg {{$errors->has('title') ? 'is-invalid' : ''}}"
                                    id="skillTitle"
                                    wire:model="title"
                                    placeholder="Enter skill title"
                                    autocomplete="off">
                                @error('title')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{$message}}
                                </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="competency_level" class="form-label fw-semibold">Competency Level <span class="text-danger">*</span></label>
                                <select
                                    class="form-select @error('competency_level') is-invalid @enderror"
                                    id="competency_level"
                                    wire:model="competency_level">
                                    <option value="">Select Level</option>
                                    <option value="basic">Basic</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
                                @error('competency_level')
                                <div class="invalid-feedback">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Is Active?</label>
                                <div>
                                    <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                                    <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                                </div>
                            </div>
                            
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>
                                    Cancel
                                </button>
                                <button type="submit" class="btn btn-primary px-4">
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

    $wire.on('hide-skillModal', () => {
        console.log('Hiding skill modal');
        $('#skillModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'Skill saved successfully!';
        toast.show();
    });

    $wire.on('show-skillModal', () => {
        console.log('Showing skill modal');
        $('#skillModal').modal('show');
    });

</script>
@endscript