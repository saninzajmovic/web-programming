<?php
// get exercise by ID
Flight::route('GET /exercises/@id', function($id){
    Flight::json(Flight::exerciseService()->getById($id));
});

// get exercises by muscle group
Flight::route('GET /exercises/muscle-group/@muscle_group', function($muscle_group){
    Flight::json(Flight::exerciseService()->getByMuscleGroup($muscle_group));
});

// search exercises by name
Flight::route('GET /exercises/search', function(){
    $searchTerm = Flight::request()->query['q'] ?? '';
    Flight::json(Flight::exerciseService()->searchByName($searchTerm));
});

// create new exercise
Flight::route('POST /exercises', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exerciseService()->createExercise($data));
});

// update exercise
Flight::route('PUT /exercises/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exerciseService()->update($id, $data));
});

// delete exercise
Flight::route('DELETE /exercises/@id', function($id){
    Flight::json(Flight::exerciseService()->delete($id));
});
?>