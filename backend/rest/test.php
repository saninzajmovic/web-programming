<?php
    require_once 'dao/UserDao.php';
    require_once 'dao/ExerciseDao.php';
    require_once 'dao/WorkoutSessionDao.php';
    require_once 'dao/SessionExerciseDao.php';
    require_once 'dao/NutritionDao.php';
    require_once 'dao/GoalDao.php';

    $userDao = new UserDao();
    $exerciseDao = new ExerciseDao();
    $workoutSessionDao = new WorkoutSessionDao();
    $sessionExerciseDao = new SessionExerciseDao();
    $nutritionDao = new NutritionDao();
    $goalDao = new GoalDao();


    // // insert new user
    // $userDao->insert([
    //     'name' => 'John Doe',
    //     'email' => 'john@example.com',
    //     'password' => password_hash('password123', PASSWORD_DEFAULT),
    //     'role' => 'user',
    //     'birth_date' => '1990-01-01',
    //     'gender' => 'male',  // (male, female, other)
    //     'height' => '179.3', // in cm
    //     'activity_level' => 'Light Exercise'
    // ]);

    // // insert exercise
    // $exerciseDao->insert([
    //     'name' => 'Bench Press',
    //     'description' => 'A classic upper body exercise.',
    //     'muscle_group' => 'Chest',
    //     'met_value' => 8.0
    // ]);

    // // insert workout session
    // $workoutSessionDao->insert([
    //     'user_id' => 1,
    //     'date' => date('Y-m-d H:i:s'), // Current date and time
    //     'notes' => 'amazing workout, should try that exercise again',
    //     'total_duration' => 35, // minutes
    // ]);

    // // insert session exercise
    // $sessionExerciseDao->insert([
    //     'session_id' => 1,
    //     'exercise_id' => 1,  
    //     'duration' => 5, // minutes
    //     'sets' => 3,
    //     'reps' => 8,
    //     'weight_used' => 80.0 // in kg
    // ]);

    // // insert nutrition
    // $nutritionDao->insert([
    //     'user_id' => 1,
    //     'date' => date('Y-m-d H:i:s'), // Current date and time
    //     'water_ml' => 2000,
    //     'calories_consumed' => 2500,
    //     'user_weight' => 73.2 // in kg
    // ]);

    // // insert goal
    // $goalDao->insert([
    //     'user_id' => 1,
    //     'goal_type' => 'weight', // ('weight', 'workout_frequency', 'daily_water', 'daily_calories')
    //     'target_value' => 70.0, // in kg
    //     'start_weight' => 85.7, // in kg
    //     'target_date' => '2025-12-31',
    // ]);



    // insert workout
    // $workoutDao->insert([
    //     'user_id' => 1,
    //     'date' => '2022-01-01',
    //     'total_calories' => 300,
    //     'notes' => 'great workout'
    // ]);

    // fetch all users
    $users = $userDao->getAll();
    print("all users");
    prettyPrint($users);
    $usersByEmail = $userDao->getByEmail('john@example.com');
    print("user by email");
    prettyPrint($usersByEmail);
    $usersByRole = $userDao->getByRole('user');
    print("users by role");
    prettyPrint($usersByRole);

    // fetch all exercises
    $exercises = $exerciseDao->getAll();
    print("all exercises");
    prettyPrint($exercises);
    $exercisesByMuscleGroup = $exerciseDao->getByMuscleGroup('Chest');
    print("exercises by muscle group");
    prettyPrint($exercisesByMuscleGroup);
    $searchNameOfExercise = $exerciseDao->searchByName('Bench');
    print("search name of exercise (Bench)");
    prettyPrint($searchNameOfExercise);

    // fetch all workout sessions
    $workoutSessions = $workoutSessionDao->getAll();
    print("all workout sessions");
    prettyPrint($workoutSessions);
    $workoutSessionsByUser = $workoutSessionDao->getByUserId(1);
    print("workout sessions by user");
    prettyPrint($workoutSessionsByUser);
    $workoutSessionsByDate = $workoutSessionDao->getByDateRange(1,'2025-04-03 16:12:30', '2025-04-07 16:12:30');
    print("workout sessions by date");
    prettyPrint($workoutSessionsByDate);

    // fetch all session exercises
    $sessionExercises = $sessionExerciseDao->getAll();
    print("all session exercises");
    prettyPrint($sessionExercises);
    $sessionExercisesBySession = $sessionExerciseDao->getBySessionId(1);
    print("session exercises by session");
    prettyPrint($sessionExercisesBySession);


    // fetch all nutrition
    $nutrition = $nutritionDao->getAll();
    print("all nutrition");
    prettyPrint($nutrition);
    $nutritionByUserAndDate = $nutritionDao->getByUserIdAndDate(1, '2025-04-06');
    print("nutrition by user and date");
    prettyPrint($nutritionByUserAndDate);
    $nutritionHistoryByUserId = $nutritionDao->getHistoryByUserId(1);
    print("nutrition history by user");
    prettyPrint($nutritionHistoryByUserId);
    $nutritionDailySummary = $nutritionDao->getDailySummary(1, '2025-04-06');
    print("nutrition daily summary");
    prettyPrint($nutritionDailySummary);
    $nutritionDetailedDailyEntries = $nutritionDao->getDetailedDailyEntries(1, '2025-04-06');
    print("nutrition detailed daily entries");
    prettyPrint($nutritionDetailedDailyEntries);

    // fetch all goals
    $goals = $goalDao->getAll();
    print("all goals");
    prettyPrint($goals);
    $goalByUserId = $goalDao->getByUserId(1);
    print("goal by user");
    prettyPrint($goalByUserId);
    $completedGoalByUserId = $goalDao->getCompletedGoalsByUserId(1);
    print("completed goals by user");
    prettyPrint($completedGoalByUserId);
    $goalByType = $goalDao->getByType(1, 'weight');
    print("goal by type");
    prettyPrint($goalByType);


    function prettyPrint($data) {
        echo '<pre>';
        if (is_array($data) || is_object($data)) {
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            echo $data;
        }
        echo '</pre>';
    }
?>