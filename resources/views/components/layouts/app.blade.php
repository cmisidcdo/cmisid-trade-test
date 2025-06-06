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
  @livewire('change-password')

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
            <span class="d-none d-md-block dropdown-toggle ps-2">{{Auth::user()->name}}</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
           <li class="dropdown-header">
                <h6>{{ Auth::user()->name }}</h6>
                <span>{{ ucfirst(Auth::user()->type) }}</span>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                  <i class="bi bi-gear"></i>
                  <span>Change Password</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            @auth
              @if(auth()->user()->type === 'superadmin')
                <li>
                  <a class="dropdown-item d-flex align-items-center" href="{{ route('logs') }}">
                    <i class="bi bi-file-earmark-fill"></i>
                    <span>Logs</span>
                  </a>
                </li>
              @endif
            @endauth

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right"></i> {{ __('Logout') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
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
        <a class="nav-link {{ Request::routeIs('dashboard') ? '' : 'collapsed' }}" href="{{ route('dashboard') }}">
          <i class="bi bi-grid-fill fs-5"></i>
          <span>Dashboard</span>
        </a>
      </li>

    @can('read user')
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('settings.users') ? '' : 'collapsed' }}" href="{{ route('settings.users') }}">
            <i class="bi bi-people-fill fs-5"></i>
            <span>Users</span>
        </a>
    </li>
    @endcan

    @can('read candidate')
    <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('candidate.list') ? '' : 'collapsed' }}" href="{{ route('candidate.list') }}">
        <i class="bi bi-person-check-fill fs-5"></i>
        <span>Candidate List</span>
        </a>
    </li>
    @endcan

     @can('read reference')
      <li class="nav-item">
        <a class="nav-link {{ Request::routeIs('references.*') ? '' : 'collapsed' }}" data-bs-target="#references-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-layout-text-window-reverse fs-5"></i><span>References</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="references-nav" class="nav-content collapse {{ Request::routeIs('references.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
          <li>
            <a class="{{ Request::routeIs('references.skills') ? 'active' : '' }}" href="{{ route('references.skills') }}">
              <i class="bi bi-lightbulb-fill fs-5"></i><span>Skills</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('references.positions') ? 'active' : '' }}" href="{{ route('references.positions') }}">
              <i class="bi bi-arrows-move fs-5"></i><span>Positions</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('references.offices') ? 'active' : '' }}" href="{{ route('references.offices') }}">
              <i class="bi bi-building-fill fs-5"></i><span>Offices</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('references.prioritygroups') ? 'active' : '' }}" href="{{ route('references.prioritygroups') }}">
              <i class="bi bi-people-fill fs-5"></i><span>Priority Groups</span>
            </a>
          </li>
          <li>
            <a class="{{ Request::routeIs('references.venues') ? 'active' : '' }}" href="{{ route('references.venues') }}">
              <i class="bi bi-geo-alt-fill fs-5"></i><span>Venues</span>
            </a>
          </li>
          <li>
            <a class="nav-link {{ Request::routeIs('references.criterias.*') ? '' : 'collapsed' }}" data-bs-target="#criteria-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-card-checklist fs-5"></i><span>Evaluation Criteria</span><i class="bi bi-chevron-down ms-auto fs-6"></i>
            </a>
            <ul id="criteria-nav" class="nav-content collapse {{ Request::routeIs('references.criterias.*') ? 'show' : '' }}" data-bs-parent="#references-nav" style="padding-left: 10px;">
              <li>
                <a class="{{ Request::routeIs('references.criterias.practical') ? 'active' : '' }}" href="{{ route('references.criterias.practical') }}">
                  <i class="bi bi-tools fs-5"></i><span>Practical Criteria</span>
                </a>
              </li>
              <li>
                <a class="{{ Request::routeIs('references.criterias.oral') ? 'active' : '' }}" href="{{ route('references.criterias.oral') }}">
                  <i class="bi bi-mic-fill fs-5"></i><span>Oral Criteria</span>
                </a>
              </li>
            </ul>
          </li>
          <li>
            <a class="nav-link {{ Request::routeIs('references.scoresheets.*') ? '' : 'collapsed' }}" data-bs-target="#scoresheet-nav" data-bs-toggle="collapse" href="#">
              <i class="bi bi-list-check fs-5"></i><span>Score Sheets</span><i class="bi bi-chevron-down ms-auto fs-6"></i>
            </a>
            <ul id="scoresheet-nav" class="nav-content collapse {{ Request::routeIs('references.scoresheets.*') ? 'show' : '' }}" data-bs-parent="#references-nav" style="padding-left: 10px;">
              <li>
                <a class="{{ Request::routeIs('references.scoresheets.practical') ? 'active' : '' }}" href="{{ route('references.scoresheets.practical') }}">
                  <i class="bi bi-tools fs-5"></i><span>Practical Exam Scoring</span>
                </a>
              </li>
              <li>
                <a class="{{ Request::routeIs('references.scoresheets.oral') ? 'active' : '' }}" href="{{ route('references.scoresheets.oral') }}">
                  <i class="bi bi-mic-fill fs-5"></i><span>Oral  Interview Scoring</span>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </li><!-- End Tables Nav -->
    @endcan

    @canany(['assessor permission', 'read exam'])
    <li class="nav-item">
      <a class="nav-link {{ Request::routeIs('test.*') || Request::routeIs('exam.*') || Request::routeIs('scores.*') ? '' : 'collapsed' }}" data-bs-target="#tests-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-clipboard-check-fill fs-5"></i><span>Tests</span><i class="bi bi-chevron-down ms-auto"></i>
      </a>
      <ul id="tests-nav" class="nav-content collapse {{ Request::routeIs('test.*') || Request::routeIs('exam.*') || Request::routeIs('scores.*') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
        
        <li>
          <a class="nav-link {{ Request::routeIs('test.*') ? '' : 'collapsed' }}" data-bs-target="#questions-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-text fs-6"></i><span>Questions / Scenarios</span><i class="bi bi-chevron-down ms-auto fs-6"></i>
          </a>
          <ul id="questions-nav" class="nav-content collapse {{ Request::routeIs('test.*') ? 'show' : '' }}" data-bs-parent="#tests-nav" style="padding-left: 10px;">
            <li>
              <a class="{{ Request::routeIs('test.assessment') ? 'active' : '' }}" href="{{ route('test.assessment') }}">
                <i class="bi bi-clipboard-data-fill fs-5"></i><span>Assessment Tests</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('test.practical') ? 'active' : '' }}" href="{{ route('test.practical') }}">
                <i class="bi bi-person-fill-gear fs-5"></i><span>Practical Exams</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('test.interview') ? 'active' : '' }}" href="{{ route('test.interview') }}">
                <i class="bi bi-wechat fs-5"></i><span>Oral Interviews</span>
              </a>
            </li>
          </ul>
        </li>
    
        <li>
          <a class="nav-link {{ Request::routeIs('exam.*') ? '' : 'collapsed' }}" data-bs-target="#assigning-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-code fs-6"></i><span>Assigning</span><i class="bi bi-chevron-down ms-auto fs-6"></i>
          </a>
          <ul id="assigning-nav" class="nav-content collapse {{ Request::routeIs('exam.*') ? 'show' : '' }}" data-bs-parent="#tests-nav" style="padding-left: 10px;">
            <li>
              <a class="{{ Request::routeIs('exam.assessmentlist') ? 'active' : '' }}" href="{{ route('exam.assessmentlist') }}">
                <i class="bi bi-clipboard-data-fill fs-5"></i><span>Assessment Test List</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('exam.practicallist') ? 'active' : '' }}" href="{{ route('exam.practicallist') }}">
                <i class="bi bi-person-fill-gear fs-5"></i><span>Practical Exam List</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('exam.interviewlist') ? 'active' : '' }}" href="{{ route('exam.interviewlist') }}">
                <i class="bi bi-wechat fs-5"></i><span>Oral Interview List</span>
              </a>
            </li>
          </ul>
        </li>
    
        <li>
          <a class="nav-link {{ Request::routeIs('scores.*') ? '' : 'collapsed' }}" data-bs-target="#scoring-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-journal-check fs-6"></i><span>Scoring</span><i class="bi bi-chevron-down ms-auto fs-6"></i>
          </a>
          <ul id="scoring-nav" class="nav-content collapse {{ Request::routeIs('scores.*') ? 'show' : '' }}" data-bs-parent="#tests-nav" style="padding-left: 10px;">
            <li>
              <a class="{{ Request::routeIs('scores.assessment') ? 'active' : '' }}" href="{{ route('scores.assessment') }}">
                <i class="bi bi-clipboard-data-fill fs-5"></i><span>Assessment Scores</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('scores.practical') ? 'active' : '' }}" href="{{ route('scores.practical') }}">
                <i class="bi bi-person-fill-gear fs-5"></i><span>Practical Scores & Notes</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('scores.oral') ? 'active' : '' }}" href="{{ route('scores.oral') }}">
                <i class="bi bi-wechat fs-5"></i><span>Oral Interview Scores & Notes</span>
              </a>
            </li>
            <li>
              <a class="{{ Request::routeIs('scores.candidatecompetency') ? 'active' : '' }}" href="{{ route('scores.candidatecompetency') }}">
                <i class="bi bi-lightbulb fs-5"></i><span>Candidate Competency</span>
              </a>
            </li>
          </ul>
        </li>
      </ul>
    </li>
    @endcanany

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