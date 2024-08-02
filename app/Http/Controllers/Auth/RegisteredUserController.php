<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Info;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'role' => ['required'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->input('first_name'),
            'email' => $request->email,
            'password' => Hash::make($request->string('password')),
        ]);

        event(new Registered($user));
        $infoUser=new Info();
        $infoUser->first_name=$request->input('first_name');
        $infoUser->last_name=$request->input('last_name');
        $infoUser->role_id=$request->input('role');
        $infoUser->user_id=$user->id;
        if ($request->input('role')===2) {
             $infoUser->tele=$request->input('tele');
            $infoUser->cin=$request->input('cin');
            $infoUser->city=$request->input('city');
            $infoUser->adresse=$request->input('adresse');
            $infoUser->country=$request->input('country');
        }
        $infoUser->save();

        Auth::login($user);
        $token=$request->user()->createToken('api-token');

        return response()->json(
            [
                'user'=>$user,
                'info'=>$infoUser,
                'token'=>$token->plainTextToken,
            ]
        );
    }
}
