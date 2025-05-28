<?php
require 'vendor/autoload.php';

// services
require_once __DIR__ . '/services/AuthService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/ExerciseService.php';
require_once __DIR__ . '/services/GoalService.php';
require_once __DIR__ . '/services/NutritionService.php';
require_once __DIR__ . '/services/WorkoutSessionService.php';
require_once __DIR__ . '/services/SessionExerciseService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// middleware
require_once __DIR__ . 'middleware/AuthMiddleware.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

Flight::register('userService', 'UserService');
Flight::register('exerciseService', 'ExerciseService');
Flight::register('goalService', 'GoalService');
Flight::register('nutritionService', 'NutritionService');
Flight::register('workoutSessionService', 'WorkoutSessionService');
Flight::register('sessionExerciseService', 'SessionExerciseService');

Flight::register('auth_service', "AuthService");
Flight::register('auth_middleware', "AuthMiddleware");

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
            if(Flight::auth_middleware()->verifyToken($token))
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

require_once __DIR__ .'/routes/AuthRoutes.php';

Flight::start();
?>