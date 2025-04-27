<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Practical Exam</h2>
    </div>
    <div class="container py-5" style="min-height: 85vh;  background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);">
        <div class="card mx-auto" style="max-width: 800px; border-radius: 12px;">
            <div class="card-body p-4" style="background-color: #1a1851; color:#ffffff;">

                <div class="row g-0">
                    <div class="col-md-6 border-end">
                        <div class="exam-container position-relative" style="background-color: #f0f0f0; border-radius: 8px 0 0 0;">
                            <div class="exam-placeholder w-100 d-flex justify-content-center align-items-center" style="border: 2px dashed #ccc; border-radius: 8px 0 0 0;">
                                <img src="{{ asset('img/exam.webp') }}" alt="Interview" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px 0 0 0;">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3">
                            <form wire:submit.prevent="login">
                            <div class="mb-3">
                                <label class="form-label">Enter the Code for Practical Exam</label>
                                <input type="text" wire:model="inputcode" class="form-control form-control-lg rounded-3 bg-light fs-6 @error('code') is-invalid @enderror" placeholder="Enter Code" aria-label="Unique Code" required>  
                                @if (session()->has('error'))
                                    <div class="alert alert-danger">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                            <div class="py-2 position-relative mb-3">
                                <div style="border-top: 1px dotted rgba(255,255,255,0.5); position: absolute; top: 50%; left: 0; right: 0;"></div>
                                <div class="d-flex justify-content-between">
                                    <label class="form-label mb-2 bg-[#1a1851] pe-2 position-relative" style="z-index: 1;">Current Time</label>
                                    <label class="col-6 form-label mb-2 position-relative d-block text-start" style="z-index: 1;">Date Now</label>
                                </div>
                                <div class="row">
                                    <div class="col-6 pe-1">
                                        <input type="text" id="currentTime" class="form-control text-center" readonly>
                                    </div>
                                    <div class="col-6 ps-1">
                                        <input type="text" id="currentDate" class="form-control text-center" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid mt-4">
                                <button class="btn btn-primary" id="startInterview">Start the Interview</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="logos col-lg-6 d-flex flex-column justify-content-center align-items-start text-start ps-3 mt-4">
            <img src="{{ asset('img/cdologo.png') }}" alt="logo" class="img-fluid">
        </div>

    </div>

    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: 2px solid #007BFF;">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title fw-bold text-center" id="confirmationModalLabel">⚠️ Warning before taking the Exam!</h5>
                </div>

                <div class="modal-body">
                    <p>Before proceeding with the examination, please read and agree to the following oath</p>
                    <p><strong>I solemnly affirm that:</strong></p>
                    <ul>
                        <li>I will complete this Practical Exam independently, without assistance from any person or unauthorized resources.</li>
                        <li>I will perform the required tasks honestly, accurately, and to the best of my ability.</li>
                        <li>I understand that violating these rules may result in disqualification or other disciplinary actions.</li>
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="confirmInterview">I Agree and take the Exam</button>

                </div>
            </div>
        </div>
    </div>

    <style>
        .logos img {
            height: 150px;
            max-width: 100%;
        }
    </style>
    <!-- Add Bootstrap and custom JS -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const startButton = document.getElementById('startInterview');
        const confirmButton = document.getElementById('confirmInterview');

        Livewire.on('show-confirmationModal', function() {
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
            confirmationModal.show();
        });

        confirmButton.addEventListener('click', function () {
            window.location.href = "{{ url('candidate/exam/practical') }}";
        });
    });
    </script>
</div>