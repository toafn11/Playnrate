<?php
require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$platforms = getGamePlatform($conn, $id);

if (isset($_SESSION['userid'])) $rvcheck = checkUserReviewed($conn, $_SESSION['userid'], $id);

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['submit_review']) && empty($rvcheck)) {
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

<section class="container detail-layout">

    <div class="detail-left">
        <img src="<?= coverSrc($game['cover_image']) ?>" class="detail-cover" alt="Cover">

        <div class="gi-title"><?= sanitize($game['title']) ?></div>
        <div><span class="genres-box"><?= sanitize($game['genre']) ?></span></div>

        <div class="review-box" style="margin-bottom: 0; width: 100%; display: flex; flex-direction: row; justify-content: space-between; align-items: center;">
            <div class="rating-badge" style="background-color: var(--score-<?= max(1, min(10, floor($game['avg_rating']))) ?>); font-size: 1.1rem; padding: 6px 12px;">
                ⭐ <?= number_format($game['avg_rating'], 1) ?>
            </div>
            <div class="gi-ratingcount">(<?= (int)$game['rating_count'] ?> reviews)</div>
        </div>

        <div class="gi-des" style="margin: 10px 0;"><?= sanitize($game['description']) ?></div>

        <div class="gi-meta">
            <p><b>Release:</b> <?= (int)$game['release_year'] ?></p>
            <p><b>Developer:</b> <?= sanitize($game['developer']) ?></p>
            <p><b>Publisher:</b> <?= sanitize($game['publisher']) ?></p>
        </div>

        <div class="gi-platforms" style="margin-top: 5px;">
            <?php foreach ($platforms as $p): ?>
                <span class="gi-platform"><?= sanitize($p) ?></span>
            <?php endforeach ?>
        </div>

        <div class="admin-actions">
            <a href="game-edit.php?id=<?= $id ?>" class="btn btn-secondary btn-sm">✏️ Edit</a>
            <a href="game-delete.php?id=<?= $id ?>" class="btn btn-danger btn-sm">🗑️ Delete</a>
        </div>
    </div>

    <div class="detail-right">

        <?php if (isset($rvcheck) && $rvcheck) : ?>
            <div class="write-review-box" style="text-align: center;">
                <h3 style="color: var(--success); margin-bottom: 10px;">Thank You!</h3>
                <p style="color: var(--text-muted);">You have already reviewed this game.</p>
            </div>
        <?php elseif (isset($_SESSION['userid'])) : ?>
            <form method="POST" id="reviewForm" class="write-review-box">
                <h3 style="margin-bottom: 15px; font-family: var(--font-brand); color: var(--text);">Write a Review</h3>

                <div class="form-group">
                    <label for="score" style="font-weight: bold; color: var(--accent-h);">Score (1 – 10) *</label>
                    <div id="starPicker" style="display:flex;gap:2px;margin: 5px 0 15px;"></div>
                    <input type="hidden" id="score" name="score" value="<?= (int)($_POST['score'] ?? 7) ?>" required>
                </div>

                <div class="form-group full">
                    <label for="review_text" style="font-weight: bold; color: var(--accent-h);">Review *</label>
                    <textarea id="review_text" name="review_text" rows="4" placeholder="Share your thoughts about this game…" required><?= sanitize($_POST['review_text'] ?? '') ?></textarea>
                </div>
                <button type="submit" name="submit_review" class="btn btn-primary" style="margin-top: 15px; width: 100%; justify-content: center;">🚀 Submit Review</button>
            </form>
        <?php else : ?>
            <div class="write-review-box" style="text-align: center;">
                <p style="font-size: 1.1rem;">You must <a href="login.php" style="color: var(--accent); font-weight: bold;">Login</a> to write a review!</p>
            </div>
        <?php endif ?>

        <div class="reviews-list">
            <h3 style="font-family: var(--font-brand); margin-bottom: 10px; border-bottom: 1px solid var(--border); padding-bottom: 10px;">Community Reviews</h3>

            <?php if (empty($reviews)): ?>
                <div style="background: var(--bg-card); padding: 20px; border-radius: var(--radius); text-align: center; border: 1px dashed var(--border);">
                    <p style="color: var(--text-muted);">This game doesn't have any reviews yet! Be the first one here.</p>
                </div>
            <?php else: ?>
                <?php foreach ($reviews as $rev): ?>
                    <div class="review-card">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                            <h4 style="color: var(--accent);">@<?= sanitize($rev['username']) ?></h4>
                            <span class="rating-badge" style="background-color: var(--score-<?= max(1, min(10, floor($rev['score']))) ?>)">
                                ⭐ <?= $rev['score'] ?>/10
                            </span>
                        </div>
                        <p style="font-style: italic; color: var(--text); line-height: 1.5; margin-bottom: 10px;">"<?= sanitize($rev['review_text']) ?>"</p>
                        <small style="color: var(--text-muted); font-size: 0.85rem;">Reviewed on <?= date('M d, Y', strtotime($rev['created_at'])) ?></small>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </div>

    </div>
</section>

<?php require_once 'footer.php'; ?>