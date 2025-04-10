<div>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Assessment Test</h2>
                <p class="mb-0">Please answer all questions within the time limit</p>
            </div>
            <div class="form-body">
                <!-- Timer Bar -->
                <div class="timer-bar">
                    <span>Time Remaining</span>
                    <span id="timer" class="timer">5:00</span>
                </div>

                <!-- Progress Bar -->
                <div class="progress-container">
                    <div id="progress-bar" class="progress-bar" style="width: 0%;"></div>
                </div>

                <!-- Question 1 -->
                <div class="question-card">
                    <h4 class="question-title">Question 1: Lorem ipsum dolor sit amet, consectetur adipiscing elit?</h4>
                    <div class="options">
                        <div class="option-item">
                            <input type="radio" name="q1" id="q1o1">
                            <label for="q1o1">Option 1: Lorem ipsum dolor sit amet</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q1" id="q1o2">
                            <label for="q1o2">Option 2: Consectetur adipiscing elit</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q1" id="q1o3">
                            <label for="q1o3">Option 3: Sed do eiusmod tempor incididunt</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q1" id="q1o4">
                            <label for="q1o4">Option 4: Ut labore et dolore magna aliqua</label>
                        </div>
                    </div>
                </div>

                <!-- Question 2 -->
                <div class="question-card">
                    <h4 class="question-title">Question 2: Ut enim ad minim veniam, quis nostrud exercitation?</h4>
                    <div class="options">
                        <div class="option-item">
                            <input type="radio" name="q2" id="q2o1">
                            <label for="q2o1">Option 1: Ullamco laboris nisi</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q2" id="q2o2">
                            <label for="q2o2">Option 2: Ut aliquip ex ea commodo consequat</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q2" id="q2o3">
                            <label for="q2o3">Option 3: Duis aute irure dolor in reprehenderit</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q2" id="q2o4">
                            <label for="q2o4">Option 4: In voluptate velit esse cillum</label>
                        </div>
                    </div>
                </div>

                <!-- Question 3 -->
                <div class="question-card">
                    <h4 class="question-title">Question 3: Excepteur sint occaecat cupidatat non proident?</h4>
                    <div class="options">
                        <div class="option-item">
                            <input type="radio" name="q3" id="q3o1">
                            <label for="q3o1">Option 1: Sunt in culpa qui officia</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q3" id="q3o2">
                            <label for="q3o2">Option 2: Deserunt mollit anim id est laborum</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q3" id="q3o3">
                            <label for="q3o3">Option 3: Sed ut perspiciatis unde omnis</label>
                        </div>
                        <div class="option-item">
                            <input type="radio" name="q3" id="q3o4">
                            <label for="q3o4">Option 4: Nemo enim ipsam voluptatem</label>
                        </div>
                    </div>
                </div>

                <div class="nav-buttons d-flex justify-content-center">
                    <button class="btn btn-google" id="submitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Warning Modals -->
    <div class="modal fade warning-modal" id="threeMinWarningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Time Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You have 3 minutes remaining to complete this quiz.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade danger-modal" id="oneMinWarningModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Time Warning</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>You have 1 minute remaining to complete this quiz!</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade danger-modal" id="timesUpModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Time's Up!</h5>
                </div>
                <div class="modal-body">
                    <p>Your time has expired. Your quiz will be automatically submitted.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Submission</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to submit your quiz?</p>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Review Quiz</button>
                    <button type="button" class="btn btn-google" id="confirmSubmitBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade success-modal" id="successModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Answers Submitted Successfully. Thank you!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Redirecting to the Homepage. Please wait.</p>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            background-color: #f0f0f0;
            font-family: 'Roboto', Arial, sans-serif;
        }

        .form-container {
            max-width: 768px;
            margin: 2rem auto;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .form-header {
            background-color: #1a1851;
            color: white;
            padding: 16px 24px;
            border-bottom: 2px solid #1565C0;
        }

        .form-body {
            background-color: white;
            padding: 24px;
        }

        .question-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 24px;
            border: 1px solid #e0e0e0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .question-title {
            font-size: 1.1rem;
            margin-bottom: 16px;
            color: #212121;
        }

        .option-item {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            padding: 8px;
            border-radius: 4px;
            transition: background-color 0.2s;
        }

        .option-item:hover {
            background-color: #e3f2fd;
        }

        .option-item input[type="radio"] {
            margin-right: 12px;
            cursor: pointer;
        }

        .option-item label {
            margin-bottom: 0;
            cursor: pointer;
            width: 100%;
            color: #555;
        }

        .timer-bar {
            background-color: #e8f5e9;
            /* light green */
            padding: 10px 20px;
            margin-bottom: 24px;
            border-radius: 4px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e0e0e0;
            transition: background-color 0.3s ease;
        }


        .timer {
            font-size: 18px;
            font-weight: 500;
            color: #4CAF50;
        }

        .timer.warning {
            color: #ff9800;
        }

        .timer.danger {
            color: #f44336;
            animation: pulse 1s infinite;
        }

        .nav-buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 24px;
        }

        .btn-google {
            background-color: #1a1851;
            color: white;
            border: none;
            padding: 8px 24px;
            border-radius: 4px;
            font-weight: 500;
            letter-spacing: 0.5px;
            transition: background-color 0.2s;
        }

        .btn-google:hover {
            background-color: #1565C0;
            color: white;
        }

        .btn-google.secondary {
            background-color: white;
            color: #0D47A1;
            border: 1px solid #0D47A1;
        }

        .btn-google.secondary:hover {
            background-color: #e3f2fd;
        }

        .warning-modal .modal-header {
            background-color: #ff9800;
            color: white;
        }

        .danger-modal .modal-header {
            background-color: #f44336;
            color: white;
        }

        .success-modal .modal-header {
            background-color: #4CAF50;
            color: white;
        }

        .progress-container {
            height: 6px;
            background-color: #e0e0e0;
            margin-bottom: 24px;
            border-radius: 3px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            background-color: #1a1851;
            width: 0;
            transition: width 0.2s;
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
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const threeMinWarningModal = new bootstrap.Modal(document.getElementById('threeMinWarningModal'));
            const oneMinWarningModal = new bootstrap.Modal(document.getElementById('oneMinWarningModal'));
            const timesUpModal = new bootstrap.Modal(document.getElementById('timesUpModal'));
            const confirmSubmitModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'));
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));


            const timerElement = document.getElementById('timer');
            const progressBar = document.getElementById('progress-bar');
            let totalSeconds = 5 * 60;
            let timerInterval;
            const totalTime = totalSeconds;


            startTimer();


            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            function startTimer() {

                timerElement.textContent = formatTime(totalSeconds);


                timerInterval = setInterval(function() {
                    totalSeconds--;


                    timerElement.textContent = formatTime(totalSeconds);


                    const progressPercentage = 100 - ((totalSeconds / totalTime) * 100);
                    progressBar.style.width = `${progressPercentage}%`;


                    const timerBar = document.querySelector('.timer-bar');

                    if (totalSeconds <= 60) {
                        timerElement.classList.add('danger');
                        timerElement.classList.remove('warning');
                        timerBar.style.backgroundColor = '#ffebee';
                    } else if (totalSeconds <= 180) {
                        timerElement.classList.add('warning');
                        timerElement.classList.remove('danger');
                        timerBar.style.backgroundColor = '#fff8e1';
                    } else {
                        timerElement.classList.remove('warning', 'danger');
                        timerBar.style.backgroundColor = '#e8f5e9';
                    }


                    if (totalSeconds === 180) {
                        threeMinWarningModal.show();
                        setTimeout(() => threeMinWarningModal.hide(), 3000);
                    } else if (totalSeconds === 60) {
                        oneMinWarningModal.show();
                        setTimeout(() => oneMinWarningModal.hide(), 3000);
                    }


                    if (totalSeconds <= 0) {
                        clearInterval(timerInterval);
                        timesUpModal.show();
                        setTimeout(() => {
                            timesUpModal.hide();
                            successModal.show();
                            setTimeout(() => successModal.hide(), 3000);
                        }, 2000);
                    }
                }, 1000);
            }


            document.getElementById('submitBtn').addEventListener('click', function() {
                confirmSubmitModal.show();
            });


            document.getElementById('confirmSubmitBtn').addEventListener('click', function() {
                confirmSubmitModal.hide();
                clearInterval(timerInterval);
                successModal.show();


                setTimeout(function() {
                    successModal.hide();

                }, 3000);
            });


            document.getElementById('clearBtn').addEventListener('click', function() {

                document.querySelectorAll('input[type="radio"]').forEach(radio => {
                    radio.checked = false;
                });
            });
        });
    </script>
</div>