<div>

<style>
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background-color: #f8f9fa;
    transition: background-color 0.5s ease;
    padding: 10px 20px;
}

#timer1 {
    font-size: 1.5rem;
    font-weight: bold;
    background-color: #2eff1b;
    color: #000;
    padding: 5px 15px;
    border-radius: 50px;
    display: inline-block;
}

body {
    padding-top: 70px;
}
</style>


    @if($score->status === 'ongoing')
        <div>
        <header class="header fixed-top d-flex align-items-center shadow-sm">
            <nav class="navbar navbar-expand-lg w-100">
                <div class="container-fluid">
                    <div class="navbar-nav ms-auto">
                        <p class="fw-bold text-center fs-5 mb-0">
                            🕒 Time Left:
                            <span id="timer1">{{ gmdate('H:i:s', $remainingTime) }}</span>
                        </p>
                    </div>
                </div>
            </nav>
        </header>
    </div>
        <div class="container-fluid mt-3">
            <div class="d-flex justify-content-start">
                <button class="btn btn-secondary" wire:click="goBack">
                    ← Back to Home
                </button>
            </div>
        </div>
        <form wire:submit.prevent="submitAnswers">
            <div class="modal-body px-4 py-4 bg-white rounded shadow-sm">
                @foreach($questionsWithChoices as $index => $question)
                    @php
                        $isAnswered = isset($selectedAnswers[$question['score_skill_question_id']]);
                    @endphp
                    <div class="mb-4 p-3 border rounded {{ $isAnswered ? 'bg-light' : ($hasSubmitted ? 'bg-warning bg-opacity-25 border-danger' : '') }}" id="question-{{ $question['score_skill_question_id'] }}">                        <p class="fw-semibold mb-3">
                            <span class="text-primary">Question {{ $index + 1 }}:</span> {{ $question['question_text'] }}
                        </p>
                        <div class="d-grid gap-2">
                            @foreach($question['choices'] as $choice)
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answers.{{ $question['score_skill_question_id'] }}" id="q{{ $question['score_skill_question_id'] }}o{{ $choice['id'] }}" value="{{ $choice['id'] }}" wire:model="selectedAnswers.{{ $question['score_skill_question_id'] }}">
                                    <label class="form-check-label" for="q{{ $question['score_skill_question_id'] }}o{{ $choice['id'] }}">
                                        {{ $choice['choice_text'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>

                        @if ($hasSubmitted && !$isAnswered)
                            <small class="text-danger">⚠️ Please select an answer.</small>
                        @endif
                    </div>
                @endforeach

        
                <div class="text-center">
                    <button type="submit" class="btn btn-success px-4 py-2 mt-3">
                        Submit Answers
                    </button>
                </div>
            </div>
        </form>
        
    @elseif($score->status === 'done')
        <div class="modal-body px-4 py-5 bg-white rounded shadow-sm text-center">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="bg-success bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                    <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem; line-height: 80px;"></i>
                </div>
                <h4 class="fw-bold text-success mb-2">Assessment Submitted</h4>
                <p class="text-secondary mb-2">You have already completed and submitted this assessment. Thank you!</p>
                <p class="text-muted mt-3">Redirecting you to home in <span id="redirect-timer">5</span> seconds...</p>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const redirectEl = document.getElementById('redirect-timer');

                if (redirectEl) {
                    let countdown = parseInt(redirectEl.textContent);

                    const interval = setInterval(() => {
                        countdown--;
                        redirectEl.textContent = countdown;
                        if (countdown <= 0) {
                            clearInterval(interval);
                            window.location.href = "{{ route('candidate.home') }}";
                        }
                    }, 1000);
                }
            });
        </script>
    @endif

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let remainingTime = @json((int) $remainingTime);
        const timerEl = document.getElementById('timer1');

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function updateTimer() {
            if (remainingTime > 0) {
                timerEl.textContent = formatTime(remainingTime);

                if (remainingTime <= 60) {
                    timerEl.style.backgroundColor = '#dc3545';
                    timerEl.style.color = '#fff';
                } else if (remainingTime <= 300) {
                    timerEl.style.backgroundColor = '#fd7e14';
                    timerEl.style.color = '#000';
                } else {
                    timerEl.style.backgroundColor = '#2eff1b';
                    timerEl.style.color = '#000';
                }

                remainingTime--;
            } else {
                timerEl.textContent = '00:00:00';
                timerEl.style.backgroundColor = '#dc3545';
                timerEl.style.color = '#fff';
            }
        }

        updateTimer(); 
        setInterval(updateTimer, 1000);
    });

    window.addEventListener('start-redirect-countdown', function () {
        const messageArea = document.querySelector('.modal-body');
        if (messageArea) {
            messageArea.innerHTML = `
                <div class="d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 3rem; line-height: 80px;"></i>
                    </div>
                    <h4 class="fw-bold text-success mb-2">Assessment Submitted</h4>
                    <p class="text-secondary mb-2">You have already completed and submitted this assessment. Thank you!</p>
                    <p class="text-muted mt-3">Redirecting you to home in <span id="redirect-timer">5</span> seconds...</p>
                </div>
            `;

            let countdown = 5;
            const interval = setInterval(() => {
                countdown--;
                document.getElementById('redirect-timer').textContent = countdown;
                if (countdown <= 0) {
                    clearInterval(interval);
                    window.location.href = "{{ route('candidate.home') }}";
                }
            }, 1000);
        }
    });
</script>

