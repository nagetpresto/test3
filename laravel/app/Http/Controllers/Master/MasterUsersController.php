<?php

namespace App\Http\Controllers\Master;

use App\Services\Master\MasterUsersService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Master User",
 *     description="Master User related endpoints"
 * )
 */
class MasterUsersController extends Controller
{
    protected $masterUsersService;

    public function __construct(MasterUsersService $masterUsersService)
    {
        $this->masterUsersService = $masterUsersService;
    }

    /**
     * 
     * @OA\Put(
     *     path="/api/v1/update-profile",
     *     summary="Update User Profile",
     *     tags={"Master User"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "phone", "ktp", "dob"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="phone", type="string", example="1234567890"),
     *             @OA\Property(property="ktp", type="string", example="1234567890"),
     *             @OA\Property(property="dob", type="date", example="2024-05-28"),
     *             @OA\Property(property="address", type="string", example="street 1"),
     *             @OA\Property(property="postal_code", type="string", example="1098"),
     *             @OA\Property(property="city", type="string", example="Jakarta"),
     *             @OA\Property(property="country", type="string", example="Indonesia"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Update profile success"),
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
    public function updateUserProfile(Request $request)
    {
        $data = $request->only(['name', 'phone', 'ktp', 'dob', 'address', 'postal_code', 'city', 'country']);
        
        $result = $this->masterUsersService->updateUserProfile($data);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }

    /**
     * 
     * @OA\Post(
     *     path="/api/v1/update-password",
     *     summary="Update User Password",
     *     tags={"Master User"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"current_password", "new_password", "new_password_confirmation"},
     *             @OA\Property(property="current_password", type="string", example="current psw"),
     *             @OA\Property(property="new_password", type="string", example="new psw"),
     *             @OA\Property(property="new_password_confirmation", type="string", example="new psw vonfirm"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Success",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Update password success"),
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
    
    public function updatePassword(Request $request)
    {
        $data = $request->only(['current_password', 'new_password', 'new_password_confirmation']);
        
        $result = $this->masterUsersService->updatePassword($data);

        if (isset($result['error'])) {
            return response()->json($result, 400);
        }
        return response()->json($result, 200);
    }
}
