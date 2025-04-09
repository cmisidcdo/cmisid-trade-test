<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Homepage</h2>
    </div>
    <div class="homepage-container">
        <div class="container d-flex flex-column justify-content-between">
            <div class="row">
                <!-- Left Column -->
                <div class="col-lg-6 d-flex flex-column text-center text-lg-start">
                    <div>
                        <h1 class="text-white text-center welcome-title">WELCOME!</h1>
                        <p class="text-white text-center lead">
                            To Assessment and <br> Candidate Management System (ACMS)
                        </p>

                        <div class="mt-5 action-buttons d-grid gap-3">
                            <a href="{{ route('candidate.exam.assessment') }}" class="btn btn-primary btn-lg w-100">
                                Take The Assessment Test Now!
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="mt-5 col-lg-6 d-flex justify-content-lg-end justify-content-center">
                    <div class="text-center text-lg-end" style="max-width: 600px;">
                        <img src="{{ asset('img/cityhall.png') }}" alt="Profile" class="profile-image img-fluid " style="width: 100%; max-width: 600px; height: auto;">

                        <!-- About Us Section -->
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
            <!-- Logos -->
            <div class="logos col-lg-6 d-flex flex-column justify-content-center align-items-start text-start ps-3 mt-4">
                <img src="{{ asset('img/cdologo.png') }}" alt="logo" class="img-fluid">
            </div>
        </div>


    </div>

    <style>
        /* General Styles */
        .homepage-container {
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);
            font-family: Arial, sans-serif;
            padding: 40px;
            height: 100vh;
            /* Full viewport height */
            overflow: hidden;
            /* Prevent scrolling */
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

        /* Responsive Adjustments */
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