<?php
require 'vendor/autoload.php';

// Add this right at the top for CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authentication");

// services
require_once __DIR__ . '/rest/services/AuthService.php';
require_once __DIR__ . '/rest/services/UserService.php';
require_once __DIR__ . '/rest/services/ExerciseService.php';
require_once __DIR__ . '/rest/services/GoalService.php';
require_once __DIR__ . '/rest/services/NutritionService.php';
require_once __DIR__ . '/rest/services/WorkoutSessionService.php';
require_once __DIR__ . '/rest/services/SessionExerciseService.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// middleware
require_once __DIR__ . '/middleware/AuthMiddleware.php';

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


// routes
require_once __DIR__ . '/rest/routes/UserRoutes.php';
require_once __DIR__ . '/rest/routes/ExerciseRoutes.php';
require_once __DIR__ . '/rest/routes/GoalRoutes.php';
require_once __DIR__ . '/rest/routes/NutritionRoutes.php';
require_once __DIR__ . '/rest/routes/WorkoutSessionRoutes.php';
require_once __DIR__ . '/rest/routes/SessionExerciseRoutes.php';

require_once __DIR__ .'/rest/routes/AuthRoutes.php';

// This wildcard route intercepts all requests and applies authentication checks before proceeding.
// Flight::route('/*', function() {
//     if(
//         strpos(Flight::request()->url, '/auth/login') === 0 ||
//         strpos(Flight::request()->url, '/auth/register') === 0
//     ) {
//         return TRUE;
//     } else {
//         try {
//             $token = Flight::request()->getHeader("Authentication");
//             if(Flight::auth_middleware()->verifyToken($token))
//                 return TRUE;
//         } catch (\Exception $e) {
//             Flight::halt(401, $e->getMessage());
//         }
//     }
//  });
Flight::route('GET /', function(){
    Flight::json([
        'message' => 'FlightPHP API is running!',
        'timestamp' => date('Y-m-d H:i:s'),
        'endpoints' => [
            'POST /auth/login' => 'User login',
            'POST /auth/register' => 'User registration'
        ]
    ]);
});
Flight::route('/*', function() {
    $url = Flight::request()->url;
    $method = Flight::request()->method;
    
    // Debug logging
    error_log("Request URL: " . $url);
    error_log("Request Method: " . $method);
    
    // Allow root path and auth routes without authentication
    if(
        $url === '/' ||
        $url === '' ||
        strpos($url, '/auth/login') !== false ||
        strpos($url, '/auth/register') !== false ||
        strpos($url, '/test') !== false  // For testing
    ) {
        error_log("Public route detected, allowing through");
        return TRUE;
    } else {
        error_log("Protected route, checking auth");
        try {
            $token = Flight::request()->getHeader("Authentication");
            if(Flight::auth_middleware()->verifyToken($token)) {
                return TRUE;
            } else {
                Flight::halt(401, "Missing or invalid authentication token");
            }
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    }
});
 
 

// Debug: Show all registered routes
if (isset($_GET['debug'])) {
    echo "<pre>";
    echo "FlightPHP Routes Debug:\n";
    echo "======================\n";
    
    // Get the router instance
    $router = Flight::router();
    
    // Use reflection to access the protected routes property
    $reflection = new ReflectionClass($router);
    $routesProperty = $reflection->getProperty('routes');
    $routesProperty->setAccessible(true);
    $routes = $routesProperty->getValue($router);
    
    foreach ($routes as $route) {
        echo sprintf("%-8s %s\n", $route->methods[0] ?? 'GET', $route->pattern);
    }
    echo "</pre>";
    exit;
}

Flight::start();
?>