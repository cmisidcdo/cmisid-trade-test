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
                    <h1 style="font-size: 3rem;">3</h1>
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
                    <h1 style="font-size: 3rem;">20</h1>
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
                    <h1 style="font-size: 3rem;">10</h1>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Distribution</h5>
              <div id="barChart" style="min-height: 365px;"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#barChart"), {
                    series: [{
                      name: 'Distribution',
                      data: [5, 3, 10, 15, 12, 9]
                    }],
                    chart: {
                      type: 'bar',
                      height: 350,
                      toolbar: {
                        show: false
                      }
                    },
                    plotOptions: {
                      bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: '55%',
                      }
                    },
                    colors: ['#2196f3'],
                    dataLabels: {
                      enabled: false
                    },
                    xaxis: {
                      categories: ['5 (9.3%)', '3 (5.6%)', '10 (18.5%)', '15 (27.8%)', '12 (22.2%)', '9 (16.7%)'],
                      labels: {
                        style: {
                          fontSize: '12px'
                        }
                      }
                    },
                    yaxis: {
                      title: {
                        text: ''
                      },
                      max: 20
                    },
                    fill: {
                      opacity: 1
                    }
                  }).render();
                });
              </script>
            </div>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Distribution</h5>
              <div id="donutChart" style="min-height: 365px;"></div>

              <script>
                document.addEventListener("DOMContentLoaded", () => {
                  new ApexCharts(document.querySelector("#donutChart"), {
                    series: [5, 3, 10, 15, 12, 9],
                    chart: {
                      height: 350,
                      type: 'donut',
                    },
                    labels: ['5 (9.3%)', '3 (5.6%)', '10 (18.5%)', '15 (27.8%)', '12 (22.2%)', '9 (16.7%)'],
                    colors: ['#9c27b0', '#ff9800', '#009688', '#4caf50', '#e91e63', '#3f51b5'],
                    responsive: [{
                      breakpoint: 480,
                      options: {
                        chart: {
                          width: 200
                        },
                        legend: {
                          position: 'bottom'
                        }
                      }
                    }],
                    legend: {
                      show: false
                    },
                    dataLabels: {
                      enabled: true,
                      formatter: function(val, opts) {
                        return opts.w.config.labels[opts.seriesIndex];
                      }
                    }
                  }).render();
                });
              </script>
            </div>
          </div>
        </div>
      </div>

      <div class="col-12 mt-4">
        <div class="card recent-sales overflow-auto">
          <div class="card-body">
            <h5 class="card-title">Recent Applications</h5>

            <table class="table table-borderless datatable">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Candidate</th>
                  <th scope="col">Position</th>
                  <th scope="col">Score</th>
                  <th scope="col">Status</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row"><a href="#">#A102</a></th>
                  <td>Jessica Williams</td>
                  <td><a href="#" class="text-primary">Frontend Developer</a></td>
                  <td>78/100</td>
                  <td><span class="badge bg-success">Approved</span></td>
                </tr>
                <tr>
                  <th scope="row"><a href="#">#A098</a></th>
                  <td>Marcus Chen</td>
                  <td><a href="#" class="text-primary">UX Designer</a></td>
                  <td>64/100</td>
                  <td><span class="badge bg-warning">Pending</span></td>
                </tr>
                <tr>
                  <th scope="row"><a href="#">#A095</a></th>
                  <td>Sophia Patel</td>
                  <td><a href="#" class="text-primary">Backend Developer</a></td>
                  <td>92/100</td>
                  <td><span class="badge bg-success">Approved</span></td>
                </tr>
                <tr>
                  <th scope="row"><a href="#">#A091</a></th>
                  <td>James Rodriguez</td>
                  <td><a href="#" class="text-primary">DevOps Engineer</a></td>
                  <td>41/100</td>
                  <td><span class="badge bg-danger">Rejected</span></td>
                </tr>
                <tr>
                  <th scope="row"><a href="#">#A089</a></th>
                  <td>Emma Thompson</td>
                  <td><a href="#" class="text-primary">Project Manager</a></td>
                  <td>83/100</td>
                  <td><span class="badge bg-success">Approved</span></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div><!-- End Recent Applications -->

    </div>
  </section>
</div>