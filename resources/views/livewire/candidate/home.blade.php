<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Homepage</h2>
    </div>
    <div class="homepage-container">
        <div class="container d-flex flex-column justify-content-between">
            <div class="row">
                <div class="col-lg-6 d-flex flex-column text-center text-lg-start justify-content-center">
                    <div>
                        <h1 class="text-white welcome-title">WELCOME!</h1>
                        <p class="text-white lead mb-4">
                            To the <strong>Assessment and Candidate Management System (ACMS)</strong>
                        </p>

                        <div class="action-buttons d-grid gap-3">
                            @if(!$assessment_completed)
                                <button data-bs-toggle="modal" data-bs-target="#warningModal" class="btn btn-primary btn-lg w-100">
                                    Take the Assessment Test Now!
                                </button>
                            @endif

                            @if($assessment_completed && !$practical_completed)
                                <div class="form-group">
                                    <label for="practical_code" class="form-label text-white">Practical Code</label>
                                    <input type="text" id="practical_code" name="practical_code" class="form-control" placeholder="Enter Practical Code" wire:model="practical_code">
                                </div>
                                <button class="btn btn-success btn-lg w-100" wire:click="submitPracticalCode">
                                    Submit Practical Code
                                </button>
                            @endif

                            @if($practical_completed && !$oral_completed)
                                <div class="form-group">
                                    <label for="interview_code" class="form-label text-white">Interview Code</label>
                                    <input type="text" id="interview_code" name="interview_code" class="form-control" placeholder="Enter Interview Code" wire:model="interview_code">
                                </div>
                                <button class="btn btn-primary btn-lg w-100" wire:click="submitInterviewCode">
                                    Submit Interview Code
                                </button>
                            @endif

                            @if($assessment_completed && $practical_completed && $oral_completed)
                                <div class="alert alert-success text-center fw-bold">
                                    🎉 All Tests Completed!
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-5 col-lg-6 d-flex justify-content-lg-end justify-content-center">
                    <div class="text-center text-lg-end" style="max-width: 600px;">
                        <img src="{{ asset('img/cityhall.png') }}" alt="Profile" class="profile-image img-fluid " style="width: 100%; max-width: 600px; height: auto;">

                        <div class="text-center about-section mx-lg-0 mx-auto" style="border: 2px solid #007BFF; border-radius: 12px; padding: 15px; max-width: 800px;">
                            <div class="about-text">
                                <h4 class="text-center fw-bold" style="color:#1a1851;">About Us!</h4>
                                <p class="fw-normal">
                                    Our system is designed to help <strong>City Government of Cagayan de Oro</strong>
                                    assess candidates efficiently, track their progress, and make informed hiring decisions with ease.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="logos col-lg-6 d-flex flex-column justify-content-center align-items-start text-start ps-3 mt-4">
                <img src="{{ asset('img/cdologo.png') }}" alt="logo" class="img-fluid">
            </div>
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
                    <button type="button" class="btn btn-primary" onclick="window.location.href='{{ route('candidate.exam.assessment') }}'">
                        I Agree and Take the Test
                    </button>
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
        .homepage-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);
            font-family: Arial, sans-serif;
            padding: 40px;
            height: 100vh;
            overflow: hidden;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 900;
            letter-spacing: 2px;
        }

        .logos img {
            height: 150px;
            max-width: 100%;
        }

        .profile-image {
            max-width: 100%;
            height: auto;
        }

        .about-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            background: white;
            padding: 15px;
            border-radius: 12px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .about-text {
            font-size: 1rem;
            text-align: center;
        }

        @media (max-width: 1200px) {
            .homepage-container {
                padding: 30px;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .about-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 992px) {
            .homepage-container {
                padding: 25px;
            }

            .welcome-title {
                font-size: 1.8rem;
            }

            .logos img {
                height: 120px;
            }

            .profile-image {
                width: 85%;
            }

            .about-text {
                font-size: 0.9rem;
            }
        }

        @media (max-width: 768px) {
            .homepage-container {
                padding: 20px;
            }

            .welcome-title {
                font-size: 1.6rem;
            }

            .logos img {
                height: 100px;
            }

            .profile-image {
                width: 80%;
            }

            .about-text {
                font-size: 0.85rem;
            }
        }

        @media (max-width: 576px) {
            .homepage-container {
                padding: 15px;
            }

            .welcome-title {
                font-size: 1.5rem;
            }

            .profile-image {
                width: 70%;
            }

            .logos img {
                height: 80px;
            }

            .about-text {
                font-size: 0.8rem;
            }

            .action-buttons a {
                font-size: 0.9rem;
                padding: 10px;
            }
        }
    </style>
</div>