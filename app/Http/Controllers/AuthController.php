<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Aktivitas;
use DateTimeZone;
use DateTime;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register()
    {
        $validator = Validator::make(request()->all(), [
            'name' => 'required',
            'position' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        $user = User::create([
            'name' => request('name'),
            'position' => request('position'),
            'email' => request('email'),
            'password' => bcrypt(request('password')),
        ]);

        if ($user) {
            return response()->json(['message' => 'Registration successful'], 201);
        } else {
            return response()->json(['message' => 'Registration failed'], 500);
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = User::where('email', request('email'))->first();

        // Menambahkan keterangan khusus langsung ke token yang dihasilkan
        $customClaims = [
            'id' => $user->id,
            'name' => $user->name,
            'level' => $user->level,
        ];

        $tokenWithClaims = JWTAuth::claims($customClaims)->fromUser($user);

        Aktivitas::create([
            'name' => $user->name,
            'description' => 'Login',
        ]);
        return $this->respondWithToken($tokenWithClaims, $user);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'sub' => $user->id,
            'name' => $user->name,
            'level' => $user->level,
            'iat' => now()->timestamp,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function listPengguna()
    {
        try {
            $result = User::get();
            return response()->json(
                [
                    'message' => 'data pengguna ditemukan',
                    'data' => $result
                ],
                200
            );
        } catch (\Exception  $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'data' => null
            ], 401);
        }
    }

    public function listManager()
    {
        try {
            $result = User::where('level', '1')->select('id', 'name')->get();
            return response()->json(
                [
                    'id' => '1',
                    'data' => $result
                ],
                200
            );
        } catch (\Exception  $e) {
            return response()->json([
                'id' => '0',
                'data' => $e->getMessage()
            ], 401);
        }
    }
    

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found',
                'data' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 400);
        }

        // Handle the image upload
        if ($request->hasFile('image')) {
            // Check if user already has an image
            if ($user->image) {
                // Delete the old image from storage
                Storage::delete('public/profiles/' . $user->image);
            }

            // Store the new image
            $image = $request->file('image');
            $imagePath = $image->store('public/profiles');
            $imageName = basename($imagePath);
            $user->image = $imageName;
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->position = $request->input('position');
        $user->save();

        return response()->json([
            'message' => 'success',
            'data' => $user
        ], 200);
    }

    

    public function delete($id)
    {
        $data = User::find($id);
        if ($data) {
            $data->delete();
            return response()->json([
                'message' => 'success',

            ], 200);
        }
        return response()->json([
            'message' => 'data not found'
        ], 404);
    }

    public function listAktivitas()
    {
        try {
            $result = Aktivitas::get();
            return response()->json(
                [
                    'id' => '1',
                    'data' => $result
                ],
                200
            );
        } catch (\Exception  $e) {
            return response()->json([
                'id' => '0',
                'data' => null
            ], 401);
        }
    }
}
