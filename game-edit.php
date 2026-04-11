<?php require_once 'db-connect.php';
require_once 'functions.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('index.html');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$errors = [];

$platforms = getGamePlatform($conn, $id);

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $genre_id = (int)($_POST['genre_id'] ?? 0);
    $release_year = (int)($_POST['release_year'] ?? 0);
    $developer = $_POST['developer'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $selected_platforms = $_POST['platforms'] ?? [];

    $errors = checkValidForm($_POST);
    $imgPath = checkImgPath($game['cover_image']);
    if ($imgPath === false) $errors['cover_image'] = 'Cannot upload image.';
    if (empty($errors)) {
        $upd = updateGame($conn, $_POST, $id);
        if ($upd !== true) $errors = $upd;
        redirect("game-detail.php?id=$id&updated=1");
    }
    $game = array_merge($game, compact('title', 'description', 'genre_id', 'release_year', 'developer', 'publisher'));
}
$existingPlatforms = array_map('intval', $_POST['platforms'] ?? []);
$all_genres = getAllGenres($conn);
$all_platforms = getAllPlatforms($conn);
$pageTitle = $game['title'] . ' Edit';
require_once 'header.php';
?>
<section class="container">
    <?php if ($errors): ?>
        <div class="alert alert-error">❌ Please fix the errors below.</div>
    <?php endif; ?>

    <form method="POST" class="game-intro" enctype="multipart/form-data" id="gameForm" class="form-card">
        <div class="gi-info">
            <div class="form-group">
                <div class="form-group full">
                    <label>Cover Image (leave blank to keep current)</label>
                    <?php if ($game['cover_image'] && $game['cover_image'] !== 'default-cover.jpg'): ?>
                        <div class="image-preview" style="margin-bottom:.75rem;">
                            <img src="<?= coverSrc($game['cover_image']) ?>" alt="Current cover">
                        </div>
                    <?php endif; ?>
                    <label class="file-upload-label" for="cover_image">
                        <span class="upload-icon">📁</span>
                        <span>Click to replace the cover image</span>
                    </label>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*">
                    <?php if (isset($errors['cover_image'])): ?><span class="error-msg"><?= $errors['cover_image'] ?></span><?php endif; ?>
                    <div id="imagePreview" class="image-preview mt-1"></div>
                </div>
                <label for="title">Game Title *</label>
                <input type="text" id="title" name="title"
                    value="<?= sanitize($game['title']) ?>"
                    maxlength="255" required
                    class="<?= isset($errors['title']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['title'])): ?><span class="error-msg"><?= $errors['title'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="genre_id">Genre *</label>
                <select id="genre_id" name="genre_id" required
                    class="<?= isset($errors['genre_id']) ? 'input-error' : '' ?>">
                    <option value="">— Select Genre —</option>
                    <?php while ($g = $all_genres->fetch_assoc()): ?>
                        <option value="<?= $g['id'] ?>" <?= $game['genre_id'] == $g['id'] ? 'selected' : '' ?>>
                            <?= sanitize($g['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                <?php if (isset($errors['genre_id'])): ?><span class="error-msg"><?= $errors['genre_id'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label for="release_year">Release Year *</label>
                <input type="number" id="release_year" name="release_year"
                    value="<?= (int)$game['release_year'] ?>"
                    min="1970" max="<?= date('Y') + 2 ?>" required
                    class="<?= isset($errors['release_year']) ? 'input-error' : '' ?>">
                <?php if (isset($errors['release_year'])): ?><span class="error-msg"><?= $errors['release_year'] ?></span><?php endif; ?>
            </div>


            <div class="form-group">
                <label for="developer">Developer</label>
                <input type="text" id="developer" name="developer"
                    value="<?= sanitize($game['developer']) ?>" maxlength="255">
            </div>

            <div class="form-group">
                <label for="publisher">Publisher</label>
                <input type="text" id="publisher" name="publisher"
                    value="<?= sanitize($game['publisher']) ?>" maxlength="255">
            </div>

            <div class="form-group full">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required
                    class="<?= isset($errors['description']) ? 'input-error' : '' ?>"><?= sanitize($game['description']) ?></textarea>
                <?php if (isset($errors['description'])): ?><span class="error-msg"><?= $errors['description'] ?></span><?php endif; ?>
            </div>



            <div class="form-group full">
                <label>Platforms</label>
                <select name="platforms[]" multiple style="height:130px;">
                    <?php while ($p = $all_platforms->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>"
                            <?= in_array((int)$p['id'], $existingPlatforms) ? 'selected' : '' ?>>
                            <?= sanitize($p['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

        </div>
        <div style="display:flex;gap:.75rem;margin-top:1.25rem;">
            <button type="submit" class="btn btn-primary">💾 Save Changes</button>
            <a href="game-detail.php?id=<?= $id ?>" class="btn btn-secondary">Cancel</a>
            <a href="delete-game.php?id=<?= $id ?>" class="btn btn-danger confirm-delete" style="margin-left:auto;">🗑️ Delete Game</a>
        </div>
    </form>
</section>

<?php
require_once 'footer.php';
?>