<?php
    require_once 'BaseDao.php';

    class GoalDao extends BaseDao {
        public function __construct() {
            parent::__construct("goals");
        }

        public function getByUserId($user_id) {
            $stmt = $this->connection->prepare("SELECT * FROM goals WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getCompletedGoalsByUserId($user_id) {
            $stmt = $this->connection->prepare("SELECT * FROM goals WHERE user_id = :user_id AND is_active = FALSE");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getByType($user_id, $goal_type) {
            $stmt = $this->connection->prepare("SELECT * FROM goals WHERE user_id = :user_id AND goal_type = :goal_type");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':goal_type', $goal_type);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>