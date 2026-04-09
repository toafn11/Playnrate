<?php require_once 'db-connect.php';
require_once 'functions.php';
$page_title = 'Games';

$games = getAllGames($conn);

require_once 'header.php'; ?>
<div class="welcome-section">
    <div class="container">
        <h1>Discover the Whole World of Games</h1>
        <p>Your ultimate destination for game reviews and ratings. Explore our collection of games, read honest reviews, and share your own experiences with the gaming community.</p>
    </div>
</div>
<section class="container">
    <h3>Games:</h3>
    <div class="grid-games">
        <?php foreach ($games as $g): ?>
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
                    <div class="rating-badge" style="background-color: var(--score-<?= (int)$g['avg_rating'] ?>)">✯ <?= number_format($g['avg_rating'], 1) ?></div>
                    <div class="text-muted"><?= (int)$g['rating_count'] ?> Reviews</div>
                </div>
            </a>
        <?php endforeach ?>
    </div>
</section>


<?php require_once 'footer.php'; ?>