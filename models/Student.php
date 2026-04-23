<?php
class Student {
    private $conn;
    private $table = "students";

    public $id;
    public $name;
    public $email;
    public $course;
    public $age;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $stmt = $this->conn->prepare(
            "INSERT INTO " . $this->table . " (name, email, course, age)
             VALUES (:name, :email, :course, :age)"
        );

        return $stmt->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':course' => $this->course,
            ':age' => $this->age
        ]);
    }

    public function read() {
        return $this->conn->query("SELECT * FROM " . $this->table . " ORDER BY id DESC");
    }

    public function getSingle() {
        $stmt = $this->conn->prepare(
            "SELECT * FROM " . $this->table . " WHERE id = ? LIMIT 1"
        );
        $stmt->execute([$this->id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update() {
        $stmt = $this->conn->prepare(
            "UPDATE " . $this->table . "
             SET name=:name, email=:email, course=:course, age=:age
             WHERE id=:id"
        );

        return $stmt->execute([
            ':name' => $this->name,
            ':email' => $this->email,
            ':course' => $this->course,
            ':age' => $this->age,
            ':id' => $this->id
        ]);
    }

    public function delete() {
        $stmt = $this->conn->prepare(
            "DELETE FROM " . $this->table . " WHERE id = ?"
        );

        return $stmt->execute([$this->id]);
    }

    public function emailExists() {
    $query = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':email', $this->email);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}
}
?>