<?php
    require_once 'UserService.php';

    class UserBusinessLogic {
        private $userService;

        public function __construct() {
            $this->userService = new UserService();
        }
// TODO unique email, 
// role (user, premium [user is default]), 
// gender (male, female, other), 
// activity level ('No Exercise','Light Exercise','Moderate Exercise','Active','Very Active')
        public function 
    }
?>