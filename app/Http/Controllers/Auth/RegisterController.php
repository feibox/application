<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\RegistrationConfirmation;
use App\User;
use Illuminate\Http\Request;
use Mail;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('pages.register');
    }

    public function register(Request $request, User $user)
    {
        $this->validator($request->all())->validate();
        $new_user = $user->create($request->all());
        Mail::to($new_user)->send(new RegistrationConfirmation($new_user));

        //$this->guard()->login($user);
        return redirect('/');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => 'required|stuba_email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    public function verifyUser(User $user, $token)
    {
        try {
            $user->whereRegistrationToken($token)->firstOrFail()->confirmEmail();
        } catch (ModelNotFoundException $e) {
            //TODO: or show meaningfull error page... user already verified etc..
            abort(404);
        }

        //TODO: flash to session success or login user
        //$this->guard()->login($user)
        return redirect('login');
    }
}
