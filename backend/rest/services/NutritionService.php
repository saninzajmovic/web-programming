<?php
    require_once 'BaseService.php';
    require_once 'NutritionDao.php';

    class NutritionService extends BaseService {
        public function __construct() {
            $dao = new NutritionDao();
            parent::__construct($dao);
        }
        public function getByUserIdAndDate($user_id, $date) {
            return $this->dao->getByUserIdAndDate($user_id, $date);
        }
        public function getHistoryByUserId($user_id, $limit = 7) {
            return $this->dao->getHistoryByUserId($user_id, $limit);
        }
        public function getDailySummary($user_id, $date) {
            return $this->dao->getDailySummary($user_id, $date);
        }
        public function getDetailedDailyEntries($user_id, $date) {
            return $this->dao->getDetailedDailyEntries($user_id, $date);
        }
    }
?>