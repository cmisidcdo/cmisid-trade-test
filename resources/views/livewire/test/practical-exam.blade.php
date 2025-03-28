<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exams</h2>
    </div>

    <div class="card p-3">
        <div class="card-header d-flex justify-content-between align-items-center">
            <button class="btn btn-primary btn-m" data-bs-toggle="modal" data-bs-target="#addPracticalScenarioModal">
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
                        <th scope="col">Attachment</th>
                        <th scope="col">Scenarios</th>
                        <th scope="col">Time Duration</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center"><i class="bi bi-paperclip"></i></td>
                        <td>You are given a partially developed web application with a few missing functionalities...</td>
                        <td>00:10:00</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-info me-1" data-bs-toggle="modal" data-bs-target="#viewScenarioModal">
                                <i class="bi bi-eye"></i>
                                <span class="d-none d-md-inline ms-1">View</span>
                            </button>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editScenarioModal">
                                <i class="bi bi-pencil"></i>
                                <span class="d-none d-md-inline ms-1">Edit</span>
                            </button>
                        </td>
                    </tr>
                    <!-- Additional table rows can be added similarly -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Practical Test Scenario Modal -->
    <div class="modal fade" id="addPracticalScenarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title  w-100 text-center">Add Practical Test Scenario</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold form-label">Competency Level</label>
                                <select class="form-select">
                                    <option>Choose Level</option>
                                    <option>Basic</option>
                                    <option>Intermediate</option>
                                    <option>Advanced</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold form-label">Choose Skill</label>
                                <select class="form-select">
                                    <option>Choose Skill</option>
                                    <option>Analytical Thinking</option>
                                    <option>Problem Solving</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="fw-bold form-label">Point(s)</label>
                                <input type="number" class="form-control" value="1">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="fw-bold form-label">Time Duration</label>
                                <input type="text" class="form-control" placeholder="HH:MM:SS">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Scenario</label>
                                <textarea class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Description</label>
                                <textarea class="form-control" rows="2"></textarea>
                            </div>
                            <!-- In the Add Practical Test Scenario Modal -->
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Attachment</label>
                                <input type="file" class="form-control mb-1" id="addScenarioFileInput">
                                <div class="mt-1 d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-upload"></i> Upload</button>
                                    <a href="#" id="addScenarioDownloadBtn" class="btn btn-outline-primary btn-sm me-2 d-none">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                    <button id="addScenarioClearBtn" class="btn btn-outline-danger btn-sm me-2 d-none">
                                        <i class="bi bi-x-circle"></i> Clear
                                    </button>
                                    <span id="addScenarioFileName" class="text-muted d-none"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                            <button type="submit" class="btn btn-primary">Add Scenario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






    <!-- View Practical Test Scenario Modal -->
    <div class="modal fade" id="viewScenarioModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title  w-100 text-center">View Practical Test Scenario</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <strong>Competency Level:</strong>
                            <p>Human Resources</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Choose Skill:</strong>
                            <p>Analytical Thinking</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Point(s):</strong>
                            <p>1</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Time Duration:</strong>
                            <p>00:10:00</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Is Active?</strong>
                            <p>Yes</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>Attachment:</strong>
                            <p><i class="bi bi-paperclip"></i> project_file.pdf</p>
                            <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Download</button>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Scenario:</strong>
                            <p>You are given a partially developed web application with missing functionalities...</p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <strong>Description:</strong>
                            <p>Debug and fix an issue where users cannot log in despite entering correct credentials...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                </div>
            </div>
        </div>
    </div>



    <!-- Fix for Edit Practical Scenario Modal -->
    <div class="modal fade" id="editScenarioModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title w-100 text-center">Edit Practical Test Scenario</h5>
                    <button type="button" class="btn-close btn-close-white position-absolute end-0 me-3" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <label class="fw-bold form-label">Competency Level</label>
                                <select class="form-select">
                                    <option>Choose Level</option>
                                    <option>Basic</option>
                                    <option>Intermediate</option>
                                    <option>Advanced</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="fw-bold form-label">Choose Skill</label>
                                <select class="form-select">
                                    <option>Choose Skill</option>
                                    <option>Analytical Thinking</option>
                                    <option>Problem Solving</option>
                                </select>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="fw-bold form-label">Point(s)</label>
                                <input type="number" class="form-control" value="1">
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="fw-bold form-label">Time Duration</label>
                                <input type="text" class="form-control" placeholder="HH:MM:SS">
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Scenario</label>
                                <textarea class="form-control" rows="2"></textarea>
                            </div>
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Description</label>
                                <textarea class="form-control" rows="2"></textarea>
                            </div>
                            <!-- In the Edit Practical Scenario Modal -->
                            <div class="col-md-12 mt-2">
                                <label class="fw-bold form-label">Attachment</label>
                                <input type="file" class="form-control mb-1" id="editScenarioFileInput">
                                <div class="mt-1 d-flex align-items-center">
                                    <button class="btn btn-outline-secondary btn-sm me-2"><i class="bi bi-upload"></i> Upload</button>
                                    <a href="#" id="editScenarioDownloadBtn" class="btn btn-outline-primary btn-sm me-2 d-none">
                                        <i class="bi bi-download"></i> Download
                                    </a>
                                    <button id="editScenarioClearBtn" class="btn btn-outline-danger btn-sm me-2 d-none">
                                        <i class="bi bi-x-circle"></i> Clear
                                    </button>
                                    <span id="editScenarioFileName" class="text-muted d-none"></span>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-flex justify-content-between mt-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Go Back</button>
                            <button type="submit" class="btn btn-primary">Update Scenario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



</div>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    // Function to handle file input changes
    function handleFileUpload(fileInputId, fileDisplayId, downloadBtnId, clearBtnId) {
        const fileInput = document.getElementById(fileInputId);
        const fileDisplay = document.getElementById(fileDisplayId);
        const downloadBtn = document.getElementById(downloadBtnId);
        const clearBtn = document.getElementById(clearBtnId);

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            
            if (file) {
                // Show file name
                fileDisplay.textContent = file.name;
                fileDisplay.classList.remove('d-none');

                // Show download button and create download link
                downloadBtn.classList.remove('d-none');
                downloadBtn.href = URL.createObjectURL(file);
                downloadBtn.download = file.name;

                // Show clear button
                clearBtn.classList.remove('d-none');
            } else {
                resetFileInput();
            }
        });

        // Clear button functionality
        clearBtn.addEventListener('click', function(event) {
            // Prevent form submission or modal closure
            event.preventDefault();
            event.stopPropagation();
            
            resetFileInput();
        });

        // Reset function
        function resetFileInput() {
            fileInput.value = ''; // Clear the file input
            fileDisplay.textContent = '';
            fileDisplay.classList.add('d-none');
            downloadBtn.classList.add('d-none');
            clearBtn.classList.add('d-none');
        }
    }

    // Initialize for Add Modal
    handleFileUpload(
        'addScenarioFileInput', 
        'addScenarioFileName', 
        'addScenarioDownloadBtn',
        'addScenarioClearBtn'
    );

    // Initialize for Edit Modal
    handleFileUpload(
        'editScenarioFileInput', 
        'editScenarioFileName', 
        'editScenarioDownloadBtn',
        'editScenarioClearBtn'
    );
});
</script>