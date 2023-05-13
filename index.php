<?php

require_once "includes/header.php";

$userLogin = $_SESSION['userLoggedIn'];

$preview = new PreviewProvider($conn, $userLogin);
$preview->createPreviewVideo(null);
