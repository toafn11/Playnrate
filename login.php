<?php require_once 'db-connect.php';
require_once 'functions.php';

$error_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = getLogin($conn, sanitize($_POST['username']), sanitize($_POST['password']));
    if ($user_id != false) {
        $_SESSION['userid'] = $user_id;
        redirect("index.php");
        exit;
    } else $error_message = "Username or password is incorrect!";
}

require_once 'header.php'; ?>
<section class="login">
    <div>
        <form action="login.php" method="POST">
            <?php if (isset($_SESSION['flash_success'])): ?>
                <div style="background: var(--success); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    <?= $_SESSION['flash_success'] ?>
                </div>
                <?php
                unset($_SESSION['flash_success']);
                ?>
            <?php endif; ?>
            <?php if ($error_message !== ""): ?>
                <div style="background: var(--danger); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            <p>Enter your username:</p>
            <input type="text" name="username">
            <p>Enter your password:</p>
            <input type="password" name="password">
            <button type="submit">Login</button>
        </form>
        <a href="signup.php">I don't have any account.</a>
    </div>
</section>

<?php require_once 'footer.php'; ?>