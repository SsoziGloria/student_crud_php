<?php
require_once "config/database.php";

$database = new Database();
$db = $database->connect();

if ($db) {
    echo "Connected successfully!";
} else {
    echo "Connection failed.";
}
?>