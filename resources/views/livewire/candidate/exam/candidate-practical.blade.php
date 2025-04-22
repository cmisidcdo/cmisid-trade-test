<div class="container my-4">
    <div>
        <header class="header fixed-top d-flex align-items-center shadow-sm" style="background-color: white;">
            <nav class="navbar navbar-expand-lg w-100">
                <div class="container-fluid position-relative">
                    <div class="position-absolute start-50 translate-middle-x fw-bold fs-5">
                        Practical Exam
                    </div>
                </div>
            </nav>
        </header>
    </div>
    
    <div class="card shadow-sm my-5" style="background-color: #f8f9fa; border-radius: 12px;">
        <div class="card-body">
            <!-- Instructions -->
            <div class="card shadow-lg mb-3" style="border: 3px solid #1a1851; border-radius: 12px;">
                <div class="card-body" style="padding: 12px;">
                    <h5 class="card-title text-center mb-3" style="color: #1a1851; font-weight: bold;">📌 Test Instructions</h5>
                    <ul class="card-text" style="padding-left: 15px; font-size: 15px;">
                        <li><strong>Proceed to the Venue which is to be held for the Practical Exam.</strong></li>
                        <li><strong>Look for the Assessor which will be the one observing you executing tasks.</strong></li>
                    </ul>
                </div>
            </div>

            <!-- Candidate Info Inputs -->
            <div class="mb-2">
                <label class="form-label fw-bold">Candidate Name</label>
                <input type="text" class="form-control" placeholder="John Smith" value="John Smith">
            </div>

            <div class="mb-2">
                <label class="form-label fw-bold">Venue</label>
                <input type="text" class="form-control" placeholder="CLENRO Roof Deck" value="CLENRO Roof Deck">
            </div>

            <div class="row g-2 mb-2">
                <div class="col-6">
                    <label class="form-label fw-bold">Date</label>
                    <input type="text" class="form-control" id="liveDate" readonly>
                </div>
                <div class="col-6">
                    <label class="form-label fw-bold">Time</label>
                    <input type="text" class="form-control" id="liveTime" readonly>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow" style="border-radius: 12px;">
        <div class="card-body">
            <h5 class="card-title mb-3" style="color: #1a1851; font-weight: bold;">🎤 Practical Scenarios</h5>
            <div class="table-responsive">
                <table class="table table-bordered table-striped global-table">
                    <thead style="background-color: #1a1851; color: white;">
                        <tr>
                            <th style="width: 5%;">#</th>
                            <th>Scenario/Tasks</th>
                            <th style="width: 20%;">Attachment</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>1 Hour Budots</td>
                            <td><a href="#">Download</a></td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>30 Minutes Gangnam style</td>
                            <td><a href="#">Download</a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <form action="">
        <div class="mb-2">
            <label class="form-label fw-bold">Confirmation code (For Assessor Only)</label>
            <input type="text" class="form-control" value="">
        </div>
    </form>
</div>