<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Authentication",
 *     description="User authentication related endpoints"
 * )
 */
class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @OA\Post(
     *     path="/api/v1/register",
     *     summary="User registration",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "email", "phone", "password", "password_confirmation"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="password", type="string", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Registration success. A verification email has been sent"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object", example={"user":{}}))
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="errMsg")
     *         )
     *     )
     * )
     */
    public function register(Request $request)
    {
        $data = $request->only(['name', 'phone', 'email', 'password', 'password_confirmation']);
        
        $result = $this->authService->register($data);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/email/verify/{id}/{hash}",
     *     summary="Verify user email",
     *     tags={"Authentication"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="hash",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="string", example="hash-example")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Email verified successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Invalid verification token.")
     *         )
     *     )
     * )
     */
    public function verify($id, $hash)
    {
        $result = $this->authService->verifyEmail($id, $hash);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/login",
     *     summary="User login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Login success"),
     *             @OA\Property(property="data", type="array", @OA\Items(type="object", example={"user":{}})),
     *             @OA\Property(property="token", type="string", example="token"),
     *             @OA\Property(property="expires", type="string", example="2 hours"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="errMsg")
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        $result = $this->authService->login($credentials);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/logout",
     *     summary="User logout",
     *     tags={"Authentication"},
     *     security={{"sanctum":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Logout success")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="errMsg")
     *         )
     *     )
     * )
     */
    public function logout(Request $request)
    {
        $result = $this->authService->logout();

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }
}
