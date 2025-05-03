<?php
require_once '../services/ExerciseService.php';

try {
    $exerciseService = new ExerciseService();
    
    // Test creating a exercise
    $newExercise = [
        'name' => 'exercise service test 1',
        'description' => 'great for biceps',
        'muscle_group' => 'biceps',
        'met_value' => 3.5,
    ];
    
    $createdExercise = $exerciseService->createExercise($newExercise);
    print_r($createdExercise);
    
    // Test getting by email
    $exercise = $exerciseService->searchByName('exercise service test 1');
    print_r($exercise);
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>