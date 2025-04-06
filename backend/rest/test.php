<?php
    require_once 'dao/UserDao.php';
    require_once 'dao/WorkoutDao.php';

    $userDao = new UserDao();
    $workoutDao = new WorkoutDao();

    // insert new user
    $userDao->insert([
        'name' => 'John Doe',
        'email' => 'john2@example.com',
        'password' => password_hash('password123', PASSWORD_DEFAULT),
        'role' => 'user',
        'current_weight' => 89.2
    ]);

    // insert workout
    $workoutDao->insert([
        'user_id' => 1,
        'date' => '2022-01-01',
        'total_calories' => 300,
        'notes' => 'great workout'
    ]);

    // fetch all users
    $users = $userDao->getAll();
    print_r($users);

    // fetch all workouts
    $workouts = $workoutDao->getAll();
    print_r($workouts);
?>