<?php
    require_once 'BaseDao.php';

    class NutritionDao extends BaseDao {
        public function __construct() {
            parent::__construct("nutrition");
        }

        public function getByUserIdAndDate($user_id, $date) {
            $stmt = $this->connection->prepare("SELECT * FROM nutrition WHERE user_id = :user_id AND DATE(date) = :date");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':date', $date);
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getHistoryByUserId($user_id, $limit = 7) {
            $sql = "SELECT
                        DATE(date) as log_date,
                        SUM(water_ml) as total_water,
                        SUM(calories_consumed) as total_calories,
                        AVG(user_weight) as average_weight
                    FROM nutrition
                    WHERE user_id = :user_id 
                    GROUP BY log_date
                    ORDER BY log_date DESC
                    LIMIT :limit";
            
            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':limit', $limit, PDO::PARAM_INT); // wont work bez ovog param hepeka
            // debugging: uutput the SQL statement
            //echo $sql; // print the SQL statement
            $stmt->execute();
            return $stmt->fetchAll();
        }

        public function getDailySummary($user_id, $date) { // to get for specific date all the stats (joj kako se napati oko ovog)
            //  it makes sure to take the latest weight even if it was only entered on a different date than provided in case there is no weight entries on that date
            $sql = "SELECT 
                        SUM(water_ml) as total_water,
                        SUM(calories_consumed) as toal_calories,
                        COALESCE(
                            (SELECT user_weight FROM nutrition WHERE user_id = :user_id AND DATE(date) = :date AND user_weight IS NOT NULL 
                            ORDER BY date DESC
                            LIMIT 1),
                            (SELECT user_weight FROM nutrition WHERE user_id = :user_id AND DATE(date) < :date AND user_weight IS NOT NULL
                            ORDER BY date DESC
                            LIMIT 1)
                        ) as latest_weight
                    FROM nutrition
                    WHERE user_id = :user_id
                    AND DATE(date) = :date";
            $stmt = $this->connection->prepare($sql);
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

        public function getLatestWeight($userId) {
            $stmt = $this->connection->prepare(
                "SELECT user_weight FROM nutrition 
                 WHERE user_id = :user_id AND user_weight IS NOT NULL
                 ORDER BY date DESC LIMIT 1"
            );
            $stmt->bindParam(':user_id', $userId);
            $stmt->execute();
            return $stmt->fetchColumn();
        }
    }
?>