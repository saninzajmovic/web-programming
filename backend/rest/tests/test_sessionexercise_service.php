<?php
require_once '../services/SessionExerciseService.php';
require_once '../services/WorkoutSessionService.php';
require_once '../services/UserService.php';
require_once '../services/NutritionService.php';

try {
    // First create test data
    $userService = new UserService();
    // $testUser = [
    //     'name' => 'Exercise Test User',
    //     'email' => 'exercisetest@example.com',
    //     'password' => 'testpass123',
    //     'gender' => 'male',
    //     'role' => 'user',
    //     'height' => 180,
    //     'activity_level' => 'Moderate Exercise'
    // ];
    // $user = $userService->createUser($testUser);
    $userId = 7;

    // Add weight data for calorie calculation
    $nutritionService = new NutritionService();
    $nutritionService->createNutritionEntry([
        'user_id' => $userId,
        'user_weight' => 75.0
    ]);

    // Create a workout session
    $sessionService = new WorkoutSessionService();
    $session = $sessionService->createWorkoutSession([
        'user_id' => $userId,
        'date' => date('Y-m-d H:i:s')
    ]);
    $sessionId = $session['id'];

    $exerciseService = new SessionExerciseService();
    
    // Test creating a session exercise (calories will be calculated)
    $exercise = [
        'session_id' => $sessionId,
        'exercise_id' => 1 // assuming ID 1 exists in exercises table
        // 'duration' => 30 // minutes
    ];
    $createdExercise = $exerciseService->createSessionExercise($exercise, $userId);
    print_r($createdExercise);
    
    // Test getting exercises by session ID
    $sessionExercises = $exerciseService->getBySessionId($sessionId);
    print_r($sessionExercises);
    
    // Test validation - missing required fields
    try {
        $invalidExercise = $exerciseService->createSessionExercise([
            'exercise_id' => 1
        ], $userId);
    } catch (Exception $e) {
        echo "Expected error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>