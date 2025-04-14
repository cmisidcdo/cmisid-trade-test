<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Add Practical Scenarios</h2>
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

                <form class="needs-validation" wire:submit.prevent="createPracticalScenarios">
                    @foreach($scenarios as $index => $scenario)
                    <div class="scenario-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                        <div class="mb-2 d-flex justify-content-between align-items-center">
                            <label for="scenario_{{ $index }}" class="form-label fw-bold fs-6 text-primary m-0">
                                <strong>scenario {{ $loop->iteration }}</strong>
                            </label>
                            <button type="button" class="btn btn-outline-danger btn-sm" wire:click="removeScenario({{ $index }})" title="Remove this scenario">
                                <i class="bi bi-trash me-1"></i> Remove Scenario
                            </button>
                        </div>
                                               
                        <div class="mb-2">
                            <label for="scenario_{{ $index }}" class="form-label fw-bold fs-7">Scenario</label>
                            <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $index . '.scenario') is-invalid @enderror"
                                id="scenario_{{ $index }}" rows="2" wire:model.live.debounce.500ms="scenarios.{{ $index }}.scenario"  maxlength="255" placeholder="Enter your scenario here"></textarea>
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
                            <label for="description_{{ $index }}" class="form-label fw-bold fs-7">Description</label>
                            <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $index . '.description') is-invalid @enderror"
                                id="description_{{ $index }}" rows="2" wire:model.live.debounce.500ms="scenarios.{{ $index }}.description"  maxlength="255" placeholder="Enter your description here"></textarea>
                                <div class="text-end small text-muted">
                                    <span id="char-count-{{ $index }}">{{ strlen($scenarios[$index]['description'] ?? '') }}</span> / 255
                                </div>
                            @error('scenarios.' . $index . '.description')
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
                                    <input type="file"
                                        class="form-control mb-1 @error('scenarios.' . $index . '.file') is-invalid @enderror"
                                        id="addScenarioFileInput_{{ $index }}" 
                                        wire:model="scenarios.{{ $index }}.file" 
                                        accept=".pdf,.png,.jpg,.jpeg">
                                    <small class="text-muted">Allowed formats: PDF, PNG, JPG</small>
                            
                                    @error('scenarios.' . $index . '.file')
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
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="23" placeholder="HH" wire:model="scenarios.{{ $index }}.hours" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" placeholder="MM" wire:model="scenarios.{{ $index }}.minutes" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                    <span class="mx-1">:</span>
                                    <input type="number" class="form-control form-control-sm fs-7" min="0" max="59" placeholder="SS" wire:model="scenarios.{{ $index }}.seconds" style="max-width: 70px;" maxlength="2" oninput="this.value = this.value.slice(0, 2);">
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @endforeach

                    <div class="d-flex justify-content-between mt-3">
                        <div>
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 fs-7" wire:click="addScenario">
                                <i class="bi bi-plus-circle me-1"></i> Add New Scenario
                            </button>
                        </div>
                    
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm px-3 fs-7">
                                <i class="bi bi-check-circle me-1"></i> Add Scenarios
                            </button>
                        </div>
                    </div>
                    
                    
                </form>
                
            </div>
        </div>
    </section>
    
</div>
