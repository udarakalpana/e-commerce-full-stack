<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class UserSignInController extends Controller
{
    public function userSignIn(Request $request)
    {

        $user = User::where('email', $request['email'])->first();

        if (! $user) {
            return  response()->json([
                'status' => Response::HTTP_NOT_FOUND,
                'message' => Response::$statusTexts[Response::HTTP_NOT_FOUND],
            ]);
        }

        return response()->json([
            'user_first_name' => $user->first_name,
            'user_last_name' => $user->last_name,
        ]);
    }
}
