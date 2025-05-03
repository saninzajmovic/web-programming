<?php
require_once '../services/GoalService.php';
require_once '../services/UserService.php';

try {
    // First create a test user
    $userService = new UserService();
    // $testUser = [
    //     'name' => 'Goal Test User',
    //     'email' => 'goaltest@example.com',
    //     'password' => 'testpass123',
    //     'gender' => 'male',
    //     'role' => 'user',
    //     'activity_level' => 'Moderate Exercise'
    // ];
    // $user = $userService->createUser($testUser);
    $userId = 5;

    $goalService = new GoalService();
    
    // Test creating a weight goal
    $weightGoal = [
        'user_id' => $userId,
        'goal_type' => 'weight',
        'target_value' => 75.5,
        'start_weight' => 80.0,
        'target_date' => '2023-12-31'
    ];
    $createdGoal = $goalService->createGoal($weightGoal);
    print_r($createdGoal);
    
    // Test getting goals by user ID
    $userGoals = $goalService->getByUserId($userId);
    print_r($userGoals);
    
    // Test getting goals by type
    $weightGoals = $goalService->getByType($userId, 'weight');
    print_r($weightGoals);
    
    // Test validation - invalid type
    try {
        $invalidGoals = $goalService->getByType($userId, 'invalid_type');
    } catch (Exception $e) {
        echo "Expected error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>