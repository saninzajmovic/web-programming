<?php
    require_once 'BaseDao.php';

    class UserDao extends BaseDao {
        public function __construct() {
            parent::__construct("users");
        }

        public function emailExists($email) {
            $stmt = $this->connection->prepare("SELECT 1 FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return (bool)$stmt->fetchColumn();
        }

        public function getByEmail($email) {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch();
        }

        public function getByRole($role) {
            $stmt = $this->connection->prepare("SELECT * FROM users WHERE role = :role");
            $stmt->bindParam(':role', $role);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>