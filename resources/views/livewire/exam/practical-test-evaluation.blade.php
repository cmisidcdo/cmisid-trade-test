@extends('layouts.app')

@section('content')
    <style>
        .evaluator {
            margin: 70px 0 24px 0;
        }

        body {
            font-family: "Open Sans", sans-serif;
            font-size: 15px;
        }

          /* Dropdown container */
        .dropdown-wrapper {
            position: relative;
            display: inline-block;
            width: 100%;
            max-width: 500px;
        }

        /* Hidden dropdown styles */
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

        /* Dropdown button styling */
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

        /* Arrow styling */
        .arrow {
            transition: transform 0.2s ease;
        }

        /* Open state using CSS checkbox */
        .dropdown-wrapper input[type="checkbox"] {
            display: none;
        }

        /* When checkbox is checked, show dropdown */
        .dropdown-wrapper input[type="checkbox"]:checked + .dropdown-btn + .dropdown-content {
            display: block;
            opacity: 1;
            transform: translateY(0);
        }

        /* Rotate arrow when open */
        .dropdown-wrapper input[type="checkbox"]:checked + .dropdown-btn .arrow {
            transform: rotate(90deg); /* From side to down */
        }

        /* Option styling */
        .dropdown-option {
            padding: 10px;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .dropdown-option:hover {
            background-color: #f0f0f0;
        }

        /* Table Design */
        .table tbody tr th {
            background-color: white;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

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


    </style>

<div class="">
    <div class="globalheader m-0">
        <h3 class="fw-bold m-0">Practical Test Evaluation Form</h3>
    </div>

    <section class="section dashboard mt-4" >
        <div class="card shadow-sm border-0 rounded-3 p-4 bg-white">

            <!-- Select Candidate -->
            <div class="d-flex align-items-center justify-content-center mb-5 me-5">
                <label for="candidate" class="form-label fw-bold me-2">Select Candidate</label>
                <div class="dropdown-wrapper">
                    <input class="border-dark bg-white" type="checkbox" id="dropdownToggle">
                    <label for="dropdownToggle" class="dropdown-btn">
                    <span></span>
                    <svg class="arrow" width="16" height="16" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9 18l6-6-6-6"></path>
                    </svg>
                    </label>
                    <div class="dropdown-content">
                        <div class="dropdown-option">Sample Candidate 1</div>
                        <div class="dropdown-option">Sample Candidate 2</div>
                        <div class="dropdown-option">Sample Candidate 3</div>
                    </div>
                </div>
            </div>

            <!-- Evaluation Criteria Table -->
            <div class="table-responsive">
                <table class="table custom-table">
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


        <div class="d-flex justify-content-between align-items-start">
            
            <!-- Comment Section -->
            <div style="width: 45%;"> 
                <label for="comments" class="form-label fw-bold">Comment & Recommendations</label>
                <textarea class="form-control bg-white border-dark " id="comments" rows="6"></textarea>
            </div>

            <div class="d-flex flex-column align-items-end" style="width: 40%;">

                <!-- Total Score Section -->
                <div class="d-flex align-items-center total-score-section">
                    <label for="totalScore" class="form-label fw-bold me-2">Total Score</label>
                    <input type="text" class="form-control bg-white border-dark me-5" id="totalScore" name="totalScore" style="width: 100px;" readonly>
                </div>

                <!-- Evaluator's Signature -->
                <div>
                    <p class="fw-bold text-center evaluator">Evaluator’s Name and Signature</p>
                    <p class="border-bottom border-dark" style="width: 270px;"></p>
                </div>
            </div>
        </div>

        </div>
    </section>
</div>

@endsection
