<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' | PlayNRate' : 'PlayNRate' ?></title>
    <link rel="stylesheet" href="style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header-site">
        <div class="header-inside">
            <h1 class="logo">PlayNRate</h1>
            <nav class="nav-bar">
                <ul class="nav-list">
                    <li>
                        <div class="nav-link"><a href="index.php">Home</a></div>
                    </li>
                    <li>
                        <div class="nav-link"><a href="games.php">Games</a></div>
                    </li>
                    <li>
                        <div class="nav-link"><a href="reviews.php">Reviews</a></div>
                    </li>
                    <li>
                        <div class="nav-link"><a href="contact.php">Contact</a></div>
                    </li>
                    <li>
                        <div class="nav-link"><a href="login.php">Login</a></div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="site-main">