<?php
require_once '../includes/db-connect.php';
require_once '../includes/functions.php';
if (checkAdmin() === false) redirect('../index.php');

$pageTitle = 'Add New Game';
$errors = [];
$title = $description = $developer = $publisher = '';
$genre_id = $release_year = 0;
$selected_platforms = [];

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $genre_id = (int)($_POST['genre_id'] ?? 0);
    $release_year = (int)($_POST['release_year'] ?? 0);
    $developer = $_POST['developer'] ?? '';
    $publisher = $_POST['publisher'] ?? '';
    $selected_platforms = $_POST['platforms'] ?? [];

    $errors = checkValidForm($_POST);

    $coverFile = 'images/placeholder.png';
    if (!empty($_FILES['cover_image']['name'])) {
        $uploadError = '';
        $uploaded = uploadCover($_FILES['cover_image'], $uploadError);
        if ($uploaded) {
            $coverFile = $uploaded;
        } else {
            $errors['cover_image'] = $uploadError;
        }
    }

    if (empty($errors)) {
        $formData = $_POST;
        $formData['cover_image'] = $coverFile;

        $addResult = addGame($conn, $formData);

        if (is_int($addResult)) {
            writeLog($conn, isset($_SESSION['userid']) ? $_SESSION['userid'] : '0', 'ADD_GAME', "Added a new game titled: " . $title);
            redirect("game-detail.php?id=$addResult&created=1");
            exit;
        } else {
            if ($coverFile !== 'images/placeholder.png') {
                $imagePath = __DIR__ . '/uploads/' . $coverFile;
                if (file_exists($imagePath)) {
                    @unlink($imagePath);
                }
            }
            $errors['db'] = "Failed to add game to database.";
        }
    }
}

$all_genres = getAllGenres($conn);
$all_platforms = getAllPlatforms($conn);
require_once '../includes/header.php';
?>

<section class="container" style="margin-top: 2rem;">
    <?php if (isset($errors['db'])): ?>
        <div class="alert alert-error" style="background-color: #fee; border: 1px solid #f00; color: #c00; padding: 1rem; margin-bottom: 1.5rem; border-radius: 4px; font-weight: 500;">
            ❌ <?= $errors['db'] ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="game-intro form-card" style="display: flex; gap: 2rem; align-items: flex-start;">

        <div style="flex: 0 0 300px;">
            <div class="form-group full">
                <label>Cover Image *</label>
                <label class="file-upload-label" for="cover_image" style="height: 400px; display: flex; flex-direction: column; justify-content: center; align-items: center; border: 2px dashed var(--border);">
                    <span class="upload-icon" style="font-size: 3rem;">📁</span>
                    <span>Choose Cover</span>
                    <input type="file" id="cover_image" name="cover_image" accept="image/*" hidden onchange="previewImage(this)">
                </label>
                <?php if (isset($errors['cover_image'])): ?><span class="error-msg"><?= $errors['cover_image'] ?></span><?php endif; ?>
                <div id="imagePreview" class="image-preview" style="margin-top: 10px;"></div>
            </div>
        </div>

        <div class="gi-info" style="flex: 1;">
            <div class="form-group">
                <label for="title">Game Title *</label>
                <input type="text" id="title" name="title" value="<?= sanitize($title) ?>" required>
                <?php if (isset($errors['title'])): ?><span class="error-msg"><?= $errors['title'] ?></span><?php endif; ?>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="genre_id">Genre *</label>
                    <select id="genre_id" name="genre_id" required>
                        <option value="">— Select —</option>
                        <?php while ($g = $all_genres->fetch_assoc()): ?>
                            <option value="<?= $g['id'] ?>" <?= $genre_id == $g['id'] ? 'selected' : '' ?>>
                                <?= sanitize($g['name']) ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="release_year">Release Year *</label>
                    <input type="number" id="release_year" name="release_year" value="<?= $release_year ?: date('Y') ?>" min="1970" max="<?= date('Y') + 2 ?>" required>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label for="developer">Developer</label>
                    <input type="text" id="developer" name="developer" value="<?= sanitize($developer) ?>">
                </div>
                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="<?= sanitize($publisher) ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description * <span style="font-size: 0.85rem; color: var(--text-muted);">(minimum 10 characters)</span></label>
                <textarea id="description" name="description" rows="5" required><?= sanitize($description) ?></textarea>
                <?php if (isset($errors['description'])): ?><span class="error-msg" style="display: block; background-color: #fee; border: 1px solid #f00; color: #c00; padding: 0.5rem; margin-top: 0.5rem; border-radius: 3px;">⚠️ <?= $errors['description'] ?></span><?php endif; ?>
            </div>

            <div class="form-group">
                <label>Platforms (Hold Ctrl to select multiple)</label>
                <select name="platforms[]" multiple style="height:120px; width: 100%;">
                    <?php while ($p = $all_platforms->fetch_assoc()): ?>
                        <option value="<?= $p['id'] ?>" <?= in_array($p['id'], $selected_platforms) ? 'selected' : '' ?>>
                            <?= sanitize($p['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div style="margin-top: 2rem; display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-primary" style="flex: 1;">🚀 Add Game Now</button>
                <a href="games.php" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</section>

<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result + '" style="width:100%; border-radius:8px;">';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.getElementById('description').addEventListener('input', function() {
        const count = this.value.trim().length;
        const minChars = 10;
        const remaining = minChars - count;

        if (count === 0) {
            this.style.borderColor = '';
        } else if (count < minChars) {
            this.style.borderColor = '#ffa500';
            this.title = `${remaining} more characters needed (${count}/${minChars})`;
        } else {
            this.style.borderColor = '#00aa00';
            this.title = `Valid: ${count} characters`;
        }
    });
</script>

<?php require_once '../includes/footer.php'; ?>