<div>
    <section class="section dashboard">
          <div class="card">
              <div class="card-body">
                <h5 class="card-title">Positions</h5>
                <div class="col-4 text-start">
                  <input type="text" class="form-control" placeholder="search" wire:model.live="search">
                </div>
                <div class="text-end">
                  {{-- <button class="btn btn-primary">Add</button> --}}
                  <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                    {{ $archive ? 'General' : 'Archive' }}
                </button>                
                  <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#positionModal" >
                    Add
                  </button>
                  
                </div>
  
  
                <!-- Table with stripped rows -->
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Salary Grade</th>
                      <th scope="col">Competency Level</th>
                      <th scope="col">Status</th>
                      <th scope="col">Priority</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($positions as $item)
                    <tr>
                      <td scope="row">{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                      <td>{{$item->salary_grade}}</td>
                      <td>{{$item->competency_level}}</td>
                      <td>
                        <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                          {{$item->deleted_at == Null ? 'active': 'inactive'}}
                        </span>
                        
                      </td>
                      <td>
                        <span class="badge rounded-pill {{$item->interview_priority == True ? 'bg-success': 'bg-danger'}}">
                          {{$item->interview_priority == True ? 'Yes': 'No'}}
                        </span>
                        
                      </td>
                      <td>
                        <button class="btn btn-secondary" wire:click='readPosition({{$item->id}})'>
                          Edit
                        </button>
  
                        <button class="{{$item->deleted_at == Null ? 'btn btn-danger': 'btn btn-success'}}" wire:click='{{$item->deleted_at == Null ? 'deletePosition('.$item->id.')': 'restorePosition('.$item->id.')'}}'>
                          {{$item->deleted_at == Null ? 'Delete': 'Restore'}}
                        </button>
                      </td>
                    </tr>
                    @empty
                      <tr>
                        <th colspan="7">No Record</th>
                      </tr>
                      
                    @endforelse
                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
                <div>
                  {{$positions->links()}}
                </div>
              </div>
            </div>
  
          
            <div class="modal fade" id="positionModal" tabindex="-1" aria-labelledby="positionModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="positionModalLabel">{{$editMode ? 'Update Position' : 'Add Position'}}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3" wire:submit.prevent="{{$editMode ? 'updatePosition' : 'createPosition'}}">
                                
                                {{-- Title --}}
                                <div class="col-12">
                                    <label for="title" class="form-label">Title</label>
                                    <input type="text" class="form-control" wire:model="title">
                                    @error('title')
                                    <div class="custom-invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
            
                                {{-- Salary Grade & Interview Priority in One Row --}}
                                <div class="row">
                                    <div class="col-6">
                                        <label for="salary_grade" class="form-label">Salary Grade</label>
                                        <input type="number" class="form-control" wire:model="salary_grade">
                                        @error('salary_grade')
                                        <div class="custom-invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
            
                                    <div class="col-6">
                                        <label class="form-label">Interview Priority</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="interview_priority" value="1">
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" wire:model="interview_priority" value="0">
                                            <label class="form-check-label">No</label>
                                        </div>
                                        @error('interview_priority')
                                        <div class="custom-invalid-feedback">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
            
                                {{-- Competency Level --}}
                                <div class="col-12">
                                    <label for="competency_level" class="form-label">Competency Level</label>
                                    <select class="form-control" wire:model="competency_level">
                                        <option value="">Select Level</option>
                                        <option value="basic">Basic</option>
                                        <option value="intermediate">Intermediate</option>
                                        <option value="advanced">Advanced</option>
                                    </select>
                                    @error('competency_level')
                                    <div class="custom-invalid-feedback">{{$message}}</div>
                                    @enderror
                                </div>
            
                                {{-- Add Skills Button --}}
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-success" wire:click="selectSkills">
                                        Add Skill
                                    </button>
                                </div>
            
                                {{-- Skills Table --}}
                                <div class="col-12">
                                    <h5>Skills</h5>
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Skill Title</th>
                                                <th>Competency Level</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($selectedskills as $index => $selectedskill)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $selectedskill['title'] }}</td>
                                                <td>
                                                    <select class="form-control" 
                                                            wire:change="updateCompetencyLevel({{ $index }}, $event.target.value)">
                                                        <option value="basic" {{ $selectedskill['competency_level'] == 'basic' ? 'selected' : '' }}>Basic</option>
                                                        <option value="intermediate" {{ $selectedskill['competency_level'] == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                                        <option value="advanced" {{ $selectedskill['competency_level'] == 'advanced' ? 'selected' : '' }}>Advanced</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" wire:click.prevent="removeSkill({{ $index }})">
                                                        Remove
                                                    </button>    
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="4">No skills added yet.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>                                        
                                        
                                    </table>
                                </div>
            
                                {{-- Submit and Close Buttons --}}
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- Skills Selection Modal --}}
            <div class="modal fade" id="skillsModal" tabindex="-1" aria-labelledby="skillsModalLabel" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="skillsModalLabel">Select Skills</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                        </div>
                        <div class="modal-body">
                            {{-- Skills Table --}}
                            <div class="col-12">
                                <h5>Available Skills</h5>
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Skill Title</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($skills as $item)
                                        <tr>
                                          <td scope="row">{{$item->id}}</td>
                                          <td>{{$item->title}}</td>
                                            <td>
                                                <button class="btn btn-success" wire:click="addSkill({{$item->id}})">
                                                    Add
                                                </button>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3">No skills available.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                    {{ $skills->links() }}

                            </div>
            
                            {{-- Submit and Close Buttons --}}
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary" wire:click="backToPosition">Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
    </section>
  </div>
  
  @script
  <script>
    $wire.on('hide-positionModal', () => {
        console.log('Hiding position modal');
        $('#positionModal').modal('hide');
    });
  
    $wire.on('show-positionModal', () => {
        console.log('Showing position modal');
        $('#positionModal').modal('show');
    });

    $wire.on('show-skillsModal', () => {
        console.log('Showing skills modal');
        $('#positionModal').modal('hide');
        $('#skillsModal').modal('show');
    });

    $wire.on('hide-skillsModal', () => {
        console.log('Showing skills modal');
        $('#positionModal').modal('show');
        $('#skillsModal').modal('hide');
    });

  </script>
  @endscript
  