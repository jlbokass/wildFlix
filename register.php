<?php
require_once "includes/config.php";
require_once "includes/classes/Constants.php";
require_once "includes/classes/FormSanitizer.php";
require_once "includes/classes/Account.php";

$account = new Account();

if (isset($_POST['submitButton'])) {
    $firstName = FormSanitizer::sanitizeFormString($_POST['firstName']);
    $lastName = FormSanitizer::sanitizeFormString($_POST['lastName']);
    $userName = FormSanitizer::sanitizeFormUserName($_POST['userName']);
    $email = FormSanitizer::sanitizeFormEmail($_POST['email']);
    $email2 = FormSanitizer::sanitizeFormEmail($_POST['email2']);
    $password = FormSanitizer::sanitizeFormPassword($_POST['password']);
    $password2 = FormSanitizer::sanitizeFormPassword($_POST['password2']);

    $success =$account->register($firstName, $lastName, $userName, $email, $email2, $password, $password2);

    if ($success) {
        $_SESSION['userLoggedIn'] = $userName;
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
    <title>Wildflix | Register</title>
</head>
<body>
<div class="signInContainer">
    <div class="column">
        <div class="header">
            <img src="assets/images/logo.png" alt="Logo">
            <h3>Sign Up</h3>
            <span>to continue to WildFlix</span>

        </div>
        <form method="post">
            <?php echo $account->getError(Constants::$firstNameCharacters); ?>
            <input
                type="text"
                name="firstName"
                placeholder="Your firstname"
                value="<?php $account->getUserValue('firstName'); ?>"
            >

            <?php echo $account->getError(Constants::$lastNameCharacters); ?>
            <input
                type="text"
                name="lastName"
                placeholder="Your lastname"
                value="<?php $account->getUserValue('lastName'); ?>"
            >

            <?php echo $account->getError(Constants::$userNameCharacters); ?>
            <?php echo $account->getError(Constants::$userNameTaken); ?>
            <input
                type="text"
                name="userName"
                placeholder="Your username"
                value="<?php $account->getUserValue('userName'); ?>"
            >

            <?php echo $account->getError(Constants::$emailDontMatch); ?>
            <?php echo $account->getError(Constants::$emailInvalid); ?>
            <?php echo $account->getError(Constants::$emailTaken); ?>
            <input
                type="email"
                name="email"
                placeholder="Your email"
                value="<?php $account->getUserValue('email'); ?>"
            >
            <input
                type="email"
                name="email2"
                placeholder="Confirm email"
                value="<?php $account->getUserValue('email2'); ?>"
            >

            <?php echo $account->getError(Constants::$passwordDontMatch); ?>
            <?php echo $account->getError(Constants::$passwordCharacters); ?>
            <input
                type="password"
                name="password"
                placeholder="Your password"
            >
            <input
                type="password"
                name="password2"
                placeholder="Conform your password"
            >
            <input type="submit" name="submitButton" value="SUBMIT">
        </form>
        <a href="login.php" class="signInMessage">Already have an account? sign in here!</a>
    </div>
</div>
</body>
</html>
