<?php
class Staff
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=duan1;charset=utf8", "root", "");
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM staff");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM staff WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($name, $position, $salary)
    {
        $stmt = $this->conn->prepare("INSERT INTO staff(name, position, salary) VALUES(?, ?, ?)");
        return $stmt->execute([$name, $position, $salary]);
    }

    public function update($id, $name, $position, $salary)
    {
        $stmt = $this->conn->prepare("UPDATE staff SET name=?, position=?, salary=? WHERE id=?");
        return $stmt->execute([$name, $position, $salary, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM staff WHERE id=?");
        return $stmt->execute([$id]);
    }
}
