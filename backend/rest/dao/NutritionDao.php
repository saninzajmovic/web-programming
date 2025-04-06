<?php
    require_once 'BaseDao.php';

    class NutritionDao extends BaseDao {
        public function __construct() {
            parent::__construct("nutrition");
        }

        public function getByUserIdAndDate($user_id, $date) {
            $stmt = $this->connection->prepare("SELECT * FROM nutrition WHERE user_id = :user_id AND date = :date");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        // public function getHistoryByUserId($user_id, $limit = 7) {
        //     $stmt = this->connectoin->prepare("SELECT * FROM nutrition WHERE user_id = :user_id ORDER BY date DESC LIMIT :limit");
        //     $stmt->bindParam(':user_id', $user_id);
        //     $stmt->bindParam(':limit', $limit);
        //     $stmt->execute();
        //     return $stmt->fetchAll();
        // }

        public function getHistoryByUserId($user_id, $limit = 7) {
            $stmt = this->connectoin->prepare("SELECT
                                                    DATE(date) as log_date
                                                    SUM(water_ml) as total_water
                                                    SUM(calories_consumed) as total_calories
                                                    AVG(user_weight) as average_weight
                                                FROM nutrition
                                                WHERE user_id = :user_id 
                                                GROUP BY log_date
                                                ORDER BY log_date DESC
                                                LIMIT :limit");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':limit', $limit);
            $stmt->execute();
            return $stmt->fetchAll();
        }   

        public function getDailySummary($user_id, $date) { // to get for specific date all the stats (joj kako se napati oko ovog)
        //  it makes sure to take the latest weight even if it was only entered on a different date than provided in case there is no weight entries on that date
            $stmt = this->connection->prepare("SELECT 
                                                    SUM(water_ml) as total_water
                                                    SUM(calories_consumed) as toal_calories
                                                    COALESCE(
                                                        (SELECT user_weight FROM nutritoin WHERE user_id = :user_id AND DATE(date) = :date AND user_weight IS NOT NULL 
                                                        ORDER BY date DESC
                                                        LIMIT 1),
                                                        (SELECT user_weight FROM nutrition WHERE user_id = :user_id AND DATE(date) < :date AND user_weight IS NOT NULL
                                                        ORDER BY date DESC
                                                        LIMIT 1)
                                                    ) as latest_weight
                                                FROM nutrition
                                                WHERE user_id = :user_id
                                                AND DATE(date) = :date");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            return $stmt->fetch();
        }

        public function getDetailedDailyEntries($user_id, $date) { // to get chronological entries for the specific date
            $stmt = $this->connection->prepare("SELECT * FROM nutrition WHERE user_id = :user_id AND DATE(date) = :date ORDER BY date ASC");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            return $stmt->fetchAll();
        }
    }
?>