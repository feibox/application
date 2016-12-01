<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SendVerificationMail;
use App\Jobs\SynchronizeUser;
use App\User;
use Auth;
use Carbon\Carbon;
use Krucas\Notification\Facades\Notification;

class RegisterController extends Controller
{

    protected $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }


    public function showRegistrationForm()
    {
        return view('auth.register');
    }


    public function register(RegisterRequest $request)
    {
        $credentials = $request->only([ 'email', 'password' ]);
        $user = $this->user->create($credentials);
        $this->synchronizeUser($user);
        $this->sendVerificationMail($user);

        return redirect()->route('login', [ 'email' => $user->email ]);
    }


    private function synchronizeUser(User $user)
    {
        dispatch((new SynchronizeUser($user))->onQueue('stuba-synchronization'));
    }


    private function sendVerificationMail(User $user)
    {
        dispatch((new SendVerificationMail($user))->onQueue('email'));
        Notification::info('Verification email was sent to '.$user->email.'.');
    }


    public function resendVerificationMail($email)
    {
        $user = $this->user->findByEmail($email);

        //FIXME: see #4 on GH
        if ($user->updated_at->diffInMinutes(Carbon::now()) < rand(5, 10)) {
            $user->touch();
            Notification::warning('System refuses to send verification email, please try later (5-10 minutes).');

            return redirect()->back()->withInput([ 'email' => $email ]);
        }

        $this->sendVerificationMail($user);

        return redirect()->route('login', [ 'email' => $email ]);
    }


    public function verifyUser($token)
    {
        $user = $this->user->verify($token);

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
