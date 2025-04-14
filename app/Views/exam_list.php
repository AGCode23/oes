<?php include "partials/htmlhead.php" ?>
<div class="exam-list__container">
    <?php include "partials/sidebar.php" ?>
    <h1>Examination List</h1>
    <section id="exam-list__exams">
        <?php if ($data['user_exams']): ?>
            <?php foreach ($data['user_exams'] as $exam): ?>
                <?php if ($data['user_exam_status'][$exam['id']] == 'pending' || $data['user_exam_status'][$exam['id']] == false): ?>
                    <div class="exam-list__list">
                        <h2><?= $exam['title'] ?></h2>
                        <p><?= $exam['description'] ?></p>
                        <p><?= $exam['duration'] ?></p>
                        <?php if ($data['user_exam_status'][$exam['id']]): ?>
                            <p><?= $data['user_exam_status'][$exam['id']] ?></p>
                        <?php endif ?>
                        <form method="get" action="/exam/take_exam">
                            <button type="submit" name="exam_id" value="<?= htmlspecialchars($exam['id']) ?>">Get Exam</button>
                        </form>
                    </div>
                <?php endif ?>
            <?php endforeach;
            unset($exam) ?>
        <?php else: ?>
            <p><?= "No exams currently available" ?></p>
        <?php endif ?>
    </section>
    </main>
</div>
</body>