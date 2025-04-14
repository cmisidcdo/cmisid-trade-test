<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Update Interview Questions</h2>
    </div>

    <section class="section Update Interview Questions">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <div class="row align-items-center pt-3 pb-3">
                    <div class="col-md-6">
                        <label for="position-title" class="form-label">Position Title:</label>
                        <input type="text" id="position-title" class="form-control" value="{{ $position->title ?? 'Position not found' }}" readonly>
                    </div>

                    <div class="col-md-6">
                        <label for="skill-title" class="form-label">Skill Title:</label>
                        <input type="text" id="skill-title" class="form-control" value="{{ $skill->title ?? 'Skill not found' }}" readonly>
                    </div>
                </div>

                <form class="needs-validation" wire:submit.prevent="updateOralQuestions">
                    @foreach($questions as $index => $question)
                    <div class="question-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label for="question_{{ $index }}" class="form-label fw-bold fs-6 text-primary m-0">
                                <strong>Question {{ $loop->iteration }}</strong>
                            </label>
                            <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removeQuestion({{ $index }})" title="Remove this question">
                                <i class="bi bi-trash me-1"></i> Remove Question
                            </button>
                        </div>
                                               
                        <div class="mb-2">
                            <label for="question_{{ $index }}" class="form-label fw-bold fs-7">question</label>
                            <textarea class="form-control form-control-sm fs-7 @error('questions.' . $index . '.question') is-invalid @enderror"
                                id="question_{{ $index }}" rows="2" wire:model.live.debounce.500ms="questions.{{ $index }}.question" placeholder="Enter your question here" maxlength="255"></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($questions[$index]['question'] ?? '') }}</span> / 255
                                </div>
                            @error('questions.' . $index . '.question')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-2">
                            <label for="description_{{ $index }}" class="form-label fw-bold fs-7">Description</label>
                            <textarea class="form-control form-control-sm fs-7 @error('questions.' . $index . '.description') is-invalid @enderror"
                                id="description_{{ $index }}" rows="2" wire:model.live.debounce.500ms="questions.{{ $index }}.description"  maxlength="255" placeholder="Enter your description here"></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($questions[$index]['description'] ?? '') }}</span> / 255
                                </div>
                            @error('questions.' . $index . '.description')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="row mb-2">
                            <div class="col-6">
                                <div class="col mb-2">
                                    <label class="form-label fw-semibold">Attachment</label>
                        
                                    @if (!empty($question['existing_file']))
                                        <p class="text-muted">
                                            <strong>
                                                @if(is_array($question['existing_file']))
                                                    {{ count($question['existing_file']) }}
                                                @else
                                                    1
                                                @endif
                                            </strong> file(s) attached.
                                        </p>
                        
                                        @if(is_array($question['existing_file']))
                                            <ul class="list-unstyled">
                                                @foreach($question['existing_file'] as $file)
                                                    <li>
                                                        {{ pathinfo($file, PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($file, PATHINFO_EXTENSION)) }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <ul class="list-unstyled">
                                                <li>
                                                    {{ pathinfo($question['existing_file'], PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($question['existing_file'], PATHINFO_EXTENSION)) }})
                                                </li>
                                            </ul>
                                        @endif
                        
                                        <div class="mb-1">
             
                                            <a href="{{ Storage::url($question['existing_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> View File
                                            </a>
                        
                                            <a href="{{ Storage::url($question['existing_file']) }}" download class="btn btn-sm btn-outline-secondary ms-2">
                                                <i class="bi bi-download me-1"></i> Download File
                                            </a>
                                               
                                            <button type="button" class="btn btn-sm btn-outline-danger ms-2" wire:click="removeFile({{ $index }})">
                                                <i class="bi bi-trash3 me-1"></i> Remove
                                            </button>
                                                 
                                            <button type="button" class="btn btn-sm btn-outline-warning ms-2" wire:click="toggleReplaceInput({{ $index }})">
                                                <i class="bi bi-arrow-clockwise me-1"></i> Replace
                                            </button>
                                        </div>
                                    @else
                                        <p class="text-muted">No files attached.</p>
                                    @endif
                        
                                    @if (empty($question['existing_file']) || (!empty($replaceFileVisibility[$index]) && $replaceFileVisibility[$index]))
                                        <input type="file"
                                            class="form-control mb-1 @error('questions.' . $index . '.file') is-invalid @enderror"
                                            id="addQuestionFileInput_{{ $index }}"
                                            wire:model="questions.{{ $index }}.file"
                                            accept=".pdf,.png,.jpg,.jpeg">
                                        <small class="text-muted">Allowed formats: PDF, PNG, JPG</small>
                                    @endif
                        
                                    @error('questions.' . $index . '.file')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            
                            
                            
                            <div class="col-6">
                                <label for="timeDuration_{{ $index }}" class="form-label fw-bold fs-7">Time Duration (HH:MM:SS)</label>
                                <div class="d-flex">
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="23" placeholder="HH" wire:model="questions.{{ $index }}.hours" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" placeholder="MM" wire:model="questions.{{ $index }}.minutes" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" placeholder="SS" wire:model="questions.{{ $index }}.seconds" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                </div>
                            </div>
                            
                        </div>

                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 fs-7" wire:click="addQuestion">
                                <i class="bi bi-plus-circle me-1"></i> Add New Question
                            </button>
                        </div>
                    
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm px-3 fs-7">
                                <i class="bi bi-check-circle me-1"></i> Update Questions
                            </button>
                        </div>
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
    </section>
    
</div>
