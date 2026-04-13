<?php require_once '../includes/db-connect.php';
require_once '../includes/functions.php';

if (!isset($_SESSION['userid'])) {
    $_SESSION['flash_error'] = "You're not logged in yet!";
    header("Location: login.php");
    exit;
}

$reviews = viewMyReview($conn, $_SESSION['userid']);
$pageTitle = "My Profile";
require_once '../includes/header.php';
?>

<section class="container" style="margin-top: 2rem; margin-bottom: 4rem;">

    <div class="user-hero">
        <div>
            <p style="color: var(--accent); font-weight: bold; margin-bottom: 5px;">WELCOME BACK,</p>
            <h2>@<?= $_SESSION['username'] ?></h2>
        </div>
        <a href="./logout.php" class="btn btn-danger">Logout ➜</a>
    </div>

    <h3 style="margin-bottom: 1.5rem; font-family: var(--font-brand);">My Reviews (<?= count($reviews) ?>)</h3>

    <div class="my-reviews-grid">
        <?php if (empty($reviews)): ?>
            <div class="stat-item" style="grid-column: 1/-1;">
                <p>You haven't reviewed any games yet! Go find some games to rate.</p>
                <br>
                <a href="../game/games.php" class="btn btn-primary">Browse Games</a>
            </div>
        <?php else: ?>
            <?php foreach ($reviews as $rev):
                $score = (int)$rev['score'];
                $level = ($score < 1) ? 1 : (($score > 10) ? 10 : $score);
            ?>
                <div class="user-review-card">
                    <div class="review-card-header">
                        <img src="<?= coverSrc($rev['cover_image']) ?>" alt="<?= sanitize($rev['game_title']) ?>">
                        <div class="user-score-badge" style="background-color: var(--score-<?= $level ?>);">
                            ⭐ <?= $score ?>/10
                        </div>
                    </div>

                    <div class="review-card-body">
                        <h3><?= sanitize($rev['game_title']) ?></h3>

                        <p class="review-text">"<?= html_entity_decode($rev['review_text'], ENT_QUOTES) ?>"</p>

                        <div class="review-card-footer">
                            <span>Reviewed on <?= date('M d, Y', strtotime($rev['created_at'])) ?></span>
                        </div>
                    </div>

                    <a href="../game/game-detail.php?id=<?= (int)$rev['game_id'] ?>" class="view-game-btn">
                        VIEW GAME PAGE
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>