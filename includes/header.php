<?php
require_once "includes/config.php";
require_once "includes/classes/PreviewProvider.php";
require_once "includes/classes/Entity.php";

if (!isset($_SESSION['userLoggedIn'])) {
    header('Location: register.php');
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
    <title>Wildflix</title>
</head>
<body>
<div class="wrapper">
