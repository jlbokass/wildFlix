<?php
require_once "includes/config.php";
require_once "includes/classes/Constants.php";
require_once "includes/classes/FormSanitizer.php";
require_once "includes/classes/Account.php";

$account = new Account();

if (isset($_POST['submitButton'])) {

    $username = FormSanitizer::sanitizeFormUserName($_POST['username']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);

    $success = $account->login($username, $password);

    if ($success) {
        $_SESSION['userLoggedIn'] = $username;
        header('Location: index.php');
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Wildflix | Login</title>
</head>
<body>
<div class="signInContainer">
    <div class="column">
        <div class="header">
            <img src="assets/images/logo.png" alt="Logo">
            <h3>Sign in</h3>
            <span>to continue to WildFlix</span>

        </div>
        <form method="post">
            <?php echo $account->getError(Constants::$loginFailed); ?>
            <input
                type="text"
                name="username"
                placeholder="Your userName"
                value="<?php $account->getUserValue('username'); ?>"
            >
            <input type="password" name="password" placeholder="Your password">
            <input type="submit" name="submitButton" value="SUBMIT">
        </form>
        <a href="register.php" class="signUpMessage">Need an account? Sing up here!</a>
    </div>
</div>
</body>
</html>
