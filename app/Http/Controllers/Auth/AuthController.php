<?php namespace App\Http\Controllers\Auth;
use Auth;
use JWTAuth;
use JWTFactory;
use App\Models\User;
// use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\AuthRegisterRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function register(AuthRegisterRequest $request)
    {
        $user = new User;
        $user->username = $request->get('username');
        $user->password = Hash::make($request->get('password'));
        $user->save();
        return response([
            'status' => 'success',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        // if ( ! $token = Auth::guard($this->getGuard())->attempt($credentials)) {
        if ( ! $token = JWTAuth::attempt($credentials)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 400);
        }
        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
    }
    public function impersonate(Request $request)
    {
        $user = User::find($request->get('id'));
        if ( ! $token = JWTAuth::fromUser($user)) {
            return response([
                'status' => 'error',
                'error' => 'invalid.credentials',
                'msg' => 'Invalid Credentials.'
            ], 404);
        }
        return response([
            'status' => 'success'
        ])
        ->header('Authorization', $token);
    }
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response([
            'status' => 'success',
            'data' => $user
        ]);
    }
    public function logout()
    {
        // JWTAuth::invalidate();
        return response([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    public function refresh()
    {
        return response([
            'status' => 'success'
        ]);
    }

}
