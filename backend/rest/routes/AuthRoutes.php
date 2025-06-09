<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Flight::group('/auth', function() {
   /**
    * @OA\Post(
    *     path="/auth/register",
    *     summary="Register new user.",
    *     description="Add a new user to the database.",
    *     tags={"auth"},
    *     security={
    *         {"ApiKey": {}}
    *     },
    *     @OA\RequestBody(
    *         description="Add new user",
    *         required=true,
    *         @OA\MediaType(
    *             mediaType="application/json",
    *             @OA\Schema(
    *                 required={"password", "email"},
    *                 @OA\Property(
    *                     property="password",
    *                     type="string",
    *                     example="some_password",
    *                     description="User password"
    *                 ),
    *                 @OA\Property(
    *                     property="email",
    *                     type="string",
    *                     example="demo@gmail.com",
    *                     description="User email"
    *                 )
    *             )
    *         )
    *     ),
    *     @OA\Response(
    *         response=200,
    *         description="User has been added."
    *     ),
    *     @OA\Response(
    *         response=500,
    *         description="Internal server error."
    *     )
    * )
    */
Flight::route("POST /auth/register", function () {
    try {
        $data = Flight::request()->data->getData();
        
        $response = Flight::auth_service()->register($data);
        
        if ($response['success']) {
            Flight::json([
                'message' => 'User registered successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    } catch (Exception $e) {
        Flight::halt(500, "Registration error: " . $e->getMessage());
    }
});
   /**
    * @OA\Post(
    *      path="/auth/login",
    *      tags={"auth"},
    *      summary="Login to system using email and password",
    *      @OA\Response(
    *           response=200,
    *           description="Student data and JWT"
    *      ),
    *      @OA\RequestBody(
    *          description="Credentials",
    *          @OA\JsonContent(
    *              required={"email","password"},
    *              @OA\Property(property="email", type="string", example="demo@gmail.com", description="Student email address"),
    *              @OA\Property(property="password", type="string", example="some_password", description="Student password")
    *          )
    *      )
    * )
    */
//    Flight::route('POST /auth/login', function() {
//        $data = Flight::request()->data->getData();


//        $response = Flight::auth_service()->login($data);
  
//        if ($response['success']) {
//            Flight::json([
//                'message' => 'User logged in successfully',
//                'data' => $response['data']
//            ]);
//        } else {
//            Flight::halt(500, $response['error']);
//        }
//    });


// Flight::route('POST /auth/login', function() {
//     try {
//         error_log("=== LOGIN ROUTE HIT ===");
        
//         // Debug: Check if we can get the request data
//         $rawInput = Flight::request()->getBody();
//         error_log("Raw input: " . $rawInput);
        
//         $data = Flight::request()->data->getData();
//         error_log("Parsed data: " . print_r($data, true));
        
//         // Check if auth service exists
//         if (!Flight::has('auth_service')) {
//             error_log("Auth service not registered!");
//             Flight::halt(500, "Auth service not available");
//         }
        
//         error_log("Calling auth service login...");
//         $response = Flight::auth_service()->login($data);
//         error_log("Auth service response: " . print_r($response, true));
        
//         if ($response['success']) {
//             Flight::json([
//                 'message' => 'User logged in successfully',
//                 'data' => $response['data']
//             ]);
//         } else {
//             error_log("Login failed: " . $response['error']);
//             Flight::halt(500, $response['error']);
//         }
//     } catch (Exception $e) {
//         error_log("Login exception: " . $e->getMessage());
//         error_log("Stack trace: " . $e->getTraceAsString());
//         Flight::halt(500, "Login error: " . $e->getMessage());
//     }
// });

// Flight::route('POST /auth/login', function() {
//     Flight::json(['message' => 'Login route is working', 'received_data' => Flight::request()->data->getData()]);
// });

Flight::route('POST /auth/login', function() {
    try {
        $data = Flight::request()->data->getData();
        $response = Flight::auth_service()->login($data);
        
        if ($response['success']) {
            Flight::json([
                'message' => 'User logged in successfully',
                'data' => $response['data']
            ]);
        } else {
            Flight::halt(500, $response['error']);
        }
    } catch (Exception $e) {
        Flight::halt(500, "Login error: " . $e->getMessage());
    }
});


// });
?>