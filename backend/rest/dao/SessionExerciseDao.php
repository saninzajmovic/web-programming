<?php
    require_once 'BaseDao.php';

    class SessionExerciseDao extends BaseDao {
        public function __construct() {
            parent::__construct("session_exercises");
        }


        // ! for some reason it only works if i made $sql separately
        // public function getBySessionId($session_id) { // joined tables da bi return imena vjezbi and not just the id of them
        //     $stmt = $this->connection->prepare("SELECT se.*, e.name, AS 'exercise_name'
        //                                         FROM 'session_exercises' AS se
        //                                         JOIN 'exercises' e ON se.'exercise_id' = e.'id'
        //                                         WHERE 'session_id' = :session_id");
        //     $stmt->bindParam(':session_id', $session_id);
        //     $stmt->execute();
        //     return $stmt->fetchAll();
        // }


        public function getBySessionId($session_id) {
            $sql = "SELECT se.*, e.name AS exercise_name
                    FROM session_exercises AS se
                    JOIN exercises e ON se.exercise_id = e.id
                    WHERE se.session_id = :session_id";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':session_id', $session_id);
            
            // Debugging: Output the SQL statement
            //echo $sql; // This will print the SQL statement
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