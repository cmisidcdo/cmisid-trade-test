<div class="container my-4">
    <div>
        <header class="header fixed-top d-flex align-items-center shadow-sm" style="background-color: white;">
            <nav class="navbar navbar-expand-lg w-100">
                <div class="container-fluid position-relative">
                    <div class="position-absolute start-50 translate-middle-x fw-bold fs-5">
                        Oral Interview
                    </div>
                </div>
            </nav>
        </header>
    </div>
    <div class="d-grid mt-4">
        <button class="btn btn-secondary" wire:click="goBack">Back</button>
    </div>
    
    
    <div class="card shadow-lg mb-4" style="border: 3px solid #1a1851; border-radius: 12px;">
        <div class="card-body">
            <h5 class="card-title text-center mb-4" style="color: #1a1851; font-weight: bold;">📌 Interview Instructions</h5>
            <ul class="card-text" style="padding-left: 20px; font-size: 15px;">
                <li><strong>Proceed to the Venue which is to be held for the Interview.</strong></li>
                <li><strong>Look for the Assessor which will be the one interviewing you.</strong></li>
                <li><strong>Wear formal/proper attire.</strong></li>
            </ul>

            <hr>

            <div class="mb-3">
                <label class="form-label fw-bold">Candidate Name</label>
                <input type="text" class="form-control" value="{{ $candidate->fullname ?? '-' }}" readonly>
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold">Venue</label>
                <input type="text" class="form-control" value="{{$venue->name}}, {{$venue->location}}" readonly>
            </div>

            <div class="row mb-3">
                <div class="col-6">
                    <label class="form-label fw-bold">Date</label>
                    <input type="text" class="form-control" value="{{ $oral->assigned_date ?? '-' }}" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold">Time</label>
                    <input type="text" class="form-control" value="{{ $oral->assigned_time ?? '-' }}" readonly>
                </div>
            </div>

        </div>
    </div>

    <div class="card shadow" style="border-radius: 12px;">
        <div class="card-body">
            <h5 class="card-title mb-3" style="color: #1a1851; font-weight: bold;">🎤 Interview Questions</h5>
            <div class="table-responsive">
                <table class="table table-bordered global-table">
                    <thead style="background-color: #1a1851; color: white;">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Question</th>
                            <th style="width: 20%;">Attachment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($oral->oralScore->oralScoreSkills->flatMap(function($skill) {
                            return $skill->oralScoreSkillQuestions;
                        }) as $skillQuestion)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $skillQuestion->oral_questions->question ?? 'No question found' }}</td>
                                <td>
                                    @if ($skillQuestion->oral_questions->file_path)
                                        <a href="{{ Storage::url($skillQuestion->oral_questions->file_path) }}" download class="btn btn-sm btn-outline-secondary ms-2">
                                            <i class="bi bi-download me-1"></i> Download File
                                        </a>
                                    @else
                                        No attachment
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    
                    
                    
                    
                </table>
            </div>
        </div>
    </div>
    

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Livewire.on('go-back', function () {
                window.history.back();
            });
        });
    </script>
</div>
