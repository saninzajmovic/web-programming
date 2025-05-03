<?php
// get session exercise by ID
Flight::route('GET /session-exercises/@id', function($id){
    Flight::json(Flight::sessionExerciseService()->getById($id));
});

// get exercises for session
Flight::route('GET /workout-sessions/@session_id/exercises', function($session_id){
    Flight::json(Flight::sessionExerciseService()->getBySessionId($session_id));
});

// create new session exercise
Flight::route('POST /session-exercises', function(){
    $data = Flight::request()->data->getData();
    $user_id = $data['user_id'] ?? null;
    if (!$user_id) {
        Flight::halt(400, 'User ID required');
    }
    Flight::json(Flight::sessionExerciseService()->createSessionExercise($data, $user_id));
});

// update session exercise
Flight::route('PUT /session-exercises/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::sessionExerciseService()->update($id, $data));
});

// delete session exercise
Flight::route('DELETE /session-exercises/@id', function($id){
    Flight::json(Flight::sessionExerciseService()->delete($id));
});

// delete all exercises for session
Flight::route('DELETE /workout-sessions/@session_id/exercises', function($session_id){
    Flight::json(Flight::sessionExerciseService()->deleteBySessionId($session_id));
});
?>