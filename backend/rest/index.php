<?php
require 'vendor/autoload.php';

// Register services
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/ExerciseService.php';
require_once __DIR__ . '/services/GoalService.php';
require_once __DIR__ . '/services/NutritionService.php';
require_once __DIR__ . '/services/WorkoutSessionService.php';
require_once __DIR__ . '/services/SessionExerciseService.php';

Flight::register('userService', 'UserService');
Flight::register('exerciseService', 'ExerciseService');
Flight::register('goalService', 'GoalService');
Flight::register('nutritionService', 'NutritionService');
Flight::register('workoutSessionService', 'WorkoutSessionService');
Flight::register('sessionExerciseService', 'SessionExerciseService');

// Include routes
require_once __DIR__ . '/routes/UserRoutes.php';
require_once __DIR__ . '/routes/ExerciseRoutes.php';
require_once __DIR__ . '/routes/GoalRoutes.php';
require_once __DIR__ . '/routes/NutritionRoutes.php';
require_once __DIR__ . '/routes/WorkoutSessionRoutes.php';
require_once __DIR__ . '/routes/SessionExerciseRoutes.php';

// Add error handling
Flight::map('notFound', function(){
    Flight::json(['message' => 'Endpoint not found'], 404);
});

Flight::map('error', function(Exception $ex){
    Flight::json(['message' => $ex->getMessage()], 500);
});

Flight::start();
?>