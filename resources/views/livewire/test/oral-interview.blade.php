<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Interviews</h2>
    </div>
    <section class="section dashboard">
        <div class="card">
            <div class="card-body p-3">
                <div class="card-header d-flex justify-content-between align-items-center ">
                    <button class="btn btn-primary btn-m" data-bs-toggle="modal" data-bs-target="#oralInterviewModal">
                        <i class="bi bi-plus"></i> Add Practical Scenario
                    </button>

                    <div class="d-flex">
                        <!-- Search Input with Icon and Clear Button -->
                        <div class="input-group me-2" style="width: 300px; height: auto;">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" class="form-control" id="searchInput" placeholder="Search..." aria-label="Search">
                            <button class="btn btn-outline-secondary" type="button" id="clearSearch">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>

                        <!-- Filter Button -->
                        <button class="btn btn-secondary btn-m">
                            <i class="bi bi-funnel"></i> SORT
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped text-center">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Competency Level</th>
                                <th scope="col">Skill</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Can you describe your experience with Microsoft Office?</td>
                                <td>Basic</td>
                                <td>Microsoft Office Proficiency</td>
                                <td>
                                    <button class="btn btn-sm btn-info rounded-2 px-2 py-1 me-2" data-bs-toggle="modal" data-bs-target="#viewInterviewModal">
                                        <i class="bi bi-eye"></i>
                                        <span class="d-none d-md-inline ms-1">View</span>
                                    </button>
                                    <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2" data-bs-toggle="modal" data-bs-target="#editInterviewModal">
                                        <i class="bi bi-pencil-square"></i>
                                        <span class="d-none d-md-inline ms-1">Edit</span>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div>
            <!-- Add Oral Interview Modal -->
            <div class="modal fade" id="oralInterviewModal" tabindex="-1" aria-labelledby="oralInterviewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white d-flex justify-content-center">
                            <h5 class="modal-title w-100 text-center">Add Oral Interview</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Competency Level</label>
                                    <select class="form-select">
                                        <option>Select Competency Level</option>
                                        <option>Basic</option>
                                        <option>Intermediate</option>
                                        <option>Advanced</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Select Skill</label>
                                    <select class="form-select">
                                        <option>Select Skill</option>
                                        <option>Microsoft Office Proficiency</option>
                                        <option>Data Entry & Management</option>
                                        <option>Communication Skills</option>
                                        <option>Administrative Support</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Question</label>
                                    <textarea class="form-control" rows="2" placeholder="Enter question"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Notes</label>
                                    <textarea class="form-control" rows="3" placeholder="Additional notes"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Is Active?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="isActive" id="activeYes" checked>
                                            <label class="form-check-label" for="activeYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="isActive" id="activeNo">
                                            <label class="form-check-label" for="activeNo">No</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                                    <button type="submit" class="btn btn-primary">Update Scenario</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Oral Interview Modal -->
            <div class="modal fade" id="editInterviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white d-flex justify-content-center">
                            <h5 class="modal-title w-100 text-center">Edit Oral Interview</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <form>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Competency Level</label>
                                    <select class="form-select">
                                        <option>Select Competency Level</option>
                                        <option>Basic</option>
                                        <option>Intermediate</option>
                                        <option>Advanced</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-boldform-label">Select Skill</label>
                                    <select class="form-select">
                                        <option>Select Skill</option>
                                        <option>Microsoft Office Proficiency</option>
                                        <option>Data Entry & Management</option>
                                        <option>Communication Skills</option>
                                        <option>Administrative Support</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Question</label>
                                    <textarea class="form-control" rows="2" placeholder="Enter question"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Notes</label>
                                    <textarea class="form-control" rows="3" placeholder="Additional notes"></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="fw-bold form-label">Is Active?</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="isActive" id="editActiveYes" checked>
                                            <label class="form-check-label" for="editActiveYes">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="isActive" id="editActiveNo">
                                            <label class="form-check-label" for="editActiveNo">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-between">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                                    <button type="submit" class="btn btn-primary">Update Scenario</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Oral Interview Modal -->
            <div class="modal fade" id="viewInterviewModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white d-flex justify-content-center">
                            <h5 class="modal-title w-100 text-center">View Oral Interview</h5>
                            <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Competency Level</label>
                                <p class="border p-2 rounded">Intermediate</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Select Skill</label>
                                <p class="border p-2 rounded">Communication Skills</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Question</label>
                                <p class="border p-2 rounded">
                                    Can you give an example of how you effectively communicated with a team to resolve a complex project challenge?
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Notes</label>
                                <p class="border p-2 rounded">
                                    Look for specific details about team collaboration, problem-solving, and communication strategies.
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Is Active?</label>
                                <p class="border p-2 rounded">Yes</p>
                            </div>
                            <div class="text-center">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Go Back</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>


@push('styles')
<style>
    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transition: background-color 0.2s ease;
    }

    .btn {
        transition: all 0.2s ease-in-out;
    }

    .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .modal.fade .modal-dialog {
        transition: transform 0.3s ease-out;
    }

    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 1.5rem;
        color: #6c757d;
    }

    .was-validated .form-control:invalid,
    .form-control.is-invalid {
        border-color: #dc3545;
        padding-right: calc(1.5em + 0.75rem);
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    @media (max-width: 768px) {
        .table-responsive {
            border: 0;
        }

        .btn {
            padding: 0.375rem 0.75rem;
        }

        .input-group {
            width: 100%;
        }
    }
</style>
@endpush