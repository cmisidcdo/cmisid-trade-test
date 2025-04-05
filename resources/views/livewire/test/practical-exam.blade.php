<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exams</h2>
    </div>

    <div class="card p-3">
        <div class="row align-items-center pt-3 pb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <button class="btn btn-primary" wire:click="showAddEditModal">
                    <i class="bi bi-plus"></i> Add Practical Scenario
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
            <table class="table table-hover table-bordered text-center global-table">
                <thead class="table-light">
                    <tr>
                        <th class="col" style="width: 5%;">#</th>
                        <th scope="col" style="width: 5%;">Attachment</th>
                        <th scope="col" style="width: 50%;">Scenarios</th>
                        <th scope="col">Duration</th>
                        <th scope="col">Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($practicalscenarios as $item)
                        <tr>
                            <td scope="row" class="text-center" style="width: 5%;">{{$loop->iteration}}</td>
                            <td class="text-center" style="width: 5%;">
                                @if($item->file_path)
                                    <a href="{{ asset('storage/' . $item->file_path) }}" download class="text-primary">
                                        <i class="bi bi-paperclip"></i>
                                    </a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td style="width: 50%;">{{$item->scenario}}</td>
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
                                        wire:click='readPracticalScenario({{$item->id}})'
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
            <div>
                {{$practicalscenarios->links()}}
            </div>
        </div>
    </div>

    <!-- Add Practical Test Scenario Modal -->
    <div class="modal fade" id="practicalScenarioModal" tabindex="-1" wire:ignore.self>
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title  w-100 text-center">Add Practical Test Scenario</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" wire:submit.prevent="{{$editMode ? 'updatePracticalScenario' : 'createPracticalScenario'}}" enctype="multipart/form-data">
                        <div class="row">
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
                                <label for="scenario" class="form-label fw-bold fs-7">Scenario</label>
                                <textarea class="form-control form-control-sm fs-7 @error('scenario') is-invalid @enderror" id="scenario" rows="2" wire:model="scenario" placeholder="Enter your scenario here"></textarea>
                                @error('scenario')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{$message}}
                                            </div>
                                @enderror
                            </div>
                            <div class="mb-2">
                                <label for="description" class="form-label fw-bold fs-7">Description</label>
                                <textarea class="form-control form-control-sm fs-7 @error('description') is-invalid @enderror" id="description" rows="2" wire:model="description" placeholder="Enter your description here"></textarea>
                                @error('description')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{$message}}
                                            </div>
                                @enderror
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-6">
                                    <div class="mb-2">

                                        @if ($editMode && $file_path)
                                            <span class="form-label fw-semibold">Uploaded file: </span>
                                            <span class="text-muted text-truncate d-inline-block filename-container" title="{{ basename($file_path) }}">
                                                {{ basename($file_path) }}
                                            </span>
                                            <div class="mt-2 d-flex align-items-center">
                                                <a href="{{ asset('storage/' . $file_path) }}" download class="btn btn-outline-primary btn-sm me-2">
                                                    <i class="bi bi-download"></i> Download
                                                </a>
                                                <a wire:click.prevent="removeFile({{ $practicalscenario_id }})" class="btn btn-outline-danger btn-sm me-2">
                                                    <i class="bi bi-x-circle"></i> Remove
                                                </a>                                                
                                            </div>
                                        @endif              
                                    </div>
                                    
                                    <div class="col mb-2">
                                        <label class="form-label fw-semibold">{{$editMode && $file_path ? 'New ' : ''}}Attachment</label>
                                        <input type="file" class="form-control mb-1" id="addScenarioFileInput" 
                                            wire:model="file" accept=".pdf,.png,.jpg,.jpeg">
                                        <small class="text-muted">Allowed formats: PDF, PNG, JPG</small>
                                    
                                        @error('file')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{$message}}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <label class="form-label fw-semibold">Is Active?</label>
                                        <div>
                                            <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                                            <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                                        </div>
                                    </div>
                                </div>
                            </div>
                            

                           
                        </div>
                        <div class="modal-footer d-flex justify-content-between mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                            <button type="submit" class="btn btn-primary">{{$editMode ? 'Update Scenario' : 'Add Scenario'}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <!-- View Practical Test Scenario Modal -->
    <div class="modal fade" id="viewScenarioModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title  w-100 text-center">View Practical Test Scenario</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Competency Level:</strong>
                            <p>Human Resources</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Choose Skill:</strong>
                            <p>Analytical Thinking</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Point(s):</strong>
                            <p>1</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Time Duration:</strong>
                            <p>00:10:00</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Is Active?</strong>
                            <p>Yes</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Attachment:</strong>
                            <p><i class="bi bi-paperclip"></i> project_file.pdf</p>
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Download</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Scenario:</strong>
                            <p>You are given a partially developed web application with missing functionalities...</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Description:</strong>
                            <p>Debug and fix an issue where users cannot log in despite entering correct credentials...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                </div>
            </div>
        </div>
    </div>

@script
<script>
    $wire.on('hide-practicalscenarioModal', () => {
        console.log('Hiding practicalScenario modal');
        $('#practicalScenarioModal').modal('hide');

        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        document.getElementById('successMessage').textContent = 'practicalScenario saved successfully!';
        toast.show();
    });

    $wire.on('show-practicalscenarioModal', () => {
        console.log('Showing practicalScenario modal');
        $('#practicalScenarioModal').modal('show');
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

<style>
    .filename-container {
    max-width: 200px; 
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    vertical-align: middle;
}
</style>