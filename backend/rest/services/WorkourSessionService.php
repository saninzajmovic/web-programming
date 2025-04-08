<?php
    require_once 'BaseService.php';
    require_once 'WorkoutSessionDao.php';

    class WorkoutSessionService extends BaseService {
        public function __construct() {
            $dao = new WorkoutSessionService();
            parent::__construct($dao);
        }
        public function  getByUserId($user_id) {
            $result = $this->dao->getByUserId($user_id);
        }
        public function getByDateRange($user_id, $start_date, $end_date) {
            return $this->dao->getByDateRange($user_id, $start_date, $end_date);
        }
    }
?>