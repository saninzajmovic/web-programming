<?php
/**
 * @OA\Get(
 *     path="/nutrition/{id}",
 *     tags={"nutrition"},
 *     summary="Get nutrition entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Nutrition entry ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Nutrition entry data"
 *     )
 * )
 */
Flight::route('GET /nutrition/@id', function($id){
    Flight::json(Flight::nutritionService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/nutrition/date/{date}",
 *     tags={"nutrition"},
 *     summary="Get nutrition entries for user on specific date",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         description="Date in YYYY-MM-DD format",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of nutrition entries"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/nutrition/date/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getByUserIdAndDate($user_id, $date));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/nutrition/history",
 *     tags={"nutrition"},
 *     summary="Get nutrition history for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="limit",
 *         in="query",
 *         required=false,
 *         description="Number of entries to return (1-50)",
 *         @OA\Schema(type="integer", default=7)
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of nutrition entries"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/nutrition/history', function($user_id){
    $limit = Flight::request()->query['limit'] ?? 7;
    Flight::json(Flight::nutritionService()->getHistoryByUserId($user_id, $limit));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/nutrition/summary/{date}",
 *     tags={"nutrition"},
 *     summary="Get daily summary for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         description="Date in YYYY-MM-DD format",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Daily nutrition summary"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/nutrition/summary/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getDailySummary($user_id, $date));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/nutrition/details/{date}",
 *     tags={"nutrition"},
 *     summary="Get detailed daily entries for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="date",
 *         in="path",
 *         required=true,
 *         description="Date in YYYY-MM-DD format",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Detailed daily nutrition entries"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/nutrition/details/@date', function($user_id, $date){
    Flight::json(Flight::nutritionService()->getDetailedDailyEntries($user_id, $date));
});

/**
 * @OA\Post(
 *     path="/nutrition",
 *     tags={"nutrition"},
 *     summary="Create new nutrition entry",
 *     @OA\RequestBody(
 *         description="Nutrition data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="water_ml", type="integer", example=2000),
 *             @OA\Property(property="calories_consumed", type="integer", example=1800),
 *             @OA\Property(property="user_weight", type="number", format="float", example=65.5),
 *             @OA\Property(property="date", type="string", format="date-time", example="2023-01-01 12:00:00")
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created nutrition entry"
 *     )
 * )
 */
Flight::route('POST /nutrition', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::nutritionService()->createNutritionEntry($data));
});

/**
 * @OA\Put(
 *     path="/nutrition/{id}",
 *     tags={"nutrition"},
 *     summary="Update nutrition entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Nutrition entry ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Nutrition data to update",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="water_ml", type="integer", example=2500),
 *             @OA\Property(property="calories_consumed", type="integer", example=2000),
 *             @OA\Property(property="user_weight", type="number", format="float", example=64.0)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated nutrition entry"
 *     )
 * )
 */
Flight::route('PUT /nutrition/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::nutritionService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/nutrition/{id}",
 *     tags={"nutrition"},
 *     summary="Delete nutrition entry by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Nutrition entry ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /nutrition/@id', function($id){
    Flight::json(Flight::nutritionService()->delete($id));
});
?>