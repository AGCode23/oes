<?php include "partials/sidebar.php" ?>

<section class="exam-create__section">
    <form id="exam-create__exam-form" action="/exam/create" method="post">
        <input type="text" name="exam-title" id="exam-title" placeholder="Exam Title">
        <input type="text" name="exam-description" id="exam-description" placeholder="Description">
        <input type="text" name="exam-duration" id="exam-duration" placeholder="Duration (in minutes)">
        <select name="exam-type" id="exam-type">
            <option value="">Choose option...</option>
            <option value="multiple_choice">Multiple Choice</option>
            <option value="true_false">True or False</option>
            <option value="short_answer">Short Answer</option>
            <option value="long_answer">Long Answer</option>
        </select>
        <div class="hidden question-divs" id="exam-create__multiple_choice-container">
            <div class="exam-create__multiple_choice">
                <p class="exam-create__question-count">1</p>
                <input class="mc-question exam-create__question" type="text" name="exam-create__mc-question-1" placeholder="Question">
                <input class="mc-option" type="text" name="exam-create__mc-option-a-1" placeholder="Option A">
                <input class="mc-option" type="text" name="exam-create__mc-option-b-1" placeholder="Option B">
                <input class="mc-option" type="text" name="exam-create__mc-option-c-1" placeholder="Option C">
                <input class="mc-option" type="text" name="exam-create__mc-option-d-1" placeholder="Option D">
                <input class="mc-answer" type="text" name="exam-create__mc-answer-1" placeholder="Answer">
            </div>
        </div>
        <div class="hidden question-divs" id="exam-create__true_false-container">
            <div class="exam-create__true_false">
                <p class="exam-create__question-count">1</p>
                <input class="tf-question exam-create__question" type="text" name="exam-create__tf-question-1" placeholder="Question">
                <input class="tf-answer" type="text" name="exam-create__tf-answer-1" placeholder="Answer">
            </div>
        </div>
        <div class="hidden question-divs" id="exam-create__short_answer-container">
            <div class="exam-create__short_answer">
                <p class="exam-create__question-count">1</p>
                <input class="exam-create__question" type="text" name="exam-create__sa-question-1" placeholder="Question">
            </div>
        </div>
        <div class="hidden question-divs" id="exam-create__long_answer-container">
            <div class="exam-create__long_answer">
                <p class="exam-create__question-count">1</p>
                <input class="exam-create__question" type="text" name="exam-create__la-question-1" placeholder="Question">
            </div>
        </div>
        <div class="exam-create__buttons">
            <button type="button" class="exam-create__add-question">Add Question</button>
        </div>
    </form>

</section>
<script src="/js/exam_create.js"></script>