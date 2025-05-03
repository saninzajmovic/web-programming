<?php
// get workout session by ID
Flight::route('GET /workout-sessions/@id', function($id){
    Flight::json(Flight::workoutSessionService()->getById($id));
});

// get all workout sessions for user
Flight::route('GET /users/@user_id/workout-sessions', function($user_id){
    Flight::json(Flight::workoutSessionService()->getByUserId($user_id));
});

// get workout sessions by date range
Flight::route('GET /users/@user_id/workout-sessions/range', function($user_id){
    $start_date = Flight::request()->query['start'] ?? date('Y-m-01');
    $end_date = Flight::request()->query['end'] ?? date('Y-m-t');
    Flight::json(Flight::workoutSessionService()->getByDateRange($user_id, $start_date, $end_date));
});

// create new workout session
Flight::route('POST /workout-sessions', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::workoutSessionService()->createWorkoutSession($data));
});

// update workout session
Flight::route('PUT /workout-sessions/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::workoutSessionService()->update($id, $data));
});

// update session calories
Flight::route('PATCH /workout-sessions/@id/update-calories', function($id){
    Flight::json(Flight::workoutSessionService()->updateSessionCalories($id));
});

// delete workout session
Flight::route('DELETE /workout-sessions/@id', function($id){
    Flight::json(Flight::workoutSessionService()->delete($id));
});
?>