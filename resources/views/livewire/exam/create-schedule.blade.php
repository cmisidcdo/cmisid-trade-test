@extends('layouts.app')


@section('content')

<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Schedule </h2>
    </div>
    <section class="section dashboard">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">

                <!-- || Create Schedule and Modal -->
                <div class="d-flex justify-content-between align-items-center mt-3">

                    <!-- Button to trigger modal -->
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createScheduleModal">
                    <i class="bi bi-plus-lg me-1"></i> Create Schedule
                    </button>

                    <!-- Modal -->
                    <div class="modal fade" id="createScheduleModal" tabindex="-1" aria-labelledby="createScheduleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="border-radius: 12px;">
                                <div class="modal-body p-4">
                                    <h5 class="text-center mb-4" style="color: black;">Create Schedule for Assessment Test</h5>
                                    <form>
                                        <!-- Custom Dropdown with Arrow -->
                                        <div class="mb-3 position-relative">
                                            <select class="form-select custom-select-arrow border-dark" id="selectCandidate" style="border-radius: 8px;">
                                                <option selected disabled>Select Candidate</option>
                                                <option value="1">Juan dela Cruz</option>
                                                <option value="2">Aiko E. Lara</option>
                                                <option value="3">Venz Nolasco</option>
                                                <option value="4">Ace Gabriel Go</option>
                                                <option value="5">Mary Well Suarez</option>
                                                <option value="6">John Clark Obsioma</option>
                                            </select>
                                            <i class="bi bi-chevron-right custom-arrow"></i>
                                        </div>

                                        <div class="mb-3">
                                            <input type="time" class="form-control border-dark" id="selectTime" style="border-radius: 8px;">
                                        </div>
                                        <div class="mb-3">
                                            <input type="date" class="form-control border-dark" id="selectDate" style="border-radius: 8px;">
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <select class="form-select custom-select-arrow border-dark" id="status" style="border-radius: 8px;">
                                                <option value="Draft" selected>Draft</option>
                                                <option value="Confirmed">Confirmed</option>
                                            </select>
                                            <i class="bi bi-chevron-right custom-arrow"></i>
                                        </div>
                                        <div class="mb-3 position-relative">
                                            <select class="form-select custom-select-arrow border-dark" id="venue" style="border-radius: 8px;">
                                                <option selected disabled>Venue</option>
                                                <option value="Room 1">Court, Ground floor</option>
                                                <option value="Room 2">Room 2</option>
                                            </select>
                                            <i class="bi bi-chevron-right custom-arrow"></i>
                                        </div>

                                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                            <button type="submit" class="btn btn-primary px-4">
                                                Save
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal -->
               

                    <!--|| Search and Filter  -->
                    <div class="d-flex justify-content-between align-items-center mb-3">

                        <!-- Search bar -->
                        <div class="row justify-content-center">
                            <div class="position-relative">
                            <input type="text" class="form-control ps-5 border-1" placeholder="Search..." style="height: 40px; border-radius: 10px; outline: none; box-shadow: none; font-size: 14px;">
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
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Position Applied</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Office Applied</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Assessment Schedule</th>
                                <th style="background-color: #1A1851; color: white; border: 1px solid #1A1851;">Action</th>
                            </tr>
                        </thead>
                        <tbody style="border: 1px solid #ccc; border-collapse: collapse;">
                            <tr>
                                <td style="border: 1px solid black;">Juan dela Cruz</td>
                                <td style="border: 1px solid black;">HR</td>
                                <td style="border: 1px solid black;">CMISID</td>
                                <td style="border: 1px solid black;">9:00am to 11:00am</td>
                                <td style="border: 1px solid black;">
                                    <button class="btn btn-sm btn-outline-dark me-1" wire:click="view(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                        <i class="bi bi-eye-fill"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">View</span> -->
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary me-1" wire:click="edit(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                        <i class="bi bi-pencil-square"></i>
                                        <!-- <span class="d-none d-md-inline ms-1">Edit</span> -->
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" wire:click="delete(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="Archive">
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
