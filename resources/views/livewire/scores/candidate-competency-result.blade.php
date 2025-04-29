<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Candidate Competency Results</h2>
    </div>
    <section class="candidate competency results">
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <div class="d-flex gap-2 mb-3">
                    <a href="{{ route('scores.candidatecompetency') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle me-1"></i> Back to Candidate Competency
                    </a>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="fullname" class="form-label">Full Name</label>
                        <input type="text" id="fullname" class="form-control" value="{{ $fullname }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label for="applied_position" class="form-label">Applied Position</label>
                        <input type="text" id="applied_position" class="form-control" value="{{ $applied_position }}" readonly>
                    </div>
                </div>
                
                
                <div class="table-responsive">
                    <table class="table table-hover table-bordered text-center global-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th>Topic/Skill</th>
                                <th style="width: 12%">Competency Level</th>
                                <th style="width: 12%">Assessment Test</th>
                                <th style="width: 12%">Practical Exam</th>
                                <th style="width: 12%">Oral Interview</th>
                                <th style="width: 12%">Average</th>
                                <th style="width: 12%">Interpretation</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($skillScores as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item['skill_name'] }}</td>
                                <td>
                                    <span class="badge rounded-pill 
                                            {{ $item['competency_level'] == 'Basic' ? 'bg-info' : 
                                            ($item['competency_level'] == 'Intermediate' ? 'bg-primary' : 'bg-dark') }}">
                                            {{ucfirst($item['competency_level'])}}
                                    </span>
                                </td>
                                
                                <td>
                                    {{ is_numeric($item['assessment']) ? $item['assessment'] . '%' : $item['assessment'] }}
                                </td>
                                <td>
                                    {{ is_numeric($item['practical']) ? $item['practical'] . '%' : $item['practical'] }}
                                </td>
                                <td>
                                    {{ is_numeric($item['oral']) ? $item['oral'] . '%' : $item['oral'] }}
                                </td>
                                <td>
                                    {{ is_numeric($item['average']) ? $item['average'] . '%' : $item['average'] }}
                                </td>
                                
                                <td>{{ $item['interpretation'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                    No competency scores found
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>  
                </div>

                <div class="my-4">
                    <canvas id="skillScoreChart" height="120"></canvas>
                </div>
                
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const skillData = @json($skillScores);
    
            const labels = skillData.map(item => item.skill_name);
            const assessment = skillData.map(item => isFinite(item.assessment) ? item.assessment : null);
            const practical = skillData.map(item => isFinite(item.practical) ? item.practical : null);
            const oral = skillData.map(item => isFinite(item.oral) ? item.oral : null);
            const average = skillData.map(item => isFinite(item.average) ? item.average : null);
    
            const ctx = document.getElementById('skillScoreChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Assessment Test',
                            data: assessment,
                            backgroundColor: '#0dcaf0'
                        },
                        {
                            label: 'Practical Exam',
                            data: practical,
                            backgroundColor: '#0d6efd'
                        },
                        {
                            label: 'Oral Interview',
                            data: oral,
                            backgroundColor: '#6610f2'
                        },
                        {
                            label: 'Average',
                            data: average,
                            backgroundColor: '#198754'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + (context.raw !== null ? context.raw + '%' : 'N/A');
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: {
                                callback: function(value) {
                                    return value + '%';
                                }
                            },
                            title: {
                                display: true,
                                text: 'Score (%)'
                            }
                        },
                        x: {
                            ticks: {
                                autoSkip: false
                            }
                        }
                    }
                }
            });
        });
    </script>
    
</div>
