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
                        <button
                            type="button"
                            class="btn btn-primary d-flex align-items-center"
                            wire:click='clear'
                            data-bs-toggle="modal"
                            data-bs-target="#positionModal"
                            title="Add new position">
                            <i class="bi bi-plus-circle me-1"></i> Add Position
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="fw-semibold">#</th>
                                <th scope="col" class="fw-semibold">Title</th>
                                <th scope="col" class="fw-semibold">Salary Grade</th>
                                <th scope="col" class="fw-semibold">Competency Level</th>
                                <th scope="col" class="fw-semibold">Status</th>
                                <th scope="col" class="fw-semibold">Priority</th>
                                <th scope="col" class="fw-semibold text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($positions as $item)
                            <tr class="position-row">
                                <td scope="row">{{$item->id}}</td>
                                <td class="fw-medium">{{$item->title}}</td>
                                <td>{{$item->salary_grade}}</td>
                                <td>
                                    <span class="badge rounded-pill 
                        {{ $item->competency_level == 'basic' ? 'bg-info' : 
                          ($item->competency_level == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                        {{ucfirst($item->competency_level)}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                        {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge rounded-pill {{$item->interview_priority == True ? 'bg-success': 'bg-secondary'}}">
                                        {{$item->interview_priority == True ? 'Priority': 'Standard'}}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <button
                                            class="btn btn-sm btn-info"
                                            wire:click='viewPosition({{$item->id}})'
                                            title="View position skills">
                                            <i class="bi bi-eye me-1"></i> View
                                        </button>
                                        <button
                                            class="btn btn-sm btn-primary"
                                            wire:click='readPosition({{$item->id}})'
                                            title="Edit position">
                                            <i class="bi bi-pencil-square me-1"></i> Edit
                                        </button>

                                        <button
                                            class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger': 'btn-outline-success'}}"
                                            wire:click='{{$item->deleted_at == Null ? 'deletePosition('.$item->id.')': 'restorePosition('.$item->id.')'}}'
                                            title="{{$item->deleted_at == Null ? 'Move to archive' : 'Restore position'}}">
                                            <i class="bi {{$item->deleted_at == Null ? 'bi-archive' : 'bi-arrow-counterclockwise'}} me-1"></i>
                                            {{$item->deleted_at == Null ? 'Archive': 'Restore'}}
                                        </button>
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

                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="pagination-info text-muted small">
                            Showing {{ $positions->firstItem() ?? 0 }} to {{ $positions->lastItem() ?? 0 }} of {{ $positions->total() ?? 0 }} entries
                        </div>
                        {{$positions->links()}}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="positionModalLabel">
                            <i class="bi {{ $editMode ? 'bi-pencil-square' : 'bi-plus-circle' }} me-1"></i>
                            {{$editMode ? 'Update Position' : 'Add Position'}}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-4" wire:submit.prevent="{{$editMode ? 'updatePosition' : 'createPosition'}}">

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
                                    <label class="form-label fw-semibold d-block">Interview Priority <span class="text-danger">*</span></label>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input @error('interview_priority') is-invalid @enderror"
                                            type="radio"
                                            id="priorityYes"
                                            wire:model="interview_priority"
                                            value="1">
                                        <label class="form-check-label" for="priorityYes">Priority</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input
                                            class="form-check-input @error('interview_priority') is-invalid @enderror"
                                            type="radio"
                                            id="priorityNo"
                                            wire:model="interview_priority"
                                            value="0">
                                        <label class="form-check-label" for="priorityNo">Standard</label>
                                    </div>
                                    @error('interview_priority')
                                    <div class="d-block invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-12">
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
                                    <table class="table table-hover">
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
                                                <td>
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
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" wire:click='clear'>
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi {{ $editMode ? 'bi-check2-circle' : 'bi-plus-circle' }} me-1"></i>
                                    {{ $editMode ? 'Update' : 'Save' }} Position
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="skillsModal" tabindex="-1" aria-labelledby="skillsModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="skillsModalLabel">
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
                            <table class="table table-hover align-middle">
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
                                        <td scope="row">{{$item->id}}</td>
                                        <td class="fw-medium">{{$item->title}}</td>
                                        <td class="text-center">
                                            <button
                                                class="btn btn-success btn-sm"
                                                wire:click="addSkill({{$item->id}})"
                                                wire:loading.attr="disabled"
                                                wire:target="addSkill({{$item->id}})">
                                                <i class="bi bi-plus-circle me-1"></i> Add
                                                <span wire:loading wire:target="addSkill({{$item->id}})">
                                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                </span>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-muted">
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
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewSkillsModalLabel">
                            <i class="bi bi-eye me-1"></i> Position: HR Manager
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Position Details</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <p class="mb-1"><span class="fw-medium">Title:</span> {{$this->title}}</p>
                                    <p class="mb-1"><span class="fw-medium">Salary Grade:</span> {{$this->salary_grade}}</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">
                                        <span class="fw-medium">Competency Level:</span>
                                        <span class="badge rounded-pill bg-primary">
                                            {{$this->competency_level}}
                                        </span>
                                    </p>
                                    <p class="mb-1">
                                        <span class="fw-medium">Priority:</span>
                                        <span class="badge rounded-pill bg-success">
                                            Priority
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="border-top pt-3">
                            <h6 class="fw-bold mb-3">Required Skills</h6>

                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fw-semibold">#</th>
                                            <th class="fw-semibold">Skill Title</th>
                                            <th class="fw-semibold">Competency Level</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @forelse($selectedskills as $index => $selectedskill)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td class="fw-medium">{{ $selectedskill['title'] }}</td>
                                            <td class="fw-medium">
                                                <span class="badge rounded-pill 
                                                    {{ $selectedskill['competency_level'] == 'basic' ? 'bg-info' : 
                                                    ($selectedskill['competency_level'] == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                                    {{ $selectedskill['competency_level'] }}
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
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
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
            console.log('Hiding position modal');
            bootstrap.Modal.getInstance(document.getElementById('positionModal')).hide();
        });

        $wire.on('show-positionModal', () => {
            console.log('Showing position modal');
            new bootstrap.Modal(document.getElementById('positionModal')).show();
        });

        $wire.on('show-skillsModal', () => {
            console.log('Showing skills modal');
            bootstrap.Modal.getInstance(document.getElementById('positionModal')).hide();
            new bootstrap.Modal(document.getElementById('skillsModal')).show();
        });

        $wire.on('hide-skillsModal', () => {
            console.log('Hiding skills modal');
            new bootstrap.Modal(document.getElementById('positionModal')).show();
            bootstrap.Modal.getInstance(document.getElementById('skillsModal')).hide();
        });
        $wire.on('show-viewSkillsModal', () => {
            console.log('Showing view skills modal');
            new bootstrap.Modal(document.getElementById('viewSkillsModal')).show();
        });
        $wire.on('hide-viewskillsModal', () => {
            consols.log('Hiding view skills modal');
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