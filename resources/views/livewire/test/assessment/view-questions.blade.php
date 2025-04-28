<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">View Assessment Questions</h2>
    </div>

    <section class="section Add Assessment Questions">
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

                <form class="needs-validation" wire:submit.prevent="updateAssessmentQuestions">
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

                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="competency_level_{{ $index }}" class="form-label fw-bold fs-7">Competency Level</label>
                                <select class="form-select form-select-sm fs-7" id="competency_level_{{ $index }}" wire:model.defer="questions.{{ $index }}.competency_level" disabled>
                                    <option value="">Select Level</option>
                                    <option value="basic">Basic</option>
                                    <option value="intermediate">Intermediate</option>
                                    <option value="advanced">Advanced</option>
                                </select>
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

                        <div class="mb-3">
                            <label class="form-label fw-bold fs-6">Choices</label>

                            <div class="table-responsive">
                                <table class="table table-hover table-bordered text-center global-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="fs-7">Option</th>
                                            <th class="fs-7 text-center" style="width: 5%;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($question['choices'] as $choiceIndex => $choice)
                                        <tr>
                                            <td>
                                                <input type="text" class="form-control form-control-sm fs-7 @error('questions.' . $index . '.choices.' . $choiceIndex . '.text') is-invalid @enderror"
                                                    value="{{ $choice['text'] }}" readonly>
                                            </td>
                                            <td class="text-center">
                                                <span class="fs-7">
                                                    @if($choice['status'] == 'correct')
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                    @else
                                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                                    @endif
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                    @endforeach
                    
                </form>
                
            </div>
        </div>
    </section>
    
</div>
