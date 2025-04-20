<div>

<style>
.header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    z-index: 1000;
    background-color: #2eff1b; 
    transition: background-color 0.5s ease;
    padding: 10px 20px;
}

#timer1 {
    font-size: 1.5rem;
    font-weight: bold;
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
                                <span id="timer1" class="text-danger fs-4">{{ gmdate('H:i:s', $remainingTime) }}</span>
                            </p>
                        </div>
                    </div>
                </nav>
            </header>
        </div>

        <form wire:submit.prevent="submitAnswers">
            <div class="modal-body px-4 py-4 bg-white rounded shadow-sm">
                @foreach($questionsWithChoices as $index => $question)
                    <div class="mb-4 p-3 border rounded bg-light">
                        <p class="fw-semibold mb-3">
                            <span class="text-primary">Question {{ $index + 1 }}:</span> {{ $question['question_text'] }}
                        </p>
                        <div class="d-grid gap-2">
                            @foreach($question['choices'] as $choice)
                                <div class="form-check">
                                    <input 
                                        class="form-check-input" 
                                        type="radio" 
                                        name="answers.{{ $question['score_skill_question_id'] }}" 
                                        id="q{{ $question['score_skill_question_id'] }}o{{ $choice['id'] }}" 
                                        value="{{ $choice['id'] }}"
                                        wire:model="selectedAnswers.{{ $question['score_skill_question_id'] }}"
                                    >
                                    <label class="form-check-label" for="q{{ $question['score_skill_question_id'] }}o{{ $choice['id'] }}">
                                        {{ $choice['choice_text'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
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
                <p class="text-secondary mb-0">You have already completed and submitted this assessment. Thank you!</p>
            </div>
        </div>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let remainingTime = @json((int) $remainingTime);

        function formatTime(seconds) {
            const hours = Math.floor(seconds / 3600);
            const minutes = Math.floor((seconds % 3600) / 60);
            const secs = seconds % 60;

            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
        }

        function updateTimer() {
            if (remainingTime > 0) {
                document.getElementById('timer1').textContent = formatTime(remainingTime);
                remainingTime--;
            } else {
                document.getElementById('timer1').textContent = '00:00:00';
            }
        }

        updateTimer(); 
        setInterval(updateTimer, 1000);
    });
</script>
