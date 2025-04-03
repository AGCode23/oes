<?php include "partials/header.php" ?>

<section class="exam_result__section">
    <h1>Examination Result</h1>
    <p>School Year</p>
    <label>
        <input type="checkbox" name="year-level" value="1" class="year-checkbox"> First Year
    </label>
    <label>
        <input type="checkbox" name="year-level" value="2" class="year-checkbox"> Second Year
    </label>
    <label>
        <input type="checkbox" name="year-level" value="3" class="year-checkbox"> Third Year
    </label>
    <label>
        <input type="checkbox" name="year-level" value="4" class="year-checkbox"> Fourth Year
    </label>
    <select name="exam_result__subject-code" id="exam_result__subject-code">
        <!-- Depends on the number of subject code related to the student -->
        <option value="">Subject Code</option>
        <?php foreach ($data['user_exam_subject_code'] as $subjectCode): ?>
            <option value="<?= $subjectCode['class_code'] ?>"><?= $subjectCode['class_code'] ?></option>
        <?php endforeach ?>
    </select>
    <div class="exam_result__body-container">
        <!-- Display all result here -->
        <div class="exam_result__title-container">
            <p>Title</p>
            <ul>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <li><?= $result['title'] ?></li>
                <?php endforeach ?>
            </ul>
        </div>
        <div class="exam_result__description-container">
            <p>Description</p>
            <div>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <p><?= $result['description'] ?></p>
                <?php endforeach ?>
            </div>
        </div>
        <div class="exam_result__subject-code-container">
            <p>Subject Code</p>
            <div>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <p><?= $result['class_code'] ?></p>
                <?php endforeach ?>
            </div>
        </div>
        <div class="exam_result__completion-date-container">
            <p>Completion Date</p>
            <div>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <?php if ($result['status'] == 'pending'): ?>
                        <p>-</p>
                    <?php else: ?>
                        <p><?= $result['submitted_at'] ?></p>
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
        <div class="exam_result__percentage-container">
            <p>Percentage</p>
            <div>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <p><?= $result['score'] ?></p>
                <?php endforeach ?>
            </div>
        </div>
        <div class="exam_result__remarks-container">
            <p>Remarks</p>
            <div>
                <?php foreach ($data['user_exam_result'] as $result): ?>
                    <p><?= $result['status'] ?></p>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>
<script src="/js/exam_result.js"></script>

<?php include "partials/footer.php" ?>