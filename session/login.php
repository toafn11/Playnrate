<?php require_once '../includes/db-connect.php';
require_once '../includes/functions.php';
$page_title = 'Login';
$error_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = getLogin($conn, sanitize($_POST['username']), $_POST['password']);
    if ($user != false) {
        session_regenerate_id(true);
        $_SESSION['userid'] = $user['id'];
        $_SESSION['username'] = strtolower($_POST['username']);
        $_SESSION['role'] = sanitize($user['role']);
        $_SESSION['flash_success'] = "Login successfully!";
        redirect("../index.php");
        exit;
    } else $error_message = "Username or password is incorrect!";
}

require_once '../includes/header.php'; ?>
<section class="container-login">
    <div>
        <form class="login-site" action="login.php" method="POST">
            <?php if ($error_message !== ""): ?>
                <div style="background: var(--danger); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            <h1>Login</h1>
            <p>Enter your username:</p>
            <input class="input-text" type="text" name="username">
            <p>Enter your password:</p>
            <input class="input-text" type="password" name="password">
            <button type="submit">Login</button>
            <a href="./signup.php">I don't have any account.</a>
        </form>
    </div>
</section>

<?php require_once '../includes/footer.php'; ?>