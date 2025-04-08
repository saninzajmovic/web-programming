<?php
    require_once 'BaseService.php';
    require_once 'SessionExerciseDao.php';

    class SessionExerciseService extends BaseService {
        public function __construct() {
            $dao = new SessionExerciseDao();
            parent::__construct($dao);
        }
        public function getBySessionId($session_id) {
            return $this->dao->getBySessionId($session_id);
        }
        public function deleteBySessionId($session_id) {
            return $this->dao->deleteBySessionId($session_id);
        }
    }
?>