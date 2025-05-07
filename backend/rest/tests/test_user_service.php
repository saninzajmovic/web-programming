<?php
require_once '../services/UserService.php';

try {
    $userService = new UserService();
    
    // Test creating a user
    $newUser = [
        'name' => 'service tester 1',
        'email' => 'test@example.com',
        'password' => 'securepassword123',
        'gender' => 'male',
        'role' => 'user',
        'activity_level' => 'Moderate Exercise'
    ];
    
    $createdUser = $userService->createUser($newUser);
    print_r($createdUser);
    
    // Test getting by email
    $user = $userService->getByEmail('test@example.com');
    print_r($user);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>