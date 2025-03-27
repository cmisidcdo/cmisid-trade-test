<div>
  <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
    <h2 class="fw-bold m-0">Users</h2>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <div class="row align-items-center pt-3 pb-3">
          <div class="d-flex justify-content-between align-items-center mb-3">
              <button class="btn btn-primary" wire:click="showAddEditModal">
                  <i class="bi bi-plus"></i> Add User
              </button>
      
              <div class="d-flex gap-2">
                  <div class="input-group">
                      <span class="input-group-text bg-light border-end-0">
                          <i class="bi bi-search"></i>
                      </span>
                      <input type="text" class="form-control border-start-0 ps-0"
                          placeholder="Search users..."
                          wire:model.live.debounce.300ms="search"
                          aria-label="Search users">
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
      
                  <div class="dropdown">
                      <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                          data-bs-toggle="dropdown" aria-expanded="false">
                          <i class="bi bi-funnel"></i> Filter
                      </button>
                      <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                          <li>
                              <button class="dropdown-item" wire:click="$set('filterStatus', 'all')">
                                  <i class="bi bi-list"></i> All Users
                              </button>
                          </li>
                          <li>
                              <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                  <i class="bi bi-person-check"></i> Active Users
                              </button>
                          </li>
                          <li>
                              <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                  <i class="bi bi-person-x"></i> Inactive Users
                              </button>
                          </li>
                      </ul>
                  </div>
      
                  <div>
                      @if($filterStatus !== 'all')
                          <span class="badge bg-secondary">
                              <i class="bi bi-funnel"></i> 
                              {{ $filterStatus === 'yes' ? 'Active' : 'Inactive' }}
                              <button class="btn btn-sm btn-outline-light border-0 ms-1" wire:click="$set('filterStatus', 'all')">
                                  <i class="bi bi-x"></i>
                              </button>
                          </span>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      

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
              <td scope="row" class="text-center">{{$loop->iteration}}</td>
              <td>{{$item->name}}</td>
              <td>{{$item->email}}</td>
              <td>
                <span class="badge rounded-3 {{$item->deleted_at == Null ? 'bg-success': 'bg-danger'}}">
                  {{$item->deleted_at == Null ? 'Active' : 'Inactive'}}
                </span>
              </td>
              <td class="d-flex justify-content-center">
                <button class="btn btn-sm btn-info rounded-2 px-2 py-1 me-2"
                  wire:click="viewUser({{$item->id}})">
                  <i class="bi bi-eye-fill"></i>
                  <span class="d-none d-md-inline ms-1">View</span>
                </button>


                @can('update user')
                <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                  wire:click='readUser({{$item->id}})'>
                  <i class="bi bi-pencil-square"></i>
                  <span class="d-none d-md-inline ms-1">Edit</span>
                </button>
                @endcan

                {{-- @can('delete user')
                <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger' : 'btn-outline-success'}} rounded-2 px-2 py-1"
                  wire:click='{{$item->deleted_at == Null ? 'confirmDelete('.$item->id.')' : 'restoreUser('.$item->id.')'}}'>
                  <i class="bi {{$item->deleted_at == Null ? 'bi bi-archive-fill' : 'bi-arrow-counterclockwise'}}"></i>
                  <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Archive' : 'Restore'}}</span>
                </button>
                @endcan --}}
              </td>
            </tr>
            @empty
            <tr>
              <th colspan="5" class="text-center">No Records Found</th>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div>
          {{$users->links()}}
        </div>
      </div>
    </div>


    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-m">
        <div class="modal-content">
          <div class="modal-header  text-white">
            <h6 class="modal-title" id="viewModalLabel">
              <i class="bi bi-eye-fill me-1"></i> User Details
            </h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3">
            <div class="d-flex justify-content-between mb-2">
              <div>
                <p class="mb-1"><strong>Name:</strong> {{ $user?->name }}</p>
                <p class="mb-1"><strong>Email:</strong> {{ $user?->email }}</p>
              </div>
              <div class="text-end">
                <span class="badge {{ $user?->deleted_at ? 'bg-danger' : 'bg-success' }}">
                  {{ $user?->deleted_at ? 'Inactive' : 'Active' }}
                </span>
                <span class="badge bg-primary">{{ ucfirst($user?->type) }}</span>
              </div>
            </div>

            <h6 class="fw-bold text-primary text-center border-bottom pb-1">Permissions</h6>
            <table class="table table-sm text-center mb-2">
              <thead class="table-light">
                <tr>
                  <th>Module</th>
                  <th>Create</th>
                  <th>Update</th>
                  <th>Read</th>
                  <th>Delete</th>
                </tr>
              </thead>
              <tbody>
                @php
                $modules = ['user', 'candidate', 'exam', 'reference'];
                @endphp
                @foreach ($modules as $module)
                <tr>
                  <td class="fw-bold text-primary">{{ ucfirst($module) }}</td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("create $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("create $module") ? '✔' : '✖' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("update $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("update $module") ? '✔' : '✖' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("read $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("read $module") ? '✔' : '✖' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("delete $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("delete $module") ? '✔' : '✖' }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>

            <p>
              <strong>Assessor:</strong>
              <span class="{{ $user?->hasPermissionTo('assessor permission') ? 'text-success' : 'text-danger' }}">
                {{ $user?->hasPermissionTo('assessor permission') ? '✔' : '✖' }}
              </span>
            </p>

            <p>
              <strong>Secretariat:</strong>
              <span class="{{ $user?->hasPermissionTo('secretariat permission') ? 'text-success' : 'text-danger' }}">
                {{ $user?->hasPermissionTo('secretariat permission') ? '✔' : '✖' }}
              </span>
            </p>

          </div>
          <div class="modal-footer bg-light border-0">
            <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>




    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-m">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title" id="userModalLabel">
              <i class="bi bi-person-circle me-2"></i> {{ $editMode ? 'Update User' : 'Add User' }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
          </div>

          <div class="modal-body">
            <form class="row g-3" wire:submit.prevent="{{ $editMode ? 'updateUser' : 'createUser' }}">
              <div id="page-1">

                <div class="col-12">
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
                    <label class="form-label fw-bold">Password</label>
                    <input type="password" class="form-control" wire:model="password"
                      placeholder="{{ $editMode ? 'Enter new password (leave blank to keep current)' : 'Enter password (leave blank to keep default)' }}"
                      autocomplete="off">
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>

                  <div class="mb-3">
                    <label class="form-label fw-bold">Type</label>
                    <select class="form-select" wire:model.live="type">
                      <option value="" disabled selected>Select a Type</option>
                      <option value="superadmin" {{ $type === 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                      <option value="admin" {{ $type === 'admin' ? 'selected' : '' }}>Admin</option>
                      <option value="secretariat" {{ $type === 'secretariat' ? 'selected' : '' }}>Secretariat</option>
                      <option value="assessor" {{ $type === 'assessor' ? 'selected' : '' }}>Assessor</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label class="form-label">Is Active?</label>
                    <div>
                        <input type="radio" wire:model="status" value="yes" {{ $status === 'yes' || !$editMode ? 'checked' : '' }}> Yes
                        <input type="radio" wire:model="status" value="no" {{ $status === 'no' ? 'checked' : '' }}> No
                    </div>
                </div>
 

          </div>
          <div class="col-12 d-flex justify-content-center">
            <button type="button" class="btn btn-primary" onclick="nextPage()">User Permissions</button>
          </div>
        </div>

        <!-- Right Column (Page 2) -->
        <div id="page-2" style="display: none;">
          <div class="col-md-6">
            <h6 class="fw-bold text-primary">Permissions</h6>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="assessor permission" wire:model="permissions">
              <label class="form-check-label" for="assessor">Assessor</label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="secretariat permission" wire:model="permissions">
              <label class="form-check-label" for="secretariat">Secretariat</label>
            </div>
          </div>
          <!-- Additional Permissions -->
          <hr class="my-3">
          <div class="row">
            <!-- Accounts Permissions -->
            <div class="col-md-6">
              <h6 class="fw-bold text-primary">Accounts</h6>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="create user" wire:model="permissions">
                <label class="form-check-label" for="create-accounts">Create</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="update user" wire:model="permissions">
                <label class="form-check-label" for="update-accounts">Update</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="read user" wire:model="permissions">
                <label class="form-check-label" for="read-accounts">Read</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="delete user" wire:model="permissions">
                <label class="form-check-label" for="delete-accounts">Delete</label>
              </div>
            </div>

            <!-- Candidates Permissions -->
            <div class="col-md-6">
              <h6 class="fw-bold text-primary">Candidates</h6>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="create candidate" wire:model="permissions">
                <label class="form-check-label" for="create-candidates">Create</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="update candidate" wire:model="permissions">
                <label class="form-check-label" for="update-candidates">Update</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="read candidate" wire:model="permissions">
                <label class="form-check-label" for="read-candidates">Read</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="delete candidate" wire:model="permissions">
                <label class="form-check-label" for="delete-candidates">Delete</label>
              </div>
            </div>

            <!-- Reference Permissions -->
            <div class="col-md-6 mt-3">
              <h6 class="fw-bold text-primary">Reference</h6>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="create reference" wire:model="permissions">
                <label class="form-check-label" for="add-Reference">Create</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="update reference" wire:model="permissions">
                <label class="form-check-label" for="update-Reference">Update</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="read reference" wire:model="permissions">
                <label class="form-check-label" for="read-reference">Read</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="delete reference" wire:model="permissions">
                <label class="form-check-label" for="delete-reference">Delete</label>
              </div>
            </div>

            <!-- Exam Permissions -->
            <div class="col-md-6 mt-3">
              <h6 class="fw-bold text-primary">Exam</h6>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="create exam" wire:model="permissions">
                <label class="form-check-label" for="create-exam">Create</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="update exam" wire:model="permissions">
                <label class="form-check-label" for="update-exam">Update</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="read exam" wire:model="permissions">
                <label class="form-check-label" for="read-exam">Read</label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="checkbox" type="checkbox" value="delete exam" wire:model="permissions">
                <label class="form-check-label" for="delete-exam">Delete</label>
              </div>
            </div>
          </div>
          <hr class="my-3">

          <!-- Save & Cancel Buttons (Only visible on Page 2) -->
          <div class="col-12 d-flex justify-content-center">
            <button type="button" class="btn btn-primary mx-1" onclick="previousPage()">User Information</button>
            <button type="submit" class="btn btn-success mx-1">
              <i class="bi bi-check-circle"></i> {{ $editMode ? 'Update' : 'Save' }}
            </button>
            <button type="button" class="btn btn-secondary mx-1" data-bs-dismiss="modal">Cancel</button>
          </div>

        </div>
        </form>
      </div>
    </div>
</div>
</div>
</section>
</div>

<script>
  function nextPage() {
    currentPage = 2;
    updatePageDisplay();
  }

  function previousPage() {
    currentPage = 1;
    updatePageDisplay();
  }

  function updatePageDisplay() {
    document.getElementById('page-1').style.display = currentPage === 1 ? 'block' : 'none';
    document.getElementById('page-2').style.display = currentPage === 2 ? 'block' : 'none';
  }
</script>


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

  $wire.on('hide-viewModal', () => {
    console.log('Hiding view modal');
    $('#viewModal').modal('hide');
  });

  $wire.on('show-viewModal', () => {
    console.log('Showing view modal');
    $('#viewModal').modal('show');
  });

  let currentPage = 1;

  function nextPage() {
    if (currentPage === 1) {
      document.getElementById("page-1").style.display = "none";
      document.getElementById("page-2").style.display = "block";
      currentPage = 2;
    }
  }

  function previousPage() {
    if (currentPage === 2) {
      document.getElementById("page-2").style.display = "none";
      document.getElementById("page-1").style.display = "block";
      currentPage = 1;
    }
  }
  $wire.on('show-userModal', () => {
    $('#userModal').modal('show');
  });
</script>
@endscript