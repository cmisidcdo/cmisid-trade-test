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
                            <div class="mb-3">
                                <label class="form-label">Enter the Code for Practical Exam</label>
                                <input type="text" class="form-control form-control-lg mb-1" placeholder="">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logos -->
        <div class="logos col-lg-6 d-flex flex-column justify-content-center align-items-start text-start ps-3 mt-4">
            <img src="{{ asset('img/cdologo.png') }}" alt="logo" class="img-fluid">
        </div>

    </div>

    <!-- Confirmation Modal -->
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


    <!-- Candidate Information Modal -->
    <div class="modal fade" id="candidateInfoModal" tabindex="-1" aria-labelledby="candidateInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-m">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF">
                <div class="modal-header" style="background-color: #1a1851; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="w-100 text-center modal-title fw-bold" id="candidateInfoLabel">Practical Exam</h5>
                </div>
                <div class="modal-body p-3">
                    <div class="card shadow-lg" style="border: 3px solid #1a1851; border-radius: 12px;">
                        <div class="card-body" style="padding: 12px;">
                            <h5 class="card-title text-center mb-3" style="color: #1a1851; font-weight: bold;">📌 Test Instructions</h5>
                            <ul class="card-text" style="padding-left: 15px; font-size: 15px;">
                                <li><strong>Proceed to the Venue which is to be held for the Practical Exam.</strong></li>
                                <li><strong>Look for the Assessor which will be the one observing you executing tasks.</strong></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Candidate Name</label>
                        <input type="text" class="form-control" placeholder="John Smith" value="John Smith">
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Venue</label>
                        <input type="text" class="form-control" placeholder="CLENRO Roof Deck" value="CLENRO Roof Deck">
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label fw-bold">Date</label>
                            <input type="text" class="form-control" id="liveDate" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Time</label>
                            <input type="text" class="form-control" id="liveTime" readonly>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label fw-bold">Assessor Name</label>
                        <input type="text" class="form-control" value="Mary Wall Santos">
                    </div>
                    <div class="mb-2">
                        <label class="form-label fw-bold">Confirmation code (For Assessor Only)</label>
                        <input type="text" class="form-control" value="">
                    </div>

                    <div class="modal-footer d-flex justify-content-between mt-1">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#confirmationModal">Back</button>
                        <button type="button" class="btn btn-primary" id="submitInterview">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Success Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; background-color: #ffffff; border: 2px solid #007BFF;">
                <div class="modal-body p-4 text-center">
                    <h5 class="modal-title fw-bold mb-3">Success!</h5>
                    <h6 class="mb-3">Interview Accessed!</h6>
                    <p class="text-muted small">Returning you to the homepage...</p>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize modals with static backdrop (confirmation and candidate info)
            const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const candidateInfoModal = new bootstrap.Modal(document.getElementById('candidateInfoModal'), {
                backdrop: 'static',
                keyboard: false
            });

            // Success modal with default dismissible behavior
            const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                backdrop: true
            });

            // Show confirmation modal on click
            document.getElementById('startInterview').addEventListener('click', function() {
                confirmationModal.show();
            });

            // When user agrees, hide confirmation and show candidate info modal
            document.getElementById('confirmInterview').addEventListener('click', function() {
                confirmationModal.hide();
                candidateInfoModal.show();
            });

            // When interview is submitted, show success modal then redirect
            document.getElementById('submitInterview').addEventListener('click', function() {
                candidateInfoModal.hide();
                successModal.show();

                setTimeout(function() {
                    successModal.hide();
                    // Uncomment the line below to redirect after success
                    // window.location.href = 'homepage.html';
                }, 3000);
            });

            // Time & date display updates
            function updateTimeAndDate() {
                const now = new Date();
                let hours = now.getHours();
                let minutes = now.getMinutes();
                let ampm = hours >= 12 ? 'PM' : 'AM';
                hours = hours % 12 || 12;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                const formattedTime = `${hours}:${minutes} ${ampm}`;

                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedDate = now.toLocaleDateString('en-US', options);

                document.getElementById('currentTime').value = formattedTime;
                document.getElementById('currentDate').value = formattedDate;
            }

            function updateDateTime() {
                const now = new Date();
                const date = now.toLocaleDateString();
                const time = now.toLocaleTimeString([], {
                    hour: '2-digit',
                    minute: '2-digit'
                });

                document.getElementById("liveDate").value = date;
                document.getElementById("liveTime").value = time;
            }

            setInterval(updateTimeAndDate, 1000);
            setInterval(updateDateTime, 1000);
            updateTimeAndDate();
            updateDateTime();
        });
    </script>
</div>