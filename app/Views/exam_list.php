<?php include "partials/header.php" ?>

<section class="exam-list__section">
    <h1>List of Exam</h1>
    <div id="exam-list__exams">
        <?php if ($data['user_exams']): ?>
            <?php foreach ($data['user_exams'] as $exam): ?>
                <div class="exam-list__list">
                    <h2><?= $exam['title'] ?></h2>
                    <p><?= $exam['description'] ?></p>
                    <p><?= $exam['duration'] ?></p>
                    <form method="get" action="/exam/take-exam">
                        <button type="submit" name="exam_id" value="<?= htmlspecialchars($exam['id']) ?>">Get Exam</button>
                    </form>
                </div>
            <?php endforeach ?>
        <?php else: ?>
            <p><?= "No exams currently available" ?></p>
        <?php endif ?>
    </div>
</section>

<?php include "partials/footer.php" ?>