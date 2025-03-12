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
            <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
            {{ $archive ? 'General' : 'View Archive' }}
          </button>
          <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#userModal">
            <i class="bi bi-person-plus-fill"></i> Add User
          </button>

        </div>


        <
          <!-- Table with stripped rows -->
          <table class="table table-hover table-bordered table-striped text-center">
            <thead class="table-light">
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
                  <span class="badge rounded-3 {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                    {{$item->deleted_at == Null ? 'Active' : 'Inactive'}}
                  </span>
                </td>
                <td class="d-flex justify-content-center">
                  <!-- Edit Button -->
                  <button class="btn btn-sm btn-outline-primary rounded-2 px-2 py-1"
                    wire:click='readUser({{$item->id}})'
                    data-bs-toggle="tooltip"
                    data-bs-title="Edit user">
                    <i class="bi bi-pencil"></i>
                    <span class="d-none d-md-inline ms-1">Edit</span>
                  </button>
                  <button class="btn btn-sm btn-outline-info rounded-2 px-2 py-1 ms-2"
                    wire:click='viewUser({{$item->id}})'
                    data-bs-toggle="tooltip"
                    data-bs-title="View user">
                    <i class="bi bi-eye"></i>
                    <span class="d-none d-md-inline ms-1">View</span>
                  </button>
                  <!-- Delete/Restore Button -->
                  <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-outline-danger' : 'btn-outline-success'}} rounded-2 px-2 py-1 ms-2"
                    wire:click='{{$item->deleted_at == Null ? 'deleteUser('.$item->id.')' : 'restoreUser('.$item->id.')'}}'
                    data-bs-toggle="tooltip"
                    data-bs-title="{{$item->deleted_at == Null ? 'Delete user' : 'Restore user'}}">
                    <i class="bi {{$item->deleted_at == Null ? 'bi-trash' : 'bi-arrow-counterclockwise'}}"></i>
                    <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Delete' : 'Restore'}}</span>
                  </button>
                </td>
              </tr>
              @empty
              <tr>
                <th colspan="5" class="text-center">No Records Found</th>
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
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="userModalLabel">
              <i class="bi bi-person-circle me-2"></i> {{ $editMode ? 'Update User' : 'Add User' }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
          </div>

          <div class="modal-body">
            <form class="row g-3" wire:submit.prevent="{{ $editMode ? 'updateUser' : 'createUser' }}">
              <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Full Name</label>
                    <input type="text" class="form-control" wire:model="name" placeholder="Enter full name">
                    @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" class="form-control" wire:model="email" placeholder="Enter email">
                    @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold">Office</label>
                    <select class="form-select">
                      <option value="option1">Office 1</option>
                      <option value="option2">Office 2</option>
                      <option value="option3">Office 3</option>
                      <option value="option4">Office 4</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold">Employee ID</label>
                    <input type="text" class="form-control" wire:model="employeeid" placeholder="Employee ID">
                    @error('employeeid') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label fw-bold">Type</label>
                    <select class="form-select">
                      <option value="superadmin">Super Admin</option>
                      <option value="secretariat">Secretariat</option>
                      <option value="assessor">Assessor</option>
                      <option value="candidate">Candidate</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold">Permission</label>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="assessor" name="permissions" value="Assessor">
                      <label class="form-check-label" for="assessor">Assessor</label>
                    </div>
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" id="secretariat" name="permissions" value="Secretariat">
                      <label class="form-check-label" for="secretariat">Secretariat</label>
                    </div>
                  </div>

                </div>
              </div>

              <!-- Additional Permissions -->
              <hr class="my-3">
              <div class="row">
                <!-- Accounts Permissions -->
                <div class="col-md-6">
                  <h6 class="fw-bold text-primary">Accounts</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="add-accounts">
                    <label class="form-check-label" for="add-accounts">Add</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="update-accounts">
                    <label class="form-check-label" for="update-accounts">Update</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="view-accounts">
                    <label class="form-check-label" for="view-accounts">View</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="delete-accounts">
                    <label class="form-check-label" for="delete-accounts">Delete</label>
                  </div>
                </div>

                <!-- Candidates Permissions -->
                <div class="col-md-6">
                  <h6 class="fw-bold text-primary">Candidates</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="add-candidates">
                    <label class="form-check-label" for="add-candidates">Add</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="update-candidates">
                    <label class="form-check-label" for="update-candidates">Update</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="view-candidates">
                    <label class="form-check-label" for="view-candidates">View</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="delete-candidates">
                    <label class="form-check-label" for="delete-candidates">Delete</label>
                  </div>
                </div>

                <!-- Reference Permissions -->
                <div class="col-md-6 mt-3">
                  <h6 class="fw-bold text-primary">Reference</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="add-Reference">
                    <label class="form-check-label" for="add-Reference">Add</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="update-Reference">
                    <label class="form-check-label" for="update-Reference">Update</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="view-reference">
                    <label class="form-check-label" for="view-reference">View</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="delete-reference">
                    <label class="form-check-label" for="delete-reference">Delete</label>
                  </div>
                </div>

                <!-- Exam Permissions -->
                <div class="col-md-6 mt-3">
                  <h6 class="fw-bold text-primary">Exam</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="add-exam">
                    <label class="form-check-label" for="add-exam">Add</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="update-exam">
                    <label class="form-check-label" for="update-exam">Update</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="view-exam">
                    <label class="form-check-label" for="view-exam">View</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="delete-exam">
                    <label class="form-check-label" for="delete-exam">Delete</label>
                  </div>
                </div>
              </div>
              <hr class="my-3">


              <div class="text-end">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">
                  <i class="bi bi-check-circle"></i> {{ $editMode ? 'Update' : 'Save' }}
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

</div>
</section>
</div>

@push('styles')
<style>
  .action-column {
    width: 100px;
    /* Adjust as needed */

  }

  .custom-invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
  }

  .sortable {
    cursor: pointer;
  }

  .sortable:hover {
    background-color: rgba(0, 0, 0, 0.05);
  }

  /* Responsive adjustments */
  @media (max-width: 768px) {
    .card-title {
      font-size: 1.25rem;
    }

    .table th,
    .table td {
      padding: 0.5rem;
    }
  }
</style>
@endpush
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