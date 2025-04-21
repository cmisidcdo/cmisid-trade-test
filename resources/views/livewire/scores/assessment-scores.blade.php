<div>
    <div>
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Assessment Scores</h2>
        </div>
    </div>

    <!-- Main Table View -->
    <section class="section dashboard">
        <div class="card">
            <div class="card-body">
                <div class="row align-items-center pt-3 pb-1">
                    <div class="d-flex justify-content-end align-items-center mb-1">
                        <!-- Search input -->
                        <div class="input-group me-2" style="max-width: 250px;">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-start-0 ps-0"
                                placeholder="Search users..."
                                aria-label="Search users">
                            <button class="btn btn-outline-secondary border-start-0 bg-light" type="button">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li>
                                    <button class="dropdown-item">
                                        <i class="bi bi-list"></i> All Scores
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item">
                                        <i class="bi bi-person-check"></i> Passed
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item">
                                        <i class="bi bi-person-x"></i> Ongoing
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div>
                            <span class="badge bg-secondary d-none" id="filterBadge">
                                <i class="bi bi-funnel"></i>
                                <span id="filterText">Active</span>
                                <button class="btn btn-sm btn-outline-light border-0 ms-1">
                                    <i class="bi bi-x"></i>
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <table class="table table-hover table-bordered text-center global-table">
                <thead class="text-white" style="background-color: #1a1851;">
                    <tr>
                        <th>Candidate</th>
                        <th>Date Finished</th>
                        <th>Time Finished</th>
                        <th>Status</th>
                        <th>Score</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Juan dela Cruz</td>
                        <td>03/18/2025</td>
                        <td>9:00am</td>
                        <td><span class="badge bg-success">Passed</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Alex E. Lara</td>
                        <td>03/21/2025</td>
                        <td>9:00am</td>
                        <td><span class="badge bg-success">Passed</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Vero Nguyen</td>
                        <td>03/21/2025</td>
                        <td>1:00pm</td>
                        <td><span class="badge bg-success">Passed</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Ana Gabriel Go</td>
                        <td>03/22/2025</td>
                        <td>1:00pm</td>
                        <td><span class="badge bg-secondary">Ongoing</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>Mary Well Suarez</td>
                        <td>03/22/2025</td>
                        <td>3:00pm</td>
                        <td><span class="badge bg-secondary">Ongoing</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                    <tr>
                        <td>John Clark Osasona</td>
                        <td>03/22/2025</td>
                        <td>3:00pm</td>
                        <td><span class="badge bg-secondary">Ongoing</span></td>
                        <td>%</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewModal">
                                    <i class="bi bi-eye"></i> View
                                </button>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </div>

                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            <nav>
                <ul class="pagination">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item active">
                        <a class="page-link" href="#">1</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">2</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">3</a>
                    </li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
        </div>


        <!-- Edit Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef;">
                        <h5 class="modal-title" id="editModalLabel">Edit (Assessment Test)</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="candidate" class="form-label">Candidate</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="candidate" value="Juan dela Cruz" readonly>
                                        <button class="btn btn-outline-secondary" type="button">
                                            <i class="fas fa-chevron-left"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="assessor" class="form-label">Assessor</label>
                                    <input type="text" class="form-control" id="assessor" value="Alex E. Lara (Auto fill upon user)">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dateFinished" class="form-label">Date Finished</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" id="dateFinished" value="2025-03-18">
                                        <span class="input-group-text">
                                            <i class="fas fa-calendar"></i>
                                        </span>
                                    </div>
                                    <div class="mt-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="statusDone" value="Done" checked>
                                            <label class="form-check-label" for="statusDone">Done</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="statusOngoing" value="Ongoing">
                                            <label class="form-check-label" for="statusOngoing">Ongoing</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="timeFinished" class="form-label">Time Finished</label>
                                    <div class="input-group">
                                        <input type="time" class="form-control" id="timeFinished" value="09:00">
                                        <span class="input-group-text">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-hover table-bordered text-center global-table">
                                <thead class="text-white" style="background-color: #1a1851;">
                                    <tr>
                                        <th>Topics / Skills Assessed</th>
                                        <th>Competency Level</th>
                                        <th>Questions</th>
                                        <th>Candidate's Score</th>
                                        <th>Final Score</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Computer Literacy</td>
                                        <td>Basic</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                View Questions
                                            </button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                Input/Edit Score
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Cybersecurity</td>
                                        <td>Basic</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                View Questions
                                            </button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                Input/Edit Score
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Communication</td>
                                        <td>Basic</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-secondary">
                                                View Questions
                                            </button>
                                        </td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                            <button class="btn btn-sm btn-primary">
                                                Input/Edit Score
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>



                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#">
                            <i class="bi bi-check-circle"></i> Confirm
                        </button>
                    </div>


                </div>
            </div>
        </div>

        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef;">
                        <h5 class="modal-title" id="viewModalLabel">View Assessment Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <p><strong>Candidate:</strong> Juan dela Cruz</p>
                                <p><strong>Date Finished:</strong> 03/18/2025</p>
                                <p><strong>Status:</strong> <span class="badge bg-success">Passed</span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Assessor:</strong> Alex E. Lara</p>
                                <p><strong>Time Finished:</strong> 9:00am</p>
                                <p><strong>Overall Score:</strong> 85%</p>
                            </div>
                        </div>

                        <table class="table table-hover table-bordered text-center global-table">
                            <thead class="text-white" style="background-color: #1a1851;">
                                <tr>
                                    <th>Topics / Skills Assessed</th>
                                    <th>Competency Level</th>
                                    <th>Questions</th>
                                    <th>Candidate's Score</th>
                                    <th>Final Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Computer Literacy</td>
                                    <td>Basic</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            View Questions
                                        </button>
                                    </td>
                                    <td>90%</td>
                                    <td>90%</td>
                                </tr>
                                <tr>
                                    <td>Cybersecurity</td>
                                    <td>Basic</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            View Questions
                                        </button>
                                    </td>
                                    <td>80%</td>
                                    <td>80%</td>
                                </tr>
                                <tr>
                                    <td>Communication</td>
                                    <td>Basic</td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-secondary">
                                            View Questions
                                        </button>
                                    </td>
                                    <td>85%</td>
                                    <td>85%</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    </div>
                </div>
            </div>
        </div>
</div>
</section>
<!-- Bootstrap JS - Required for modals -->
<script>
    // This script is just for reference - you would typically include Bootstrap JS in your layout
    // If you're using Laravel, these scripts would normally be in your layout file
    document.addEventListener('DOMContentLoaded', function() {
        // You can add any necessary JavaScript initialization here
    });
</script>
</div>