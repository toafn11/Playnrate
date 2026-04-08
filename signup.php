<?php require_once 'db-connect.php';
require_once 'functions.php';

$error_message = "";
$sucess_message = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $pwd = $_POST['password'];
    $repwd = $_POST['retype'];

    $signup = checkPasswordMatch($pwd, $repwd);
    if ($signup === true) {
        if (addUsers($conn, $username, password_hash($pwd, PASSWORD_DEFAULT)) === true) {
            $_SESSION['flash_success'] = "Sign up successfully! You can login.";
            redirect("login.php");
        } else $error_message = "Error in adding user.";
    } else $error_message = "Fail to sign up";
}

require_once 'header.php'; ?>
<section class="login">
    <div>
        <form action="signup.php" method="POST">
            <?php if ($error_message !== ""): ?>
                <div style="background: var(--danger); color: white; padding: 10px; border-radius: 5px; margin-bottom: 10px;">
                    <?= $error_message ?>
                </div>
            <?php endif; ?>
            <p>Enter your username:</p>
            <input type="text" name="username">
            <p>Enter your password:</p>
            <input type="password" name="password">
            <p>Re-type your password:</p>
            <input type="password" name="retype">
            <button type="submit">Sign up</button>
        </form>
        <a href="login.php">I already have an account!</a>
    </div>
</section>

<?php require_once 'footer.php'; ?>