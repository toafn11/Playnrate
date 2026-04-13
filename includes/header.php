<?php $currentPage = basename($_SERVER['PHP_SELF'], '.php');
// Determine base path for navigation (how many levels deep we are)
$projectRoot = str_replace('\\', '/', realpath(dirname(__DIR__)));
$currentScriptDir = str_replace('\\', '/', realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
$depth = max(0, substr_count($currentScriptDir, '/') - substr_count($projectRoot, '/'));
$baseUrl = $depth === 0 ? './' : str_repeat('../', $depth);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($page_title) ? $page_title . ' | Playnrate' : 'Playnrate' ?></title>
    <link rel="stylesheet" href="<?= $baseUrl ?>css/style.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Orbitron:wght@700;900&display=swap" rel="stylesheet">
</head>

<body>
    <header class="header-site">
        <div class="header-inside">
            <a class="logo-icon" title="Logo" href="<?= $baseUrl ?>index.php"></a>
            <div class="logo-text">Playnrate</div>
            <nav class="nav-bar">
                <ul class="nav-list">
                    <li>
                        <div class="nav-link<?= $currentPage === 'index' ? '-active' : '' ?>"><a href="<?= $baseUrl ?>index.php">Home</a></div>
                    </li>
                    <li>
                        <div class="nav-link<?= $currentPage === 'games' ? '-active' : '' ?>"><a href="<?= $baseUrl ?>game/games.php">Games</a></div>
                    </li>
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                        <li>
                            <div class="nav-link<?= $currentPage === 'game-add' ? '-active' : '' ?>"><a href="<?= $baseUrl ?>game/game-add.php">Add Game</a></div>
                        </li>
                    <?php endif ?>
                    <li>
                        <?php if (isset($_SESSION['userid'])): ?>
                            <div class="nav-link<?= $currentPage === 'user-page' ? '-active' : '' ?>">
                                <a href="<?= $baseUrl ?>session/user-page.php">
                                    Hi, @<?= $_SESSION['username'] ?>
                                </a>
                            </div>
                        <?php else: ?>
                            <div class="nav-link<?= $currentPage === 'login' ? '-active' : '' ?>">
                                <a href="<?= $baseUrl ?>session/login.php">
                                    Login
                                </a>
                            </div>
                        <?php endif ?>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="site-main">
        <?php if (isset($_SESSION['flash_success'])): ?>
            <div style="background: var(--success); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                <?= $_SESSION['flash_success'] ?>
            </div>
            <?php
            unset($_SESSION['flash_success']);
            ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['flash_error'])): ?>
            <div style="background: var(--danger); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                <?= $_SESSION['flash_error'] ?>
            </div>
            <?php
            unset($_SESSION['flash_error']);
            ?>
        <?php endif; ?>