<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Update Scheduled Oral Questions</h2>
    </div>

    <section class="section Update Oral Questions">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('exam.interviewlist') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Assigned Orals
                    </a>
                
                    <button type="button"
                        class="btn {{ $archive ? 'btn-secondary' : 'btn-success' }}"
                        wire:click.prevent="toggleArchive">
                        <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                        {{ $archive ? 'Return' : 'Add Existing Questions' }}
                    </button>
                </div>                
                
                <div class="row align-items-center pt-3 pb-3">
                    <div class="col-md-6">
                        <label for="position-title" class="form-label">Position Title:</label>
                        <input type="text" id="position-title" class="form-control" value="{{ $position->title ?? 'Position not found' }}" readonly>
                    </div>            
                </div>

                <form class="needs-validation" wire:submit.prevent="updateOralQuestions">
                    @foreach($questions as $key => $question)
                        <div wire:key="question-{{ $question['id'] ?? $key }}">
                            <div class="question-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <label for="question_{{ $key }}" class="form-label fw-bold fs-6 {{ $archive ? 'text-danger' : 'text-primary' }} m-0">
                                        <strong>Question {{ $loop->iteration }}</strong>
                                    </label>
                
                                    <button type="button" class="btn {{ $archive ? 'btn-outline-success' : 'btn-outline-danger' }} btn-sm"
                                        wire:click.prevent="{{ $archive ? 'addExistingQuestion(' . $key . ')' : 'removeQuestion(' . $key . ')' }}"
                                        title="{{ $archive ? 'Add this question' : 'Remove this question' }}">
                                        <i class="bi bi-trash me-1"></i> {{ $archive ? 'Add Question' : 'Remove Question' }}
                                    </button>
                                </div>
                
                                <div class="mb-2">
                                    <div class="col-6">
                                        <label for="skill_{{ $key }}" class="form-label fw-bold fs-7">Skill</label>
                
                                        @if (!empty($questions[$key]['skill_id']) && !empty($questions[$key]['skill_title']))
                                            <input type="text" 
                                                class="form-control form-control-sm fs-7" 
                                                value="{{ data_get($questions[$key], 'skill_title', '') }}"
                                                readonly
                                                @if($archive) disabled @endif>
                                        @else
                                            <select 
                                                id="skill_{{ $key }}" 
                                                class="form-select form-select-sm fs-7 @error('questions.' . $key . '.skill_id') is-invalid @enderror" 
                                                wire:model="questions.{{ $key }}.skill_id" 
                                                @if($archive) disabled @endif>
                                                <option value="">-- Select Skill --</option>
                                                @foreach($skills as $skill)
                                                    <option value="{{ $skill['skill_id'] }}">{{ $skill['title'] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                
                                        @error('questions.' . $key . '.skill_id')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                
                                <div class="mb-2">
                                    <label for="question_{{ $key }}" class="form-label fw-bold fs-7">Question</label>
                                    <textarea class="form-control form-control-sm fs-7 @error('questions.' . $key . '.question') is-invalid @enderror"
                                        id="question_{{ $key }}" rows="2" wire:model.live.debounce.500ms="questions.{{ $key }}.question"
                                        placeholder="Enter your question here" maxlength="255" @if($archive) readonly @endif></textarea>
                                    <div class="text-end small text-muted">
                                        <span id="char-count-{{ $key }}">{{ strlen($questions[$key]['question'] ?? '') }}</span> / 255
                                    </div>
                                    @error('questions.' . $key . '.question')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                
                                <div class="mb-2">
                                    <label for="description_{{ $key }}" class="form-label fw-bold fs-7">Description</label>
                                    <textarea class="form-control form-control-sm fs-7 @error('questions.' . $key . '.description') is-invalid @enderror"
                                        id="description_{{ $key }}" rows="2" wire:model.live.debounce.500ms="questions.{{ $key }}.description"
                                        maxlength="255" placeholder="Enter your description here" @if($archive) readonly @endif></textarea>
                                    <div class="text-end small text-muted">
                                        <span id="char-count-{{ $key }}">{{ strlen($questions[$key]['description'] ?? '') }}</span> / 255
                                    </div>
                                    @error('questions.' . $key . '.description')
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
                                                            <li>{{ pathinfo($file, PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($file, PATHINFO_EXTENSION)) }})</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <ul class="list-unstyled">
                                                        <li>{{ pathinfo($question['existing_file'], PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($question['existing_file'], PATHINFO_EXTENSION)) }})</li>
                                                    </ul>
                                                @endif
                
                                                <div class="mb-1">
                                                    <a href="{{ Storage::url($question['existing_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i> View File
                                                    </a>
                
                                                    <a href="{{ Storage::url($question['existing_file']) }}" download class="btn btn-sm btn-outline-secondary ms-2">
                                                        <i class="bi bi-download me-1"></i> Download File
                                                    </a>
                
                                                    @if(!$archive)
                                                        <button type="button" class="btn btn-sm btn-outline-danger ms-2" wire:click="removeFile({{ $key }})">
                                                            <i class="bi bi-trash3 me-1"></i> Remove
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-outline-warning ms-2" wire:click="toggleReplaceInput({{ $key }})">
                                                            <i class="bi bi-arrow-clockwise me-1"></i> Replace
                                                        </button>
                                                    @endif
                                                </div>
                                            @else
                                                <p class="text-muted">No files attached.</p>
                                            @endif
                
                                            @if(!$archive && (empty($question['existing_file']) || (!empty($replaceFileVisibility[$key]) && $replaceFileVisibility[$key])))
                                                <input type="file"
                                                    class="form-control mb-1 @error('questions.' . $key . '.file') is-invalid @enderror"
                                                    id="addquestionFileInput_{{ $key }}"
                                                    wire:model="questions.{{ $key }}.file"
                                                    accept=".pdf,.png,.jpg,.jpeg"
                                                    @if($archive) disabled @endif>
                                                <small class="text-muted">Allowed formats: PDF, PNG, JPG</small>
                                            @endif
                
                                            @error('questions.' . $key . '.file')
                                                <div class="invalid-feedback">
                                                    <i class="bi bi-exclamation-circle me-1"></i>
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                
                                    <div class="col-6">
                                        <label for="timeDuration_{{ $key }}" class="form-label fw-bold fs-7">Time Duration (HH:MM:SS)</label>
                                        <div class="d-flex">
                                            <input type="number" class="form-control form-control-sm fs-7" min="0" max="23"
                                                placeholder="HH" wire:model="questions.{{ $key }}.hours"
                                                style="max-width: 70px;" maxlength="2"
                                                oninput="this.value = this.value.slice(0, 2);"
                                                @if($archive) readonly @endif>
                                            <span class="mx-1">:</span>
                                            <input type="number" class="form-control form-control-sm fs-7" min="0" max="59"
                                                placeholder="MM" wire:model="questions.{{ $key }}.minutes"
                                                style="max-width: 70px;" maxlength="2"
                                                oninput="this.value = this.value.slice(0, 2);"
                                                @if($archive) readonly @endif>
                                            <span class="mx-1">:</span>
                                            <input type="number" class="form-control form-control-sm fs-7" min="0" max="59"
                                                placeholder="SS" wire:model="questions.{{ $key }}.seconds"
                                                style="max-width: 70px;" maxlength="2"
                                                oninput="this.value = this.value.slice(0, 2);"
                                                @if($archive) readonly @endif>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                
                    @if(!$archive)
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
                    @endif
                </form>             
            </div>
        </div>
    </section>
    
</div>
