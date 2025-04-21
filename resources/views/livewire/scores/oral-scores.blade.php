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
                <div class="row align-items-center pt-3 pb-3">
                    <!-- Left side -->
                    <div class="col d-flex justify-content-start align-items-center mb-1">
                        <button class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#criteriaModal">
                            <i class="bi bi-card-list me-1"></i> View Criteria
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#evaluateModal">
                            <i class="bi bi-person-check me-1"></i> Evaluate Candidate
                        </button>
                    </div>


                    <!-- Right side -->
                    <div class="col d-flex justify-content-end align-items-center mb-1">
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

                        <!-- Filter dropdown -->
                        <div class="dropdown me-2">
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

                        <!-- Active filter badge -->
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


                <table class="table table-hover table-bordered text-center global-table">
                    <thead class="text-white" style="background-color: #1a1851;">
                        <tr>
                            <th>Notes</th>
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
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>


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

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>
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

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>
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

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>
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

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>
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

                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#noteModal" style="cursor: pointer;">
                                    <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="max-width: 24px; max-height: 24px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </a>
                            </td>
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


            <!-- Evaluate Modal -->
            <div class="modal fade" id="evaluateModal" tabindex="-1" aria-labelledby="evaluateModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef; position: relative;">
                            <h5 class="modal-title text-center" id="evaluateModalLabel">Evaluate Candidate</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem; top: 1rem;"></button>
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
                                            <th>Task Completion</th>
                                            <th>Accuracy and Precision</th>
                                            <th>Problem Solving and Troubleshooting</th>
                                            <th>Efficiency and Time Management</th>
                                            <th>Final Score</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Computer Literacy</td>
                                            <td>Basic</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary view-questions-btn" type="button" data-bs-toggle="modal" data-bs-target="#viewQuestionsModal" data-skill="Computer Literacy" onclick="event.stopPropagation()">
                                                    <i class="bi bi-journals"></i> View Questions
                                                </button>
                                            </td>
                                            <td>4</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>3</td>
                                            <td>3.5</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editScoreModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Input/Edit Score</span>
                                                </button>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td>Cybersecurity</td>
                                            <td>Basic</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary view-questions-btn" type="button" data-bs-toggle="modal" data-bs-target="#viewQuestionsModal" data-skill="Cybersecurity" onclick="event.stopPropagation()">
                                                    <i class="bi bi-journals"></i> VView Questions
                                                </button>
                                            </td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>3</td>
                                            <td>4</td>
                                            <td>3.5</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editScoreModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Input/Edit Score</span>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Communication</td>
                                            <td>Basic</td>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary view-questions-btn" type="button" data-bs-toggle="modal" data-bs-target="#viewQuestionsModal" data-skill="Communication" onclick="event.stopPropagation()">
                                                    <i class="bi bi-journals"></i> View Questions
                                                </button>
                                            </td>
                                            <td>5</td>
                                            <td>4</td>
                                            <td>4</td>
                                            <td>5</td>
                                            <td>4.5</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary d-flex align-items-center gap-1" data-bs-toggle="modal" data-bs-target="#editScoreModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                    <span>Input/Edit Score</span>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                        <div class="modal-footer d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">
                                <i class="bi bi-check-circle"></i> Confirm
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Questions Modal -->
            <div class="modal fade" id="viewQuestionsModal" tabindex="-1" aria-labelledby="viewQuestionsModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef; position: relative;">
                            <h5 class="modal-title text-center" id="viewQuestionsModalLabel">View Computer Literacy Scenarios</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem; top: 1rem;"></button>
                        </div>

                        <div class="modal-body px-4">
                            <form>
                                <!-- Scenario 1 -->
                                <div class="scenario-section mb-4 pb-3 border-bottom">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Qestion 1</label>
                                            <input type="text" class="form-control" id="qestion1Title" maxlength="250" readonly>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Time Duration*</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" readonly>
                                                <span class="input-group-text">
                                                    <i class="fas fa-circle-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" id="qestion1Desc" maxlength="250" readonly></textarea>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Attachment (5MB Max)</label>
                                            <div>
                                                <input type="button" class="btn btn-outline-secondary btn-sm" value="<Attachment Name>" style="font-size: 0.8rem;" disabled>
                                            </div>
                                            <small class="text-muted d-block mt-1 opacity-50">.pdf .docx</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Scenario 2 -->
                                <div class="scenario-section mb-4 pb-3 border-bottom">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Qestion 2</label>
                                            <input type="text" class="form-control" id="qestion2Title" maxlength="250" readonly>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Time Duration*</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" readonly>
                                                <span class="input-group-text">
                                                    <i class="fas fa-circle-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" id="qestion2Desc" maxlength="250" readonly></textarea>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Attachment (5MB Max)</label>
                                            <div>
                                                <input type="button" class="btn btn-outline-secondary btn-sm" value="<Attachment Name>" style="font-size: 0.8rem;" disabled>
                                            </div>
                                            <small class="text-muted d-block mt-1 opacity-50">.pdf .docx</small>
                                        </div>
                                    </div>
                                </div>

                                <!-- Scenario 3 -->
                                <div class="scenario-section mb-4">
                                    <div class="row mb-2">
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Qestion 3</label>
                                            <input type="text" class="form-control" id="qestion3Title" maxlength="250" readonly>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-bold">Time Duration*</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" readonly>
                                                <span class="input-group-text">
                                                    <i class="fas fa-circle-info"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-12">
                                            <label class="form-label">Description</label>
                                            <textarea class="form-control" rows="3" id="qestion3Desc" maxlength="250" readonly></textarea>
                                            <small class="text-muted float-end">Characters left: 0/250</small>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12">
                                            <label class="form-label">Attachment (5MB Max)</label>
                                            <div>
                                                <input type="button" class="btn btn-outline-secondary btn-sm" value="<Attachment Name>" style="font-size: 0.8rem;" disabled>
                                            </div>
                                            <small class="text-muted d-block mt-1 opacity-50">.pdf .docx</small>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="modal-footer justify-content-start">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>

                    </div>
                </div>
            </div>
            <!-- View Modal -->
            <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center" style="background-color: #ffffff; border-bottom: 1px solid #e9ecef; position: relative;">
                            <h5 class="modal-title text-center" id="viewModalLabel">View Candidate Evaluation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position: absolute; right: 1rem; top: 1rem;"></button>
                        </div>

                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="candidate" class="form-label">Candidate</label>
                                    <input type="text" class="form-control" id="candidate" value="Juan dela Cruz" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="assessor" class="form-label">Assessor</label>
                                    <input type="text" class="form-control" id="assessor" value="Alex E. Lara" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dateFinished" class="form-label">Date Finished</label>
                                    <input type="date" class="form-control" id="dateFinished" value="2025-03-18" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="timeFinished" class="form-label">Time Finished</label>
                                    <input type="time" class="form-control" id="timeFinished" value="09:00" readonly>
                                </div>
                            </div>

                            <table class="table table-hover table-bordered text-center global-table">
                                <thead class="text-white" style="background-color: #1a1851;">
                                    <tr>
                                        <th>Topics / Skills Assessed</th>
                                        <th>Competency Level</th>
                                        <th>Scenarios / Task</th>
                                        <th>Task Completion</th>
                                        <th>Accuracy and Precision</th>
                                        <th>Problem Solving and Troubleshooting</th>
                                        <th>Efficiency and Time Management</th>
                                        <th>Final Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Computer Literacy</td>
                                        <td>Basic</td>
                                        <td>View Questions</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>3.5</td>
                                    </tr>
                                    <tr>
                                        <td>Cybersecurity</td>
                                        <td>Basic</td>
                                        <td>View Questions</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>3.5</td>
                                    </tr>
                                    <tr>
                                        <td>Communication</td>
                                        <td>Basic</td>
                                        <td>View Questions</td>
                                        <td>5</td>
                                        <td>4</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td>4.5</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer d-flex justify-content-between mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Score Modal -->
            <div class="modal fade" id="editScoreModal" tabindex="-1" aria-labelledby="editScoreModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header justify-content-center border-0">
                            <h5 class="modal-title text-center fw-bold" id="editScoreModalLabel">Computer Literacy Score</h5>
                        </div>

                        <div class="modal-body px-4 pb-4">
                            <form>
                                <div class="row mb-4 align-items-center">
                                    <div class="col-6 text-center">
                                        <label for="problemSolving" class="font-weight-bold form-label mb-2">Problem-Solving and<br>Troubleshooting</label>
                                        <select class="form-select mx-auto" id="problemSolving" style="width: 120px;">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3" selected>3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-center">
                                        <label for="efficiency" class="font-weight-bold form-label mb-2">Completeness and<br>Relevance of Responses</label>
                                        <select class="form-select mx-auto" id="efficiency" style="width: 120px;">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4" selected>4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-4 align-items-center">
                                    <div class="col-6 text-center">
                                        <label for="accuracyPrecision" class="font-weight-bold form-label mb-2">Knowledge and<br>Understanding</label>
                                        <select class="form-select mx-auto" id="accuracyPrecision" style="width: 120px;">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3" selected>3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-center">
                                        <!-- Space for additional field if needed -->
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="recommendation" class="font-weight-bold form-label">Recommendation/s</label>
                                    <div class="position-relative">
                                        <textarea class="form-control" id="recommendation" rows="3" maxlength="250"></textarea>
                                        <span class="char-counter-inline" id="recommendationCounter">0/250</span>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="comment" class="font-weight-bold form-label">Comment/s</label>
                                    <div class="position-relative">
                                        <textarea class="form-control" id="comment" rows="3" maxlength="250"></textarea>
                                        <span class="char-counter-inline" id="commentCounter">0/250</span>
                                    </div>
                                </div>



                                <div class="d-flex justify-content-between mt-4">
                                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Update Score</button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>



            <!-- Note Modal -->
            <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="noteModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-m">
                    <div class="modal-content">
                        <<div class="modal-header justify-content-center position-relative">
                            <h5 class="modal-title text-center fw-bold" id="noteModalLabel">View Note</h5>
                            <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Recommendation/s</label>
                            <textarea class="form-control" rows="4" readonly></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Comment/s</label>
                            <textarea class="form-control" rows="4" readonly></textarea>
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </button>

                    </div>
                </div>
            </div>
        </div>
        <!-- Criteria Modal -->
        <div class="modal fade" id="criteriaModal" tabindex="-1" aria-labelledby="criteriaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content ">
                    <div class="modal-header justify-content-center position-relative">
                        <h5 class="modal-title fw-bold text-center" id="criteriaModalLabel">View Practical Exam Criteria</h5>
                        <button type="button" class="btn-close position-absolute end-0 me-3" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-center align-middle">
                                <thead class="text-white" style="background-color: #0D0D4C;">
                                    <tr>
                                        <th>Criteria Name</th>
                                        <th>Description</th>
                                        <th>Percent</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold">Knowledge and Understanding</td>
                                        <td>Evaluates the candidate’s grasp of the subject matter, technical knowledge, or job-specific expertise.</td>
                                        <td class="fw-bold">30%</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Completeness and Relevance of Responses</td>
                                        <td>Assess whether the candidate provides comprehensive answers that directly address the interview questions.</td>
                                        <td class="fw-bold">30%</td>
                                    </tr>
                                    <tr>
                                        <td class="fw-bold">Accuracy</td>
                                        <td>Measures the correctness of the candidate’s answers, particularly for technical or factual questions.</td>
                                        <td class="fw-bold">40%</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="modal-footer justify-content-start">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-arrow-left"></i> Go Back
                        </button>
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

        document.addEventListener('DOMContentLoaded', function() {
            // Function to update character counter
            function updateCharCounter(textareaId, counterId) {
                const textarea = document.getElementById(textareaId);
                const counter = document.getElementById(counterId);
                const maxLength = textarea.getAttribute('maxlength');

                textarea.addEventListener('input', function() {
                    const currentLength = this.value.length;
                    counter.textContent = `${currentLength}/${maxLength} characters`;

                    // Add warning class if approaching limit (>80% of max)
                    if (currentLength > maxLength * 0.8) {
                        counter.classList.add('warning');
                    } else {
                        counter.classList.remove('warning');
                    }
                });
            }

            // Initialize character counters for both textareas
            updateCharCounter('recommendation', 'recommendationCounter');
            updateCharCounter('comment', 'commentCounter');
        });
        document.addEventListener('DOMContentLoaded', function() {
            const viewButtons = document.querySelectorAll('.view-questions-btn');

            viewButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    // Prevent the click from bubbling up to parent elements
                    event.stopPropagation();

                    // Get the skill type from the data attribute
                    const skill = this.getAttribute('data-skill');

                    // Update the modal title
                    document.getElementById('viewQuestionsModalLabel').textContent = `View ${skill} Scenarios`;
                });
            });
        });



        document.addEventListener('DOMContentLoaded', function() {
            // Find all input and textarea elements with maxlength attribute
            const textInputs = document.querySelectorAll('input[maxlength], textarea[maxlength]');

            // Process each input/textarea element
            textInputs.forEach(function(element) {
                const maxLength = element.getAttribute('maxlength');
                const parentDiv = element.parentElement;

                // Find the corresponding counter element (small tag with 'Characters left' text)
                const counterElement = parentDiv.querySelector('small.text-muted');

                // Initial count display
                if (counterElement) {
                    updateCounter(element, counterElement, maxLength);
                }

                // Add event listener for input changes
                element.addEventListener('input', function() {
                    if (counterElement) {
                        updateCounter(this, counterElement, maxLength);
                    }
                });
            });

            // Function to update the counter display
            function updateCounter(inputElement, counterElement, maxLength) {
                const currentLength = inputElement.value.length;
                const remainingChars = maxLength - currentLength;

                // Update the counter text
                counterElement.textContent = `Characters left: ${remainingChars}/${maxLength}`;

                // Add warning class if approaching limit (>80% of max)
                if (currentLength > maxLength * 0.8) {
                    counterElement.classList.add('text-warning');
                } else {
                    counterElement.classList.remove('text-warning');
                }
            }
        });
    </script>
    <style>
        
    </style>
</div>