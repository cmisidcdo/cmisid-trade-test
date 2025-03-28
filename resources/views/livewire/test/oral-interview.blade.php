<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Interviews</h2>
    </div>
    <section class="section dashboard">
        <div class="card">
            <div class="card-body p-3">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <button class="btn btn-primary" wire:click="showAddEditModal">
                            <i class="bi bi-plus"></i> Oral Interview Question
                        </button>
                
                        <div class="d-flex gap-2">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-start-0 ps-0"
                                    placeholder="Search question..."
                                    wire:model.live.debounce.300ms="search"
                                    aria-label="Search question">
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
                                            <i class="bi bi-list"></i> All
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                            <i class="bi bi-person-check"></i> Active
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                            <i class="bi bi-person-x"></i> Inactive
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
                                <th scope="col">Question</th>
                                <th scope="col">Competency Level</th>
                                <th scope="col">Skill</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($oralquestions as $item)
                                <tr>
                                    <td scope="row" class="text-center" style="width: 5%;">{{$loop->iteration}}</td>
                                    <td>{{$item->question}}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill 
                                            {{ $item->competency_level == 'basic' ? 'bg-info' : 
                                            ($item->competency_level == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                            {{ ucfirst($item->skill->competency_level) }}
                                        </span>
                                    </td>

                                    <td class="text-center" >{{$item->skill->title}}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                            {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                        </span>
                                    </td>

                                    <td class="d-flex justify-content-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <button class="btn btn-sm btn-info rounded-2 px-2 py-1"
                                                data-bs-toggle="modal"
                                                data-bs-target="#viewOralModal"
                                                data-bs-title="View Question">
                                                <i class="bi bi-eye"></i>
                                                <span class="d-none d-md-inline ms-1">View</span>
                                            </button>

                                            @can('update reference')
                                            <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                                wire:click='readOralQuestion({{$item->id}})'
                                                data-bs-toggle="tooltip"
                                                data-bs-title="Edit Question">
                                                <i class="bi bi-pencil-square"></i>
                                                <span class="d-none d-md-inline ms-1">Edit</span>
                                            </button>
                                            @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                        No questions found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

            <!-- Add Oral Interview Modal -->
            <div class="modal fade" id="oralQuestionModal" tabindex="-1" aria-labelledby="oralQuestionModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white d-flex justify-content-center">
                            <h5 class="modal-title w-100 text-center">Add Oral Interview</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form class="needs-validation" wire:submit.prevent="{{$editMode ? 'updateOralQuestion' : 'createOralQuestion'}}">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="competency_level" class="form-label fw-bold fs-7">Competency Level</label>
                                        <select class="form-select form-select-sm fs-7" id="competency_level" wire:model.live="competency_level">
                                            <option value="" class="fs-7">Select Level</option>
                                            @foreach($competency_levels as $level)
                                            <option value="{{ $level }}" class="fs-7">{{ ucfirst($level) }}</option>
                                            @endforeach
                                        </select>
                                        @error('competency_level')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="skill" class="form-label fw-bold fs-7">Choose Skill</label>
                                        <select class="form-select form-select-sm fs-7  @error('skill_id') is-invalid @enderror" wire:model="skill_id">
                                            <option value="" class="fs-7">Select Skill</option>
                                            @foreach ($skills as $skill)
                                            <option value="{{ $skill->id }}" class="fs-7"
                                                @if($skill->id == $skill_id) selected @endif>
                                                {{ $skill->title }}
                                            </option>
                                            @endforeach
                                        </select>
                                        @error('skill_id')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{$message}}
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Question</label>
                                    <textarea class="form-control @error('question') is-invalid @enderror"
                                            rows="2" wire:model="question"
                                            placeholder="Enter question"></textarea>
                                    @error('question')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{$message}}
                                        </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Notes</label>
                                    <textarea class="form-control" rows="3" wire:model="notes" placeholder="Additional notes"></textarea>
                                    
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Is Active?</label>
                                    <div>
                                        <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                                        <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                                    </div>
                                </div>

                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                                    <button type="submit" class="btn btn-primary btn-sm px-3 fs-7">
                                        {{$editMode ? 'Update Question' : 'Add Question'}}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        
            <!-- View Oral Interview Modal -->
            <div class="modal fade" id="viewOralModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white d-flex justify-content-center">
                            <h5 class="modal-title w-100 text-center">View Oral Interview</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Competency Level</label>
                                <p class="border p-2 rounded">Intermediate</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Skill</label>
                                <p class="border p-2 rounded">Communication Skills</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Question</label>
                                <p class="border p-2 rounded">
                                    Can you give an example of how you effectively communicated with a team to resolve a complex project challenge?
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notes</label>
                                <p class="border p-2 rounded">
                                    Look for specific details about team collaboration, problem-solving, and communication strategies.
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Is Active?</label>
                                <p class="border p-2 rounded">Yes</p>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Go Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    </section>
</div>

@script
<script>
    $wire.on('hide-oralquestionModal', () => {
        console.log('Hiding oralQuestion modal');
        $('#oralQuestionModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'oralQuestion saved successfully!';
        toast.show();
    });

    $wire.on('show-oralquestionModal', () => {
        console.log('Showing oralQuestion modal');
        $('#oralQuestionModal').modal('show');
    });
</script>
@endscript

@push('styles')
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
@endpush