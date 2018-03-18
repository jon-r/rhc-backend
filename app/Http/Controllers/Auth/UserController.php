<?php
namespace App\Http\Controllers\Auth;
use App\Models\User;
use Illuminate\Http\Request;
// use App\Http\Requests\UserAllRequest;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function all()
    {
        $users = User::orderBy('created_at', 'desc')->limit(50)->get();
        return response([
            'status' => 'success',
            'values' => [
                'items' => $users
            ]
        ]);
    }
}
