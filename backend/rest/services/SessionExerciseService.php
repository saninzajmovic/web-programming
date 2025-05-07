<?php
    require_once 'BaseService.php';
    require_once '../dao/SessionExerciseDao.php';
    require_once '../dao/ExerciseDao.php';
    require_once '../dao/NutritionDao.php';

    class SessionExerciseService extends BaseService {
        public function __construct() {
            $dao = new SessionExerciseDao();
            parent::__construct($dao);
            $exerciseDao = new ExerciseDao();
            $nutritionDao = new NutritionDao();
        }

        public function getBySessionId($session_id) {
            if (empty($session_id)) {
                throw new Exception("Session ID is required.");
            }
            return $this->dao->getBySessionId($session_id);
        }

        public function deleteBySessionId($session_id) {
            if (empty($session_id)) {
                throw new Exception("Session ID is required.");
            }
            return $this->dao->deleteBySessionId($session_id);
        }

        // helper function to calculate calories burned for exercise
        public function calculateExerciseCalories($exercise_id, $duration, $weight_kg) {
            $exercise = $this->exerciseDao->getById($exercise_id);
            if (!$exercise) {
                throw new Exception("Excericise not found.");
            }
            if (empty($exercise['met_value'])) {
                throw new Exception("MET value not defined for this exercise.");
            }

            // formula for calories => (MET * weight in kg * duration in hours)
            return (int) round($exercise['met_value'] * $weight_kg * ($duration/60));
        }

        public function createSessionExercise($data, $user_id) {
            $required = ['session_id', 'exercise_id', 'duration'];
            foreach ($required as $field) {
                if (empty($data[$field])) {
                    throw new Exception("$field is required.");
                }
            }

            $user_weight = $this->nutritionDao->getLatestWeight($user_id);
            if (!$user_weight) {
                throw new Exception("User weight not available for calorie calculation");
            }

            // calculating calories if they arent provided
            if (!isset($data['calories_burned'])) {
                $data['calories_burned'] = calculateExerciseCalories($data['exercise_id'], $data['duration'], $user_weight);
            }

            return $this->dao->insert($data);
        }
    }
?>