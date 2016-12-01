<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\PasswordChangeRequest;
use Krucas\Notification\Facades\Notification;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.password');
    }

    public function update(PasswordChangeRequest $request)
    {
        $user = $request->user();
        $user->password = $request->input('new_password');
        $user->save();
        Notification::success('Password to the application has been changed.');

        return redirect()->route('account.password.edit');
    }
}
