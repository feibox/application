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
            return $request;
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
                <a href="' . route('account.resend.verification.email',
            $this->request->get('email')) . '">Yes, resend!</a>';
    }
}
