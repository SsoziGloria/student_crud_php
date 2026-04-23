<?php
require_once "config/database.php";
require_once "models/Student.php";

$db = (new Database())->connect();
$student = new Student($db);

$student->id = $_GET['id'];
$data = $student->getSingle();

$error = "";

if ($_POST) {
    $student->name = htmlspecialchars(trim($_POST['name']));
    $student->email = htmlspecialchars(trim($_POST['email']));
    $student->course = htmlspecialchars(trim($_POST['course']));
    $student->age = (int) $_POST['age'];

    if (empty($student->name) || empty($student->email) || empty($student->course) || empty($student->age)) {
        $error = "All fields are required.";
    } elseif (!filter_var($student->email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        if ($student->update()) {
            header("Location: read.php");
        } else {
            $error = "Update failed.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Student</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card p-4 shadow">
        <h3>Edit Student</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <input class="form-control mb-2" name="name" value="<?= htmlspecialchars($data['name']) ?>">
            <input class="form-control mb-2" name="email" value="<?= htmlspecialchars($data['email']) ?>">
            <input class="form-control mb-2" name="course" value="<?= htmlspecialchars($data['course']) ?>">
            <input class="form-control mb-2" name="age" value="<?= $data['age'] ?>">

            <button class="btn btn-warning">Update</button>
            <a href="read.php" class="btn btn-secondary">Back</a>
        </form>
    </div>
</div>
</body>
</html>