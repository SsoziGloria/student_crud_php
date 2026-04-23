<?php
require_once "config/database.php";
require_once "models/Student.php";

$db = (new Database())->connect();
$student = new Student($db);

$error = "";
$success = "";

if ($_POST) {
    $student->name = htmlspecialchars(trim($_POST['name']));
    $student->email = htmlspecialchars(trim($_POST['email']));
    $student->course = htmlspecialchars(trim($_POST['course']));
    $student->age = (int) $_POST['age'];

    if (empty($student->name) || empty($student->email) || empty($student->course) || empty($student->age)) {
    $error = "All fields are required.";
} elseif (!filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
    $error = "Invalid email format.";
} elseif ($student->emailExists()) {
    $error = "This email is already registered.";
} else {
    if ($student->create()) {
        header("Location: read.php");
    } else {
        $error = "Failed to add student.";
    }
}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3>Add Student</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input class="form-control mb-2" name="name" placeholder="Name">
            <input class="form-control mb-2" name="email" placeholder="Email">
            <input class="form-control mb-2" name="course" placeholder="Course">
            <input class="form-control mb-2" name="age" type="number" placeholder="Age">

            <button class="btn btn-success">Save</button>
            <a href="read.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
</body>
</html>