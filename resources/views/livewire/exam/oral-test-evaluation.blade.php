@extends('layouts.app')


@section('content')

<style>

body {
    font-family: "Open Sans", sans-serif;
    font-size: 15px;
}

/* || Table */
.custom-table th,
.custom-table td {
    border-bottom: 1px solid #ccc;
    padding: 10px;
}

.custom-table th {
    background-color: #f8f9fa;
    font-weight: bold;
}

.custom-table td {
    background-color: #ffffff; 
}

/* || Signature */
.assessor {
            margin: 60px 0 24px 0;
        }


/* || Input size adjustment */

.row .candidate-input .column-left {
    max-width: 81%;
}

.row .candidate-input .column-right {
    max-width: 85%; 
}

/* || Dropdown */

.dropdown-wrapper {
        position: relative;
        display: inline-block;
        width: 100%;
        max-width: 500px;
}

.dropdown-content {
    display: none;
    position: absolute;
    width: 100%;
    background-color: #fff;
    border: 1px solid #ccc;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 10;
    border-radius: 4px;
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.dropdown-btn {
    width: 100%;
    padding: 10px;
    border: 1px solid black;
    background-color: #fff;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    cursor: pointer;
}

.arrow {
    transition: transform 0.2s ease;
}

.dropdown-wrapper.active .dropdown-content {
    display: block;
    opacity: 1;
    transform: translateY(0);
}

.dropdown-wrapper.active .arrow {
    transform: rotate(90deg);
}

.dropdown-option {
    padding: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.dropdown-option:hover {
    background-color: #f0f0f0;
}

</style>



<div class="">
    <div class="card-header text-white text-center py-3" style="background-color: #1A1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Test Evaluation Form</h2>
    </div>

    <section class="section dashboard mt-4" >
        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">
            
        <!-- Candidate Details -->
            <h5 class="fw-bold">Candidate Details</h5>
            <div class="row g-3 mb-4">
                <!-- Name Dropdown -->
                <div class="candidate-input col-md-6 d-flex justify-content-end gap-1 align-items-center">
                    <label for="nameDropdown" class="form-label text-nowrap me-2 fw-semibold">Name</label>
                    <div class="dropdown-wrapper column-left">
                        <div class="dropdown-btn">
                            <span></span>
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </div>
                        <div class="dropdown-content">
                            <div class="dropdown-option">John Doe</div>
                            <div class="dropdown-option">Jane Smith</div>
                            <div class="dropdown-option">Emily Johnson</div>
                        </div>
                    </div>
                </div>

                <!-- Position Dropdown -->
                <div class="candidate-input col-md-6 d-flex justify-content-end gap-1 align-items-center">
                    <label for="positionDropdown" class="form-label text-nowrap me-2 fw-semibold">Position</label>
                    <div class="dropdown-wrapper column-right">
                        <div class="dropdown-btn">
                            <span></span>
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </div>
                        <div class="dropdown-content">
                            <div class="dropdown-option">Manager</div>
                            <div class="dropdown-option">Assistant</div>
                            <div class="dropdown-option">Developer</div>
                        </div>
                    </div>
                </div>

                <!-- Salary Grade Dropdown -->
                <div class="candidate-input col-md-6 d-flex justify-content-end gap-1 align-items-center">
                    <label for="salaryDropdown" class="form-label text-nowrap me-2 fw-semibold">Salary Grade</label>
                    <div class="dropdown-wrapper column-left">
                        <div class="dropdown-btn">
                            <span></span>
                            <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 18l6-6-6-6"></path>
                            </svg>
                        </div>
                        <div class="dropdown-content">
                            <div class="dropdown-option">Grade 1</div>
                            <div class="dropdown-option">Grade 2</div>
                            <div class="dropdown-option">Grade 3</div>
                        </div>
                    </div>
                </div>
                <!-- Date -->
                <div class="candidate-input col-md-6 d-flex justify-content-end gap-1 align-items-center">
                    <label for="date" class="form-label text-nowrap me-2 fw-semibold">Date</label>
                    <input type="date" class="form-control bg-white border-dark column-right" id="date">
                </div>
            </div>

            <!-- Evaluation Criteria Table -->
            <div class="table-responsive mt-2">
                <table class="table bg-white custom-table">
                    <thead>
                        <tr>
                            <th>Criteria Name</th>
                            <th>Percentage</th>
                            <th>Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Analytical Thinking</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Problem Solving</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Criteria #3</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Criteria #4</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex flex-row justify-content-between">

                <!-- Comments and Recommendations -->
                <div style="width: 75%;"> 
                    <h5 class="fw-bold mb-3 mt-3">Comments and Final Recommendations</h5>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendation" id="waitlist" value="waitlist">
                        <label class="form-check-label bg-white" for="waitlist">Waitlist</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendation" id="pass" value="pass">
                        <label class="form-check-label bg-white" for="pass">Pass</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="recommendation" id="fail" value="fail">
                        <label class="form-check-label bg-white" for="fail">Fail</label>
                    </div>
                </div>

                <!-- Total Score Section -->
                <div class="d-flex align-items-center total-score-section">
                    <label for="totalScore" class="form-label fw-bold me-2">Total Score</label>
                    <input type="text" class="form-control bg-white border-dark me-5" id="totalScore" name="totalScore" style="width: 100px;" readonly>
                </div>
            </div>

            <!-- Assessor's Signature -->
  
                <div>
                    <p class="fw-bold text-center assessor">Assessor's  Name and Signature</p>
                    <p class="border-bottom border-dark mx-auto" style="width: 270px;"></p>
                </div>

        </div>
    </section>
</div>


<script>
    document.querySelectorAll('.dropdown-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const wrapper = btn.parentElement;
        wrapper.classList.toggle('active');
    });
});
</script>

@endsection