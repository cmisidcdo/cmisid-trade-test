<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Homepage</h2>
    </div>
    <div class="homepage-container">
        <div class="container">
            <div class="row align-items-center">
                <!-- Left Column -->
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class=" text-white text-center welcome-title">WELCOME!</h1>
                    <p class=" text-white text-center lead">
                        To Assessment and <br> Candidate Management System (ACMS)
                    </p>



                    <div class="mt-5 action-buttons d-grid gap-3">
                        <a href="{{ route('candidate.exam.assessment') }}" class="btn btn-primary btn-lg w-100">Assessment</a>
                        <a href="{{ route('candidate.exam.practical') }}" class="btn btn-success btn-lg w-100">Practical</a>
                        <a href="{{ route('candidate.exam.oral') }}" class="oral btn btn-warning btn-lg w-100">Oral</a>
                    </div>

                    <!-- Logos -->
                    <div class="logos mt-5">
                        <img src="{{ asset('img/cdologo.png') }}" alt="logo" class=" img-fluid">

                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-lg-6 text-center text-lg-end">
                    <img src="{{ asset('img/mayor.png') }}" alt="Profile" class="profile-image img-fluid" style="width: 400px; height: auto;">


                    <!-- About Us Section -->
                    <div class="text-center about-section" style="border: 2px solid #007BFF; border-radius: 12px; padding: 15px;">
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

        <style>
            /* General Styles */
            .homepage-container {
                min-height: 85vh;
                /* Ensure full viewport height */
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);
                font-family: Arial, sans-serif;
                padding: 40px;

            }

            /* Welcome Title */
            .welcome-title {
                font-size: 2.5rem;
                font-weight: 900;
                letter-spacing: 2px;

            }

            /* Buttons */
            .oral:hover {
                background-color: #d39e00 !important;
                border-color: #c69500 !important;
            }

            /* Logos */
            .logos img {
                height: 150px;
                max-width: 100%;
                /* Ensures responsiveness */
            }

            /* Profile Image */
            .profile-image {
                max-width: 100%;
                height: auto;
            }

            /* About Section */
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

            /* About Text */
            .about-text {
                font-size: 1rem;
                text-align: center;
            }

            /* Responsive Adjustments */
            @media (max-width: 992px) {
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

            @media (max-width: 768px) {
                .homepage-container {
                    padding: 20px;
                }

                .welcome-title {
                    font-size: 1.8rem;
                }

                .logos img {
                    height: 100px;
                    /* Reduce logo size */
                }

                .profile-image {
                    width: 80%;
                    /* Shrinks the profile image */
                }

                .about-text {
                    font-size: 0.85rem;
                }
            }

            @media (max-width: 480px) {
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
                    /* Smaller text for buttons */
                    padding: 10px;
                }
            }
        </style>
    </div>
</div>