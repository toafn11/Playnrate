<?php
require_once '../includes/db-connect.php';
require_once '../includes/functions.php';
if (checkAdmin() === false) redirect('index.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('games.php');

$game = getGameDetail($conn, $id);
if ($game === false) redirect('games.php');

$errors = [];
$platforms = getGamePlatform($conn, $id);
$existingPlatforms = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $genre_id = (int)($_POST['genre_id'] ?? 0);
    $release_year = (int)($_POST['release_year'] ?? 0);
    $developer = $_POST['developer'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $selected_platforms = $_POST['platforms'] ?? [];

    $errors = checkValidForm($_POST);

    $coverFile = $game['cover_image'];
    if (!empty($_FILES['cover_image']['name'])) {
        $uploaded = checkImgPath($game['cover_image']);
        if ($uploaded) {
            $coverFile = $uploaded;
        } else {
            $errors['cover_image'] = "Failed to upload new image.";
        }
    }

    if (empty($errors)) {
        $formData = $_POST;
        $formData['cover_image'] = $coverFile;
        $upd = updateGame($conn, $formData, $id);

        if ($upd === true) {
            writeLog($conn, $_SESSION['userid'], 'UPDATE_GAME', "Updated details for game: " . $title);
            redirect("game-detail.php?id=$id&updated=1");
        } else {
            $errors = $upd;
        }
    }
    $game = array_merge($game, compact('title', 'description', 'genre_id', 'release_year', 'developer', 'publisher'));
    $existingPlatforms = array_map('intval', $_POST['platforms'] ?? []);
} else {
    $existingPlatforms = getGamePlatformIDs($conn, $id);
}


$all_genres = getAllGenres($conn);
$all_platforms = getAllPlatforms($conn);
$pageTitle = 'Edit: ' . $game['title'];
require_once '../includes/header.php';
?>

<section class="container" style="margin-top: 2rem; margin-bottom: 4rem;">
    <h2 class="section-title">Edit Game Details</h2>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-error">❌ Please check the information again.</div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="game-intro form-card" style="display: flex; gap: 2rem; align-items: flex-start;">

        <div style="flex: 0 0 300px;">
            <div class="form-group">
                <label>Game Cover Image</label>
                <label class="file-upload-label" for="cover_image" style="height: 400px;">
                    <img src="<?= coverSrc($game['cover_image']) ?>" id="currentPreview" class="upload-preview-img">

                    <div id="uploadOverlay" style="position: relative; z-index: 2; text-align: center; background: rgba(0,0,0,0.4); padding: 10px; border-radius: 5px;">
                        <span class="upload-icon" style="font-size: 2rem;">📁</span>
                        <p style="font-size: 0.8rem;">Click to change</p>
                    </div>

                    <input type="file" id="cover_image" name="cover_image" accept="image/*" hidden onchange="previewImage(this)">
                </label>
                <?php if (isset($errors['cover_image'])): ?><span class="error-msg"><?= $errors['cover_image'] ?></span><?php endif; ?>
            </div>
        </div>

        <div class="gi-info" style="flex: 1;">

            <div class="form-group">
                <label for="title">Game Title *</label>
                <input type="text" id="title" name="title" value="<?= sanitize($game['title']) ?>" required>
                <?php if (isset($errors['title'])): ?><span class="error-msg"><?= $errors['title'] ?></span><?php endif; ?>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="genre_id">Genre *</label>
                    <select id="genre_id" name="genre_id" required>
                        <?php while ($g = $all_genres->fetch_assoc()): ?>
                            <option value="<?= $g['id'] ?>" <?= $game['genre_id'] == $g['id'] ? 'selected' : '' ?>>
                                <?= sanitize($g['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="release_year">Release Year *</label>
                    <input type="number" id="release_year" name="release_year" value="<?= (int)$game['release_year'] ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="developer">Developer</label>
                    <input type="text" id="developer" name="developer" value="<?= sanitize($game['developer']) ?>">
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="<?= sanitize($game['publisher']) ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" rows="5" required><?= sanitize($game['description']) ?></textarea>
                <?php if (isset($errors['description'])): ?><span class="error-msg"><?= $errors['description'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Platforms (Ctrl + Click to select)</label>
                <select name="platforms[]" multiple style="height: 100px;">
                    <?php while ($p = $all_platforms->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>" <?= in_array((int)$p['id'], $existingPlatforms) ? 'selected' : '' ?>>
                            <?= sanitize($p['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary" style="flex: 2;">💾 Save Changes</button>
                <a href="./game-detail.php?id=<?= $id ?>" class="btn btn-secondary" style="flex: 1;">Cancel</a>
                <a href="./game-delete.php?id=<?= $id ?>" class="btn btn-danger" style="margin-left: auto;">🗑️ Delete</a>
            </div>
        </div>
    </form>
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('currentPreview').src = e.target.result;
                document.getElementById('uploadOverlay').style.background = "rgba(0, 112, 243, 0.6)";
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<?php require_once '../includes/footer.php'; ?>