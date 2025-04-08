<?php
    require_once 'BaseService.php';
    require_once 'GoalDao.php';

    class GoalService extends BaseService {
        public function __construct() {
            $dao = new GoalDao();
            parent::_construct($dao);
        }
        public function getByUserId($user_id) {
            return $this->dao->getByUserId($user_id);
        }
        public function getCompletedGoalsByUserId($user_id) {
            return $this->dao->getCompletedGoalsByUserId($user_id);
        }
        public function getByType($user_id, $goal_type) {
            return $this->dao->getByType($user_id, $goal_type);
        }
    }
?>