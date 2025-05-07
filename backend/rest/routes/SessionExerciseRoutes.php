<?php
/**
 * @OA\Get(
 *     path="/session-exercises/{id}",
 *     tags={"session-exercises"},
 *     summary="Get session exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Session exercise data"
 *     )
 * )
 */
Flight::route('GET /session-exercises/@id', function($id){
    Flight::json(Flight::sessionExerciseService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/workout-sessions/{session_id}/exercises",
 *     tags={"session-exercises"},
 *     summary="Get exercises for session",
 *     @OA\Parameter(
 *         name="session_id",
 *         in="path",
 *         required=true,
 *         description="Workout session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of exercises for the session"
 *     )
 * )
 */
Flight::route('GET /workout-sessions/@session_id/exercises', function($session_id){
    Flight::json(Flight::sessionExerciseService()->getBySessionId($session_id));
});

/**
 * @OA\Post(
 *     path="/session-exercises",
 *     tags={"session-exercises"},
 *     summary="Create new session exercise",
 *     @OA\RequestBody(
 *         description="Session exercise data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"session_id","exercise_id","duration","user_id"},
 *             @OA\Property(property="session_id", type="integer", example=1),
 *             @OA\Property(property="exercise_id", type="integer", example=1),
 *             @OA\Property(property="duration", type="integer", example=30),
 *             @OA\Property(property="sets", type="integer", example=3),
 *             @OA\Property(property="reps", type="integer", example=10),
 *             @OA\Property(property="weight_used", type="number", format="float", example=20.5),
 *             @OA\Property(property="calories_burned", type="integer", example=150),
 *             @OA\Property(property="user_id", type="integer", example=1)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created session exercise"
 *     )
 * )
 */
Flight::route('POST /session-exercises', function(){
    $data = Flight::request()->data->getData();
    $user_id = $data['user_id'] ?? null;
    if (!$user_id) {
        Flight::halt(400, 'User ID required');
    }
    Flight::json(Flight::sessionExerciseService()->createSessionExercise($data, $user_id));
});

/**
 * @OA\Put(
 *     path="/session-exercises/{id}",
 *     tags={"session-exercises"},
 *     summary="Update session exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Session exercise data to update",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="duration", type="integer", example=35),
 *             @OA\Property(property="sets", type="integer", example=4),
 *             @OA\Property(property="reps", type="integer", example=12),
 *             @OA\Property(property="weight_used", type="number", format="float", example=22.5),
 *             @OA\Property(property="calories_burned", type="integer", example=175)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated session exercise"
 *     )
 * )
 */
Flight::route('PUT /session-exercises/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::sessionExerciseService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/session-exercises/{id}",
 *     tags={"session-exercises"},
 *     summary="Delete session exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Session exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /session-exercises/@id', function($id){
    Flight::json(Flight::sessionExerciseService()->delete($id));
});

/**
 * @OA\Delete(
 *     path="/workout-sessions/{session_id}/exercises",
 *     tags={"session-exercises"},
 *     summary="Delete all exercises for session",
 *     @OA\Parameter(
 *         name="session_id",
 *         in="path",
 *         required=true,
 *         description="Workout session ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /workout-sessions/@session_id/exercises', function($session_id){
    Flight::json(Flight::sessionExerciseService()->deleteBySessionId($session_id));
});
?>