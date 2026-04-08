<?php require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$platforms = getGamePlatform($conn, $id);

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
        <div class="gi-avgrating"><?= number_format($game['avg_rating']) ?></div>
        <div class="gi-ratingcount"><?= (int)$game['rating_count'] ?></div>
        <?php foreach ($platforms as $p): ?>
            <div class="gi-platform"><?= sanitize($p) ?></div>
        <?php endforeach ?>

    </div>
</section>

<?php
require_once 'footer.php';
?>