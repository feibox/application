<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SynchronizeUser;
use App\User;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;

class UsersController extends Controller
{
    public function index(User $user)
    {
        $users = $user->sortable(['updated_at' => 'desc'])->paginate(10);
        return view('pages.users')->with(['users' => $users]);
    }

    public function synchronize(User $user, $email)
    {
        //TODO: implement gate / policy here
        dispatch((new SynchronizeUser($user->findByEmail($email)))->onQueue('stuba-synchronization'));
        Notification::info('Your request to synchronize user (' . e($email) . ') is pushed on queue.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
