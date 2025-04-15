<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exams</h2>
    </div>

    <div class="card p-3">
        <div class="row align-items-center pt-3 pb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary" wire:click="showAddEditModal">
                        <i class="bi bi-plus"></i> Practical Scenario
                    </button>
        
                    <button class="btn btn-outline-secondary"
                            wire:click="refreshTable"
                            wire:loading.attr="disabled"
                            wire:target="refreshTable">
                        <span wire:loading.remove wire:target="refreshTable">
                            <i class="bi bi-arrow-clockwise"></i> Refresh
                        </span>
                        <span wire:loading wire:target="refreshTable">
                            <span class="spinner-border spinner-border-sm text-primary" role="status"></span>
                            Loading...
                        </span>
                    </button>
                </div>
        
                <div class="d-flex gap-2">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0 ps-0"
                               placeholder="Search position..."
                               wire:model.live.debounce.300ms="search"
                               aria-label="Search position">
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
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center global-table">
                <thead style="background-color: #f8f9fa;">
                    <tr>
                        <th class="text-center" style="width: 5%;">#</th>
                        <th class="text-center">Position</th>
                        <th class="text-center" style="width: 15%;">Actions</th>
                    </tr>
                </thead>
        
                <tbody>
                    @forelse($practicalscenarios as $item)
                    <tr>
                        <td class="text-center fw-medium align-middle">{{ $loop->iteration }}</td>
                        <td class="fw-bold align-middle">{{ $item->position_title }}</td>
                        <td style="width: 15%;">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <button class="btn btn-sm btn-info rounded-2"
                                    wire:click='viewPracticalScenario({{$item->position_id}})'
                                    data-bs-title="View Scenarios">
                                    <i class="bi bi-eye"></i>
                                    <span class="d-none d-md-inline ms-1">View</span>
                                </button>
        
                                @can('update reference')
                                <button class="btn btn-sm btn-primary rounded-2"
                                    wire:click='readPracticalScenario({{$item->position_id}})'
                                    data-bs-toggle="tooltip"
                                    data-bs-title="Edit Scenarios">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </button>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                            No scenarios found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div>
            {{$practicalscenarios->links(data: ['scrollTo' => false])}}
        </div>
    </div>

    <div class="modal fade" id="practicalScenarioModal" tabindex="-1" aria-labelledby="practicalScenarioModalLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="practicalScenarioModalLabel">
                        {{ $editMode ? 'Update Practical Scenarios' : ($viewMode ? 'View Practical Scenarios' : 'Add Practical Scenarios') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-2" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
    
                <div class="modal-body p-3 text-sm">
    
                    @if (session()->has('success'))
                        <div class="alert alert-success alert-dismissible fade show fs-7 py-1 px-2" role="alert">
                            <i class="bi bi-check-circle-fill me-1"></i> {{ session('success') }}
                            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
    
                    <form wire:submit.prevent>
                        <div class="row mb-2">
                            <div class="col-6">
                                <label for="position_id" class="form-label fw-bold fs-7">Position</label>
                                <select class="form-select form-select-sm fs-7 @error('position_id') is-invalid @enderror" id="position_id" wire:model.live="position_id">
                                    <option value="">Select Position</option>
                                    @foreach($positions as $pos)
                                        <option 
                                            value="{{ $pos->id }}" 
                                            @if($position_id == $pos->id) selected @endif>
                                            {{ $pos->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
    
                        <table class="table table-hover table-bordered text-center global-table">
                            <thead class="table-light">
                                <tr>
                                    <th class="fw-semibold" style="width:5%">#</th>
                                    <th class="fw-semibold">Skill Title</th>
                                    <th class="fw-semibold" style="width:20%">Competency Level</th>
                                    <th class="fw-semibold" style="width:20%">Total Scenarios</th>
                                    <th class="fw-semibold text-center" style="width:15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($skills as $item)
                                <tr>
                                    <td scope="row" class="text-center" style="width:5%">{{ $loop->iteration }}</td>
                                    <td class="fw-medium">{{ $item['title'] }}</td> 
                                    <td class="fw-medium" style="width:20%">
                                        <span class="badge rounded-pill 
                                            {{  $item['competency_level'] == 'basic' ? 'bg-info' : 
                                            ($item['competency_level'] == 'intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                            {{ ucfirst($item['competency_level']) }}
                                        </span>
                                    </td>
                                    <td class="fw-medium text-center" style="width:20%">
                                        {{ $item['scenario_count'] ?? 0 }}
                                    </td>
                                    <td class="text-center" style="width:15%">
                                        <button
                                            class="btn {{$editMode ? 'btn-primary' : ($viewMode ? 'btn-info' : 'btn-success')}} btn-sm"
                                            wire:click="{{ $editMode ? 'updateScenarios(' . $position_id . ', ' . $item['id'] . ')' : ($viewMode ? 'viewScenarios(' . $position_id . ', ' . $item['id'] . ')' : 'addScenarios(' . $position_id . ', ' . $item['id'] . ')') }}">
                                            <i class="bi {{ $editMode ? 'bi-pencil-fill' : ($viewMode ? 'bi-eye' : 'bi-plus-circle') }} me-1"></i>
                                            {{ $editMode ? 'Update' : ($viewMode ? 'View' : 'Add') }}
                                        </button>
                                    </td>                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="bi bi-info-circle me-1"></i> No skills available.
                                    </td>
                                </tr>
                            @endforelse
                            
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary btn-sm px-3 fs-7" data-bs-dismiss="modal">
                                Go Back
                            </button>
                        </div>
    
                    </form>
                </div>
            </div>
        </div>
    </div>

@script
<script>
    $wire.on('hide-practicalscenarioModal', () => {
        $('#practicalScenarioModal').modal('hide');
    });

    $wire.on('show-practicalscenarioModal', () => {
        $('#practicalScenarioModal').modal('show');
    });

        Livewire.on('open-new-tab', (data = {}) => {
            const { position_id, skill_id } = data;

            if (position_id && skill_id) {
                const newTab = window.open(`/test/practical/addscenarios?position_id=${position_id}&skill_id=${skill_id}`, '_blank');
            } else {
                console.log('Invalid data received.');
            }
        });  

        Livewire.on('open-new-update-tab', (data = {}) => {
            const { position_id, skill_id } = data;

            if (position_id && skill_id) {
                const newTab = window.open(`/test/practical/updatescenarios?position_id=${position_id}&skill_id=${skill_id}`, '_blank');
            } else {
                console.log('Invalid data received.');
            }
        });      

        Livewire.on('open-new-view-tab', (data = {}) => {
            const { position_id, skill_id } = data;

            if (position_id && skill_id) {
                const newTab = window.open(`/test/practical/viewscenarios?position_id=${position_id}&skill_id=${skill_id}`, '_blank');
            } else {
                console.log('Invalid data received.');
            }
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