<?php
    require_once 'BaseDao.php';

    class ExerciseDao extends BaseDao {
        public function __construct() {
            parent::__construct('exercises');
        }

        public function getByMuscleGroup($muscle_group) {
            $stmt = $this->connection->prepare("SELECT * FROM exercises WHERE muscle_group = :muscle_group");
            $stmt->bindParam(':muscle_group', $muscle_group);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function searchByName($searchTerm) {  // to search exercises without having to put entire exact name
            $stmt = this->connection->prepare("SELECT * FROM exercises where name LIKE :searchTerm");
            $stmt->bindParam(':searchTerm', $searchTerm);
            $stmt->execute();
            return $stmt->fetchAll();
        }

    }

?>