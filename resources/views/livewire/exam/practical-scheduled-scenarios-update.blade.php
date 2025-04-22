<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Update Scheduled Practical Scenarios</h2>
    </div>

    <section class="section Update Practical Scenarios">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('exam.practicallist') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Assigned Practicals
                    </a>
                
                    <button type="button"
                        class="btn {{ $archive ? 'btn-secondary' : 'btn-success' }}"
                        wire:click.prevent="toggleArchive">
                        <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
                        {{ $archive ? 'Return' : 'Add Existing Scenarios' }}
                    </button>
                </div>                
                
                <div class="row align-items-center pt-3 pb-3">
                    <div class="col-md-6">
                        <label for="position-title" class="form-label">Position Title:</label>
                        <input type="text" id="position-title" class="form-control" value="{{ $position->title ?? 'Position not found' }}" readonly>
                    </div>            
                </div>

                <form class="needs-validation" wire:submit.prevent="updatePracticalScenarios">
                    @foreach($scenarios as $key => $scenario)
                        <div wire:key="scenario-{{ $scenario['id'] ?? $key }}">
                            <div class="scenario-set mb-4 p-3 border rounded-3" style="border: 2px solid #ddd;">
                                <div class="mb-2 d-flex justify-content-between align-items-center">
                                    <label for="scenario_{{ $key }}" class="form-label fw-bold fs-6 {{ $archive ? 'text-danger' : 'text-primary' }} m-0">
                                        <strong>Scenario {{ $loop->iteration }}</strong>
                                    </label>
                
                                    <button type="button" class="btn {{ $archive ? 'btn-outline-success' : 'btn-outline-danger' }} btn-sm"
                                        wire:click.prevent="{{ $archive ? 'addExistingScenario(' . $key . ')' : 'removeScenario(' . $key . ')' }}"
                                        title="{{ $archive ? 'Add this scenario' : 'Remove this scenario' }}">
                                        <i class="bi bi-trash me-1"></i> {{ $archive ? 'Add Scenario' : 'Remove Scenario' }}
                                    </button>
                                </div>
                
                                <div class="mb-2">
                                    <div class="col-6">
                                        <label for="skill_{{ $key }}" class="form-label fw-bold fs-7">Skill</label>
                
                                        @if (!empty($scenarios[$key]['skill_id']) && !empty($scenarios[$key]['skill_title']))
                                            <input type="text" 
                                                class="form-control form-control-sm fs-7" 
                                                value="{{ data_get($scenarios[$key], 'skill_title', '') }}"
                                                readonly
                                                @if($archive) disabled @endif>
                                        @else
                                            <select 
                                                id="skill_{{ $key }}" 
                                                class="form-select form-select-sm fs-7 @error('scenarios.' . $key . '.skill_id') is-invalid @enderror" 
                                                wire:model="scenarios.{{ $key }}.skill_id" 
                                                @if($archive) disabled @endif>
                                                <option value="">-- Select Skill --</option>
                                                @foreach($skills as $skill)
                                                    <option value="{{ $skill['skill_id'] }}">{{ $skill['title'] }}</option>
                                                @endforeach
                                            </select>
                                        @endif
                
                                        @error('scenarios.' . $key . '.skill_id')
                                            <div class="invalid-feedback">
                                                <i class="bi bi-exclamation-circle me-1"></i>
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                
                                <div class="mb-2">
                                    <label for="scenario_{{ $key }}" class="form-label fw-bold fs-7">Scenario</label>
                                    <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $key . '.scenario') is-invalid @enderror"
                                        id="scenario_{{ $key }}" rows="2" wire:model.live.debounce.500ms="scenarios.{{ $key }}.scenario"
                                        placeholder="Enter your scenario here" maxlength="255" @if($archive) readonly @endif></textarea>
                                    <div class="text-end small text-muted">
                                        <span id="char-count-{{ $key }}">{{ strlen($scenarios[$key]['scenario'] ?? '') }}</span> / 255
                                    </div>
                                    @error('scenarios.' . $key . '.scenario')
                                        <div class="invalid-feedback">
                                            <i class="bi bi-exclamation-circle me-1"></i>
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                
                                <div class="mb-2">
                                    <label for="description_{{ $key }}" class="form-label fw-bold fs-7">Description</label>
                                    <textarea class="form-control form-control-sm fs-7 @error('scenarios.' . $key . '.description') is-invalid @enderror"
                                        id="description_{{ $key }}" rows="2" wire:model.live.debounce.500ms="scenarios.{{ $key }}.description"
                                        maxlength="255" placeholder="Enter your description here" @if($archive) readonly @endif></textarea>
                                    <div class="text-end small text-muted">
                                        <span id="char-count-{{ $key }}">{{ strlen($scenarios[$key]['description'] ?? '') }}</span> / 255
                                    </div>
                                    @error('scenarios.' . $key . '.description')
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
                                                            <li>{{ pathinfo($file, PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($file, PATHINFO_EXTENSION)) }})</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <ul class="list-unstyled">
                                                        <li>{{ pathinfo($scenario['existing_file'], PATHINFO_BASENAME) }} ({{ strtoupper(pathinfo($scenario['existing_file'], PATHINFO_EXTENSION)) }})</li>
                                                    </ul>
                                                @endif
                
                                                <div class="mb-1">
                                                    <a href="{{ Storage::url($scenario['existing_file']) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                        <i class="bi bi-eye me-1"></i> View File
                                                    </a>
                
                                                    <a href="{{ Storage::url($scenario['existing_file']) }}" download class="btn btn-sm btn-outline-secondary ms-2">
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
                
                                            @if(!$archive && (empty($scenario['existing_file']) || (!empty($replaceFileVisibility[$key]) && $replaceFileVisibility[$key])))
                                                <input type="file"
                                                    class="form-control mb-1 @error('scenarios.' . $key . '.file') is-invalid @enderror"
                                                    id="addScenarioFileInput_{{ $key }}"
                                                    wire:model="scenarios.{{ $key }}.file"
                                                    accept=".pdf,.png,.jpg,.jpeg"
                                                    @if($archive) disabled @endif>
                                                <small class="text-muted">Allowed formats: PDF, PNG, JPG</small>
                                            @endif
                
                                            @error('scenarios.' . $key . '.file')
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
                                                placeholder="HH" wire:model="scenarios.{{ $key }}.hours"
                                                style="max-width: 70px;" maxlength="2"
                                                oninput="this.value = this.value.slice(0, 2);"
                                                @if($archive) readonly @endif>
                                            <span class="mx-1">:</span>
                                            <input type="number" class="form-control form-control-sm fs-7" min="0" max="59"
                                                placeholder="MM" wire:model="scenarios.{{ $key }}.minutes"
                                                style="max-width: 70px;" maxlength="2"
                                                oninput="this.value = this.value.slice(0, 2);"
                                                @if($archive) readonly @endif>
                                            <span class="mx-1">:</span>
                                            <input type="number" class="form-control form-control-sm fs-7" min="0" max="59"
                                                placeholder="SS" wire:model="scenarios.{{ $key }}.seconds"
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
                            <button type="button" class="btn btn-outline-primary btn-sm px-3 fs-7" wire:click="addScenario">
                                <i class="bi bi-plus-circle me-1"></i> Add New Scenario
                            </button>
                        </div>
                
                        <div>
                            <button type="submit" class="btn btn-primary btn-sm px-3 fs-7">
                                <i class="bi bi-check-circle me-1"></i> Update Scenarios
                            </button>
                        </div>
                    </div>
                    @endif
                </form>             
            </div>
        </div>
    </section>
    
</div>
