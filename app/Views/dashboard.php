<?php include "partials/htmlhead.php";
date_default_timezone_set('Asia/Manila'); ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div class="dashboard__container">
    <?php include "partials/sidebar.php" ?>
    <section class="dashboard__section">
        <div class="dashboard__sub-container">
            <h1 id="dashboard__greetings">Loading...</h1>
            <p>Stay focused. Stay confident. Give your best!</p>
        </div>
        <div class="dashboard__sub-container-1">
            <div class="dashboard__announcement">
                <p class="bold">Announcement!</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eaque, vero adipisci! Ea voluptates vitae sunt non, quaerat facilis suscipit incidunt?</p>
            </div>
            <div class="dashboard__pie-chart">
                <canvas id="examResultsChart"></canvas>
            </div>
        </div>
        <div class=" dashboard__sub-container-2">
            <h1>Pending Exam</h1>
            <div class="dashboard__table-heading">
                <p class="semi-bold">Title</p>
                <p class="semi-bold">Desciption</p>
                <p class="semi-bold">Due Date</p>
            </div>
            <div class="dashboard__table-content">
                <p>Title</p>
                <p>Desciption</p>
                <p>Due Date</p>
            </div>
        </div>
    </section>
    </main>
</div>
</body>
<script src="/js/dashboard.js"></script>