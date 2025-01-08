<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *     title="Laravel API",
 *     version="1.0.0",
 *     description="API for handling authentication, tranaction, etc.",
 * )
 * 
 * * @OA\SecurityScheme(
 *     securityScheme="sanctum",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization",
 *     description="Sanctum Token"
 * )
 */

abstract class Controller
{
    //
}
