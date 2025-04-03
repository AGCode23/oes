<?php include 'partials/header.php' ?>

<section class="exam__section">
    <?php if ($data['user_role'] == 'student'): ?>
        <button><a href="/exam/list">Exam List</a></button>
        <button><a href="/exam/result">Exam Result</a></button>
    <?php elseif ($data['user_role'] == 'teacher'): ?>
        <button><a href="/exam/create">Exam Create</a></button>
    <?php endif ?>
</section>

<?php include 'partials/footer.php' ?>