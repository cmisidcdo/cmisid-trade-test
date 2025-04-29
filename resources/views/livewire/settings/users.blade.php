<div>
  <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
    <h2 class="fw-bold m-0">Users</h2>
  </div>
  <section class="section dashboard">
    <div class="card shadow-sm border-0 rounded-3">
      <div class="card-body p-4">
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
      

        <table class="table table-hover table-bordered text-center global-table">
          <thead class="table-light">
            <tr>
              <th scope="col" style="width: 5%">#</th>
              <th scope="col">Name</th>
              <th scope="col" style="width: 25%">Email</th>
              <th scope="col" style="width: 5%">Status</th>
              <th scope="col" style="width: 5%">Actions</th>
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
                  <i class="bi bi-eye"></i>
                </button>


                @can('update user')
                <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                  wire:click='readUser({{$item->id}})'>
                  <i class="bi bi-pencil-square"></i>
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
          {{$users->links(data: ['scrollTo' => false])}}
        </div>
      </div>
    </div>


    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
          <div class="modal-header py-2 bg-light">
            <h6 class="modal-title fw-bold text-center w-100 mb-0" id="viewModalLabel">User Details</h6>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-3">
            <div class="d-flex justify-content-between mb-2">
              <div>
                <p class="mb-1 small"><strong>Name:</strong> {{ $user?->name }}</p>
                <p class="mb-1 small"><strong>Email:</strong> {{ $user?->email }}</p>
              </div>
              <div class="text-end">
                <span class="badge {{ $user?->deleted_at ? 'bg-danger' : 'bg-success' }}">
                  {{ $user?->deleted_at ? 'Inactive' : 'Active' }}
                </span>
                <span class="badge bg-primary">{{ ucfirst($user?->type) }}</span>
              </div>
            </div>
    
            <h6 class="fw-bold text-primary text-center border-bottom pb-1 small">Permissions</h6>
            <table class="table table-sm text-center mb-2 small global-table">
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
                      {{ $user?->hasPermissionTo("create $module") ? '✓' : '✕' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("update $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("update $module") ? '✓' : '✕' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("read $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("read $module") ? '✓' : '✕' }}
                    </span>
                  </td>
                  <td class="text-center">
                    <span class="{{ $user?->hasPermissionTo("delete $module") ? 'text-success' : 'text-danger' }}">
                      {{ $user?->hasPermissionTo("delete $module") ? '✓' : '✕' }}
                    </span>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
    
            <div class="row small">
              <div class="col-6">
                <p class="mb-1">
                  <strong>Assessor:</strong>
                  <span class="{{ $user?->hasPermissionTo('assessor permission') ? 'text-success' : 'text-danger' }}">
                    {{ $user?->hasPermissionTo('assessor permission') ? '✓' : '✕' }}
                  </span>
                </p>
              </div>
              <div class="col-6">
                <p class="mb-1">
                  <strong>Secretariat:</strong>
                  <span class="{{ $user?->hasPermissionTo('secretariat permission') ? 'text-success' : 'text-danger' }}">
                    {{ $user?->hasPermissionTo('secretariat permission') ? '✓' : '✕' }}
                  </span>
                </p>
              </div>
            </div>
          </div>
          <div class="modal-footer py-1 bg-light">
            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>




    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow">
          <div class="modal-header py-2 bg-light">
            <h5 class="modal-title fw-bold text-center w-100 mb-0 fs-6" id="userModalLabel">
              {{ $editMode ? 'Update User' : 'Add User' }}
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" wire:click='clear'></button>
          </div>
    
          <div class="modal-body p-2">
            <form class="row g-2" wire:submit.prevent="{{ $editMode ? 'updateUser' : 'createUser' }}">
              <div id="page-1">
                <div class="mb-2">
                  <label class="form-label small fw-bold mb-1">Full Name</label>
                  <input type="text" class="form-control form-control-sm" wire:model="name" placeholder="Enter full name">
                  @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
    
                <div class="mb-2">
                  <label class="form-label small fw-bold mb-1">Email</label>
                  <input type="email" class="form-control form-control-sm" wire:model="email" placeholder="Enter email">
                  @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
    
                <div class="mb-2">
                  <label class="form-label small fw-bold mb-1">Password</label>
                  <input type="password" class="form-control form-control-sm" wire:model="password"
                    placeholder="{{ $editMode ? 'New password (or leave blank)' : 'Password (or leave blank)' }}"
                    autocomplete="off">
                  @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
    
                <div class="row mb-2">
                  <div class="col-md-6">
                    <label class="form-label small fw-bold mb-1">Type</label>
                    <select class="form-select form-select-sm" wire:model.live="type">
                      <option value="" disabled selected>Select Type</option>
                      <option value="superadmin">Super Admin</option>
                      <option value="admin">Admin</option>
                      <option value="secretariat">Secretariat</option>
                      <option value="assessor">Assessor</option>
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label class="form-label small fw-bold mb-1">Is Active?</label>
                    <div class="mt-1">
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="status" value="yes" id="statusYes">
                        <label class="form-check-label small" for="statusYes">Yes</label>
                      </div>
                      <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" wire:model="status" value="no" id="statusNo">
                        <label class="form-check-label small" for="statusNo">No</label>
                      </div>
                    </div>
                  </div>
                </div>
    
                <div class="d-flex justify-content-center mt-3">
                  <button type="button" class="btn btn-sm btn-primary" onclick="nextPage()">Next: Permissions</button>
                </div>
              </div>

              <div id="page-2" style="display: none;">
                <div class="row g-2">
                  <div class="col-md-6 mb-2">
                    <div class="card card-body p-2 h-100">
                      <h6 class="fw-bold text-primary small mb-1">Special Roles</h6>
                      <div class="form-check mb-1">
                        <input class="form-check-input" type="checkbox" value="assessor permission" wire:model="permissions" id="assessor">
                        <label class="form-check-label small" for="assessor">Assessor</label>
                      </div>
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="secretariat permission" wire:model="permissions" id="secretariat">
                        <label class="form-check-label small" for="secretariat">Secretariat</label>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mb-2">
                    <div class="card card-body p-2 h-100">
                      <h6 class="fw-bold text-primary small mb-1">User Management</h6>
                      <div class="d-flex flex-wrap">
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="create user" wire:model="permissions" id="create-user">
                          <label class="form-check-label small" for="create-user">Create</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="update user" wire:model="permissions" id="update-user">
                          <label class="form-check-label small" for="update-user">Update</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="read user" wire:model="permissions" id="read-user">
                          <label class="form-check-label small" for="read-user">Read</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="delete user" wire:model="permissions" id="delete-user">
                          <label class="form-check-label small" for="delete-user">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mb-2">
                    <div class="card card-body p-2 h-100">
                      <h6 class="fw-bold text-primary small mb-1">Candidate Management</h6>
                      <div class="d-flex flex-wrap">
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="create candidate" wire:model="permissions" id="create-candidate">
                          <label class="form-check-label small" for="create-candidate">Create</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="update candidate" wire:model="permissions" id="update-candidate">
                          <label class="form-check-label small" for="update-candidate">Update</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="read candidate" wire:model="permissions" id="read-candidate">
                          <label class="form-check-label small" for="read-candidate">Read</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="delete candidate" wire:model="permissions" id="delete-candidate">
                          <label class="form-check-label small" for="delete-candidate">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mb-2">
                    <div class="card card-body p-2 h-100">
                      <h6 class="fw-bold text-primary small mb-1">Reference Management</h6>
                      <div class="d-flex flex-wrap">
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="create reference" wire:model="permissions" id="create-reference">
                          <label class="form-check-label small" for="create-reference">Create</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="update reference" wire:model="permissions" id="update-reference">
                          <label class="form-check-label small" for="update-reference">Update</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="read reference" wire:model="permissions" id="read-reference">
                          <label class="form-check-label small" for="read-reference">Read</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="delete reference" wire:model="permissions" id="delete-reference">
                          <label class="form-check-label small" for="delete-reference">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-md-6 mb-2">
                    <div class="card card-body p-2 h-100">
                      <h6 class="fw-bold text-primary small mb-1">Exam Management</h6>
                      <div class="d-flex flex-wrap">
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="create exam" wire:model="permissions" id="create-exam">
                          <label class="form-check-label small" for="create-exam">Create</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="update exam" wire:model="permissions" id="update-exam">
                          <label class="form-check-label small" for="update-exam">Update</label>
                        </div>
                        <div class="form-check me-2">
                          <input class="form-check-input" type="checkbox" value="read exam" wire:model="permissions" id="read-exam">
                          <label class="form-check-label small" for="read-exam">Read</label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" value="delete exam" wire:model="permissions" id="delete-exam">
                          <label class="form-check-label small" for="delete-exam">Delete</label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
    
                <div class="d-flex justify-content-center gap-2 mt-3">
                  <button type="button" class="btn btn-sm btn-secondary" onclick="previousPage()">
                    <i class="bi bi-arrow-left"></i> Back
                  </button>
                  <button type="submit" class="btn btn-sm btn-success">
                    <i class="bi bi-check-circle"></i> {{ $editMode ? 'Update' : 'Save' }}
                  </button>
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
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