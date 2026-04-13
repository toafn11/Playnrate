<?php
require_once '../includes/db-connect.php';
require_once '../includes/functions.php';

if (checkAdmin() === false) redirect('../index.php');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) redirect('games.php');

$game = getGameDetail($conn, $id);
if (!$game) redirect('games.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_delete'])) {
    if (delGame($conn, $game)) {
        writeLog($conn, $_SESSION['userid'], 'DELETE_GAME', "Deleted game: " . $game['title'] . " (ID: " . $game['id'] . ")");
        redirect('games.php?deleted=1');
    } else
        redirect('game-delete.php?id=' . $id);
}

$pageTitle = 'Delete: ' . $game['title'];
require_once '../includes/header.php';
?>


<div class="container" style="padding-top:2rem;">
    <div class="danger-zone">
        <div style="font-size:3rem;margin-bottom:1rem;">⚠️</div>
        <h2>Delete "<?= sanitize($game['title']) ?>"?</h2>
        <p style="color:var(--text-muted);margin-bottom:1.5rem;line-height:1.6;">
            This will permanently delete the game, all its reviews and all platform links.
            <strong>This action cannot be undone.</strong>
        </p>

        <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
            <form method="POST">
                <button type="submit" name="confirm_delete" class="btn btn-danger">Yes, Delete Game</button>
            </form>
            <a href="./game-detail.php?id=<?= $id ?>" class="btn btn-secondary">No, Go Back</a>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>