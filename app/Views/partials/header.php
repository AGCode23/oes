<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Examination</title>
    <link rel="stylesheet" href="/css/styles-1739675312.min.css?1739675312">

</head>

<body>
    <header>
        <div class="header__header">
            <nav class="header__nav">
                <div class="header__title">
                    <h1><a href="/">Online Examination System</a></h1>
                </div>
                <div class="header__hamburger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                        <rect class="bar bar-1" x="5" y="5" width="20" height="3" rx="1.5" />
                        <rect class="bar bar-2" x="5" y="12" width="20" height="3" rx="1.5" />
                        <rect class="bar bar-3" x="5" y="19" width="20" height="3" rx="1.5" />
                    </svg>
                </div>
                <ul class="header__nav-links">
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li><a href="/">
                                <div class="header__link">Dashboard</div>
                            </a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['user_name'])): ?>
                        <li><a href="/logout">
                                <div class="header__link">Logout</div>
                            </a></li>
                    <?php else: ?>
                        <li><a href="/login">
                                <div class="header__link">Login</div>
                            </a></li>
                        <li><a href="/register">
                                <div class="header__link">Register</div>
                            </a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <div class="header__overlay">
        <nav class="header__overlay-nav">
            <div class="header__overlay-hamburger">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                    <rect class="bar bar-1" x="5" y="5" width="20" height="3" rx="1.5" />
                    <rect class="bar bar-2" x="5" y="12" width="20" height="3" rx="1.5" />
                    <rect class="bar bar-3" x="5" y="19" width="20" height="3" rx="1.5" />
                </svg>
            </div>
            <ul>
                <?php if (isset($_SESSION['user_name'])): ?>
                    <li><a href="/">
                            <div class="header__overlay-link">Dashboard</div>
                        </a></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_name'])): ?>
                    <li><a href="/logout">
                            <div class="header__overlay-link">Logout</div>
                        </a></li>
                <?php else: ?>
                    <li><a href="/login">
                            <div class="header__overlay-link">Login</div>
                        </a></li>
                    <li><a href="/register">
                            <div class="header__overlay-link">Register</div>
                        </a></li>
                <?php endif; ?>
                <svg width="50px" height="50px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path d="M20.7457 3.32851C20.3552 2.93798 19.722 2.93798 19.3315 3.32851L12.0371 10.6229L4.74275 3.32851C4.35223 2.93798 3.71906 2.93798 3.32854 3.32851C2.93801 3.71903 2.93801 4.3522 3.32854 4.74272L10.6229 12.0371L3.32856 19.3314C2.93803 19.722 2.93803 20.3551 3.32856 20.7457C3.71908 21.1362 4.35225 21.1362 4.74277 20.7457L12.0371 13.4513L19.3315 20.7457C19.722 21.1362 20.3552 21.1362 20.7457 20.7457C21.1362 20.3551 21.1362 19.722 20.7457 19.3315L13.4513 12.0371L20.7457 4.74272C21.1362 4.3522 21.1362 3.71903 20.7457 3.32851Z" fill="#0F0F0F"></path>
                    </g>
                </svg>
            </ul>
        </nav>
    </div>
    <script src="/js/header/header.js"></script>
    <main>