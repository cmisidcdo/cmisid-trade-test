<div class="container-fluid p-0">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Assessment Tests</h2>
        </div>
    
        <div class="card-body bg-white p-4">
            <!-- Toolbar with search and buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <button type="button" class="btn btn-primary px-4 shadow-sm" wire:click='showAddEditModal'>
                        <i class="fas fa-plus me-1"></i> Add Assessment Question
                    </button>
                </div>
                <div class="d-flex">
                    <div class="input-group me-2 shadow-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Type to search...">
                        <button class="btn btn-light border-start-0">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary px-3 shadow-sm">
                        <i class="fas fa-filter me-1"></i> SORT
                    </button>
                </div>
            </div>
                
            <!-- Data table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-start" style="width: 30%;">Question</th>
                            <th class="text-center" style="width: 15%;">Competency_level</th>
                            <th class="text-center" style="width: 15%;">Skills</th>
                            <th class="text-center" style="width: 15%;">Time Duration</th>
                            <th class="text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                        <!-- Updated data rows -->
                        <tr>
                            <td class="text-center">1</td>
                            <td class="align-middle">Can you describe your experience...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-info text-white px-3 py-2">Human Resources</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-primary text-white px-3 py-2">Analytical Thinking</span>
                            </td>
                            <td class="text-center align-middle">00:03:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="align-middle">How can you manage the...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-info text-white px-3 py-2">Human Resources</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-success text-white px-3 py-2">Management</span>
                            </td>
                            <td class="text-center align-middle">00:03:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="align-middle">Solve the mathematical equation and...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-warning text-white px-3 py-2">Electrical Engineer</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-danger text-white px-3 py-2">Problem Solving</span>
                            </td>
                            <td class="text-center align-middle">00:10:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody> --}}

                    <tbody>
                        @forelse($assessmentquestions as $item)
                        <tr>
                            <td scope="row" class="text-center" style="width: 5%;">{{$loop->iteration}}</td>
                            <td>{{$item->question}}</td>
                            <td  class="text-center" >
                                <span class="badge rounded-pill 
                                    {{ $item->competency_level == 'basic' ? 'bg-info' : 
                                    ($item->competency_level == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                    {{ ucfirst($item->competency_level) }}
                                </span>
                            </td>
                            <td  class="text-center" >{{$item->skill_title}}</td>
                            <td  class="text-center" >{{$item->formatted_duration}}</td>
                            <td class="d-flex justify-content-center">
                                @can('update reference')
                                <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                    wire:click='readAssessmentQuestion({{$item->id}})'
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Edit Question">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </button>
                                @endcan
                    
                                @can('delete reference')
                                <button class="btn btn-sm {{$item->deleted_at == null ? 'btn-danger' : 'btn-outline-success'}} rounded-2 px-2 py-1"
                                    wire:click="{{$item->deleted_at == null ? 'confirmDelete('.$item->id.')' : 'restoreAssessmentQuestion('.$item->id.')'}}"
                                    data-bs-toggle="tooltip"
                                    data-bs-title="{{$item->deleted_at == null ? 'Move to archive' : 'Restore question'}}">
                                    <i class="bi {{$item->deleted_at == null ? 'bi bi-archive-fill' : 'bi-arrow-counterclockwise'}}"></i>
                                    <span class="d-none d-md-inline ms-1">{{$item->deleted_at == null ? 'Archive' : 'Restore'}}</span>
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
            <div>
                {{$assessmentquestions->links()}}
            </div>    
            <!-- Footer with pagination and record count -->
        </div>
    </div>
    
    <!-- Add Assessment Question Modal -->
    <div class="modal fade" id="assessmentquestionModal" tabindex="-1" aria-labelledby="assessmentquestionModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="assessmentquestionModalLabel">
                        {{$editMode ? 'Update Assessment Question' : 'Add Assessment Question'}}
                    </h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-3 text-sm">
                    <form class="needs-validation" wire:submit="{{$editMode ? 'updateAssessmentQuestion' : 'createAssessmentQuestion'}}">
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="competency_level" class="form-label fw-bold fs-7">Competency Level</label>
                                <select class="form-select form-select-sm fs-7" id="competency_level" wire:model.live="competency_level">
                                    <option value="" class="fs-7">Select Level</option>
                                    @foreach($competency_levels as $level)
                                        <option value="{{ $level }}" class="fs-7">{{ ucfirst($level) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="skill" class="form-label fw-bold fs-7">Choose Skill</label>
                                <select class="form-select form-select-sm fs-7" wire:model="skill_id">
                                    <option value="" class="fs-7">Select Skill</option>
                                    @foreach ($skills as $skill)
                                        <option value="{{ $skill->id }}" class="fs-7"
                                            @if($skill->id == $skill_id) selected @endif>
                                            {{ $skill->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <div class="mb-2">
                            <label for="question" class="form-label fw-bold fs-7">Question</label>
                            <textarea class="form-control form-control-sm fs-7" id="question" rows="2" wire:model="question" placeholder="Enter your question here"></textarea>
                        </div>
    
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="points" class="form-label fw-bold fs-7">Point(s)</label>
                                <select class="form-select form-select-sm fs-7" id="points" wire:model="points">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" class="fs-7">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="timeDuration" class="form-label fw-bold fs-7">Time Duration</label>
                                <div class="input-group input-group-sm">
                                    <input type="text" class="form-control form-control-sm fs-7" id="timeDuration" wire:model="time_duration" placeholder="HH:MM:SS">
                                    <span class="input-group-text fs-7"><i class="far fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-2">
                            <label class="form-label fw-bold fs-7">Is Active?</label>
                            <div class="d-flex">
                                <div class="form-check form-check-sm me-3">
                                    <input class="form-check-input" type="radio" name="isActive" id="activeYes" value="yes" checked wire:model="is_active">
                                    <label class="form-check-label fs-7" for="activeYes">Yes</label>
                                </div>
                                <div class="form-check form-check-sm">
                                    <input class="form-check-input" type="radio" name="isActive" id="activeNo" value="no" wire:model="is_active">
                                    <label class="form-check-label fs-7" for="activeNo">No</label>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-2">
                            <label class="form-label fw-bold fs-7 mb-1">Choices</label>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2" type="radio" name="correctAnswer" id="option1" value="1">
                                        <input type="text" class="form-control form-control-sm fs-7" placeholder="Option 1">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" type="checkbox" id="correct1">
                                        <label class="form-check-label fs-7" for="correct1">Correct</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" type="checkbox" id="incorrect1">
                                        <label class="form-check-label fs-7" for="incorrect1">Incorrect</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1">
                                <div class="col-6">
                                    <div class="d-flex align-items-center">
                                        <input class="form-check-input me-2" type="radio" name="correctAnswer" id="option2" value="2">
                                        <input type="text" class="form-control form-control-sm fs-7" placeholder="Option 2">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" type="checkbox" id="correct2">
                                        <label class="form-check-label fs-7" for="correct2">Correct</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-check form-check-sm">
                                        <input class="form-check-input" type="checkbox" id="incorrect2">
                                        <label class="form-check-label fs-7" for="incorrect2">Incorrect</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-link text-primary p-0 fs-7">
                                <i class="fas fa-plus me-1"></i> Add an Option
                            </button>
                        </div>
    
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-outline-secondary btn-sm px-3 fs-7" data-bs-dismiss="modal">
                                Go Back
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm px-3 fs-7">
                                {{$editMode ? 'Update Question' : 'Add Question'}}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- View Assessment Question Modal -->
<div class="modal fade" id="viewAssessmentModal" tabindex="-1" aria-labelledby="viewAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAssessmentModalLabel">View Assessment Question</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form class="needs-validation" wire:submit="{{$editMode ? 'updateAssessmentQuestion' : 'createAssessmentQuestion'}}">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="viewPosition" class="form-label fw-bold">Add Position</label>
                            <div class="input-group">
                                <select class="form-select form-select-sm" id="viewPosition" disabled>
                                    <option value="human-resources" selected>Human Resources</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="viewSkill" class="form-label fw-bold">Choose Skill</label>
                            <div class="input-group">
                                <select class="form-select form-select-sm" id="viewSkill" disabled>
                                    <option value="analytical-thinking" selected>Analytical Thinking</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label for="viewQuestion" class="form-label fw-bold">Question:</label>
                        <textarea class="form-control form-control-sm" id="viewQuestion" rows="3" disabled>Can you describe your experience...</textarea>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="viewPoints" class="form-label fw-bold">Point(s)</label>
                            <select class="form-select form-select-sm" id="viewPoints" disabled>
                                <option value="1" selected>1</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="viewTimeDuration" class="form-label fw-bold">Time Duration</label>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-sm" id="viewTimeDuration" value="00:03:00" disabled>
                                <span class="input-group-text bg-light">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Is Active?</label>
                        <div class="form-check form-check-inline ms-2">
                            <input class="form-check-input" type="radio" name="viewIsActive" id="viewActiveYes" value="yes" checked disabled>
                            <label class="form-check-label" for="viewActiveYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="viewIsActive" id="viewActiveNo" value="no" disabled>
                            <label class="form-check-label" for="viewActiveNo">No</label>
                        </div>
                    </div>

                    <div class="mb-2">
                        <p class="fw-bold mb-1">Choices:</p>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="viewCorrectAnswer" value="1" checked disabled>
                            </div>
                            <input type="text" class="form-control form-control-sm" value="Option 1" disabled>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="viewCorrectAnswer" value="2" disabled>
                            </div>
                            <input type="text" class="form-control form-control-sm" value="Option 2" disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@script
<script>
    $wire.on('hide-assessmentquestionModal', () => {
        console.log('Hiding assessmentquestion modal');
        $('#assessmentquestionModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'assessmentquestion saved successfully!';
        toast.show();
    });

    $wire.on('show-assessmentquestionModal', () => {
        console.log('Showing assessmentquestion modal');
        $('#assessmentquestionModal').modal('show');
    });

</script>
@endscript