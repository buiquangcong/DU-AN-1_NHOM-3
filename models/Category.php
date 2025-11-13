<?php
class Category
{
    private $conn;

    public function __construct()
    {
        $this->conn = new PDO("mysql:host=localhost;dbname=duan1;charset=utf8", "root", "");
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT * FROM category_tour");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM category_tour WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insert($name)
    {
        $stmt = $this->conn->prepare("INSERT INTO category_tour(name) VALUES(?)");
        return $stmt->execute([$name]);
    }

    public function update($id, $name)
    {
        $stmt = $this->conn->prepare("UPDATE category_tour SET name=? WHERE id=?");
        return $stmt->execute([$name, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM category_tour WHERE id=?");
        return $stmt->execute([$id]);
    }
}
