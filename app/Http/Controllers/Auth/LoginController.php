<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/';

    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function showLoginForm()
    {
        return view('auth.login');
    }

    protected function authenticated(Request $request, $user)
    {
        $this->request = $request;

        if ($user->is_terminated) {
            return $this->denyAccess('Your account has been terminated, most likely you are not member of STU anymore.');
        } elseif ($user->is_banned) {
            //TODO: add TOS term of service document
            return $this->denyAccess('Your account has been banned, most likely you violated <a href="#">TOS</a>.');
        } elseif (!$user->is_verified) {
            return $this->denyAccess($this->resendVerificationMessage());
        } elseif (!$user->is_valid) {
            return $this->denyAccess('Your account is not valid, please inform Feibox people.');
        } else {
            return null;
        }
    }

    private function denyAccess($message)
    {
        $this->logout($this->request);
        Notification::error($message);

        return redirect()->back()->withInput($this->request->only($this->username(), 'remember'));
    }

    private function resendVerificationMessage()
    {
        return 'Please check your email first and verify your account. Do you wish to resend verification email? 
                <a href="' . route('account.resend.verification.mail',
            $this->request->get('email')) . '">Yes, resend!</a>';
    }

    protected function credentials(Request $request)
    {
        if (!filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)) {
            $credentials = [
                $this->username() => $request->get($this->username()) . '@stuba.sk',
                'password' => $request->get('password')
            ];
            $request->replace($credentials);
        }
        
        return $request->only($this->username(), 'password');
    }
}
