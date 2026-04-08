<?php require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$platforms = getGamePlatform($conn, $id);

$reviews = getReview($conn, $id);

require_once 'header.php';
?>
<section class="container">
    <div class="game-intro">
        <img src="<?= coverSrc($game['cover_image']) ?>" alt=" <?= sanitize($game['title']) ?>">
        <div class="gi-title"><?= sanitize($game['title']) ?></div>
        <div class="gi-des"><?= sanitize($game['description']) ?></div>
        <div class="gi-year"><?= (int)$game['release_year'] ?></div>
        <div class="gi-genre"><?= sanitize($game['genre']) ?></div>
        <div class="gi-developer"><?= sanitize($game['developer']) ?></div>
        <div class="gi-pub"><?= sanitize($game['publisher']) ?></div>
        <?php foreach ($platforms as $p): ?>
            <div class="gi-platform"><?= sanitize($p) ?></div>
        <?php endforeach ?>

    </div>
    <div class="game-reviews">
        <?php if (empty($reviews)): ?>
            <p>his game doesn't have any reviews yet! Be the first one here:</p>
        <?php else: ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="review-card" style="border: 1px solid var(--border); padding: 10px; margin-bottom: 10px;">
                    <h4>@<?= $rev['username'] ?></h4>
                    <p>⭐<?= $rev['score'] ?>/10</p>
                    <p>"<?= $rev['review_text'] ?>"</p>
                    <small>at <?= $rev['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php endif ?>

    </div>
</section>

<?php
require_once 'footer.php';
?>