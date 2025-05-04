<?php
/**
 * @OA\Get(
 *     path="/goals/{id}",
 *     tags={"goals"},
 *     summary="Get goal by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Goal ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Goal data"
 *     )
 * )
 */
Flight::route('GET /goals/@id', function($id){
    Flight::json(Flight::goalService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/goals",
 *     tags={"goals"},
 *     summary="Get all goals for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's goals"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/goals', function($user_id){
    Flight::json(Flight::goalService()->getByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/goals/completed",
 *     tags={"goals"},
 *     summary="Get completed goals for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's completed goals"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/goals/completed', function($user_id){
    Flight::json(Flight::goalService()->getCompletedGoalsByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/goals/type/{type}",
 *     tags={"goals"},
 *     summary="Get goals by type for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="type",
 *         in="path",
 *         required=true,
 *         description="Goal type (weight/workout_frequency/daily_water/daily_calories)",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's goals of specified type"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/goals/type/@type', function($user_id, $type){
    Flight::json(Flight::goalService()->getByType($user_id, $type));
});

/**
 * @OA\Post(
 *     path="/goals",
 *     tags={"goals"},
 *     summary="Create new goal",
 *     @OA\RequestBody(
 *         description="Goal data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id","goal_type","target_value"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="goal_type", type="string", example="weight"),
 *             @OA\Property(property="target_value", type="number", format="float", example=75.5),
 *             @OA\Property(property="start_weight", type="number", format="float", example=80.0),
 *             @OA\Property(property="target_date", type="string", format="date", example="2023-12-31"),
 *             @OA\Property(property="is_active", type="boolean", example=true)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created goal data"
 *     )
 * )
 */
Flight::route('POST /goals', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::goalService()->createGoal($data));
});

/**
 * @OA\Put(
 *     path="/goals/{id}",
 *     tags={"goals"},
 *     summary="Update goal by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Goal ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Goal data to update",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="goal_type", type="string", example="weight"),
 *             @OA\Property(property="target_value", type="number", format="float", example=70.0),
 *             @OA\Property(property="target_date", type="string", format="date", example="2023-12-31"),
 *             @OA\Property(property="is_active", type="boolean", example=false)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated goal data"
 *     )
 * )
 */
Flight::route('PUT /goals/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::goalService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/goals/{id}",
 *     tags={"goals"},
 *     summary="Delete goal by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Goal ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /goals/@id', function($id){
    Flight::json(Flight::goalService()->delete($id));
});
?>