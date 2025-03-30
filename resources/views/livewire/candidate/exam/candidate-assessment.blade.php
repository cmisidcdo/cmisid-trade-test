<div>
    <div class="card-header text-white text-center py-3" style="background-color: #1a1851; border-radius: 12px 12px 0 0;">
        <h2 class="fw-bold m-0">Assessment Test</h2>
    </div>
    <div class="assesment-container py-4" style="min-height: 85vh; background: linear-gradient(180deg, rgb(81, 166, 219) 0%, rgba(0, 51, 102, 1) 100%);">

        <div class="card mx-auto" style="max-width: 600px; border-radius: 12px; border: 2px solid #007BFF">
            <div class="card-body">
                <h3 class="text-center card-title fw-bold" style="font-size: 22px;">Test Instructions</h3>
                <ul class="card-text" style="font-size: 18px;">
                    <li>This exam consists of <strong>multiple-choice questions</strong> (MCQs).</li>
                    <li>The exam is <strong>timed</strong>, and the remaining time will be displayed on your screen.</li>
                    <li>Kindly <strong>minimize noises</strong> during the exam.</li>
                    <li>If there are any issues, you may raise your hand or call and ask the person in charge of the test.</li>
                    <li>Any form of <strong>cheating or misconduct</strong> will result in disqualification.</li>
                    <li>Once you submit the test, you may <strong>not return</strong> to change it.</li>
                </ul>
                <div class="text-center mt-4">
                    <button type="button" class="btn btn-primary text-white px-4 py-2" data-bs-toggle="modal" data-bs-target="#warningModal">
                        Proceed to the Assessment Test
                    </button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title fw-bold text-center" id="warningModalLabel">⚠️Warning before taking the Test!</h5>
                </div>

                <div class="modal-body">
                    <p>Before proceeding with the examination, please read and agree to the following oath</p>
                    <p><strong>I solemnly affirm that:</strong></p>
                    <ul>
                        <li>I will not use any external devices, software, or tools that may provide an unfair advantage.</li>
                        <li>I will not engage in cheating, plagiarism, or any form of academic dishonesty during this examination.</li>
                        <li>I understand that any violation of these rules may result in disqualification, cancellation of my results, or further disciplinary action.</li>
                    </ul>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">I Agree and take the Test</button>

                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="testModal" tabindex="-1" aria-labelledby="testModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-m">
            <div class="modal-content" style="border-radius: 12px; background-color: #f8f9fa;border: 2px solid #007BFF">
                <div class="modal-header text-center">
                    <h5 class="modal-title fw-bold w-100" id="testModalLabel">Assessment Test - Page 1</h5>
                </div>
                <div class="modal-body px-3 py-3">
                    <p class="fw-bold text-center">Time Left: <span>HH:mm</span></p>


                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 1:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q1" id="q1o1"> <label for="q1o1">Option 1</label><br>
                            <input type="radio" name="q1" id="q1o2"> <label for="q1o2">Option 2</label><br>
                            <input type="radio" name="q1" id="q1o3"> <label for="q1o3">Option 3</label><br>
                            <input type="radio" name="q1" id="q1o4"> <label for="q1o4">Option 4</label>
                        </div>
                    </div>

                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 2:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q2" id="q2o1"> <label for="q2o1">Option 1</label><br>
                            <input type="radio" name="q2" id="q2o2"> <label for="q2o2">Option 2</label><br>
                            <input type="radio" name="q2" id="q2o3"> <label for="q2o3">Option 3</label><br>
                            <input type="radio" name="q2" id="q2o4"> <label for="q2o4">Option 4</label>
                        </div>
                    </div>

                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 3:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q2" id="q2o1"> <label for="q2o1">Option 1</label><br>
                            <input type="radio" name="q2" id="q2o2"> <label for="q2o2">Option 2</label><br>
                            <input type="radio" name="q2" id="q2o3"> <label for="q2o3">Option 3</label><br>
                            <input type="radio" name="q2" id="q2o4"> <label for="q2o4">Option 4</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-center">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModalPage2">Next</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="testModalPage2" tabindex="-1" aria-labelledby="testModalPage2Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-m">
            <div class="modal-content" style="border-radius: 12px; background-color: #f8f9fa;border: 2px solid #007BFF">
                <div class="modal-header text-center">
                    <h5 class="modal-title fw-bold w-100" id="testModalPage2Label">Assessment Test - Page 2</h5>
                </div>
                <div class="modal-body px-3 py-3">
                    <p class="fw-bold text-center">Time Left: <span>HH:mm</span></p>


                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 4:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q3" id="q3o1"> <label for="q3o1">Option 1</label><br>
                            <input type="radio" name="q3" id="q3o2"> <label for="q3o2">Option 2</label><br>
                            <input type="radio" name="q3" id="q3o3"> <label for="q3o3">Option 3</label><br>
                            <input type="radio" name="q3" id="q3o4"> <label for="q3o4">Option 4</label>
                        </div>
                    </div>

                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 5:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q3" id="q3o1"> <label for="q3o1">Option 1</label><br>
                            <input type="radio" name="q3" id="q3o2"> <label for="q3o2">Option 2</label><br>
                            <input type="radio" name="q3" id="q3o3"> <label for="q3o3">Option 3</label><br>
                            <input type="radio" name="q3" id="q3o4"> <label for="q3o4">Option 4</label>
                        </div>
                    </div>

                    <div class="p-1 bg-light rounded">
                        <p><strong>Question 6:</strong> Lorem Ipsum Lorem Ipsum Lorem Ipsum</p>
                        <div>
                            <input type="radio" name="q3" id="q3o1"> <label for="q3o1">Option 1</label><br>
                            <input type="radio" name="q3" id="q3o2"> <label for="q3o2">Option 2</label><br>
                            <input type="radio" name="q3" id="q3o3"> <label for="q3o3">Option 3</label><br>
                            <input type="radio" name="q3" id="q3o4"> <label for="q3o4">Option 4</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#testModal">Back</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#submitconfirmationModal">Submit</button>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="submitconfirmationModal" tabindex="-1" aria-labelledby="submitconfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px;border: 2px solid #007BFF">
                <div class="modal-header">
                    <h5 class=" text-center w-100 modal-title fw-bold" id="submitconfirmationModalLabel">Warning!</h5>
                </div>
                <div class="modal-body">
                    <strong>Are you sure to submit your Assessment Test answers? All responses will be saved.</strong>
                </div>
                <div class="modal-footer d-flex justify-content-between mt-2">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#testModal">Review</button>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#successModal">
                        Confirm Submission
                    </button>


                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center" style="border-radius: 12px; border: 2px solid #007BFF;">

                <div class="modal-body py-5">
                    <h3 class="fw-bold">Answers Submitted Successfully!</h3>
                    <p class="text-muted">Redirecting to the Homepage. Please wait.</p>
                </div>
            </div>
        </div>
    </div>
</div>