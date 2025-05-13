<?php
    require_once '../config.php';
    require_once '../database.php';

    class BaseDao {
        protected $table;
        protected $connection;

        public function __construct($table) {
            $this->table = $table;
            $this->connection = Database::connect();
        }

        public function getAll() {
            $stmt = $this->connection->prepare("SELECT * FROM " . $this->table);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getById($id) {
            $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch();
        }

        // for services to check if same thing already exists
        public function getBy($columnm, $search) {
            $stmt = $this->connection->prepare("SELECT * FROM " . $this->table . " WHERE :column = :search");
            $stmt->bindParam(':column', $columnm);
            $stmt->bindParam(':search', $search);
            $stmt->execute();
            return $stmt->fetch();
        }

        public function insert($data) {
            $columns = implode(", ", array_keys($data));
            $placeholders = ":" . implode(", :", array_keys($data));
            $stmt = $this->connection->prepare("INSERT INTO " . $this->table . " ($columns) VALUES ($placeholders)");
            return $stmt->execute($data);
        }

        public function update($id, $data) {
            $fields = "";
            foreach ($data as $key => $value) {  // ovo je kao key value pair
                $fields .= "$key = :$key, ";  
            }
            $fields = rtrim($fields, ", ");
            $stmt = $this->connection->prepare("UPDATE " . $this->table . " SET $fields WHERE id = :id");
            $data['id'] = $id;  // nema ono bindParam?
            return $stmt->execute($data);
        }

        public function delete($id) {
            $stmt = $this->connection->prepare("DELETE FROM " . $this->table . " WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();  // zasto ovdje ne treba execute($id)?  zato sto smo pass $id as argument into the fuction delete($id)
        }
    }
?>