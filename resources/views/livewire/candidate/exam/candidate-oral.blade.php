<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Oral Interview</h2>
    </div>
    <div class="container py-5" style="min-height: 85vh;  background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);">
        <div class="card mx-auto" style="max-width: 800px; border-radius: 12px;">
            <div class="card-body p-4" style="background-color: #1a1851; color:#ffffff;">

                <div class="row g-0">
                    <div class="col-md-6 border-end">
                        <div class="interview-container position-relative" style="background-color: #f0f0f0; border-radius: 8px 0 0 0;">
                            <div class="video-placeholder w-100 d-flex justify-content-center align-items-center" style="border: 2px dashed #ccc; border-radius: 8px 0 0 0;">
                                <img src="{{ asset('img/interview.webp') }}" alt="Interview" style="width: 100%; height: 300px; object-fit: cover; border-radius: 8px 0 0 0;">
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
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF;">
                <div class="modal-body p-4 text-center">
                    <h5 class="modal-title mb-4">Are you sure to have now the interview?</h5>
                    <div class="d-flex justify-content-between">
                        <button class="btn btn-secondary px-4" data-bs-dismiss="modal">No</button>
                        <button class="btn btn-primary px-4" id="confirmInterview">Yes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Candidate Information Modal -->
    <div class="modal fade" id="candidateInfoModal" tabindex="-1" aria-labelledby="candidateInfoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF;">
                <div class="modal-header" style="background-color: #1a1851; color: white; border-radius: 12px 12px 0 0;">
                    <h5 class="w-100 text-center modal-title fw-bold" id="candidateInfoLabel">Oral Interview</h5>
                </div>
                <div class="modal-body p-4">
                    <div class="card shadow-lg" style="border: 3px solid #1a1851; border-radius: 12px;">
                        <div class="card-body">
                            <h5 class="card-title text-center mb-4" style="color: #1a1851; font-weight: bold;">📌 Interview Instructions</h5>
                            <p class="card-text" style="font-size: 16px; color: #333;">Prepare for the formal setting as the recruiter looks for the following:</p>
                            <ul class="card-text" style="padding-left: 20px; font-size: 15px;">
                                <li><strong>🗣 Communication skills</strong></li>
                                <li><strong>💼 Work Experience/Portfolio</strong></li>
                            </ul>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Candidate Name</label>
                        <input type="text" class="form-control" placeholder="John Smith" value="John Smith">
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label class="form-label fw-bold">Date</label>
                            <input type="text" class="form-control" id="liveDate" readonly>
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-bold">Time</label>
                            <input type="text" class="form-control" id="liveTime" readonly>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Assessor Name</label>
                        <input type="text" class="form-control" value="Mary Wall Santos">
                    </div>

                    <div class="modal-footer d-flex justify-content-between mt-2">
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

    <!-- Add Bootstrap and custom JS -->
    <script>
       document.addEventListener('DOMContentLoaded', function() {
    // Open Confirmation Modal when clicking "Start the Interview"
    document.getElementById('startInterview').addEventListener('click', function() {
        var confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'));
        confirmationModal.show();
    });

    // Confirm Interview (Opens Candidate Info Modal)
    document.getElementById('confirmInterview').addEventListener('click', function() {
        bootstrap.Modal.getInstance(document.getElementById('confirmationModal')).hide();
        var candidateInfoModal = new bootstrap.Modal(document.getElementById('candidateInfoModal'));
        candidateInfoModal.show();
    });

    // Proceed to Success Modal
    document.getElementById('submitInterview').addEventListener('click', function() {
        bootstrap.Modal.getInstance(document.getElementById('candidateInfoModal')).hide();
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();

        // Redirect after 3 seconds
        setTimeout(function() {
            successModal.hide();
            // window.location.href = 'homepage.html'; // Uncomment this for redirection
        }, 3000);
    });

    function updateTimeAndDate() {
        const now = new Date();

        // Format time in 12-hour format with AM/PM
        let hours = now.getHours();
        let minutes = now.getMinutes();
        let ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12; 
        minutes = minutes < 10 ? '0' + minutes : minutes; 
        const formattedTime = `${hours}:${minutes} ${ampm}`;

        // Format date
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const formattedDate = now.toLocaleDateString('en-US', options);

        document.getElementById('currentTime').value = formattedTime;
        document.getElementById('currentDate').value = formattedDate;
    }

    setInterval(updateTimeAndDate, 1000);
    updateTimeAndDate();

    function updateDateTime() {
        const now = new Date();
        const date = now.toLocaleDateString();
        const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

        document.getElementById("liveDate").value = date;
        document.getElementById("liveTime").value = time;
    }

    updateDateTime();
    setInterval(updateDateTime, 1000);
});

        function updateTimeAndDate() {
            const now = new Date();

            // Format time in 12-hour format with AM/PM
            let hours = now.getHours();
            let minutes = now.getMinutes();
            let ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12 || 12; // Convert 0 (midnight) and 12 (noon) to 12-hour format
            minutes = minutes < 10 ? '0' + minutes : minutes; // Ensure two-digit minutes
            const formattedTime = `${hours}:${minutes} ${ampm}`;

            // Format date (e.g., March 31, 2025)
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = now.toLocaleDateString('en-US', options);

            // Update the input fields
            document.getElementById('currentTime').value = formattedTime;
            document.getElementById('currentDate').value = formattedDate;
        }

        // Run function every second
        setInterval(updateTimeAndDate, 1000);

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', updateTimeAndDate);

        document.addEventListener("DOMContentLoaded", function() {
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

            updateDateTime(); // Update immediately
            setInterval(updateDateTime, 1000); // Update every second
        });
    </script>
</div>