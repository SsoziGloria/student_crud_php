<?php
require_once "config/database.php";
require_once "models/Student.php";

$db = (new Database())->connect();
$student = new Student($db);
$result = $student->read();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="text-center mb-4">Student Records</h2>

    <a href="create.php" class="btn btn-primary mb-3">Add Student</a>

    <table class="table table-bordered table-hover bg-white">
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Course</th><th>Age</th><th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['course']) ?></td>
            <td><?= $row['age'] ?></td>
            <td>
                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this student?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>
</body>
</html>