<div>
  <div class="globalheader">
    <h3 class="fw-bold m-0">Users</h3>
  </div>
  <section class="section dashboard">
    <div class="card">
      <div class="card-body">
        <div class="row align-items-center pt-3 pb-3">
          <!-- Search Input -->
          <div class="col-md-4 text-start">
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
          </div>

          <!-- Buttons (Aligned to the Right) -->
          <div class="col-md-8 text-end">
            <button type="button" class="btn {{ $archive ? 'btn-success' : 'btn-warning' }}" wire:click="toggleArchive">
              <i class="bi {{ $archive ? 'bi-box-arrow-in-up' : 'bi-archive' }} me-1"></i>
              {{ $archive ? 'General' : 'View Archive' }}
            </button>
            <button type="button" class="btn btn-primary" wire:click='clear' data-bs-toggle="modal" data-bs-target="#userModal">
              <i class="bi bi-person-plus-fill"></i> Add User
            </button>
          </div>
        </div>

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
                <button class="btn btn-sm btn-info rounded-2 px-2 py-1 me-2"
                  wire:click="viewUser({{ $item->id }})"
                  data-bs-toggle="modal"
                  data-bs-target="#viewUserModal">
                  <i class="bi bi-eye-fill"></i>
                  <span class="d-none d-md-inline ms-1">View</span>
                </button>


                <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2"
                  wire:click='readUser({{$item->id}})'
                  data-bs-toggle="tooltip"
                  data-bs-title="Edit user">
                  <i class="bi bi-pencil-square"></i>
                  <span class="d-none d-md-inline ms-1">Edit</span>
                </button>

                <button class="btn btn-sm {{$item->deleted_at == Null ? 'btn-danger' : 'btn-outline-success'}} rounded-2 px-2 py-1"
                  wire:click='{{$item->deleted_at == Null ? 'deleteUser('.$item->id.')' : 'restoreUser('.$item->id.')'}}'
                  data-bs-toggle="tooltip"
                  data-bs-title="{{$item->deleted_at == Null ? 'Move to archive' : 'Restore user'}}">
                  <i class="bi {{$item->deleted_at == Null ? 'bi bi-archive-fill' : 'bi-arrow-counterclockwise'}}"></i>
                  <span class="d-none d-md-inline ms-1">{{$item->deleted_at == Null ? 'Archive' : 'Restore'}}</span>
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

        <div>
          {{$users->links()}}
        </div>
      </div>
    </div>
    <!-- View User Modal -->
    <div class="modal fade" id="viewUserModal" tabindex="-1" aria-labelledby="viewUserModalLabel" aria-hidden="true" wire:ignore.self>
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-info text-white">
            <h5 class="modal-title" id="viewUserModalLabel">
              <i class="bi bi-eye-fill me-2"></i> View User Details
            </h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="row">
              <!-- User Information -->
              <div class="col-md-6">
                <p><strong>Name:</strong> {{ $viewUser?->name }}</p>
                <p><strong>Email:</strong> {{ $viewUser?->email }}</p>
                <p><strong>Employee ID:</strong> {{ $viewUser?->employeeid }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Status:</strong>
                  <span class="badge {{ $viewUser?->deleted_at == null ? 'bg-success' : 'bg-danger' }}">
                    {{ $viewUser?->deleted_at == null ? 'Active' : 'Inactive' }}
                  </span>
                </p>
                <p><strong>Type:</strong> {{ ucfirst($viewUser?->type) }}</p>
                <p><strong>Office:</strong> {{ ucfirst($viewUser?->office) }}</p>
              </div>
            </div>

            <hr>

            <div class="row">
              <!-- Left Column -->
              <div class="col-md-6">
                <!-- Permissions -->
                <h5 class="fw-bold text-primary">Permissions</h5>
                <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Assessor:</strong> {{ $viewUser?->permissions['assessor'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Secretariat:</strong> {{ $viewUser?->permissions['secretariat'] ? '✔ Yes' : '✖ No' }}</li>
                </ul>

                <!-- Accounts -->
                <h5 class="fw-bold text-primary">Accounts</h5>
                <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Add:</strong> {{ $viewUser?->accounts['add'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Update:</strong> {{ $viewUser?->accounts['update'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>View:</strong> {{ $viewUser?->accounts['view'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Delete:</strong> {{ $viewUser?->accounts['delete'] ? '✔ Yes' : '✖ No' }}</li>
                </ul>

                <!-- Candidates -->
                <h5 class="fw-bold text-primary">Candidates</h5>
                <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Add:</strong> {{ $viewUser?->candidates['add'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Update:</strong> {{ $viewUser?->candidates['update'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>View:</strong> {{ $viewUser?->candidates['view'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Delete:</strong> {{ $viewUser?->candidates['delete'] ? '✔ Yes' : '✖ No' }}</li>
                </ul>
              </div>

              <!-- Right Column -->
              <div class="col-md-6">
                <!-- Exams -->
                <h5 class="fw-bold text-primary">Exams</h5>
                <ul class="list-group mb-3">
                  <li class="list-group-item"><strong>Add:</strong> {{ $viewUser?->candidates['add'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Update:</strong> {{ $viewUser?->candidates['update'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>View:</strong> {{ $viewUser?->candidates['view'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Delete:</strong> {{ $viewUser?->candidates['delete'] ? '✔ Yes' : '✖ No' }}</li>
                </ul>

                <!-- References -->
                <h5 class="fw-bold text-primary">References</h5>
                <ul class="list-group">
                  <li class="list-group-item"><strong>Add:</strong> {{ $viewUser?->candidates['add'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>Update:</strong> {{ $viewUser?->candidates['update'] ? '✔ Yes' : '✖ No' }}</li>
                  <li class="list-group-item"><strong>View:</strong> {{ $viewUser?->candidates['view'] ? '✔ Yes' : '✖ Yes' }}</li>
                  <li class="list-group-item"><strong>Delete:</strong> {{ $viewUser?->candidates['delete'] ? '✔ Yes' : '✖ Yes' }}</li>
                </ul>
              </div>
            </div>
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
                <!-- Left Column -->
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
                    <input type="password" class="form-control" wire:model="password" placeholder="Enter password">
                    @error('password') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>

                  <div class="row mb-3">
                    <div class="col-6">
                      <label class="form-label fw-bold">Type</label>
                      <select class="form-select">
                        <option value="superadmin">Super Admin</option>
                        <option value="secretariat">Secretariat</option>
                        <option value="assessor">Assessor</option>
                        <option value="candidate">Candidate</option>
                      </select>
                    </div>

                    <div class="col-6">
                      <label class="form-label fw-bold">Office</label>
                      <select class="form-select">
                        <option value="option1">Office 1</option>
                        <option value="option2">Office 2</option>
                        <option value="option3">Office 3</option>
                        <option value="option4">Office 4</option>
                      </select>
                    </div>
                  </div>


                  <div class="mb-3">
                    <label class="form-label fw-bold">Employee ID</label>
                    <input type="text" class="form-control" wire:model="employeeid" placeholder="Employee ID">
                    @error('employeeid') <div class="text-danger small">{{ $message }}</div> @enderror
                  </div>


                </div>
                <!-- Next Button -->
                <div class="col-12 d-flex justify-content-center">
                  <button type="button" class="btn btn-primary" onclick="nextPage()">User Permissions</button>
                </div>
              </div>

              <!-- Right Column (Page 2) -->
              <div id="page-2" style="display: none;">
                <div class="col-md-6">
                  <h6 class="fw-bold text-primary">Permissions</h6>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="assessor">
                    <label class="form-check-label" for="assessor">Assessor</label>
                  </div>
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="secretariat">
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