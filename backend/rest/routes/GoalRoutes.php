<?php
// get goal by ID
Flight::route('GET /goals/@id', function($id){
    Flight::json(Flight::goalService()->getById($id));
});

// get all goals for user
Flight::route('GET /users/@user_id/goals', function($user_id){
    Flight::json(Flight::goalService()->getByUserId($user_id));
});

// get completed goals for user
Flight::route('GET /users/@user_id/goals/completed', function($user_id){
    Flight::json(Flight::goalService()->getCompletedGoalsByUserId($user_id));
});

// get goals by type for user
Flight::route('GET /users/@user_id/goals/type/@type', function($user_id, $type){
    Flight::json(Flight::goalService()->getByType($user_id, $type));
});

// create new goal
Flight::route('POST /goals', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::goalService()->createGoal($data));
});

// update goal
Flight::route('PUT /goals/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::goalService()->update($id, $data));
});

// delete goal
Flight::route('DELETE /goals/@id', function($id){
    Flight::json(Flight::goalService()->delete($id));
});
?>