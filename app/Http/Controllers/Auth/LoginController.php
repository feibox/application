<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        if ($user->verified === false || $user->is_valid === false) {
            $message = 'Your account is not valid, please inform Feibox people.';

            if (!$user->verified) {
                $message = $this->resendVerificationMessage($request->get('email'));
            }

            $this->logout($request);

            return redirect()
                ->back()
                ->withInput($request->only($this->username(), 'remember'))
                ->withErrors([
                    'not_allowed' => $message,
                ]);
        }
    }

    private function resendVerificationMessage($email)
    {
        return 'Please check your email first and verify your account. Do you wish to resend verification email? 
                <a href="' . route('account.resend.verification.email', $email) . '">Yes, resend!</a>';
    }
}
