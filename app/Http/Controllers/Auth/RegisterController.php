<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Mail\RegistrationConfirmation;
use App\Objects\StubaUser;
use App\User;
use Auth;
use Carbon\Carbon;
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

    public function register(RegisterRequest $request, StubaUser $stubaUser)
    {
        $credentials = $request->only(['email', 'password']);
        $user = $this->user->create($credentials);
        $this->validateUser($user, $stubaUser);
        $this->sendVerificationMail($user);

        return redirect('/');
    }

    private function validateUser(User $user, StubaUser $stubaUser)
    {
        $username = explode('@', $user->email)[0];
        $stubaUser->initialize($username);

        if ($stubaUser->isValid()) {
            $user->unguard();
            $user->update([
                'ais_id' => $stubaUser->getId(),
                'rank' => $stubaUser->getRank(),
                'study_level' => $stubaUser->getStudyLevel(),
                'user_name' => $username,
                'first_name' => $stubaUser->getFirstName(),
                'middle_name' => $stubaUser->getMiddleName(),
                'last_name' => $stubaUser->getLastName(),
                'title_prefix' => $stubaUser->getTitlePrefix(),
                'title_suffix' => $stubaUser->getTitleSuffix(),
                'study_information' => $stubaUser->getStudyInformation(),
                'is_valid' => true
            ]);
            $user->reguard();
        }
    }

    private function sendVerificationMail(User $user)
    {
        //TODO: inform user that email was sent + user needs to verify their account //display this message
        Mail::to($user->email)->send(new RegistrationConfirmation($user));
        return redirect('/')->with(['message' => 'Verification email was sent to ' . $user->email . '.']);
    }

    public function resendVerificationEmail($email)
    {
        $user = $this->user->findByEmail($email);

        if ($user->updated_at->diffInMinutes(Carbon::now()) > rand(5, 10)) {
            $user->touch();
            return redirect()
                ->back()
                ->withInput(['email' => $email])
                ->withErrors(['message' => 'System refuses to send verification email, please try later (5-10 minutes).']);
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
