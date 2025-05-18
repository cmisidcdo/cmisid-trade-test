<div>
  <div class="pagetitle">
    <h1>Dashboard</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </nav>
  </div>

  <section class="section dashboard">
    <div class="row">
      

      <div class="col-lg-12">
        <div class="row">
          <div class="col-xxl-4 col-md-4">
            <div class="card info-card sales-card" style="background-color: #0a2482; color: white;">
              <div class="card-body">
                <h5 class="card-title" style="color: white;">Admins</h5>
                <div class="d-flex align-items-center justify-content-center">
                  <div class="ps-3 text-center">
                    <h1 style="font-size: 3rem;">{{ $adminCount }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xxl-4 col-md-4">
            <div class="card info-card revenue-card" style="background-color: #b8962e; color: white;">
              <div class="card-body">
                <h5 class="card-title" style="color: white;">Candidates</h5>
                <div class="d-flex align-items-center justify-content-center">
                  <div class="ps-3 text-center">
                    <h1 style="font-size: 3rem;">{{ $candidateCount }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xxl-4 col-md-4">
            <div class="card info-card customers-card" style="background-color: #13866f; color: white;">
              <div class="card-body">
                <h5 class="card-title" style="color: white;">Incoming Assessment</h5>
                <div class="d-flex align-items-center justify-content-center">
                  <div class="ps-3 text-center">
                    <h1 style="font-size: 3rem;">{{ $incomingAssessmentCount }}</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4">
          <div class="card">
              <div class="card-body">
                  <h5 class="card-title">Calendar</h5>
                  <div id="calendar" style="max-width: 100%; margin: 0 auto;"></div>
              </div>
          </div>
      </div>


    </div>
  </section>
  <link href="{{ asset('fullcalendar/index.global.min.css') }}" rel="stylesheet">
  <script src="{{ asset('fullcalendar/index.global.min.js') }}"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false
            }
        });

        calendar.render();
    });
  </script>
</div>