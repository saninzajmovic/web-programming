<?php
/**
 * @OA\Get(
 *     path="/workout-sessions/{id}",
 *     tags={"workout-sessions"},
 *     summary="Get workout session by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Workout session data"
 *     )
 * )
 */
Flight::route('GET /workout-sessions/@id', function($id){
    Flight::json(Flight::workoutSessionService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/workout-sessions",
 *     tags={"workout-sessions"},
 *     summary="Get all workout sessions for user",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of user's workout sessions"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/workout-sessions', function($user_id){
    Flight::json(Flight::workoutSessionService()->getByUserId($user_id));
});

/**
 * @OA\Get(
 *     path="/users/{user_id}/workout-sessions/range",
 *     tags={"workout-sessions"},
 *     summary="Get workout sessions by date range",
 *     @OA\Parameter(
 *         name="user_id",
 *         in="path",
 *         required=true,
 *         description="User ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Parameter(
 *         name="start",
 *         in="query",
 *         required=false,
 *         description="Start date (YYYY-MM-DD)",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Parameter(
 *         name="end",
 *         in="query",
 *         required=false,
 *         description="End date (YYYY-MM-DD)",
 *         @OA\Schema(type="string", format="date")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of workout sessions in date range"
 *     )
 * )
 */
Flight::route('GET /users/@user_id/workout-sessions/range', function($user_id){
    $start_date = Flight::request()->query['start'] ?? date('Y-m-01');
    $end_date = Flight::request()->query['end'] ?? date('Y-m-t');
    Flight::json(Flight::workoutSessionService()->getByDateRange($user_id, $start_date, $end_date));
});

/**
 * @OA\Post(
 *     path="/workout-sessions",
 *     tags={"workout-sessions"},
 *     summary="Create new workout session",
 *     @OA\RequestBody(
 *         description="Session data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"user_id","date"},
 *             @OA\Property(property="user_id", type="integer", example=1),
 *             @OA\Property(property="date", type="string", format="date-time", example="2023-01-01 12:00:00"),
 *             @OA\Property(property="notes", type="string", example="Great workout!"),
 *             @OA\Property(property="total_duration", type="integer", example=60)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created workout session"
 *     )
 * )
 */
Flight::route('POST /workout-sessions', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::workoutSessionService()->createWorkoutSession($data));
});

/**
 * @OA\Put(
 *     path="/workout-sessions/{id}",
 *     tags={"workout-sessions"},
 *     summary="Update workout session by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Session data to update",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="date", type="string", format="date-time", example="2023-01-01 13:00:00"),
 *             @OA\Property(property="notes", type="string", example="Updated notes"),
 *             @OA\Property(property="total_duration", type="integer", example=75)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated workout session"
 *     )
 * )
 */
Flight::route('PUT /workout-sessions/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::workoutSessionService()->update($id, $data));
});

/**
 * @OA\Patch(
 *     path="/workout-sessions/{id}/update-calories",
 *     tags={"workout-sessions"},
 *     summary="Update session calories based on exercises",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated session with total calories"
 *     )
 * )
 */
Flight::route('PATCH /workout-sessions/@id/update-calories', function($id){
    Flight::json(Flight::workoutSessionService()->updateSessionCalories($id));
});

/**
 * @OA\Delete(
 *     path="/workout-sessions/{id}",
 *     tags={"workout-sessions"},
 *     summary="Delete workout session by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /workout-sessions/@id', function($id){
    Flight::json(Flight::workoutSessionService()->delete($id));
});
?>