<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>{{ $title ?? 'Page Title' }}</title>

  <link rel="dns-prefetch" href="//fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  <link href="{{asset('img/favicon.png')}}" rel="icon">
  <link href="{{asset('img/apple-touch-icon.png')}}" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
  <link href="{{asset(path: 'vendor/boxicons/css/boxicons.min.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.snow.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/quill/quill.bubble.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/remixicon/remixicon.css')}}" rel="stylesheet">
  <link href="{{asset('vendor/simple-datatables/style.css')}}" rel="stylesheet">


  <link href="{{asset('sweetalert2/sweetalert2.min.css')}}" rel="stylesheet">

  <link href="{{asset('css/style.css')}}" rel="stylesheet">
  <link href="{{asset('css/global.css')}}" rel="stylesheet">



</head>

<body>

  <header id="header" class="header fixed-top d-flex align-items-center">

  <div class="d-flex ">
  <a href="{{ route('dashboard') }}" class="logo d-flex align-items-center">
    <img src="{{ asset('img/logo.png') }}" alt="Logo" class="img-fluid" style="height: 75px;">
  </a>
  <i class="bi bi-list toggle-sidebar-btn"></i>
</div>


    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

       

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
              <span class="d-none d-md-block dropdown-toggle ps-2">
                  {{ session('candidate_name', 'Guest') }}
              </span>
          </a><!-- End Profile Image Icon -->
          
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
              <li class="dropdown-header">
                  <h6>{{ session('candidate_name', 'Guest') }}</h6>
                  <span>Candidate</span>
              </li>
              <li>
                  <hr class="dropdown-divider">
              </li>  

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item" href="{{ route('candidate.logout') }}"
                 onclick="event.preventDefault();
                          document.getElementById('candidate-logout-form').submit();">
                  <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
              </a>
          
              <form id="candidate-logout-form" action="{{ route('candidate.logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
            </li>
          

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('candidate.home') ? '' : 'collapsed' }}" href="{{ route('candidate.home') }}">
          <i class="bi bi-grid-fill fs-5"></i>
          <span>Home</span>
        </a>
      </li><!-- End Dashboard Nav -->

   
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('candidate.*') ? '' : 'collapsed' }}" data-bs-target="#tests-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-clipboard-check-fill fs-5"></i><span>Candidate</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tests-nav" class="nav-content collapse {{ Request::routeIs('candidate.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">         
          <li>
            <a class="{{ Request::routeIs('candidate.exam.assessmentinstructions') ? 'active' : '' }}" href="{{ route('candidate.exam.assessmentinstructions') }}">
              <i class="bi bi-clipboard-data-fill fs-5"></i><span>Assessment Tests</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('candidate.exam.practicalcode') ? 'active' : '' }}" href="{{ route('candidate.exam.practicalcode') }}">
              <i class="bi bi-person-fill-gear fs-5"></i><span>Practical Exams</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('candidate.exam.oralcode') ? 'active' : '' }}" href="{{ route('candidate.exam.oralcode') }}">
              <i class="bi bi-wechat fs-5"></i><span>Oral Interviews</span>
            </a>
          </li>
        </ul>
      </li>


   

    </ul>

  </aside><!-- End Sidebar-->
  <main id="main" class="main" style="padding-top: 0;"> 
    {{ $slot }} 
  </main>



  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>CMISID ACMS</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
      <div>
      <img src="{{ asset('img/rise-cdo.png') }}" class="img-fluid" style="height: 110px;" alt="Login Illustration">
      </div>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>


  <script src="{{asset('vendor/apexcharts/apexcharts.min.js')}}"></script>
  <script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('vendor/chart.js/chart.umd.js')}}"></script>
  <script src="{{asset('vendor/echarts/echarts.min.js')}}"></script>
  <script src="{{asset('vendor/quill/quill.js')}}"></script>
  <script src="{{asset('vendor/simple-datatables/simple-datatables.js')}}"></script>
  <script src="{{asset('vendor/php-email-form/validate.js')}}"></script>
  <script src="{{asset('js/main.js')}}"></script>
  <script src="{{asset('sweetalert2/sweetalert2.min.js')}}"></script>
  <script src="{{asset('jquery/jquery.min.js')}}"></script>

  <script>
    document.addEventListener('livewire:init', () => {
      Livewire.on('success', (message) => {
        const Toast = Swal.mixin({
          toast: true,
          position: "top-end",
          showConfirmButton: false,
          timer: 3000,
          timerProgressBar: true,
          didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
          }
        });
        Toast.fire({
          icon: "success",
          title: message
        });
      });

      Livewire.on('confirm-delete', (data = {}) => {
          const { message = "Are you sure?", eventName, eventData = {} } = data;

          Swal.fire({
              title: "Confirm archive?",
              text: message,
              icon: "warning",
              showCancelButton: true,
              confirmButtonColor: "#3085d6",
              cancelButtonColor: "#d33",
              confirmButtonText: "Yes, archive it!"
          }).then((result) => {
              if (result.isConfirmed && eventName) {
                  Livewire.dispatch(eventName, eventData);
              }
          });
      });


    });
  </script>
</body>

</html>