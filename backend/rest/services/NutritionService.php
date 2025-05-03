<?php
    require_once 'BaseService.php';
    require_once '../dao/NutritionDao.php';

    class NutritionService extends BaseService {
        public function __construct() {
            $dao = new NutritionDao();
            parent::__construct($dao);
        }

        public function getByUserIdAndDate($user_id, $date) {
            return $this->dao->getByUserIdAndDate($user_id, $date);
        }

        public function getHistoryByUserId($user_id, $limit = 7) {
            if ($limit <=0 || $limit > 50) {
                throw new Exception("Limit must be between 1 and 50.");
            }
            return $this->dao->getHistoryByUserId($user_id, $limit);
        }

        public function getDailySummary($user_id, $date) {
            return $this->dao->getDailySummary($user_id, $date);
        }

        public function getDetailedDailyEntries($user_id, $date) {
            return $this->dao->getDetailedDailyEntries($user_id, $date);
        }

        public function createNutritionEntry($data) {
            // validating data
            if (empty($data['user_id'])) {
                throw new Exception("User ID is required.");
            }

            // validating values to not be negative
            if (isset($data['water_ml']) && $data['water_ml'] < 0) {
                throw new Exception("Water intake cannot be negative.");
            }
            if (isset($data['calories_consumed']) && $data['calories_consumed'] < 0) {
                throw new Excpetion("Calories consumed cannot be negative.");
            }
            if (isset($data['user_weight'])) {
                if ($data['user_weight'] <= 20) {
                    throw new Excpetion("Weight is unrealistically low.");
                }
                if ($data['user_weight'] > 350) {
                    throw new Exception("Weight is unrealistically high.");
                }
            }

            // default date = now
            $data['date'] = $data['date'] ?? date('Y-m-d H:i:s');

            return $this->dao->insert($data);
        }
    }
?>