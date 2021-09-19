<?php
$username = "root";
$password = "strongpassword";

try {
    $dbh = new PDO("mysql:host=localhost;dbname=products", $username, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    file_put_contents('PDOErrors.txt', $e->getMessage(), FILE_APPEND);
    $dbh = null;
}
