<div>
    <div class="assessment-form">
        <h1 class="form-title">Assessment Notes Form</h1>
        
        <div class="form-content">
            <div class="form-row select-candidate">
                <label for="candidate">Select Candidate</label>
                <div class="input-with-icon">
                    <input type="text" id="candidate" name="candidate">
                    <span class="icon-right">
                        <i class="fas fa-chevron-left"></i>
                    </span>
                </div>
            </div>
            
            <div class="assessor-details">
                <h3>Assessor Details</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="autofill when candidate is selected">
                    </div>
                    <div class="form-group">
                        <label for="date">Date</label>
                        <div class="input-with-icon">
                            <input type="text" id="date" name="date" placeholder="mm/dd/yyyy (autofill; editable)">
                            <span class="icon-right">
                                <i class="fas fa-calendar"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="assessment-notes">
                <h3>Assessment Notes</h3>
                <div class="form-row">
                    <div class="form-group">
                        <label for="observations">Observations</label>
                        <textarea id="observations" name="observations" placeholder="notes..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="areas_for_improvement">Areas for Improvement</label>
                        <textarea id="areas_for_improvement" name="areas_for_improvement" placeholder="notes..."></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="strengths">Strengths</label>
                        <textarea id="strengths" name="strengths" placeholder="notes..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="comments">Comments</label>
                        <textarea id="comments" name="comments" placeholder="notes..."></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .assessment-form {
            width: 100%;
            padding: 0;
        }
        
        .form-title {
            background-color: #1a237e;
            color: white;
            padding: 15px;
            text-align: center;
            margin: 0 0 20px 0;
            font-size: 24px;
        }
        
        .form-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin: 0 10px;
        }
        
        .select-candidate {
            margin-bottom: 20px;
        }
        
        .assessor-details, .assessment-notes {
            margin-bottom: 20px;
        }
        
        .assessor-details h3, .assessment-notes h3 {
            margin-top: 0;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .form-row {
            display: flex;
            gap: 20px;
            margin-bottom: 15px;
        }
        
        .form-group {
            flex: 1;
            margin-bottom: 15px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        
        textarea {
            height: 100px;
            resize: vertical;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .icon-right {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
        }
    </style>
</div>