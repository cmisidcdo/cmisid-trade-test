<div>
  <section class="section dashboard">
        <div class="card">
            <div class="card-body">
              <h5 class="card-title">Users</h5>
              <div class="col-4 text-start">
                <input type="text" class="form-control" placeholder="search" wire:model.live="search">
              </div>
              <div class="text-end">
                <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
                  {{ $archive ? 'General' : 'Archive' }}
                </button>  
                <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#userModal" >
                  Add
                </button>
                
              </div>


              <!-- Table with stripped rows -->
              <table class="table table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($users as $item)
                  <tr>
                    <td scope="row">{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->email}}</td>
                    <td>
                      <span class="badge rounded-pill {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                        {{$item->deleted_at == Null ? 'active': 'inactive'}}
                      </span>
                      
                    </td>
                    <td>
                      <button class="btn btn-secondary" wire:click='readUser({{$item->id}})'>
                        Edit
                      </button>

                      <button class="{{$item->deleted_at == Null ? 'btn btn-danger': 'btn btn-success'}}" wire:click='{{$item->deleted_at == Null ? 'deleteUser('.$item->id.')': 'restoreUser('.$item->id.')'}}'>
                        {{$item->deleted_at == Null ? 'Delete': 'Restore'}}
                      </button>
                    </td>
                  </tr>
                  @empty
                    <tr>
                      <th colspan="5">No Record</th>
                    </tr>
                    
                  @endforelse
                </tbody>
              </table>
              <!-- End Table with stripped rows -->
              <div>
                {{$users->links()}}
              </div>
            </div>
          </div>

        
          <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" wire:ignore.self>
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="userModalLabel">{{$editMode ? 'Update' : 'Add'}}</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
                </div>
                <div class="modal-body">
                  <form class="row g-3" wire:submit="{{$editMode ? 'updateUser' : 'createUser'}}">
                    <div class="col-12">
                      <label for="inputNanme4" class="form-label">Your Name</label>
                      <input type="text" class="form-control" wire:model="name">
                      @error('name')
                        <div class="custom-invalid-feedback">
                          {{$message}}
                        </div>
                      @enderror
                    </div>
                    <div class="col-12">
                      <label for="inputEmail4" class="form-label">Email</label>
                      <input type="email" class="form-control" wire:model="email">
                      @error('email')
                        <div class="custom-invalid-feedback">
                          {{$message}}
                        </div>
                      @enderror
                    </div>
                    {{-- <div class="col-12">
                      <label for="inputPassword4" class="form-label">Password</label>
                      <input type="password" class="form-control" id="inputPassword4">
                    </div> --}}
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary">Submit</button>
                      {{-- <button type="reset" class="btn btn-secondary" wire:click='clear'>Reset</button> --}}
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" wire:click='clear'>Close</button>
                    </div>
                  </form>
                </div>
                {{-- <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary" wire:click='clear'>Save changes</button>
                </div> --}}
              </div>
            </div>
          </div>
  </section>
</div>

@script
<script>
  $wire.on('hide-userModal', () => {
      console.log('Hiding user modal');
      $('#userModal').modal('hide');
  });

  $wire.on('show-userModal', () => {
      console.log('Showing user modal');
      $('#userModal').modal('show');
  });

</script>
@endscript
