<?php
require_once "config/database.php";
require_once "models/Student.php";

$db = (new Database())->connect();
$student = new Student($db);

$student->id = $_GET['id'];

if ($student->delete()) {
    header("Location: read.php");
}
?>