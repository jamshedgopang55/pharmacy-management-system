<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="/admin/register/",
     *      operationId="admin/register",
     *      tags={"Auth"},
     *      summary="register new admin",
     *      description="register new admin",
     *     @OA\RequestBody(
     *         description="Pet object that needs to be added to the store",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="name",
     *                     description="Updated name of the pet",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     description=" email of the pet",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description=" password of the pet",
     *                     type="string"
     *                 ),
     *                     required={"name", "email", "password"}
     *             )
     *           
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items()
     *          )     
     *      ),
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $validatedData = $validator->validated();

        $validatedData['password'] = bcrypt($validatedData['password']);

        $user = User::create($validatedData);

        $token = $user->createToken('API Token')->accessToken;

        return response([
            'status' => true,
            'user' => $user,
            'token' => $token
        ]);
    }


    /**
     * @OA\Post(
     *      path="/admin/login/",
     *      operationId="admin/login",
     *      tags={"Auth"},
     *      summary="login  admin",
     *      description="login  admin",
     *     @OA\RequestBody(
     *         description="login Admin",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="application/x-www-form-urlencoded",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="email",
     *                     description=" email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description=" password",
     *                     type="string"
     *                 ),
     *                     required={"email", "password"}
     *             )
     *           
     *         )
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",    
     *           @OA\JsonContent(
     *              type="array",
     *              @OA\Items()
     *          )     
     *      ),
     * )
     */

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $data = $validator->validated();

        if (!auth()->attempt($data)) {
            return response()->json([
                'status' => false,
                'error' => 'Invlaid email or password'
            ]);
        }

        $token = User::find(auth()->user()->id)->createToken('API Token')->accessToken;
        return response()->json([
            'status' => true,
            'user' => auth()->user(),
            'token' =>  $token
        ]);
    }
}
