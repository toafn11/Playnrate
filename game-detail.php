<?php require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$platforms = getGamePlatform($conn, $id);

require_once 'header.php';
?>
<section class="container-detail">
    <div class="game-intro">
        <!-- LEFT -->
        <img src="<?= coverSrc($game['cover_image']) ?>">

        <!-- RIGHT -->
        <div class="gi-info">
            <div class="gi-title"><?= sanitize($game['title']) ?></div>
            <div class="gi-des"><?= sanitize($game['description']) ?></div>
            <div class="review-box">
                <div class="gi-avgrating">⭐ <?= number_format($game['avg_rating']) ?></div>
                <div class="gi-ratingcount">(<?= (int)$game['rating_count'] ?> reviews)</div>
            </div>
            <div class="gi-meta">
                <p><b>Release:</b> <?= (int)$game['release_year'] ?></p>
                <p><b>Genre:</b> <?= sanitize($game['genre']) ?></p>
                <p><b>Developer:</b> <?= sanitize($game['developer']) ?></p>
                <p><b>Publisher:</b> <?= sanitize($game['publisher']) ?></p>
            </div>

            <div class="gi-platforms">
                <?php foreach ($platforms as $p): ?>
                    <span class="gi-platform"><?= sanitize($p) ?></span>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</section>

<?php
require_once 'footer.php';
?>