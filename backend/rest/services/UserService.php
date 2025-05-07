<?php
    require_once 'BaseService.php';
    require_once '../dao/UserDao.php';

    // TODO unique email, DONE
    // role (user, premium [user is default]), DONE
    // gender (male, female, other), DONE
    // activity level ('No Exercise','Light Exercise','Moderate Exercise','Active','Very Active') DONE

    class UserService extends BaseService {
        public function __construct() {
            $dao = new UserDao();
            parent::__construct($dao);
        }

        public function createUser($data) {
            if (empty($data['name'])) {
                throw new Exception("Name is required.");
            }
            // imal mail
            if (empty($data['email'])) {
                throw new Exception('Email is required');
            }
            // validate email za svaki slucaj posto haj znadni sta se moze desiti u frontendu
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Invalid email.");
            }
            // provjera mail-a
            if ($this->dao->emailExists($data['email'])) {
                throw new Exception("Email already in use.");
            } 

            // hash password
            if (empty($data['password'])) {
                throw new Exception("Password is required.");
            }
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

            // ako nije unesen gender
            $data['gender'] = strtolower($data['gender'] ?? 'other');
            // provjera gender-a
            if (!in_array($data['gender'], ['male', 'female', 'other'])) {
                throw new Exception("Invalid gender, can only be 'male', 'female' or 'other'");
            }

            // ako niije unesen role
            $data['role'] = strtolower($data['role'] ?? 'user');
            // provjera role-a
            if (!in_array($data['role'], ['user', 'premium'])) {
                throw new Exception("Invalid role");
            }

            // provjera activity levela
            if (empty($data['activity_level'])) {
                throw new Exception("Activity level is required");
            }
            if (!in_array($data['activity_level'], ['No Exercise','Light Exercise','Moderate Exercise', 'Active', 'Very Active'])) {
                throw new Exception("Invalid activity level");
            }

            return $this->dao->insert($data);
        }

        public function getByEmail($email) {
            return $this->dao->getByEmail($email);
        }

        public function getByRole($role) {
            return $this->dao->getByRole($role);
        }
    }
?>