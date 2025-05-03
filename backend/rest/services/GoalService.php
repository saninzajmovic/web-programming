<?php
    require_once 'BaseService.php';
    require_once '../dao/GoalDao.php';

    class GoalService extends BaseService {
        public function __construct() {
            $dao = new GoalDao();
            parent::__construct($dao);
        }

        public function getByUserId($user_id) {
            return $this->dao->getByUserId($user_id);
        }

        public function getCompletedGoalsByUserId($user_id) {
            return $this->dao->getCompletedGoalsByUserId($user_id);
        }

        public function getByType($user_id, $goal_type) {
            $valid_types = ['weight','workout_frequency','daily_water','daily_calories'];
            if (!in_array($goal_type, $valid_types)) {
                throw new Exception("Invalid goal type");
            }
            return $this->dao->getByType($user_id, $goal_type);
        }

        public function createGoal($data) {
            // validation of fields
            if (empty($data['user_id'])) {
                throw new Exception("User ID is required.");
            }
            if (empty($data['goal_type'])) {
                throw new Exception("Goal type is required.");
            }
            if (empty($data['target_value'])) {
                throw new Exception("Target value is required.");
            }
            if (!is_numeric($data['target_value'])) {
                throw new Exception("Target value must be a number.");
            }

            // set default is_active to true
            $data['is_active'] = $data['is_active'] ?? true;

            return $this->dao->insert($data);
        }
    }
?>