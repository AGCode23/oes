<?php include "partials/htmlhead.php" ?>
<div class="exam_result__container">
    <?php include "partials/sidebar.php" ?>
    <section class="exam_result__section">
        <h1>Examination Result</h1>
        <p class="bold">School Year</p>
        <div class="exam_result__filter-container">
            <div class="exam_result__year-container">
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
            </div>
            <select name="exam_result__subject-code" id="exam_result__subject-code">
                <!-- Depends on the number of subject code related to the student -->
                <option value="">Subject Code</option>
                <?php foreach ($data['user_exam_subject_code'] as $subjectCode): ?>
                    <option value="<?= $subjectCode['class_code'] ?>"><?= $subjectCode['class_code'] ?></option>
                <?php endforeach ?>
            </select>
        </div>
        <div class="exam_result__body-container">
            <!-- Display all result here -->
            <div class="exam_result__table-heading">
                <p class="semi-bold" style="width: 180px;">Title</p>
                <p class="semi-bold" style="width: 110px;">Subject Code</p>
                <p class="semi-bold" style="width: 150px;">Completion Date</p>
                <p class="semi-bold" style="width: 85px;">Percentage</p>
                <p class="semi-bold" style="width: 65px;">Remarks</p>
            </div>
            <div id="exam_result__table-content-container">
                <?php foreach ($data['user_exam_result'] as $key => $result): ?>
                    <div class="exam_result__table-content">
                        <p style="width: 180px;"><?= $key + 1 . '. ' . $result['title'] ?></p>
                        <p style="width: 110px;"><?= $result['class_code'] ?></p>
                        <?php if ($result['status'] == 'pending'): ?>
                            <p style="width: 150px;">-</p>
                            <p style="width: 85px;">-</p>
                            <p style="width: 65px;"><?= $result['status'] ?></p>
                        <?php else: ?>
                            <p style="width: 150px;"><?= $result['submitted_at'] ?></p>
                            <?= $result['status'] == 'passed' ? '<p class="exam_result__passed" style="width: 85px;">' . $result['score'] . '</p><p class="exam_result__passed" style="width: 65px;">' . $result['status'] . '</p>'
                                : '<p class="exam_result__failed" style="width: 85px;">' . $result['score'] . '</p><p class="exam_result__failed" style="width: 65px;">' . $result['status'] . '</p>' ?>
                        <?php endif ?>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>
    </main>
</div>
</body>
<script src="/js/exam_result.js"></script>