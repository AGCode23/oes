<nav class="header__nav">
    <div class="header__upper">
        <a href="/">
            <div class="header__logo">
                <img src="/assets/LIU-Logo.svg" alt="School logo">
                <h1>LoremIU</h1>
            </div>
        </a>
        <div class="header__portal-container">
            <div class="header__portal">
                <a href="/" class="header__nav-links">
                    <div class="header__nav-link header__dashboard">
                        <img src="/assets/DASHBOARD.svg" alt="Dashboard Nav">
                        <p>Dashboard</p>
                    </div>
                </a>
                <a href="/profile" class="header__nav-links">
                    <div class="header__nav-link header__profile">
                        <img src="/assets/PROFILE.svg" alt="Profile Nav">
                        <p>Profile</p>
                    </div>
                </a>
                <a href="/calendar" class="header__nav-links">
                    <div class="header__nav-link header__calendar">
                        <img src="/assets/CALENDAR.svg" alt="Calendar Nav">
                        <p>Calendar</p>
                    </div>
                </a>
                <div class="header__nav-links header__exam">
                    <div class="header__nav-group">
                        <div class="header__exam-button">
                            <button class="header__nav-link header__nav-toggle" data-target="header__exam-submenu">
                                <img src="/assets/EXAM.svg" alt="Exam Nav">
                                Exam
                            </button>
                        </div>
                    </div>
                </div>
                <div class="header__exam-group">
                    <div id="header__exam-submenu" class="header__submenu">
                        <a href="/exam/list" class="header__nav-sublink">List</a>
                        <a href="/exam/result" class="header__nav-sublink">Result</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class=" header__support">
        <a class="semi-bold" href="/logout">Logout</a>
        <a href="/support">Help & Support</a>
    </div>
</nav>
<script src="/js/sidebar/sidebar.js"></script>
<main>