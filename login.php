<?php require_once 'db-connect.php';
require_once 'functions.php';
$page_title = 'Login';
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
<section class="container-login">
    <div>
        <form class="login-site" action="login.php" method="POST">
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
            <h1>Login</h1>
            <p1>Enter your username:</p>
            <input class="input-text" type="text" name="username">
            <p2>Enter your password:</p>
            <input class type="password" name="password">
            <button type="submit">Login</button>
            <a href="signup.php">I don't have any account.</a>
        </form>
    </div>
</section>

<?php require_once 'footer.php'; ?>