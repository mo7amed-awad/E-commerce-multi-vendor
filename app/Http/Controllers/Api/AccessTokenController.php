<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;




class AccessTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255',
            'password' => 'required|string|min:6',
            'device_name' => 'string|max:255',
            'abilities' => 'nullable|array'
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            
            $device_name = $request->post('device_name', $request->userAgent());
            
            // Ensure $abilities is always an array
            $abilities = $request->post('abilities', ['*']); // Default to ['*'] for full access if not provided
            
            $token = $user->createToken($device_name, $abilities);

            return Response::json([
                'code' => 1,
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);

        }

        return Response::json([
            'code' => 0,
            'message' => 'Invalid credentials',
        ], 401);
    }
    public function destroy($token = null)
    {
        // Check if the user is authenticated
        $user = Auth::guard('sanctum')->user();
    
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    
        // Revoke the current access token if no specific token is provided
        if (null === $token) {
            $user->currentAccessToken()->delete();
            return response()->json(['message' => 'Token revoked'], 200);
        }
    
        // Revoke a specific token
        $personalAccessToken = PersonalAccessToken::findToken($token);
    
        if ($personalAccessToken && $user->id == $personalAccessToken->tokenable_id 
            && get_class($user) == $personalAccessToken->tokenable_type) {
            $personalAccessToken->delete();
            return response()->json(['message' => 'Token revoked'], 200);
        }
    
        return response()->json(['message' => 'Invalid token'], 404);
    }
}
