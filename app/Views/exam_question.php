<?php include "partials/sidebar.php" ?>

<section class="exam-question__section">
    <form action="/exam/submit_answer" method="POST">
        <input type="hidden" name="exam_id" value="<?= $data['exam_id'] ?>">
        <input type="hidden" name="exam_type" value="<?= $data['exam_questions'][0]['type'] ?>">
        <?php foreach ($data['exam_questions'] as $question): ?>
            <div class="exam-question__question-container">
                <p class="exam-question__question"><?= $question['question_text'] ?></p>
                <?php if ($question['type'] == 'multiple_choice'): ?>
                    <?php

                    $rawOpt = $question['options'];
                    $string = str_replace("'", '\"', $rawOpt);
                    $options = json_decode($string);

                    $options = array_filter($options, function ($value) {
                        return $value !== '';
                    })

                    ?>
                    <?php foreach ($options as $option): ?>
                        <label>
                            <input type="radio" name="answer[<?= $question['id'] ?>]" value="<?= $option ?>"> <?= $option ?>
                        </label>
                    <?php endforeach;
                    unset($option) ?>
                <?php endif ?>
            </div>
        <?php endforeach;
        unset($question) ?>
        <button type="submit">Submit Answers</button>
    </form>
</section>