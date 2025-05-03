<?php
    require_once 'BaseService.php';
    require_once '../dao/WorkoutSessionDao.php';
    require_once 'SessionExerciseService.php';

    class WorkoutSessionService extends BaseService {
        public function __construct() {
            $dao = new WorkoutSessionDao();
            parent::__construct($dao);
            $sessionExerciseService = new SessionExerciseService();
        }

        public function  getByUserId($user_id) {
            if (empty($user_id)) {
                throw new Exception("User ID is required.");
            }
            return $this->dao->getByUserId($user_id);
        }

        public function getByDateRange($user_id, $start_date, $end_date) {
            // validating the inputs
            if (empty($user_id)) {
                throw new Exception("User ID is required.");
            }
            // is date format ok
            if (!strtotime($start_date) || !strtotime($end_date)) {
                throw new Exception("Invalid date format.");
            }
            if ($start_date > $end_date) {
                throw new Exception("Start date cannot be after end date.");
            }
            return $this->dao->getByDateRange($user_id, $start_date, $end_date);
        }

        public function createWorkoutSession($data) {
            if (empty($data['user_id'])) {
                throw new Exception("User ID is required");
            }
            if (empty($data['date'])) {
                throw new Exception("Session date is required");
            }

            // if duration not provided set to 0
            $data['duration'] = $data['duration'] ?? 0;
            
            return $this->dao->insert($data);
        }

        // calculating and updating calories for workout session
        public function updateSessionCalories($session_id) {
            $exercises = $this->sessionExerciseService->getBySessionId($session_id);

            $total_calories = 0;
            foreach ($exercises as $exercise) {
                $total_calories += $exercise['calories_burned'] ?? 0;
            }

            return $this->dao->update($session_id, ['total_calories' => $total_calories]);
        }
    }
?>