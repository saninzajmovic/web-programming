<?php
// get nutrition entry by ID
Flight::route('GET /nutrition/@id', function($id){
    Flight::json(Flight::nutritionService()->getById($id));
});

// get nutrition entries for user on specific date
Flight::route('GET /users/@user_id/nutrition/date/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getByUserIdAndDate($user_id, $date));
});

// get nutrition history for user
Flight::route('GET /users/@user_id/nutrition/history', function($user_id){
    $limit = Flight::request()->query['limit'] ?? 7;
    Flight::json(Flight::nutritionService()->getHistoryByUserId($user_id, $limit));
});

// get daily summary for user
Flight::route('GET /users/@user_id/nutrition/summary/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getDailySummary($user_id, $date));
});

// get detailed daily entries for user
Flight::route('GET /users/@user_id/nutrition/details/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getDetailedDailyEntries($user_id, $date));
});

// create new nutrition entry
Flight::route('POST /nutrition', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::nutritionService()->createNutritionEntry($data));
});

// update nutrition entry
Flight::route('PUT /nutrition/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::nutritionService()->update($id, $data));
});

// delete nutrition entry
Flight::route('DELETE /nutrition/@id', function($id){
    Flight::json(Flight::nutritionService()->delete($id));
});
?>