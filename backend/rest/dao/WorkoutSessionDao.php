<?php
    require_once 'BaseDao.php';

    class WorkoutSessionDao extends BaseDao {
        public function __construct() {
            parent::__construct("workout_sessions");
        }

        public function getByUserId($user_id) {
            $stmt = $this->connection->prepare("SELECT * FROM workout_sessions WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByDateRange($user_id, $start_date, $end_date) {
            $stmt = this->connection->prepare("SELECT * FROM workout_sessions WHERE user_id = :user_id AND date BETWEEN :start_date AND :end_date");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>