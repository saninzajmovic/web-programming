<?php
require_once '../services/WorkoutSessionService.php';
require_once '../services/UserService.php';

try {
    // First create a test user
    $userService = new UserService();
    // $testUser = [
    //     'name' => 'Workout Test User',
    //     'email' => 'workouttest@example.com',
    //     'password' => 'testpass123',
    //     'gender' => 'female',
    //     'role' => 'user',
    //     'activity_level' => 'Moderate Exercise'
    // ];
    // $user = $userService->createUser($testUser);
    $userId = 8;

    $sessionService = new WorkoutSessionService();
    
    // Test creating a workout session
    $session = [
        'user_id' => $userId,
        'date' => date('Y-m-d H:i:s'),
        'notes' => 'Test session'
    ];
    $createdSession = $sessionService->createWorkoutSession($session);
    print_r($createdSession);
    
    // Test getting sessions by user ID
    $userSessions = $sessionService->getByUserId($userId);
    print_r($userSessions);
    
    // Test getting by date range
    $startDate = date('Y-m-01');
    $endDate = date('Y-m-t');
    $rangeSessions = $sessionService->getByDateRange($userId, $startDate, $endDate);
    print_r($rangeSessions);
    
    // Test validation - invalid date range
    try {
        $invalidRange = $sessionService->getByDateRange($userId, $endDate, $startDate);
    } catch (Exception $e) {
        echo "Expected error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>