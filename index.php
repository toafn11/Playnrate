<?php require_once 'db-connect.php';
require_once 'functions.php';
$page_title = 'Home';

$topGames = getTopGames($conn, 8);
$recentGames = getRecentGames($conn, 4);

$stat = getStat($conn);

require_once 'header.php'; ?>
<div class="welcome-section">
    <div class="container">
        <h1>Discover the Whole World of Games</h1>
        <p>Your ultimate destination for game reviews and ratings. Explore our collection of games, read honest reviews, and share your own experiences with the gaming community.</p>
    </div>
</div>
<section class="container">
    <div class="stats-section">
        <div class="stat-item">
            <h3><?= isset($stat['Game']) ? (int)$stat['Game'] : "Many" ?></h3>
            <p>Games</p>
        </div>
        <div class="stat-item">
            <h3><?= isset($stat['Review']) ? (int)$stat['Review'] : "Many" ?></h3>
            <p>User Reviews</p>
        </div>
        <div class="stat-item">
            <h3><?= isset($stat['Genres']) ? (int)$stat['Genres'] : "Many" ?></h3>
            <p>Genres</p>
        </div>
    </div>

    <h3>Top Rating Games:</h3>
    <div class="grid-games">
        <?php foreach ($topGames as $g): ?>
            <a href="game-detail.php?id=<?= (int)$g['id'] ?>" class="game-card">
                <img src="<?= coverSrc($g['cover_image']) ?>" alt=" <?= sanitize($g['title']) ?>">
                <div class="card-title">
                    <p><?= sanitize($g['title']) ?></p>
                    <div class="card-info">
                        <div class="genres-box"><?= sanitize($g['genre']) ?></div>
                        <div class="release-box"><?= (int)$g['release_year'] ?></div>
                    </div>
                </div>
                <div class="card-main">
                    <div class="rating-badge">✯ <?= number_format($g['avg_rating'], 1) ?></div>
                    <div class="text-muted"><?= (int)$g['rating_count'] ?> Reviews</div>
                </div>
            </a>
        <?php endforeach ?>
    </div>

    <h3>Recent Added Games:</h3>
    <div class="grid-games">

        <?php foreach ($recentGames as $g): ?>
            <a href="game-detail.php?id=<?= (int)$g['id'] ?>" class="game-card">
                <img src="<?= coverSrc($g['cover_image']) ?>" alt=" <?= sanitize($g['title']) ?>">
                <div class="card-title">
                    <p><?= sanitize($g['title']) ?></p>
                    <div class="card-info">
                        <div class="genres-box"><?= sanitize($g['genre']) ?></div>
                        <div class="release-box"><?= (int)$g['release_year'] ?></div>
                    </div>
                </div>
                <div class="card-main">
                    <div class="rating-badge">✯ <?= number_format($g['avg_rating'], 1) ?></div>
                    <div class="text-muted"><?= (int)$g['rating_count'] ?> Reviews</div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
</section>


<?php require_once 'footer.php'; ?>