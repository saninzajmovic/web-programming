<?php
    require_once 'UserBusinessLogic.php';

    class UserControlloer {
        private $userBusinessLogic;

        public function __construct() {
            $this->userBusinessLogic = new UserBusinessLogic();
        }
        public function handleRequest() {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data = $_POST;
                try {
                    //! default create() need to make new with BLL 
                    $this->userBusinessLogic->create($data);
                    echo json_encode(['message' => 'User created successfuly.']);
                } catch (Exception $e) {
                    echo json_encode(['error' => e->getMessage()]);
                }
            }
            if ($_SERVER['REQUEST_METHOD' == 'GET']) {
                $email = $_GET['email'] ?? '';
                $user = $this->userBusinessLogic->getUserByEmail($email);
                echo json_encode($user);
            }
        }
    }
?>