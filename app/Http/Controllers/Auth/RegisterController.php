<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\SynchronizeUser;
use App\Mail\RegistrationConfirmation;
use App\User;
use Auth;
use Carbon\Carbon;
use Krucas\Notification\Facades\Notification;
use Mail;

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
        $credentials = $request->only(['email', 'password']);
        $user = $this->user->create($credentials);
        $this->synchronizeUser($user);
        $this->sendVerificationMail($user);

        return redirect('/');
    }

    private function synchronizeUser(User $user)
    {
        //TODO: implement gate / policy here
        dispatch((new SynchronizeUser($user))->onQueue('stuba-synchronization'));
    }

    private function sendVerificationMail(User $user)
    {
        Mail::to($user->email)->send(new RegistrationConfirmation($user));
        Notification::info('Verification email was sent to ' . $user->email . '.');
        return redirect()->back();
    }

    public function resendVerificationEmail($email)
    {
        $user = $this->user->findByEmail($email);

        if ($user->updated_at->diffInMinutes(Carbon::now()) > rand(5, 10)) {
            $user->touch();
            Notification::warning('System refuses to send verification email, please try later (5-10 minutes).');
            return redirect()->back()->withInput(['email' => $email]);
        }

        return $this->sendVerificationMail($user);
    }

    public function verifyUser($token)
    {
        $user = $this->user->verify($token);

        Auth::login($user, true);
        return redirect()->route('dashboard');
    }
}
