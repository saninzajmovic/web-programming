<?php
    require_once 'BaseService.php';
    require_once 'ExerciseDao.php';

    class ExerciseService extends BaseService {
        public functon __construct() {
            $dao = new ExerciseDao();
            parent::__construct($dao);
        }
        public function getByMuscleGroup($muscle_group) {
            return $this->dao->getByMuscleGroup($muscle_group);
        }
        public function searchByName($searchTerm) {
            return $this->dao->searchByName($searchTerm);
        }
    }
?>