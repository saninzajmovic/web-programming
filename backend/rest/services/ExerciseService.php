<?php
    require_once 'BaseService.php';
    require_once __DIR__ . '/../dao/ExerciseDao.php';

    class ExerciseService extends BaseService {
        public function __construct() {
            $dao = new ExerciseDao();
            parent::__construct($dao);
        }

        public function getByMuscleGroup($muscle_group) {
            return $this->dao->getByMuscleGroup($muscle_group);
        }

        public function searchByName($searchTerm) {
            if (empty($searchTerm)) {
                throw new Exception("Search term is empty.");
            }
            return $this->dao->searchByName($searchTerm);
        }

        public function createExercise($data) {
            // validation of fields
            if (empty($data['name'])) {
                throw new Exception("Exercise name required.");
            }
            if (!empty($this->dao->getBy("name", $data['name']))) {
                throw new Exception("Excercise name already exists");
            }
            if (empty($data['muscle_group'])) {
                throw new Exception("Exercise muscle group required.");
            }
            if (empty($data['met_value'])) {
                throw new Exception("MET value is required");
            }
            if (!is_double($data['met_value'])) {
                throw new Exception("MET value must be a number.");
            }
            if (strlen($data['name']) > 100) {
                throw new Exception("Exercise name is too long.");
            }
            return $this->dao->insert($data);
        }
    }
?>