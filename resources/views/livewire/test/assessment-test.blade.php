<div>
    <div class="container-fluid p-0">
        <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
            <h2 class="fw-bold m-0">Assessment Tests</h2>
        </div>
    
        <div class="card-body bg-white p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addAssessmentModal">
                        <i class="fas fa-plus me-1"></i> Add Assessment Test
                    </button>
                    <button type="button" class="btn rounded-pill px-4 shadow-sm ms-2" style="background-color: #d4af37; color: white;" data-bs-toggle="modal" data-bs-target="#updateAssessmentModal">
                        <i class="fas fa-edit me-1"></i> Update Assessment Test
                    </button>
                </div>
                <div class="d-flex">
                    <div class="input-group me-2 shadow-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control border-start-0" placeholder="Type to search...">
                    </div>
                    <button class="btn btn-outline-secondary rounded-pill px-3 shadow-sm">
                        <i class="fas fa-filter me-1"></i> FILTER
                    </button>
                </div>
            </div>
            
            <!-- Data table with filter headers -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    ID <i class="fas fa-filter ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Position <i class="fas fa-filter ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Skill <i class="fas fa-filter ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Question <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Difficulty <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Created By <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Date <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Status <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Options <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                            <th class="text-center">
                                <button class="btn btn-sm btn-link text-dark">
                                    Actions <i class="fas fa-chevron-down ms-1"></i>
                                </button>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Static data rows -->
                        <tr>
                            <td class="text-center align-middle">1</td>
                            <td class="text-center align-middle">Software Engineer</td>
                            <td class="text-center align-middle">JavaScript</td>
                            <td class="align-middle">What is the difference between 'let' and 'var' in JavaScript?</td>
                            <td class="text-center align-middle"><span class="badge bg-success rounded-pill">Basic</span></td>
                            <td class="text-center align-middle">John Doe</td>
                            <td class="text-center align-middle">18/03/2025</td>
                            <td class="text-center align-middle"><span class="badge bg-success rounded-pill">Active</span></td>
                            <td class="text-center align-middle">4</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">2</td>
                            <td class="text-center align-middle">Web Developer</td>
                            <td class="text-center align-middle">CSS</td>
                            <td class="align-middle">Explain the box model in CSS and its components.</td>
                            <td class="text-center align-middle"><span class="badge bg-warning rounded-pill">Intermediate</span></td>
                            <td class="text-center align-middle">Jane Smith</td>
                            <td class="text-center align-middle">17/03/2025</td>
                            <td class="text-center align-middle"><span class="badge bg-success rounded-pill">Active</span></td>
                            <td class="text-center align-middle">4</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">3</td>
                            <td class="text-center align-middle">Backend Engineer</td>
                            <td class="text-center align-middle">PHP</td>
                            <td class="align-middle">What are the key differences between Laravel 9 and Laravel 10?</td>
                            <td class="text-center align-middle"><span class="badge bg-primary rounded-pill">Advanced</span></td>
                            <td class="text-center align-middle">Robert Johnson</td>
                            <td class="text-center align-middle">16/03/2025</td>
                            <td class="text-center align-middle"><span class="badge bg-danger rounded-pill">Inactive</span></td>
                            <td class="text-center align-middle">5</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">4</td>
                            <td class="text-center align-middle">Data Analyst</td>
                            <td class="text-center align-middle">SQL</td>
                            <td class="align-middle">Write a query to find the second highest salary from an employees table.</td>
                            <td class="text-center align-middle"><span class="badge bg-warning rounded-pill">Intermediate</span></td>
                            <td class="text-center align-middle">Maria Garcia</td>
                            <td class="text-center align-middle">15/03/2025</td>
                            <td class="text-center align-middle"><span class="badge bg-success rounded-pill">Active</span></td>
                            <td class="text-center align-middle">4</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-center align-middle">5</td>
                            <td class="text-center align-middle">DevOps Engineer</td>
                            <td class="text-center align-middle">Docker</td>
                            <td class="align-middle">Explain the difference between Docker containers and virtual machines.</td>
                            <td class="text-center align-middle"><span class="badge bg-primary rounded-pill">Advanced</span></td>
                            <td class="text-center align-middle">David Wilson</td>
                            <td class="text-center align-middle">14/03/2025</td>
                            <td class="text-center align-middle"><span class="badge bg-success rounded-pill">Active</span></td>
                            <td class="text-center align-middle">4</td>
                            <td class="text-center align-middle">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-outline-primary rounded-circle me-1"><i class="fas fa-eye"></i></button>
                                    <button class="btn btn-sm btn-outline-warning rounded-circle me-1"><i class="fas fa-edit"></i></button>
                                    <button class="btn btn-sm btn-outline-danger rounded-circle"><i class="fas fa-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination and difficulty level indicators -->
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="d-flex align-items-center">
                    <span class="me-3">1/10</span>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle me-2">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button class="btn btn-sm btn-primary rounded-circle me-1">1</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle me-1">2</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle me-2">3</button>
                    <button class="btn btn-sm btn-outline-secondary rounded-circle">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center">
                    <span class="me-1 text-success fw-bold">Basic</span>
                    <span class="badge bg-success rounded-pill me-3">10</span>
                    <span class="me-1 text-warning fw-bold">Intermediate</span>
                    <span class="badge bg-warning rounded-pill me-3">7</span>
                    <span class="me-1 text-primary fw-bold">Advanced</span>
                    <span class="badge bg-primary rounded-pill">15</span>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addAssessmentModal" tabindex="-1" aria-labelledby="addAssessmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addAssessmentModalLabel">Add Assessment Test</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="skill" class="form-label fw-bold">Choose Skill</label>
                                <div class="input-group">
                                    <select class="form-select" id="skill">
                                        <option selected>Skills</option>
                                        <option value="javascript">JavaScript</option>
                                        <option value="php">PHP</option>
                                        <option value="css">CSS</option>
                                        <option value="sql">SQL</option>
                                        <option value="docker">Docker</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="position" class="form-label fw-bold">Add Position</label>
                                <div class="input-group">
                                    <select class="form-select" id="position">
                                        <option selected>Position</option>
                                        <option value="software-engineer">Software Engineer</option>
                                        <option value="web-developer">Web Developer</option>
                                        <option value="backend-engineer">Backend Engineer</option>
                                        <option value="data-analyst">Data Analyst</option>
                                        <option value="devops-engineer">DevOps Engineer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="question" class="form-label fw-bold">Question:</label>
                            <input type="text" class="form-control" id="question" placeholder="Question">
                            <div class="form-text">Enter the assessment question here</div>
                        </div>

                        <div class="mb-3">
                            <label for="difficulty" class="form-label fw-bold">Difficulty Level:</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="difficulty" id="difficultyBasic" autocomplete="off" checked>
                                <label class="btn btn-outline-success" for="difficultyBasic">Basic</label>

                                <input type="radio" class="btn-check" name="difficulty" id="difficultyIntermediate" autocomplete="off">
                                <label class="btn btn-outline-warning" for="difficultyIntermediate">Intermediate</label>

                                <input type="radio" class="btn-check" name="difficulty" id="difficultyAdvanced" autocomplete="off">
                                <label class="btn btn-outline-primary" for="difficultyAdvanced">Advanced</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="fw-bold mb-1">Options:</p>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">A</span>
                                <input type="text" class="form-control" placeholder="Option A">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="A">
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">B</span>
                                <input type="text" class="form-control" placeholder="Option B">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="B">
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">C</span>
                                <input type="text" class="form-control" placeholder="Option C">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="C">
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">D</span>
                                <input type="text" class="form-control" placeholder="Option D">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="correctAnswer" value="D">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i> Add Another Option
                            </button>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn text-white me-3 rounded-pill px-4 shadow-sm" style="background-color: #3498db; width: 150px;">Add Test</button>
                            <button type="button" class="btn rounded-pill px-4 shadow-sm" style="background-color: #f1c40f; color: white; width: 150px;" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Assessment Test Modal (similar to Add but with different title and button) -->
    <div class="modal fade" id="updateAssessmentModal" tabindex="-1" aria-labelledby="updateAssessmentModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 shadow">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title" id="updateAssessmentModalLabel">Update Assessment Test</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="updateSkill" class="form-label fw-bold">Choose Skill</label>
                                <div class="input-group">
                                    <select class="form-select" id="updateSkill">
                                        <option>Skills</option>
                                        <option value="javascript" selected>JavaScript</option>
                                        <option value="php">PHP</option>
                                        <option value="css">CSS</option>
                                        <option value="sql">SQL</option>
                                        <option value="docker">Docker</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="updatePosition" class="form-label fw-bold">Add Position</label>
                                <div class="input-group">
                                    <select class="form-select" id="updatePosition">
                                        <option>Position</option>
                                        <option value="software-engineer" selected>Software Engineer</option>
                                        <option value="web-developer">Web Developer</option>
                                        <option value="backend-engineer">Backend Engineer</option>
                                        <option value="data-analyst">Data Analyst</option>
                                        <option value="devops-engineer">DevOps Engineer</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="updateQuestion" class="form-label fw-bold">Question:</label>
                            <input type="text" class="form-control" id="updateQuestion" value="What is the difference between 'let' and 'var' in JavaScript?">
                            <div class="form-text">Edit the assessment question here</div>
                        </div>

                        <div class="mb-3">
                            <label for="difficulty" class="form-label fw-bold">Difficulty Level:</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="updateDifficulty" id="updateDifficultyBasic" autocomplete="off" checked>
                                <label class="btn btn-outline-success" for="updateDifficultyBasic">Basic</label>

                                <input type="radio" class="btn-check" name="updateDifficulty" id="updateDifficultyIntermediate" autocomplete="off">
                                <label class="btn btn-outline-warning" for="updateDifficultyIntermediate">Intermediate</label>

                                <input type="radio" class="btn-check" name="updateDifficulty" id="updateDifficultyAdvanced" autocomplete="off">
                                <label class="btn btn-outline-primary" for="updateDifficultyAdvanced">Advanced</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <p class="fw-bold mb-1">Options:</p>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">A</span>
                                <input type="text" class="form-control" value="'let' has block scope, 'var' has function scope">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="updateCorrectAnswer" value="A" checked>
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">B</span>
                                <input type="text" class="form-control" value="'let' cannot be redeclared, 'var' can be redeclared">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="updateCorrectAnswer" value="B">
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">C</span>
                                <input type="text" class="form-control" value="'let' is hoisted, 'var' is not hoisted">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="updateCorrectAnswer" value="C">
                                </div>
                            </div>
                            <div class="input-group mb-2">
                                <span class="input-group-text bg-light">D</span>
                                <input type="text" class="form-control" value="All of the above">
                                <div class="input-group-text">
                                    <input class="form-check-input mt-0" type="radio" name="updateCorrectAnswer" value="D">
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i> Add Another Option
                            </button>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <button type="submit" class="btn text-white me-3 rounded-pill px-4 shadow-sm" style="background-color: #3498db; width: 150px;">Update</button>
                            <button type="button" class="btn rounded-pill px-4 shadow-sm" style="background-color: #f1c40f; color: white; width: 150px;" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>