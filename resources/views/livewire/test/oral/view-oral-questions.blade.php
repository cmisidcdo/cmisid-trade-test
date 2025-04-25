<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">View Interview Questions</h2>
    </div>

    <section class="section Add Interview Questions">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                    <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                    {{ $archive ? 'General' : 'View Archive' }}
                </button>

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

                <form class="needs-validation" wire:submit.prevent>
                    @foreach($questions as $index => $question)
                    <div class="question-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label for="question_{{ $index }}" class="form-label fw-bold fs-6 {{$archive ? 'text-danger' : 'text-primary'}} m-0">
                                <strong>Question {{ $loop->iteration }}</strong>
                            </label>
                        </div>
                                               
                        <div class="mb-2">
                            <label for="question_{{ $index }}" class="form-label fw-bold fs-7">Question</label>
                            <textarea class="form-control form-control-sm fs-7 @error('questions.' . $index . '.question') is-invalid @enderror"
                                id="question_{{ $index }}" rows="2" wire:model.live="questions.{{ $index }}.question" placeholder="Enter your question here" maxlength="255" readonly></textarea>
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
                            <label for="question_{{ $index }}" class="form-label fw-bold fs-7">Description</label>
                            <textarea class="form-control form-control-sm fs-7 @error('questions.' . $index . '.description') is-invalid @enderror"
                                id="question_{{ $index }}" rows="2" wire:model.live="questions.{{ $index }}.description" placeholder="Enter your description here" maxlength="255" readonly></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($questions[$index]['description'] ?? '') }}</span> / 255
                                </div>
                            @error('questions.' . $index . '.question')
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
                                        </div>
                                    @else
                                        <p class="text-muted">No files attached.</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="timeDuration_{{ $index }}" class="form-label fw-bold fs-7">Time Duration (HH:MM:SS)</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $questions[$index]['hours'] ?? '00' }}" readonly style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $questions[$index]['minutes'] ?? '00' }}" readonly style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $questions[$index]['seconds'] ?? '00' }}" readonly style="max-width: 70px;">
                                </div>
                            </div>
                        </div>

                    </div>
                    @endforeach
                    
                </form>
                
            </div>
        </div>
    </section>
    
</div>
