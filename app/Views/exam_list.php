<?php include "partials/htmlhead.php" ?>
<div class="exam-list__container">
    <?php include "partials/sidebar.php" ?>
    <section id="exam-list__exams">
        <h1>Examination List</h1>
        <p class="bold">School Year: Placeholder</p>
        <div class="exam-list__body-container">
            <!-- Display all exam here -->
            <div class="exam-list__table-heading">
                <p class="semi-bold" style="width: 180px;">Title</p>
                <p class="semi-bold" style="width: 180px;">Description</p>
                <p class="semi-bold" style="width: 110px;">Subject Code</p>
                <p class="semi-bold" style="width: 90px;">Duration</p>
                <p class="semi-bold" style="width: 135px;">Due Date</p>
                <p class="semi-bold" style="width: 75px;">Status</p>
                <div style="width: 65px;"></div>
            </div>

            <div class="exam-list__table-content-container">
                <?php if ($data['user_exams']): ?>
                    <?php foreach ($data['user_exams'] as $exam): ?>
                        <?php if ($data['status'][$exam['id']] == 'pending' || $data['status'][$exam['id']] == false): ?>
                            <div class="exam-list__table-content">
                                <p style="width: 180px;"><?= $exam['title'] ?></p>
                                <p style="width: 180px;"><?= $exam['description'] ?></p>
                                <p style="width: 110px;"><?= $exam['class_code'] ?></p>
                                <p style="width: 90px;"><?= $exam['duration'] ?> minutes</p>
                                <p style="width: 135px;"><?= date('m-d-y h:iA', strtotime($exam['due_date'])) ?></p>
                                <?php if ($data['status'][$exam['id']]): ?>
                                    <p style="width: 75px;"><?= ucfirst($data['status'][$exam['id']]) ?></p>
                                <?php else: ?>
                                    <p style="width: 75px;">Not Taken</p>
                                <?php endif ?>
                                <button class="openModalBtn" data-exam-id="<?= htmlspecialchars($exam['id']) ?>" data-exam-duration="<?= htmlspecialchars($exam['duration']) ?>">Take</button>
                            </div>
                        <?php endif ?>
                    <?php endforeach;
                    unset($exam) ?>
                <?php else: ?>
                    <p><?= "No exams currently available" ?></p>
                <?php endif ?>
            </div>
        </div>
        <?php include "partials/modal.php" ?>
    </section>
    </main>
</div>
<script src="/js/exam_list.js"></script>
</body>