<div class="container-fluid p-0">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Assessment Tests</h2>
        </div>

        <div class="card-body bg-white p-4">

            <div class="row align-items-center pt-3 pb-3">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <button class="btn btn-primary" wire:click="showAddEditModal">
                        <i class="bi bi-plus"></i> Assessment Question
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

            <!-- Data table -->
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center global-table">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-start" style="width: 30%;">Question</th>
                            <th class="text-center" style="width: 15%;">Competency level</th>
                            <th class="text-center" style="width: 10%;">Skills</th>
                            <th class="text-center" style="width: 10%;">Duration</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-center" style="width: 15%;">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($assessmentquestions as $item)
                        <tr>
                            <td scope="row" class="text-center" style="width: 5%;">{{$loop->iteration}}</td>
                            <td>{{$item->question}}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill 
                                    {{ $item->competency_level == 'basic' ? 'bg-info' : 
                                    ($item->competency_level == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                    {{ ucfirst($item->competency_level) }}
                                </span>
                            </td>

                            <td  class="text-center" >{{$item->skill_title}}</td>
                            <td  class="text-center" >{{$item->formatted_duration}}</td>
                            <td class="text-center">
                                <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                                    {{$item->deleted_at == Null ? 'Active': 'Inactive'}}
                                </span>
                            </td>

                            <td class="d-flex justify-content-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <button class="btn btn-sm btn-info rounded-2 px-2 py-1"
                                        wire:click='showViewModal({{$item->id}})'
                                        data-bs-title="View Question">
                                        <i class="bi bi-eye"></i>
                                        <span class="d-none d-md-inline ms-1">View</span>
                                    </button>

                                    @can('update reference')
                                    <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                                        wire:click='readAssessmentQuestion({{$item->id}})'
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
                            <td colspan="7" class="text-center py-4 text-muted">
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
                    <form class="needs-validation" wire:submit.prevent="{{$editMode ? 'updateAssessmentQuestion' : 'createAssessmentQuestion'}}">
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
                                <select class="form-select form-select-sm fs-7 @error('skill_id') is-invalid @enderror" wire:model="skill_id">
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

                        <div class="mb-2">
                            <label for="question" class="form-label fw-bold fs-7">Question</label>
                            <textarea class="form-control form-control-sm fs-7 @error('question') is-invalid @enderror" id="question" rows="2" wire:model="question" placeholder="Enter your question here"></textarea>
                            @error('question')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{$message}}
                                        </div>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="points" class="form-label fw-bold fs-7">Point(s)</label>
                                <select class="form-select form-select-sm fs-7" id="points" wire:model.defer="points">
                                    @for ($i = 1; $i <= 10; $i++)
                                        <option value="{{ $i }}" class="fs-7">{{ $i }}</option>
                                        @endfor
                                </select>
                                
                            </div>

                            <div class="col-md-6">
                                <label for="timeDuration" class="form-label fw-bold">Time Duration (HH:MM:SS)</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="23" 
                                           placeholder="HH" wire:model="hours" style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" 
                                           placeholder="MM" wire:model="minutes" style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" 
                                           placeholder="SS" wire:model="seconds" style="max-width: 70px;">
                                </div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold">Is Active?</label>
                            <div>
                                <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                                <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-bold fs-6">Choices</label>
                        
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered text-center global-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fs-7">Option</th>
                                            <th class="fs-7 text-center">Correct</th>
                                            <th class="fs-7 text-center">Incorrect</th>
                                            <th class="fs-7 text-center">Remove</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($choices as $index => $choice)
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control form-control-sm fs-7 @error('choices.' . $index . '.text') is-invalid @enderror"
                                                        placeholder="Option {{ $index + 1 }}" wire:model="choices.{{ $index }}.text">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="choices[{{ $index }}][status]" value="correct" 
                                                        wire:model="choices.{{ $index }}.status">
                                                </td>
                                                <td class="text-center">
                                                    <input class="form-check-input" type="radio" name="choices[{{ $index }}][status]" value="incorrect" 
                                                        wire:model="choices.{{ $index }}.status" checked>
                                                </td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removeChoice({{ $index }})">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    
                                </table>
                            </div>
                        
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" wire:click="addChoice">
                                <i class="fas fa-plus me-1"></i> Add an Option
                            </button>
                        </div>
                        
    
                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary btn-sm px-3 fs-7" data-bs-dismiss="modal">
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


    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title fw-bold text-center w-100 fs-5" id="viewModalLabel">
                        View Assessment Question
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body px-4">
                    <!-- Question Details -->
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2">Question Details</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="mb-2"><span class="fw-semibold">Skill:</span> {{$title}}</p>
                                <p class="mb-2"><span class="fw-semibold">Points:</span> {{$points}}</p>
                                <p class="mb-2"><span class="fw-semibold">Duration:</span> {{$vduration}}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="mb-2">
                                    <span class="fw-semibold">Competency Level:</span>
                                    <span class="badge rounded-pill 
                                        {{ strtolower($competency_level) == 'basic' ? 'bg-info' : 
                                        (strtolower($competency_level) == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                        {{ $competency_level }}
                                    </span>
                                </p>
                    
                                <p class="mb-2">
                                    <span class="fw-semibold">Status:</span>
                                    <span class="badge rounded-pill {{ $status === 'yes' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $status === 'yes' ? 'Active' : 'Inactive' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
    
                    <!-- Question -->
                    <div class="mb-4">
                        <h6 class="fw-bold border-bottom pb-2">Question</h6>
                        <p class="mb-0">{{$this->question}}</p>
                    </div>
    
                    <!-- Options Table -->
                    <div class="border-top pt-3">
                        <h6 class="fw-bold mb-3">Options</h6>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered text-center global-table">
                                <thead class="table-light">
                                    <tr>
                                        <th class="fw-semibold text-center" style="width: 5%;">#</th>
                                        <th class="fw-semibold">Detail</th>
                                        <th class="fw-semibold text-center" style="width: 15%;">Correct</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($choices as $index => $choice)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td class="fw-medium">{{ $choice['text'] }}</td>
                                        <td class="text-center">
                                            <span class="badge rounded-pill {{ $choice['status'] ? 'bg-success' : 'bg-danger' }}">
                                                {{ $choice['status'] ? 'Yes' : 'No' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-3 text-muted">
                                                <i class="bi bi-info-circle me-1"></i> No choices available.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
    
                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-1"></i> Close
                        </button>
                    </div>
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

        $wire.on('hide-viewModal', () => {
            console.log('Hiding view modal');
            $('#viewModal').modal('hide');

            const toast = new bootstrap.Toast(document.getElementById('successToast'));
            document.getElementById('successMessage').textContent = 'view saved successfully!';
            toast.show();
        });

        $wire.on('show-viewModal', () => {
            console.log('Showing view modal');
            $('#viewModal').modal('show');
        });
    </script>
    @endscript