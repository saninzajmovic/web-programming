<?php
    require_once 'BaseDao.php';

    class SessionExerciseDao extends BaseDao {
        public function __construct() {
            parent::__construct("session_exercises");
        }

        public function getBySessionId($session_id) { // joined tables da bi return imena vjezbi and not just the id of them
            $stmt = $this->connection->prepare("SELECT se.*, e.name, as exercise_name
                                                FROM session_exercises as se
                                                JOIN exercises e ON se.exercise_id = e.id
                                                WHERE session_id = :session_id");
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function deleteBySessionId($session_id) {
            $stmt = $this->connection->prepare("DELETE FROM session_exercises WHERE session_id = :session_id");
            $stmt->bindParam(':session_id', $session_id);
            $stmt->execute();
        }
    }
?>