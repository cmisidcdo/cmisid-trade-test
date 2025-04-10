<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">View Practical Scenarios</h2>
    </div>

    <section class="section Add Practical Scenarios">
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

                <form class="needs-validation" wire:submit.prevent>
                    @foreach($scenarios as $index => $scenario)
                    <div class="scenario-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label for="scenario_{{ $index }}" class="form-label fw-bold fs-6 text-primary m-0">
                                <strong>Scenario {{ $loop->iteration }}</strong>
                            </label>
                        </div>
                                               
                        <div class="mb-2">
                            <label for="scenario_{{ $index }}" class="form-label fw-bold fs-7">Scenario</label>
                            <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $index . '.scenario') is-invalid @enderror"
                                id="scenario_{{ $index }}" rows="2" wire:model.live="scenarios.{{ $index }}.scenario" placeholder="Enter your scenario here" maxlength="255" readonly></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($scenarios[$index]['scenario'] ?? '') }}</span> / 255
                                </div>
                            @error('scenarios.' . $index . '.scenario')
                                <div class="invalid-feedback">
                                    <i class="bi bi-exclamation-circle me-1"></i>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-2">
                            <label for="scenario_{{ $index }}" class="form-label fw-bold fs-7">Description</label>
                            <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $index . '.description') is-invalid @enderror"
                                id="scenario_{{ $index }}" rows="2" wire:model.live="scenarios.{{ $index }}.description" placeholder="Enter your description here" maxlength="255" readonly></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($scenarios[$index]['description'] ?? '') }}</span> / 255
                                </div>
                            @error('scenarios.' . $index . '.scenario')
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
                        
                                    @if (!empty($scenario['existing_file']))
                                        <p class="text-muted">
                                            <strong>
                                                @if(is_array($scenario['existing_file']))
                                                    {{ count($scenario['existing_file']) }}
                                                @else
                                                    1
                                                @endif
                                            </strong> file(s) attached.
                                        </p>
                        
                                        @if(is_array($scenario['existing_file']))
                                            <ul class="list-unstyled">
                                                @foreach($scenario['existing_file'] as $file)
                                                    <li>
                                                        {{ pathinfo($file, PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($file, PATHINFO_EXTENSION)) }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <ul class="list-unstyled">
                                                <li>
                                                    {{ pathinfo($scenario['existing_file'], PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($scenario['existing_file'], PATHINFO_EXTENSION)) }})
                                                </li>
                                            </ul>
                                        @endif
                        
                                        <div class="mb-1">
             
                                            <a href="{{ Storage::url($scenario['existing_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="bi bi-eye me-1"></i> View File
                                            </a>
                        
                                            <a href="{{ Storage::url($scenario['existing_file']) }}" download class="btn btn-sm btn-outline-secondary ms-2">
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
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $scenarios[$index]['hours'] ?? '00' }}" readonly style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $scenarios[$index]['minutes'] ?? '00' }}" readonly style="max-width: 70px;">
                                    <span class="mx-1">:</span>
                                    <input type="text" class="form-control form-control-sm fs-7" value="{{ $scenarios[$index]['seconds'] ?? '00' }}" readonly style="max-width: 70px;">
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
