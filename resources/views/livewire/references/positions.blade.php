<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Positions</h2>
    </div>

    <section class="section dashboard">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <div class="row mb-4 align-items-center">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0"
                                placeholder="Search positions..."
                                wire:model.live.debounce.300ms="search"
                                aria-label="Search positions">
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
                    </div>
                    <div class="col-md-6 d-flex justify-content-end gap-2 mt-3 mt-md-0">
                        <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                            <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                            {{ $archive ? 'General' : 'View Archive' }}
                        </button>

                        @can('create reference')
                        <button
                            type="button"
                            class="btn btn-primary d-flex align-items-center"
                            wire:click='showAddEditModal'
                            title="Add new position">
                            <i class="bi bi-plus-circle me-1"></i> Add Position
                        </button>
                        @endcan
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center global-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="fw-semibold" style="width: 5%;">#</th>
                                <th scope="col" class="fw-semibold">Title</th>
                                <th scope="col" class="fw-semibold" style="width: 40%;">Description</th>
                                <th scope="col" class="fw-semibold" style="width: 10%;">Salary Grade</th>
                                <th scope="col" class="fw-semibold" style="width: 5%;">Status</th>
                                
                                <th scope="col" class="fw-semibold text-center" style="width: 15%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($positions as $item)
                            <tr class="position-row">
                                <td scope="row"  class="text-center align-middle" style="width: 5%;">{{$loop->iteration}}</td>
                                <td class="fw-medium align-middle" style="max-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"">{{$item->title}}</td>
                                <td class="fw-medium align-middle text-truncate" style="width: 40%; max-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    {{$item->position_description}}
                                </td>                                
                                <td class="fw-medium align-middle" style="width: 10%;">{{$item->salary_grade}}</td>
                                <td class="fw-medium align-middle" style="width: 5%;">
                                    <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                
                                <td style="width: 15%;">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <button
                                            class="btn btn-sm btn-info"
                                            wire:click='viewPosition({{$item->id}})'
                                            title="View position skills">
                                            <i class="bi bi-eye me-0"></i>
                                        </button>
                                
                                        @can('update reference')
                                        <button
                                            class="btn btn-sm btn-primary"
                                            wire:click='readPosition({{$item->id}})'
                                            title="Edit position">
                                            <i class="bi bi-pencil-square me-0"></i>
                                        </button>
                                        @endcan
                                
                                        @can('delete reference')
                                        <button
                                            class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger': 'btn-outline-success'}}"
                                            wire:click='{{$item->deleted_at == Null ? 'confirmDelete('.$item->id.')': 'restorePosition('.$item->id.')'}}'
                                            title="{{$item->deleted_at == Null ? 'Move to archive' : 'Restore position'}}">
                                            <i class="bi {{$item->deleted_at == Null ? 'bi-archive' : 'bi-arrow-counterclockwise'}} me-0"></i>
                                        </button>
                                        @endcan
                                    </div>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="empty-state">
                                        <i class="bi bi-folder2-open text-muted" style="font-size: 2rem;"></i>
                                        <p class="mt-2 mb-0">No positions found</p>
                                        @if(!empty($search))
                                        <p class="text-muted small">Try adjusting your search criteria</p>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4 gap-3">
                    {{ $positions->links(data: ['scrollTo' => false]) }}
                </div>
            </div>
        </div>

        <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="positionModalLabel">
                            {{$editMode ? 'Update Position' : 'Add Position'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-4" wire:submit.prevent="{{$editMode ? 'updatePosition' : 'createPosition'}}">

                            <div class="row g-3">
                                <div class="col-12">
                                    <label for="title" class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        wire:model="title"
                                        placeholder="Enter position title">
                                    @error('title')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            
                               

                            <div class="col-12">
                                <label for="position_description" class="form-label fw-semibold">
                                    Position Description <span class="text-danger">*</span>
                                </label>
                            
                                <textarea
                                    id="position_description"
                                    class="form-control @error('position_description') is-invalid @enderror"
                                    wire:model.live="position_description"
                                    placeholder="Enter Description"
                                    rows="4"
                                    maxlength="255"
                                ></textarea>
                            
                                <div class="text-end small text-muted">
                                    {{ strlen($position_description) }} / 255
                                </div>
                            
                                @error('position_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="salary_grade" class="form-label fw-semibold">Salary Grade <span class="text-danger">*</span></label>
                                    <input
                                        type="number"
                                        id="salary_grade"
                                        class="form-control @error('salary_grade') is-invalid @enderror"
                                        wire:model="salary_grade"
                                        placeholder="Enter grade (1-30)">
                                    @error('salary_grade')
                                    <div class="invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Items per Topic</label>
                                    <div class="d-flex align-items-center gap-3">
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="radio" wire:model="item" value="8" class="form-check-input me-1" {{ $item === '8' || !$editMode ? 'checked' : '' }}> 8
                                        </label>
                                        <label class="form-check-label d-flex align-items-center">
                                            <input type="radio" wire:model="item" value="10" class="form-check-input me-1" {{ $item === '10' ? 'checked' : '' }}> 10
                                        </label>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                            
                            
                            

                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h5 class="fw-semibold mb-0">Required Skills</h5>
                                    <button
                                        type="button"
                                        class="btn btn-success btn-sm d-flex align-items-center"
                                        wire:click="selectSkills">
                                        <i class="bi bi-plus-circle me-1"></i> Add Skill
                                    </button>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-hover table-bordered text-center global-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="fw-semibold">#</th>
                                                <th class="fw-semibold">Skill Title</th>
                                                <th class="fw-semibold">Competency Level</th>
                                                <th class="fw-semibold text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($selectedskills as $index => $selectedskill)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td class="fw-medium">{{ $selectedskill['title'] }}</td>
                                                <td class="fw-medium">
                                                    <select
                                                        class="form-select form-select-sm"
                                                        wire:change="updateCompetencyLevel({{ $index }}, $event.target.value)"
                                                        aria-label="Select competency level">
                                                        <option value="basic" {{ $selectedskill['competency_level'] == 'basic' ? 'selected' : '' }}>Basic</option>
                                                        <option value="intermediate" {{ $selectedskill['competency_level'] == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                        <option value="advanced" {{ $selectedskill['competency_level'] == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                    </select>
                                                </td>
                                                <td class="text-center">
                                                    <button
                                                        class="btn btn-danger btn-sm"
                                                        wire:click.prevent="removeSkill({{ $index }})"
                                                        title="Remove this skill">
                                                        <i class="bi bi-trash me-1"></i> Remove
                                                    </button>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4" class="text-center py-3 text-muted">
                                                    <i class="bi bi-info-circle me-1"></i> No skills added yet.
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            




                            <div class="col-12 d-flex justify-content-end gap-2 mt-4">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi {{ $editMode ? 'bi-check2-circle' : 'bi-plus-circle' }} me-1"></i>
                                    {{ $editMode ? 'Update' : 'Add' }} Position
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="skillsModal" tabindex="-1" aria-labelledby="skillsModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="skillsModalLabel">
                            <i class="bi bi-list-check me-1"></i> Select Skills
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
                                    placeholder="Search skills..."
                                    wire:model.live="skillSearch"
                                    aria-label="Search skills">
                                <span wire:loading wire:target="skillSearch" class="input-group-text bg-light border">
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
                                        <th class="fw-semibold">Skill Title</th>
                                        <th class="fw-semibold text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($skills as $item)
                                        <tr>
                                            <td scope="row" class="text-center">{{ $loop->iteration }}</td>
                                            <td class="fw-medium">{{ $item->title }}</td>
                                            <td class="text-center">
                                                <button
                                                    class="btn btn-success btn-sm"
                                                    wire:click="addSkill({{ $item->id }})"
                                                    @if($loadingSkillId === $item->id) disabled @endif
                                                >
                                                    <i class="bi bi-plus-circle me-1"></i>
                                                    @if($loadingSkillId === $item->id)
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    @else
                                                        Add
                                                    @endif
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-4 text-muted">
                                                <i class="bi bi-info-circle me-1"></i> No skills available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                                
                            </table>

                            <div class="mt-3">
                                {{ $skills->links() }}
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button
                                type="button"
                                class="btn btn-primary"
                                wire:click="backToPosition">
                                <i class="bi bi-arrow-left me-1"></i> Back to Position
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="viewSkillsModal" tabindex="-1" aria-labelledby="viewSkillsModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content shadow">
                    <div class="modal-header bg-primary text-white py-2">
                        <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewSkillsModalLabel">
                            View Position
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Position Details</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="fw-medium">Title:</span> {{$this->title}}</p>
                                    
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="fw-medium">Salary Grade:</span> {{$this->salary_grade}}</p>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12">
                                <p class="mb-1">Description:</p>
                                <p>{{$this->position_description}}</p>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-bold mb-3">Required Skills</h6>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered text-center global-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold" style="width:5%">#</th>
                                            <th class="fw-semibold">Skill Title</th>
                                            <th class="fw-semibold" style="width:20%">Competency Level</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($selectedskills as $index => $selectedskill)
                                        <tr>
                                            <td style="width:5%">{{ $index + 1 }}</td>
                                            <td class="fw-medium">{{ $selectedskill['title'] }}</td>
                                            <td class="fw-medium" style="width:20%">
                                                <span class="badge rounded-pill 
                                                    {{ $selectedskill['competency_level'] == 'basic' ? 'bg-info' : 
                                                    ($selectedskill['competency_level'] == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                                    {{ucfirst($selectedskill['competency_level'])}}
                                                </span>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">
                                                <i class="bi bi-info-circle me-1"></i> No skills added yet.
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="bi bi-x-circle me-1"></i> Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @script
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl, {
                    trigger: 'hover'
                });
            });

            document.addEventListener('livewire:load', function() {
                initTooltips();
            });

            document.addEventListener('livewire:update', function() {
                initTooltips();
            });

            function initTooltips() {
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                    return new bootstrap.Tooltip(tooltipTriggerEl, {
                        trigger: 'hover'
                    });
                });
            }
        });

        $wire.on('hide-positionModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('positionModal')).hide();
        });

        $wire.on('show-positionModal', () => {
            new bootstrap.Modal(document.getElementById('positionModal')).show();
        });

        $wire.on('show-skillsModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('positionModal')).hide();
            new bootstrap.Modal(document.getElementById('skillsModal')).show();
        });

        $wire.on('hide-skillsModal', () => {
            new bootstrap.Modal(document.getElementById('positionModal')).show();
            bootstrap.Modal.getInstance(document.getElementById('skillsModal')).hide();
        });

        $wire.on('show-viewSkillsModal', () => {
            new bootstrap.Modal(document.getElementById('viewSkillsModal')).show();
        });

        $wire.on('hide-viewskillsModal', () => {
            bootstrap.Modal.getInstance(document.getElementById('viewSkillsModal')).hide();
        });
    </script>
    @endscript

    <style>
        .table tbody tr:hover {
            background-color: rgba(0, 123, 255, 0.05);
            transition: background-color 0.2s ease;
        }

        .btn {
            transition: all 0.2s ease-in-out;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
        }

        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 1.5rem;
            color: #6c757d;
        }

        .was-validated .form-control:invalid,
        .form-control.is-invalid {
            border-color: #dc3545;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }

        @media (max-width: 768px) {
            .table-responsive {
                border: 0;
            }

            .btn {
                padding: 0.375rem 0.75rem;
            }

            .input-group {
                width: 100%;
            }
        }
    </style>
</div>