<?php require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$platforms = getGamePlatform($conn, $id);

$rvcheck = checkUserReviewed($conn, $_SESSION['userid'], $id);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit_review']) && !$rvcheck) {
    $score = (int)($_POST['score'] ?? 0);
    $text = sanitize($_POST['review_text'] ?? '');
    if ($score < 1 || $score > 10) $errors[] = 'Score must be between 1 and 10.';
    if (strlen($text) < 5)         $errors[] = 'Review must be at least 5 characters.';

    if (empty($errors)) {
        if (createReview($conn, $_SESSION['userid'], $id, $score, $text)) {
            $_SESSION['flash_success'] = 'Your review has been submitted!';
            header("Location: game-detail.php?id=" . $id);
            exit;
        }
    }
}


$reviews = getReview($conn, $id);
$pageTitle = $game['title'];
require_once 'header.php';
?>
<section class="container">
    <div class="game-intro">
        <img src="<?= coverSrc($game['cover_image']) ?>">
        <!-- RIGHT -->
        <div class="gi-info">
            <div class="gi-title"><?= sanitize($game['title']) ?></div>
            <p class="genres-box"><?= sanitize($game['genre']) ?></p>
            <div class="gi-des"><?= sanitize($game['description']) ?></div>

            <div class="review-box">
                <div class="rating-badge" style="background-color: var(--score-<?= (int)$game['avg_rating'] ?>)">⭐ <?= number_format($game['avg_rating']) ?></div>
                <div class="gi-ratingcount">(<?= (int)$game['rating_count'] ?> reviews)</div>

            </div>
            <div class="gi-meta">
                <p><b>Release:</b> <?= (int)$game['release_year'] ?></p>

                <p><b>Developer:</b> <?= sanitize($game['developer']) ?></p>
                <p><b>Publisher:</b> <?= sanitize($game['publisher']) ?></p>
            </div>

            <div class="gi-platforms">
                <?php foreach ($platforms as $p): ?>
                    <span class="gi-platform"><?= sanitize($p) ?></span>
                <?php endforeach ?>
            </div>

        </div>
        <?php if ($rvcheck) : ?>
            <div class="write-review-box">
                <p>You have reviewed this game!</p>
            </div>
        <?php elseif (isset($_SESSION['userid'])) : ?>
            <form method="POST" id="reviewForm" class="write-review-box">
                <div class="form-group">
                    <label for="score">Score (1 – 10) *</label>
                    <div id="starPicker" style="display:flex;gap:2px;margin-bottom:.3rem;"></div>

                    <input type="hidden" id="score" name="score" value="<?= (int)($_POST['score'] ?? 7) ?>" required>
                </div>

                <div class="form-group full">
                    <label for="review_text">Review *</label>
                    <textarea id="review_text" name="review_text" placeholder="Share your thoughts about this game…" required><?= sanitize($_POST['review_text'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="submit_review">Submit!</button>
            </form>
        <?php else : ?>
            <div class="write-review-box">
                <p>You must login to write a review!</p>
            </div>
        <?php endif ?>
    </div>
    <div class="game-reviews">
        <?php if (empty($reviews)): ?>
            <p>This game doesn't have any reviews yet! Be the first one here:</p>
        <?php else: ?>
            <?php foreach ($reviews as $rev): ?>
                <div class="review-card" style="border: 1px solid var(--border); padding: 10px; margin-bottom: 10px;">
                    <h4>@<?= $rev['username'] ?></h4>
                    <p class="rating-badge" style="background-color: var(--score-<?= (int)$rev['score'] ?>)"><?= $rev['score'] ?>/10</p>
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