<div class="container-fluid p-0">
    <div class="container-fluid p-0">
        <!-- Header -->
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 0;">
            <h2 class="fw-bold m-0">Assessment Tests</h2>
        </div>
    
        <div class="card-body bg-white p-4">
            <!-- Toolbar with search and buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <button type="button" class="btn btn-primary px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addAssessmentModal">
                        <i class="fas fa-plus me-1"></i> Add Assessment Question
                    </button>
                </div>
                <div class="d-flex">
                    <div class="input-group me-2 shadow-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Type to search...">
                        <button class="btn btn-light border-start-0">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <button class="btn btn-outline-secondary px-3 shadow-sm">
                        <i class="fas fa-filter me-1"></i> SORT
                    </button>
                </div>
            </div>
                
            <!-- Data table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead style="background-color: #f8f9fa;">
                        <tr>
                            <th class="text-center" style="width: 5%;">#</th>
                            <th class="text-start" style="width: 30%;">Question</th>
                            <th class="text-center" style="width: 15%;">Position</th>
                            <th class="text-center" style="width: 15%;">Skills</th>
                            <th class="text-center" style="width: 15%;">Time Duration</th>
                            <th class="text-center" style="width: 20%;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Updated data rows -->
                        <tr>
                            <td class="text-center">1</td>
                            <td class="align-middle">Can you describe your experience...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-info text-white px-3 py-2">Human Resources</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-primary text-white px-3 py-2">Analytical Thinking</span>
                            </td>
                            <td class="text-center align-middle">00:03:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">2</td>
                            <td class="align-middle">How can you manage the...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-info text-white px-3 py-2">Human Resources</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-success text-white px-3 py-2">Management</span>
                            </td>
                            <td class="text-center align-middle">00:03:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center">3</td>
                            <td class="align-middle">Solve the mathematical equation and...</td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-warning text-white px-3 py-2">Electrical Engineer</span>
                            </td>
                            <td class="text-center align-middle">
                                <span class="badge rounded-pill text-bg-danger text-white px-3 py-2">Problem Solving</span>
                            </td>
                            <td class="text-center align-middle">00:10:00</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-info text-white me-1" data-bs-toggle="modal" data-bs-target="#viewAssessmentModal">
                                        <i class="fas fa-eye"></i> View
                                    </button>
                                    <button class="btn btn-primary me-1" data-bs-toggle="modal" data-bs-target="#editAssessmentModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Archive
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
                
            <!-- Footer with pagination and record count -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div>
                    <span class="text-muted">Showing 1 to 3 of 3 entries</span>
                </div>
                <div>
                    <button class="btn btn-sm btn-outline-secondary me-2">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-sm btn-primary me-1">1</button>
                    <button class="btn btn-sm btn-outline-secondary me-1">2</button>
                    <button class="btn btn-sm btn-outline-secondary me-1">3</button>
                    <button class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Add Assessment Question Modal -->
    <div class="modal fade" id="addAssessmentModal" tabindex="-1" aria-labelledby="addAssessmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addAssessmentModalLabel">Add Assessment Question</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="position" class="form-label fw-bold">Add Position</label>
                                <div class="input-group">
                                    <select class="form-select" id="position">
                                        <option selected>Position</option>
                                        <option value="human-resources">Human Resources</option>
                                        <option value="electrical-engineer">Electrical Engineer</option>
                                        <option value="software-engineer">Software Engineer</option>
                                        <option value="web-developer">Web Developer</option>
                                        <option value="data-analyst">Data Analyst</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="skill" class="form-label fw-bold">Choose Skill</label>
                                <div class="input-group">
                                    <select class="form-select" id="skill">
                                        <option selected>Skill</option>
                                        <option value="analytical-thinking">Analytical Thinking</option>
                                        <option value="management">Management</option>
                                        <option value="problem-solving">Problem Solving</option>
                                        <option value="javascript">JavaScript</option>
                                        <option value="css">CSS</option>
                                    </select>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label for="question" class="form-label fw-bold">Question:</label>
                            <textarea class="form-control" id="question" rows="3" placeholder="Enter your question here"></textarea>
                        </div>
    
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="points" class="form-label fw-bold">Point(s)</label>
                                <select class="form-select" id="points">
                                    <option value="1" selected>1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="timeDuration" class="form-label fw-bold">Time Duration</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="timeDuration" placeholder="00:00:00" value="00:03:00">
                                    <span class="input-group-text bg-light">
                                        <i class="far fa-clock"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <label class="form-label fw-bold">Is Active?</label>
                            <div class="form-check form-check-inline ms-2">
                                <input class="form-check-input" type="radio" name="isActive" id="activeYes" value="yes" checked>
                                <label class="form-check-label" for="activeYes">Yes</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="isActive" id="activeNo" value="no">
                                <label class="form-check-label" for="activeNo">No</label>
                            </div>
                        </div>
    
                        <div class="mb-3">
                            <p class="fw-bold mb-1">Choices:</p>
                            <div class="input-group mb-2">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="1" checked>
                                </div>
                                <input type="text" class="form-control" placeholder="Option 1">
                                <button class="btn btn-outline-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="input-group mb-2">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="2">
                                </div>
                                <input type="text" class="form-control" placeholder="Option 2">
                                <button class="btn btn-outline-danger" type="button">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i> Add an Option
                            </button>
                        </div>
    
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">
                                <i class="fas fa-arrow-left me-1"></i> Go Back
                            </button>
                            <button type="submit" class="btn btn-primary px-4">
                                Add Question
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>    

<!-- Edit Assessment Question Modal -->
<div class="modal fade" id="editAssessmentModal" tabindex="-1" aria-labelledby="editAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="editAssessmentModalLabel">Edit Assessment Question</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="editPosition" class="form-label fw-bold">Add Position</label>
                            <div class="input-group">
                                <select class="form-select" id="editPosition">
                                    <option>Position</option>
                                    <option value="human-resources" selected>Human Resources</option>
                                    <option value="electrical-engineer">Electrical Engineer</option>
                                    <option value="software-engineer">Software Engineer</option>
                                    <option value="web-developer">Web Developer</option>
                                    <option value="data-analyst">Data Analyst</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="editSkill" class="form-label fw-bold">Choose Skill</label>
                            <div class="input-group">
                                <select class="form-select" id="editSkill">
                                    <option>Skill</option>
                                    <option value="analytical-thinking" selected>Analytical Thinking</option>
                                    <option value="management">Management</option>
                                    <option value="problem-solving">Problem Solving</option>
                                    <option value="javascript">JavaScript</option>
                                    <option value="css">CSS</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="editQuestion" class="form-label fw-bold">Question:</label>
                        <textarea class="form-control" id="editQuestion" rows="3">Can you describe your experience...</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="editPoints" class="form-label fw-bold">Point(s)</label>
                            <select class="form-select" id="editPoints">
                                <option value="1" selected>1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="editTimeDuration" class="form-label fw-bold">Time Duration</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="editTimeDuration" value="00:03:00">
                                <span class="input-group-text bg-light">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Is Active?</label>
                        <div class="form-check form-check-inline ms-2">
                            <input class="form-check-input" type="radio" name="editIsActive" id="editActiveYes" value="yes" checked>
                            <label class="form-check-label" for="editActiveYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="editIsActive" id="editActiveNo" value="no">
                            <label class="form-check-label" for="editActiveNo">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="fw-bold mb-1">Choices:</p>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="editCorrectAnswer" value="1" checked>
                            </div>
                            <input type="text" class="form-control" value="Option 1">
                            <button class="btn btn-outline-danger" type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="editCorrectAnswer" value="2">
                            </div>
                            <input type="text" class="form-control" value="Option 2">
                            <button class="btn btn-outline-danger" type="button">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i> Add an Option
                        </button>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>
                        <button type="submit" class="btn btn-warning text-white rounded-pill px-4">
                            Confirm Edit Question
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- View Assessment Question Modal -->
<div class="modal fade" id="viewAssessmentModal" tabindex="-1" aria-labelledby="viewAssessmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="viewAssessmentModalLabel">View Assessment Question</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <label for="viewPosition" class="form-label fw-bold">Add Position</label>
                            <div class="input-group">
                                <select class="form-select" id="viewPosition" disabled>
                                    <option value="human-resources" selected>Human Resources</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="viewSkill" class="form-label fw-bold">Choose Skill</label>
                            <div class="input-group">
                                <select class="form-select" id="viewSkill" disabled>
                                    <option value="analytical-thinking" selected>Analytical Thinking</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="viewQuestion" class="form-label fw-bold">Question:</label>
                        <textarea class="form-control" id="viewQuestion" rows="3" disabled>Can you describe your experience...</textarea>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="viewPoints" class="form-label fw-bold">Point(s)</label>
                            <select class="form-select" id="viewPoints" disabled>
                                <option value="1" selected>1</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="viewTimeDuration" class="form-label fw-bold">Time Duration</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="viewTimeDuration" value="00:03:00" disabled>
                                <span class="input-group-text bg-light">
                                    <i class="far fa-clock"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Is Active?</label>
                        <div class="form-check form-check-inline ms-2">
                            <input class="form-check-input" type="radio" name="viewIsActive" id="viewActiveYes" value="yes" checked disabled>
                            <label class="form-check-label" for="viewActiveYes">Yes</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="viewIsActive" id="viewActiveNo" value="no" disabled>
                            <label class="form-check-label" for="viewActiveNo">No</label>
                        </div>
                    </div>

                    <div class="mb-3">
                        <p class="fw-bold mb-1">Choices:</p>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="viewCorrectAnswer" value="1" checked disabled>
                            </div>
                            <input type="text" class="form-control" value="Option 1" disabled>
                        </div>
                        <div class="input-group mb-2">
                            <div class="input-group-text">
                                <input class="form-check-input mt-0" type="radio" name="viewCorrectAnswer" value="2" disabled>
                            </div>
                            <input type="text" class="form-control" value="Option 2" disabled>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">
                            <i class="fas fa-arrow-left me-1"></i> Go Back
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>