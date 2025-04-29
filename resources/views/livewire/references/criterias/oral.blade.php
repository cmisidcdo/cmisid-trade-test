<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Test Criteria</h2>
    </div>

    <section class="section dashboard">
        <div class="card shadow-sm">
            <div class="card-body p-4">

                <div class="table-responsive">
                    <table class="table table-hover table-bordered align-middle text-center global-table">
                        <thead class="table-light">
                            <tr>
                                <th scope="col" class="text-center">Criteria Name</th>
                                <th scope="col" class="text-center">Description</th>
                                <th scope="col" class="text-center" style="width: 5%">Percentage</th>
                                <th scope="col" class="text-center" style="width: 5%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td scope="row" class="text-center">Code Organization</td>
                                <td scope="row" class="text-center">Proper structure and organization of code</td>
                                <td scope="row" class="text-center">25%</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Criteria Actions">
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewCriteriaModal1">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center">Functionality</td>
                                <td scope="row" class="text-center">Working implementation of all required features</td>
                                <td scope="row" class="text-center">40%</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Criteria Actions">
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewCriteriaModal2">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center">UI Design</td>
                                <td scope="row" class="text-center">User interface aesthetics and responsiveness</td>
                                <td scope="row" class="text-center">20%</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Criteria Actions">
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewCriteriaModal3">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td scope="row" class="text-center">Documentation</td>
                                <td scope="row" class="text-center">Code comments and project documentation</td>
                                <td scope="row" class="text-center">15%</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Criteria Actions">
                                        <button class="btn btn-sm btn-primary rounded-2 px-2 py-1" data-bs-toggle="modal" data-bs-target="#viewCriteriaModal4">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <!-- View Criteria Modal 1 -->
    <div class="modal fade" id="viewCriteriaModal1" tabindex="-1" aria-labelledby="viewCriteriaModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewCriteriaModalLabel1">Criteria Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5 class="fw-bold">Code Organization</h5>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>Proper structure and organization of code</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Percentage:</label>
                        <p>25%</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detailed Rubric:</label>
                        <ul class="list-group">
                            <li class="list-group-item">Follows MVC architecture</li>
                            <li class="list-group-item">Proper file naming conventions</li>
                            <li class="list-group-item">Code is modular and reusable</li>
                            <li class="list-group-item">Appropriate separation of concerns</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Criteria Modal 2 -->
    <div class="modal fade" id="viewCriteriaModal2" tabindex="-1" aria-labelledby="viewCriteriaModalLabel2" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewCriteriaModalLabel2">Criteria Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5 class="fw-bold">Functionality</h5>
                        <hr>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>Working implementation of all required features</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Percentage:</label>
                        <p>40%</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detailed Rubric:</label>
                        <ul class="list-group">
                            <li class="list-group-item">CRUD operations work correctly</li>
                            <li class="list-group-item">Form validation functions properly</li>
                            <li class="list-group-item">Authentication works as expected</li>
                            <li class="list-group-item">No errors or bugs in implemented features</li>
                            <li class="list-group-item">Features work across different browsers</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Criteria Modal 3 -->
    <div class="modal fade" id="viewCriteriaModal3" tabindex="-1" aria-labelledby="viewCriteriaModalLabel3" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewCriteriaModalLabel3">Criteria Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5 class="fw-bold">UI Design</h5>
                        <hr>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>User interface aesthetics and responsiveness</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Percentage:</label>
                        <p>20%</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detailed Rubric:</label>
                        <ul class="list-group">
                            <li class="list-group-item">Responsive on mobile, tablet, and desktop</li>
                            <li class="list-group-item">Consistent color scheme and typography</li>
                            <li class="list-group-item">Intuitive layout and navigation</li>
                            <li class="list-group-item">Proper spacing and alignment</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Criteria Modal 4 -->
    <div class="modal fade" id="viewCriteriaModal4" tabindex="-1" aria-labelledby="viewCriteriaModalLabel4" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="viewCriteriaModalLabel4">Criteria Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <h5 class="fw-bold">Documentation</h5>
                        <hr>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Description:</label>
                        <p>Code comments and project documentation</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Percentage:</label>
                        <p>15%</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Detailed Rubric:</label>
                        <ul class="list-group">
                            <li class="list-group-item">Comprehensive README file</li>
                            <li class="list-group-item">Clear installation instructions</li>
                            <li class="list-group-item">Well-commented code</li>
                            <li class="list-group-item">API documentation (if applicable)</li>
                        </ul>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addCriteriaModal" tabindex="-1" aria-labelledby="addCriteriaModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content shadow">
                <div class="modal-header bg-primary text-white py-2">
                    <h5 class="modal-title fw-bold text-center w-100 fs-6" id="addCriteriaModal">Criteria Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="criteriaName" class="form-label">Criteria Name</label>
                            <input type="text" class="form-control" id="criteriaName" required>
                        </div>
                        <div class="mb-3">
                            <label for="criteriaDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="criteriaDescription" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="criteriaPercentage" class="form-label">Percentage</label>
                            <input type="number" class="form-control" id="criteriaPercentage" min="1" max="100" required>
                        </div>
                        <div class="mb-3">
                            <label for="criteriaRubric" class="form-label">Detailed Rubric</label>
                            <textarea class="form-control" id="criteriaRubric" rows="5" placeholder="Enter each rubric point on a new line"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save Criteria</button>
                </div>
            </div>
        </div>
    </div>
