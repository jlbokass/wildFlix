<?php
ob_start();
session_start();
date_default_timezone_set("Europe/London");

try {
    $conn = new PDO("mysql:dbname=netflix;host=localhost", "root", "dabok1977");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}