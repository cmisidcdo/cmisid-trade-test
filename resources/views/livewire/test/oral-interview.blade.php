<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Candidates</h2>
    </div>
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center pt-3 pb-3">
                    <div class="col-md-4 text-start">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0" placeholder="Search candidates..." aria-label="Search candidates">
                            <button class="btn btn-outline-secondary border-start-0 bg-light" type="button">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-8 text-end">
                        <button type="button" class="btn btn-warning">
                            <i class="bi bi-archive me-1"></i> View Archive
                        </button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#oralInterviewModal">
                            <i class="bi bi-plus-circle"></i> Add Interview
                        </button>
                    </div>
                </div>
                <table class="table table-hover table-bordered table-striped text-center">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Position</th>
                            <th scope="col">Skill</th>
                            <th scope="col">Question</th>
                            <th scope="col">Notes</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1</td>
                            <td>Software Developer</td>
                            <td>JavaScript</td>
                            <td>What is closure in JS?</td>
                            <td>Explain with examples</td>
                            <td><span class="badge rounded-3 bg-success">Active</span></td>
                            <td>
                                <button class="btn btn-sm btn-info rounded-2 px-2 py-1 me-2" data-bs-toggle="modal" data-bs-target="#viewInterviewModal">
                                    <i class="bi bi-eye-fill"></i>
                                    <span class="d-none d-md-inline ms-1">View</span>
                                </button>
                                <button class="btn btn-sm btn-primary rounded-2 px-2 py-1 me-2" data-bs-toggle="modal" data-bs-target="#editInterviewModal">
                                    <i class="bi bi-pencil-square"></i>
                                    <span class="d-none d-md-inline ms-1">Edit</span>
                                </button>
                                <button class="btn btn-sm btn-danger rounded-2 px-2 py-1">
                                    <i class="bi bi-archive-fill"></i>
                                    <span class="d-none d-md-inline ms-1">Archive</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


        <div class="modal fade" id="oralInterviewModal" tabindex="-1" aria-labelledby="oralInterviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="oralInterviewModalLabel">Add Oral Interview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Select Position</label>
                                <select class="form-select">
                                    <option>Select Position</option>
                                    <option>Software Developer</option>
                                    <option>Product Manager</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select Skill</label>
                                <select class="form-select">
                                    <option>Select Skill</option>
                                    <option>JavaScript</option>
                                    <option>Python</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Question</label>
                                <textarea class="form-control" rows="2" placeholder="Question"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" rows="2" placeholder="Additional notes"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is Active?</label>
                                <div>
                                    <input type="radio" name="status" value="yes" checked> Yes
                                    <input type="radio" name="status" value="no"> No
                                </div>
                            </div>
                            <div class="modal-footer bg-light border-0">
                                <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class=" bi bi-plus-circle btn btn-primary "> Save Oral Interview</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="viewInterviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">View Interview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Position:</strong> Software Developer</p>
                        <p><strong>Skill:</strong> JavaScript</p>
                        <p><strong>Question:</strong> What is closure in JS?</p>
                        <p><strong>Notes:</strong> Explain with examples</p>
                        <p><strong>Status:</strong>
                            <span class="badge bg-success">Active</span>
                            
                        </p>
                    </div>
                    <div class="modal-footer bg-light border-0">
                        <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="editInterviewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="oralInterviewModalLabel">Add Oral Interview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mb-3">
                                <label class="form-label">Select Position</label>
                                <select class="form-select">
                                    <option>Select Position</option>
                                    <option>Software Developer</option>
                                    <option>Product Manager</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Select Skill</label>
                                <select class="form-select">
                                    <option>Select Skill</option>
                                    <option>JavaScript</option>
                                    <option>Python</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Question</label>
                                <input type="text" class="form-control" placeholder="Enter question">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" rows="2" placeholder="Additional notes"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Is Active?</label>
                                <div>
                                    <input type="radio" name="status" value="yes" checked> Yes
                                    <input type="radio" name="status" value="no"> No
                                </div>
                            </div>
                            <div class="text-end">

                                <div class="modal-footer bg-light border-0">
                                    <button type="button" class="btn btn-secondary rounded-2" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class=" bi bi-check-circle btn btn-primary "> Update oral interview</button>
                                </div>

                            </div>
                        </form>
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