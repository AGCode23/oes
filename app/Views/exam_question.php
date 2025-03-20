<?php include "partials/header.php" ?>

<section class="exam-question__section">
    <form action="/submit-answer" method="POST">
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
                            <input type="radio" name="choice-<?= $question['id'] ?>" value="<?= $option ?>"> <?= $option ?>
                        </label>
                    <?php

                    endforeach;
                    unset($option);

                    ?>
                <?php endif ?>
            </div>
        <?php endforeach ?>
        <button type="submit">Submit Answers</button>
    </form>
</section>