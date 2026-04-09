<?php require_once 'db-connect.php';
require_once 'functions.php';

if (!isset($_SESSION['userid'])) {
    $_SESSION['flash_error'] = "You're not login yet!";
    header("Location: login.php");
    exit;
}


$reviews = viewMyReview($conn, $_SESSION['userid']);

require_once 'header.php';
?>
<section class="container">
    <div class="user-main">
        <h2>HELLO, @<?= $_SESSION['username'] ?>!</h2>
        <div class="nav-link"><a href="logout.php">Logout➜]</a></div>
    </div>
    <div class="game-reviews">
        <?php if (empty($reviews)): ?>
            <p>You haven't reviewed any games yet!</p>
        <?php else: ?>
            <?php foreach ($reviews as $rev): ?>
                <a href="game-detail.php?id=<?= (int)$rev['game_id'] ?>" class="game-card">
                    <img src="<?= coverSrc($rev['cover_image']) ?>" alt=" <?= sanitize($rev['game_title']) ?>">
                    <div class="card-title">
                        <p><?= $rev['game_title'] ?></p>
                    </div>

                </a>
                <div class="review-card" style="border: 1px solid var(--border); padding: 10px; margin-bottom: 10px;">
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