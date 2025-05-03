<?php
// get user by ID
Flight::route('GET /users/@id', function($id){
    Flight::json(Flight::userService()->getById($id));
});

// get user by email
Flight::route('GET /users/email/@email', function($email){
    Flight::json(Flight::userService()->getByEmail($email));
});

// get users by role
Flight::route('GET /users/role/@role', function($role){
    Flight::json(Flight::userService()->getByRole($role));
});

// create new user
Flight::route('POST /users', function(){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->createUser($data));
});

// update user
Flight::route('PUT /users/@id', function($id){
    $data = Flight::request()->data->getData();
    Flight::json(Flight::userService()->update($id, $data));
});

// delete user
Flight::route('DELETE /users/@id', function($id){
    Flight::json(Flight::userService()->delete($id));
});
?>