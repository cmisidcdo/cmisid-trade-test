<div>
    <section class="section dashboard">
          <div class="card">
              <div class="card-body">
                <h5 class="card-title">Skills</h5>
                <div class="col-4 text-start">
                  <input type="text" class="form-control" placeholder="search" wire:model.live="search">
                </div>
                <div class="text-end">
                  {{-- <button class="btn btn-primary">Add</button> --}}
                  <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                    {{ $archive ? 'General' : 'Archive' }}
                </button>                
                  <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#skillModal" >
                    Add
                  </button>
                  
                </div>
  
  
                <!-- Table with stripped rows -->
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Title</th>
                      <th scope="col">Status</th>
                      <th scope="col">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($skills as $item)
                    <tr>
                      <td scope="row">{{$item->id}}</td>
                      <td>{{$item->title}}</td>
                      <td>
                        <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                          {{$item->deleted_at == Null ? 'active': 'inactive'}}
                        </span>
                        
                      </td>
                      <td>
                        <button class="btn btn-secondary" wire:click='readSkill({{$item->id}})'>
                          Edit
                        </button>
  
                        <button class="{{$item->deleted_at == Null ? 'btn btn-danger': 'btn btn-success'}}" wire:click='{{$item->deleted_at == Null ? 'deleteSkill('.$item->id.')': 'restoreSkill('.$item->id.')'}}'>
                          {{$item->deleted_at == Null ? 'Delete': 'Restore'}}
                        </button>
                      </td>
                    </tr>
                    @empty
                      <tr>
                        <th colspan="4">No Record</th>
                      </tr>
                      
                    @endforelse
                  </tbody>
                </table>
                <!-- End Table with stripped rows -->
                <div>
                  {{$skills->links()}}
                </div>
              </div>
            </div>
  
          
            <div class="modal fade" id="skillModal" tabindex="-1" aria-labelledby="skillModalLabel" aria-hidden="true" wire:ignore.self>
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="skillModalLabel">{{$editMode ? 'Update' : 'Add'}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                  </div>
                  <div class="modal-body">
                    <form class="row g-3" wire:submit="{{$editMode ? 'updateSkill' : 'createSkill'}}">
                      <div class="col-12">
                        <label for="inputNanme4" class="form-label">Title</label>
                        <input type="text" class="form-control" wire:model="title">
                        @error('title')
                          <div class="custom-invalid-feedback">
                            {{$message}}
                          </div>
                        @enderror
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Close</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
    </section>
  </div>
  
  @script
  <script>
    $wire.on('hide-skillModal', () => {
        console.log('Hiding skill modal');
        $('#skillModal').modal('hide');
    });
  
    $wire.on('show-skillModal', () => {
        console.log('Showing skill modal');
        $('#skillModal').modal('show');
    });
  
  </script>
  @endscript
  