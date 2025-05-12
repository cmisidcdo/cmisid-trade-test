<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Assessment Test</h2>
    </div>
    <div class="assesment-container py-4" style="min-height: 85vh; background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);">

        <div class="card mx-auto mt-4" style="max-width: 600px; border-radius: 12px; border: 2px solid #007BFF;">
            <div class="card-body">
                <h3 class="text-center card-title fw-bold" style="font-size: 22px;">Test Instructions</h3>
                <ul class="card-text" style="font-size: 18px;">
                    <li>This exam consists of <strong>multiple-choice questions</strong> (MCQs).</li>
                    <li>The exam is <strong>timed</strong>, and the remaining time will be displayed on your screen.</li>
                    <li>Kindly <strong>minimize noises</strong> during the exam.</li>
                    <li>If there are any issues, you may raise your hand or call and ask the person in charge of the test.</li>
                    <li>Any form of <strong>cheating or misconduct</strong> will result in disqualification.</li>
                    <li>Once you submit the test, you may <strong>not return</strong> to change it.</li>
                </ul>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary text-white px-4 py-2" data-bs-toggle="modal" data-bs-target="#warningModal">
                        Proceed to the Assessment Test
                    </button>
                </div>
            </div>
        </div>

        <div class="logos col-lg-6 d-flex flex-column justify-content-center align-items-start text-start ps-3 mt-4">
            <img src="{{ asset('img/cdologo.png') }}" alt="logo" class="img-fluid">
        </div>

    </div>

    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title fw-bold text-center" id="warningModalLabel">⚠️Warning before taking the Test!</h5>
                </div>
    
                <div class="modal-body">
                    <p>Before proceeding with the examination, please read and agree to the following oath</p>
                    <p><strong>I solemnly affirm that:</strong></p>
                    <ul>
                        <li>I will not use any external devices, software, or tools that may provide an unfair advantage.</li>
                        <li>I will not engage in cheating, plagiarism, or any form of academic dishonesty during this examination.</li>
                        <li>I understand that any violation of these rules may result in disqualification, cancellation of my results, or further disciplinary action.</li>
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" wire:click="proceedToTest" data-bs-dismiss="modal">I Agree and take the Test</button>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        Livewire.on('openTestInNewTab', function () {
            window.open("{{ route('candidate.exam.assessment') }}", '_blank');
        });

        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('go-back', function () {
                window.history.back();
            });
        });
    </script>
    
    <style>
        .logos img {
            height: 150px;
            max-width: 100%;
        }

        .timer-display {
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 16px;
            transition: all 0.5s ease;
            font-size: 20px;
            background-color: #4CAF50;
            /* Green background */
            color: white;
            /* White text */
            font-weight: bold;
        }


        .timer-warning {
            background-color: #ff9800;
            /* Orange background */
            color: white;
            font-weight: bold;
        }

        .timer-danger {
            background-color: #f44336;
            /* Red background */
            color: white;
            font-weight: bold;
            animation: pulse 1s infinite;
        }

        .modal-warning-bg {
            background-color: #fff3e0 !important;
            /* Light orange background */
        }

        .modal-danger-bg {
            background-color: #ffebee !important;
            /* Light red background */
            animation: bg-pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }

            100% {
                opacity: 1;
            }
        }

        @keyframes bg-pulse {
            0% {
                background-color: #ffebee;
            }

            50% {
                background-color: #ffcdd2;
            }

            100% {
                background-color: #ffebee;
            }
        }
    </style>
    @script
    <script>
        Livewire.on('openTestInNewTab', function () {
        
            window.open("{{ route('candidate.exam.assessment') }}", '_blank');
        });
    </script>
    @endscript
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize all modals with static backdrop except for success modal
            const warningModal = new bootstrap.Modal(document.getElementById('warningModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const testModal = new bootstrap.Modal(document.getElementById('testModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const testModalPage2 = new bootstrap.Modal(document.getElementById('testModalPage2'), {
                backdrop: 'static',
                keyboard: false
            });

            const submitconfirmationModal = new bootstrap.Modal(document.getElementById('submitconfirmationModal'), {
                backdrop: 'static',
                keyboard: false
            });

            const threeMinWarningModal = new bootstrap.Modal(document.getElementById('threeMinWarningModal'));
            const oneMinWarningModal = new bootstrap.Modal(document.getElementById('oneMinWarningModal'));
            const timesUpModal = new bootstrap.Modal(document.getElementById('timesUpModal'), {
                backdrop: 'static',
                keyboard: false
            });

            // Success modal can be closed by clicking outside
            const successModal = new bootstrap.Modal(document.getElementById('successModal'), {
                backdrop: true
            });

            // Timer variables
            let totalSeconds = 5 * 60; // 5 minutes in seconds
            let timerInterval;
            let isTimerRunning = false;

            // Timer element references
            const timerEl1 = document.getElementById('timer1');
            const timerEl2 = document.getElementById('timer2');
            const timerDisplays = document.querySelectorAll('.timer-display');
            const testModalContents = document.querySelectorAll('.test-modal-content');

            // Format seconds to MM:SS
            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            // Start the timer when test begins
            function startTimer() {
                if (!isTimerRunning) {
                    isTimerRunning = true;
                    timerInterval = setInterval(updateTimer, 1000);
                }
            }

            // Update timer display and check for warnings
            function updateTimer() {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    // Auto-submit when time is up
                    autoSubmitTest();
                    return;
                }

                totalSeconds--;
                const timeString = formatTime(totalSeconds);

                // Update all timer displays
                timerEl1.textContent = timeString;
                timerEl2.textContent = timeString;

                // Check for warning thresholds
                if (totalSeconds === 180) { // 3 minutes warning
                    show3MinuteWarning();
                } else if (totalSeconds === 60) { // 1 minute warning
                    show1MinuteWarning();
                }
            }

            // Show 3-minute warning
            function show3MinuteWarning() {
                // Change timer display to orange
                timerDisplays.forEach(display => {
                    display.classList.add('timer-warning');
                    display.classList.remove('timer-danger');
                });

                // Change modal background to light orange
                testModalContents.forEach(content => {
                    content.classList.add('modal-warning-bg');
                    content.classList.remove('modal-danger-bg');
                });

                // Show 3-minute warning modal
                threeMinWarningModal.show();

                // Auto-close warning after 3 seconds
                setTimeout(() => {
                    threeMinWarningModal.hide();
                }, 3000);
            }

            // Show 1-minute warning
            function show1MinuteWarning() {
                // Change timer display to red with pulsing
                timerDisplays.forEach(display => {
                    display.classList.remove('timer-warning');
                    display.classList.add('timer-danger');
                });

                // Change modal background to light red with pulsing
                testModalContents.forEach(content => {
                    content.classList.remove('modal-warning-bg');
                    content.classList.add('modal-danger-bg');
                });

                // Show 1-minute warning modal
                oneMinWarningModal.show();

                // Auto-close warning after 3 seconds
                setTimeout(() => {
                    oneMinWarningModal.hide();
                }, 3000);
            }

            // Auto-submit test when time runs out
            function autoSubmitTest() {
                // Hide any open modals
                testModal.hide();
                testModalPage2.hide();

                // Show time's up modal
                timesUpModal.show();

                // Auto-proceed to submission after 2 seconds
                setTimeout(() => {
                    timesUpModal.hide();
                    successModal.show();

                    // Auto-close success modal and redirect
                    setTimeout(function() {
                        successModal.hide();
                        // window.location.href = 'homepage.html'; // Uncomment this for redirection
                    }, 3000);
                }, 2000);
            }

            // Button click handlers
            document.querySelector('[data-bs-target="#warningModal"]').addEventListener('click', function() {
                warningModal.show();
            });

            document.querySelector('[data-bs-target="#testModal"]').addEventListener('click', function() {
                warningModal.hide();
                testModal.show();
                // Start the timer when the test begins
                startTimer();
            });

            document.querySelector('[data-bs-target="#testModalPage2"]').addEventListener('click', function() {
                testModal.hide();
                testModalPage2.show();
            });

            document.querySelector('[data-bs-target="#submitconfirmationModal"]').addEventListener('click', function() {
                testModalPage2.hide();
                submitconfirmationModal.show();
            });

            // Back button from test page 2 to test page 1
            document.querySelector('#testModalPage2 [data-bs-target="#testModal"]').addEventListener('click', function() {
                testModalPage2.hide();
                testModal.show();
            });

            // Review button (back to test page 1)
            document.querySelector('#submitconfirmationModal [data-bs-target="#testModal"]').addEventListener('click', function() {
                submitconfirmationModal.hide();
                testModal.show();
            });

            // Submit button
            document.querySelector('[data-bs-target="#successModal"]').addEventListener('click', function() {
                submitconfirmationModal.hide();
                successModal.show();

                // Stop the timer
                clearInterval(timerInterval);

                // Auto-close success modal and redirect
                setTimeout(function() {
                    successModal.hide();
                    // window.location.href = 'homepage.html'; // Uncomment this for redirection
                }, 3000);
            });

            // Cancel button (close warning modal)
            document.querySelector('#warningModal [data-bs-dismiss="modal"]').addEventListener('click', function() {
                warningModal.hide();
            });
        });
    </script>
</div>