<?php
/**
 * @OA\Get(
 *     path="/exercises/{id}",
 *     tags={"exercises"},
 *     summary="Get exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Exercise data"
 *     )
 * )
 */
Flight::route('GET /exercises/@id', function($id){
    Flight::json(Flight::exerciseService()->getById($id));
});

/**
 * @OA\Get(
 *     path="/exercises/muscle-group/{muscle_group}",
 *     tags={"exercises"},
 *     summary="Get exercises by muscle group",
 *     @OA\Parameter(
 *         name="muscle_group",
 *         in="path",
 *         required=true,
 *         description="Muscle group name",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of exercises for specified muscle group"
 *     )
 * )
 */
Flight::route('GET /exercises/muscle-group/@muscle_group', function($muscle_group){
    Flight::json(Flight::exerciseService()->getByMuscleGroup($muscle_group));
});

/**
 * @OA\Get(
 *     path="/exercises/search",
 *     tags={"exercises"},
 *     summary="Search exercises by name",
 *     @OA\Parameter(
 *         name="q",
 *         in="query",
 *         required=true,
 *         description="Search term",
 *         @OA\Schema(type="string")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="List of matching exercises"
 *     )
 * )
 */
Flight::route('GET /exercises/search', function(){
    $searchTerm = Flight::request()->query['q'] ?? '';
    Flight::json(Flight::exerciseService()->searchByName($searchTerm));
});

/**
 * @OA\Post(
 *     path="/exercises",
 *     tags={"exercises"},
 *     summary="Create new exercise",
 *     @OA\RequestBody(
 *         description="Exercise data",
 *         required=true,
 *         @OA\JsonContent(
 *             required={"name","muscle_group","met_value"},
 *             @OA\Property(property="name", type="string", example="Push-ups"),
 *             @OA\Property(property="description", type="string", example="Basic bodyweight exercise"),
 *             @OA\Property(property="muscle_group", type="string", example="Chest"),
 *             @OA\Property(property="met_value", type="number", format="float", example=3.8)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Created exercise data"
 *     )
 * )
 */
Flight::route('POST /exercises', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exerciseService()->createExercise($data));
});

/**
 * @OA\Put(
 *     path="/exercises/{id}",
 *     tags={"exercises"},
 *     summary="Update exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\RequestBody(
 *         description="Exercise data to update",
 *         required=true,
 *         @OA\JsonContent(
 *             @OA\Property(property="name", type="string", example="Updated Push-ups"),
 *             @OA\Property(property="description", type="string", example="Updated description"),
 *             @OA\Property(property="muscle_group", type="string", example="Chest and Triceps"),
 *             @OA\Property(property="met_value", type="number", format="float", example=4.0)
 *         )
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Updated exercise data"
 *     )
 * )
 */
Flight::route('PUT /exercises/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::exerciseService()->update($id, $data));
});

/**
 * @OA\Delete(
 *     path="/exercises/{id}",
 *     tags={"exercises"},
 *     summary="Delete exercise by ID",
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="Exercise ID",
 *         @OA\Schema(type="integer")
 *     ),
 *     @OA\Response(
 *         response=200,
 *         description="Delete confirmation"
 *     )
 * )
 */
Flight::route('DELETE /exercises/@id', function($id){
    Flight::json(Flight::exerciseService()->delete($id));
});
?>