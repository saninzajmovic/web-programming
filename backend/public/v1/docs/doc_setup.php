<?php

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="API",
 *   description="Fitness Tracker (Trackify) API",
 *   
 *   @OA\Contact(
 *     email="web2001programming@gmail.com",
 *     name="Trackify"
 *   )
 * ),
 * @OA\Server(
 *     url=LOCALSERVER,
 *     description="API server"
 * ),
 * @OA\Server(
 *     url=PRODSERVER,
 *     description="API server"
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="ApiKey",
 *     type="apiKey",
 *     in="header",
 *     name="Authentication"
 * )
 */
