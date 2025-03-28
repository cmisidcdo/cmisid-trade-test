@extends('layouts.app')


@section('content')

<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exam List</h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <!-- || Create Schedule and Modal -->
                <div class="d-flex justify-content-between align-items-center mt-3">

                <div class="d-flex gap-2">

                    <!-- Create Schedule Button -->
                    <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
                        <i class="bi bi-plus-lg me-1"></i> Create Schedule for Oral Interview
                    </button>

                    <!-- View Archive Button -->
                    <button type="button" class="btn btn-sm d-flex align-items-center" style="background-color:rgb(205, 168, 58); color: #000; border-radius: 8px; padding: 6px 12px; border: none;">
                        <i class="bi bi-file-earmark-fill me-1" style="color:rgb(213, 35, 35);"></i> View Archive
                    </button>
                </div>


                    <!-- Modal -->
                    <div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="createScheduleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content" style="border-radius: 12px;">
                                <div class="modal-body p-4">
                                    <h5 class="text-center mb-4 fw-bold" style="color: black;">Create Schedule for Oral Interview</h5>
                                    <form>
                                        <div class="row g-3">
                                            <!-- Select Candidate -->
                                            <div class="col-md-6">
                                                <select class="form-select border-dark" id="selectCandidate" style="border-radius: 8px;">
                                                    <option selected disabled>Select Candidate</option>
                                                    <option value="1">Juan dela Cruz</option>
                                                    <option value="2">Aiko E. Lara</option>
                                                    <option value="3">Venz Nolasco</option>
                                                    <option value="4">Ace Gabriel Go</option>
                                                    <option value="5">Mary Well Suarez</option>
                                                    <option value="6">John Clark Obsioma</option>
                                                </select>
                                            </div>
                                            <!-- Select Time -->
                                            <div class="col-md-6">
                                                <input type="time" class="form-control border-dark" id="selectTime" style="border-radius: 8px;">
                                            </div>
                                            <!-- Select Date -->
                                            <div class="col-md-6">
                                                <input type="date" class="form-control border-dark" id="selectDate" style="border-radius: 8px;">
                                            </div>
                                            <!-- Status -->
                                            <div class="col-md-6">
                                                <select class="form-select border-dark" id="status" style="border-radius: 8px;">
                                                    <option value="Draft" selected>Draft</option>
                                                    <option value="Confirmed">Publish</option>
                                                </select>
                                            </div>
                                            <!-- Venue -->
                                            <div class="col-12">
                                                <select class="form-select border-dark" id="venue" style="border-radius: 8px;">
                                                    <option selected disabled>Venue</option>
                                                    <option value="Room 1">Court, Ground floor</option>
                                                    <option value="Room 2">Room 2</option>
                                                </select>
                                            </div>
                                            <!-- Assessor and Secretariat Assign -->
                                            <div class="col-md-6">
                                                <select class="form-select border-dark" id="assessorAssign" style="border-radius: 8px;">
                                                    <option selected disabled>Assessor Assign</option>
                                                    <option value="1">Assessor 1</option>
                                                    <option value="2">Assessor 2</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-select border-dark" id="secretariatAssign" style="border-radius: 8px;">
                                                    <option selected disabled>Secretariat Assign</option>
                                                    <option value="1">Secretariat 1</option>
                                                    <option value="2">Secretariat 2</option>
                                                </select>
                                            </div>
                                        </div>

                                        <hr style="border: 1px solid blaclk; margin: 1.5rem 0;">

                                        <!-- Assessment Exam Questions -->
                                        <div class="col-12">
                                            <div class="d-flex justify-content-between align-items-center mb-2 mt-3">
                                                <h5 class="fw-semibold mb-0">Oral Exam Questions</h5>
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" wire:click="selectSkills">
                                                    <i class="bi bi-plus-circle me-1"></i> Add Questions
                                                </button>
                                            </div>

                                            <div class="table-responsive">
                                                <table class="table text-center mt-2">
                                                    <thead style="border-collapse: collapse;">
                                                        <tr>
                                                            <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Questions</th>
                                                            <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="border: 1px solid #ccc; border-collapse: collapse; text-align: left;">
                                                    <tr>
                                                        <td style="border: 1px solid black;">Is the world ending?</td>
                                                        <td style="border: 1px solid black; text-align: center;">
                                                        <button type="button" class="btn btn-sm align-items-center">
                                                            <i class="bi bi-trash me-1"></i> Remove
                                                        </button>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border: 1px solid black;">Which is which?</td>
                                                        <td style="border: 1px solid black; text-align: center;">
                                                        <button type="button" class="btn btn-sm align-items-center" >
                                                            <i class="bi bi-plus-circle me-1"></i> Add
                                                        </button>
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                        <!-- End of Assessment Exam Questions -->

                                        <!-- Confirm Create Schedule & Generate Code Button -->
                                         <div class="float-start">
                                            <div class="d-flex gap-2 justify-content-start flex-column mt-2">
                                                <button type="submit" class="btn btn-primary btn-sm d-flex align-items-center" style="width: 180px;">
                                                    <i class="bi bi-check-circle me-1"></i> Confirm Create Schedule
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" style="width: 70px;">
                                                    <i class="bi bi-arrow-left me-1"></i> Back
                                                </button>
                                            </div>
                                         </div>

                                        <!-- Modal Pagination -->
                                        <div class="float-end">
                                            <div class="d-flex justify-content-between align-items-center mt-2 flex-column">
                                                <div>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="previousPage" disabled onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        &laquo;
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(1)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        1
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(2)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        2
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(3)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        3
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm" wire:click="nextPage" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        &raquo;
                                                    </button>
                                                </div>
                                                <div class="pageNumber-overTotal ">1 / 10</div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->

                     <!-- View Modal -->
                    <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content" style="border-radius: 12px;">
                                    <div class="modal-body p-4">
                                        <h5 class="text-center mb-4 fw-bold" style="color: black;">Create Schedule for Oral Interview</h5>
                                        <form>
                                            <div class="row g-3">
                                                <!-- Select Candidate -->
                                                <div class="col-md-6">
                                                    <select class="form-select border-dark" id="selectCandidate" style="border-radius: 8px;">
                                                        <option selected disabled>Select Candidate</option>
                                                        <option value="1">Juan dela Cruz</option>
                                                        <option value="2">Aiko E. Lara</option>
                                                        <option value="3">Venz Nolasco</option>
                                                        <option value="4">Ace Gabriel Go</option>
                                                        <option value="5">Mary Well Suarez</option>
                                                        <option value="6">John Clark Obsioma</option>
                                                    </select>
                                                </div>
                                                <!-- Select Time -->
                                                <div class="col-md-6">
                                                    <input type="time" class="form-control border-dark" id="selectTime" style="border-radius: 8px;">
                                                </div>
                                                <!-- Select Date -->
                                                <div class="col-md-6">
                                                    <input type="date" class="form-control border-dark" id="selectDate" style="border-radius: 8px;">
                                                </div>
                                                <!-- Status -->
                                                <div class="col-md-6">
                                                    <select class="form-select border-dark" id="status" style="border-radius: 8px;">
                                                        <option value="Draft" selected>Draft</option>
                                                        <option value="Confirmed">Publish</option>
                                                    </select>
                                                </div>
                                                <!-- Venue -->
                                                <div class="col-12">
                                                    <select class="form-select border-dark" id="venue" style="border-radius: 8px;">
                                                        <option selected disabled>Venue</option>
                                                        <option value="Room 1">Court, Ground floor</option>
                                                        <option value="Room 2">Room 2</option>
                                                    </select>
                                                </div>
                                                <!-- Assessor and Secretariat Assign -->
                                                <div class="col-md-6">
                                                    <select class="form-select border-dark" id="assessorAssign" style="border-radius: 8px;">
                                                        <option selected disabled>Assessor Assign</option>
                                                        <option value="1">Assessor 1</option>
                                                        <option value="2">Assessor 2</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <select class="form-select border-dark" id="secretariatAssign" style="border-radius: 8px;">
                                                        <option selected disabled>Secretariat Assign</option>
                                                        <option value="1">Secretariat 1</option>
                                                        <option value="2">Secretariat 2</option>
                                                    </select>
                                                </div>
                                            </div>

                                        <hr style="border: 1px solid blaclk; margin: 1.5rem 0;">

                                        <!-- Assessment Exam Questions -->
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table class="table text-center mt-2">
                                                    <thead style="border-collapse: collapse;">
                                                        <tr>
                                                            <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Questions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody style="border: 1px solid #ccc; border-collapse: collapse; text-align: left;">
                                                        <tr>
                                                            <td style="border: 1px solid black;">Is the world ending?</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="border: 1px solid black;">Which is which?</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>   
                                        </div>
                                        <!-- End of Assessment Exam Questions -->

                                        <!-- Back Button -->
                                         <div class="float-start mt-3">
                                            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center" style="width: 70px;">
                                                <i class="bi bi-arrow-left me-1"></i> Back
                                            </button>
                                         </div>

                                        <!-- Modal Pagination -->
                                        <div class="float-end">
                                            <div class="d-flex justify-content-between align-items-center mt-2 flex-column">
                                                <div>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="previousPage" disabled onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        &laquo;
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(1)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        1
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(2)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        2
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(3)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        3
                                                    </button>
                                                    <button class="btn btn-outline-dark btn-sm" wire:click="nextPage" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                                                        &raquo;
                                                    </button>
                                                </div>
                                                <div class="pageNumber-overTotal ">1 / 10</div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End View Modal -->

            
                    <!--|| Search and Filter  -->
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <!-- Search bar -->
                        <div class="row justify-content-center">
                            <div class="position-relative">
                            <input type="text" class="form-control ps-5 border-1 border-" placeholder="Search..." style="height: 40px; border-radius: 10px; outline: none; box-shadow: none; font-size: 14px; border: 1px solid #4a4a4a;">
                            <i class="bi bi-search position-absolute top-50 start-1 translate-middle-y ms-3 text-secondary"></i>
                            </div>
                        </div>

                        <!-- Filter button -->
                        <div class="dropdown ms-2">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="filterDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-funnel"></i> Filter
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                <li>
                                    <button class="dropdown-item" wire:click="$set('filterStatus', 'all')">
                                        <i class="bi bi-list"></i> All Users
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" wire:click="$set('filterStatus', 'yes')">
                                        <i class="bi bi-person-check"></i> Active Users
                                    </button>
                                </li>
                                <li>
                                    <button class="dropdown-item" wire:click="$set('filterStatus', 'no')">
                                        <i class="bi bi-person-x"></i> Inactive Users
                                    </button>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <!-- Table -->
                <div class="table-responsive">
                    <table class="table text-center mt-2">
                        <thead style="border-collapse: collapse;">
                            <tr>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Name</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Access Code</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Date</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Time</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Venue</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid #ccc; border-collapse: collapse;">
                            <tr>
                                <td style="border: 1px solid black;">Juan dela Cruz</td>
                                <td style="border: 1px solid black;">#code</td>
                                <td style="border: 1px solid black;">3/28/2025</td>
                                <td style="border: 1px solid black;">9:00am</td>
                                <td style="border: 1px solid black;">City Hall CDO</td>
                                <td style="border: 1px solid black;">
                                    <button class="btn btn-sm btn-outline-dark me-1" data-bs-toggle="modal" data-bs-target="#viewModal" data-bs-placement="top" title="View">
                                        <i class="bi bi-eye-fill"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">View</span> -->
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary me-1" data-bs-toggle="modal" data-bs-target="#createScheduleModal" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">Edit</span> -->
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive">
                                        <i class="bi bi-archive-fill"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">Archive</span> -->
                                    </button>
                                </td>
                            </tr>
                        
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex flex-column align-items-end justify-content-end mt-3">
        
                    <div>
                        <button class="btn btn-outline-dark btn-sm me-1" wire:click="previousPage" disabled onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                            &laquo;
                        </button>
                        <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(1)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                            1
                        </button>
                        <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(2)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                            2
                        </button>
                        <button class="btn btn-outline-dark btn-sm me-1" wire:click="gotoPage(3)" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                            3
                        </button>
                        <button class="btn btn-outline-dark btn-sm" wire:click="nextPage" onmouseover="this.style.backgroundColor='#6c757d'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='#000';">
                            &raquo;
                        </button>
                    </div>
                    <div class="pageNumber-overTotal  me-5">1 / 10</div>
                </div>
    
            </div>
        </div>
    </section>
</div>

<style>
.custom-select-arrow {
    background-image: none;
}

.custom-arrow {
    position: absolute;
    top: 50%;
    right: 12px;
    transform: translateY(-50%) rotate(0deg);
    transition: transform 0.3s ease;
    pointer-events: none;
}

.custom-select-arrow:focus + .custom-arrow,
.custom-select-arrow:active + .custom-arrow {
    transform: translateY(-50%) rotate(90deg); /* Rotate when open */
}

</style>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

@endsection
