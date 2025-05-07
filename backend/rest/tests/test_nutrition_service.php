<?php
require_once '../services/NutritionService.php';
require_once '../services/UserService.php';

try {
    // First create a test user
    $userService = new UserService();
    // $testUser = [
    //     'name' => 'Nutrition Test User',
    //     'email' => 'nutritiontest@example.com',
    //     'password' => 'testpass123',
    //     'gender' => 'female',
    //     'role' => 'user',
    //     'activity_level' => 'Moderate Exercise'
    // ];
    // $userService->createUser($testUser);
    $userId = 6;

    $nutritionService = new NutritionService();
    
    // Test creating a nutrition entry
    $entry = [
        'user_id' => $userId,
        'water_ml' => 2000,
        'calories_consumed' => 1800,
        'user_weight' => 65.5
    ];
    $createdEntry = $nutritionService->createNutritionEntry($entry);
    print_r($createdEntry);
    
    // Test getting by user ID and date
    $today = date('Y-m-d');
    $entries = $nutritionService->getByUserIdAndDate($userId, $today);
    print_r($entries);
    
    // Test getting history
    $history = $nutritionService->getHistoryByUserId($userId, 3);
    print_r($history);
    
    // Test validation - negative values
    try {
        $invalidEntry = $nutritionService->createNutritionEntry([
            'user_id' => $userId,
            'water_ml' => -500
        ]);
    } catch (Exception $e) {
        echo "Expected error: " . $e->getMessage() . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>