<?php
require 'vendor/autoload.php';
require 'rest/services/AuthService.php';
require 'rest/services/RestaurantService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// services
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/ExerciseService.php';
require_once __DIR__ . '/services/GoalService.php';
require_once __DIR__ . '/services/NutritionService.php';
require_once __DIR__ . '/services/WorkoutSessionService.php';
require_once __DIR__ . '/services/SessionExerciseService.php';

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

Flight::register('userService', 'UserService');
Flight::register('exerciseService', 'ExerciseService');
Flight::register('goalService', 'GoalService');
Flight::register('nutritionService', 'NutritionService');
Flight::register('workoutSessionService', 'WorkoutSessionService');
Flight::register('sessionExerciseService', 'SessionExerciseService');

Flight::register('auth_service', "AuthService");

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
Flight::route('/*', function() {
    if(
        strpos(Flight::request()->url, '/auth/login') === 0 ||
        strpos(Flight::request()->url, '/auth/register') === 0
    ) {
        return TRUE;
    } else {
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(!$token)
                Flight::halt(401, "Missing authentication header");
 
 
            $decoded_token = JWT::decode($token, new Key(Config::JWT_SECRET(), 'HS256'));
 
 
            Flight::set('user', $decoded_token->user);
            Flight::set('jwt_token', $token);
            return TRUE;
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
 });
 

// routes
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/ExerciseRoutes.php';
require_once __DIR__ . '/routes/GoalRoutes.php';
require_once __DIR__ . '/routes/NutritionRoutes.php';
require_once __DIR__ . '/routes/WorkoutSessionRoutes.php';
require_once __DIR__ . '/routes/SessionExerciseRoutes.php';

Flight::start();
?>