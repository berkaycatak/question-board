<?php

namespace App\Http\Controllers\Api\Mobile\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\AuthLoginRequest;
use App\Http\Requests\Api\Auth\AuthRegisterRequest;
use App\Models\User;
use App\Models\UserDevices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(AuthLoginRequest $request)
    {
        $user = User::where("email", $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password))
        {
            return [
                "status" => 0,
                "errors" => "Kullanıcı adı veya şifre hatalı."
            ];
        }

        $token = $user->createToken("app_token")->plainTextToken;

        if ($request->has('playerId'))
        {
            $player_id = UserDevices::updateOrCreate(
                [
                    'player_id' => $request->playerId
                ],
                [
                    'user_id' => $user->id,
                    'player_id' => $request->playerId
                ]
            );
        }

        $response = [
            "status" => 1,
            "user" => $user,
            "token" => $token,
        ];

        return $response;
    }


    public function register(AuthRegisterRequest $request)
    {
        $user               = new User();
        $user->name         = $request->name;
        $user->email        = $request->email;
        $user->password     = bcrypt($request->password);
        $save               = $user->save();

        if ($save)
        {
            $token = $user->createToken("app_token")->plainTextToken;
            if($token)
            {
                $user = User::find($user->id);

                $response = [
                    "status" => 1,
                    "user" => $user,
                    "token" => $token,
                ];
            }
            else
            {
                return [
                    "status" => 0,
                    "errors" => "Kayıt işlemi sırasında hata oluştu",
                ];
            }
        }
        else
        {
            return [
                "status" => 0,
                "errors" => "Kayıt işlemi sırasında hata oluştu",
            ];
        }

        return $response;
    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        return [
            "status" => 1,
            "message" => "Başarıyla çıkış yapıldı",
        ];
    }

    public function loginCheck(Request $request)
    {
        $token = Auth::user()->createToken("app_token")->plainTextToken;
        $token_id = explode("|", $token)[0];
        Auth()->user()->tokens()->where("id", "!=", $token_id)->delete();

        if ($request->has('playerId'))
        {
            $player_id = UserDevices::updateOrCreate(
                [
                    'player_id' => $request->playerId
                ],
                [
                    'user_id' => Auth::user()->id,
                    'player_id' => $request->playerId
                ]
            );
        }

        $response = [
            "status" => 1,
            "user" => Auth()->user(),
            "token" => $token,
        ];

        return $response;
    }

}
