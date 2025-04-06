<?php
    require_once 'BaseDao.php';

    class WorkoutDao extends BaseDao {
        public function __construct() {
            parent::__construct("workouts");
        }

        public function getByUserId($user_id) {
            $stmt = $this->connection->prepare("SELECT * FROM orders WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>