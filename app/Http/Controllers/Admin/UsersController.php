<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SynchronizeUser;
use App\User;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;

class UsersController extends Controller
{

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $users = $this->user->sortable(['updated_at' => 'desc'])->paginate(10);
        return view('pages.users')->with(['users' => $users]);
    }

    public function synchronize($id)
    {
        //TODO: implement gate / policy here
        $user = $this->user->findOrFail($id);
        dispatch((new SynchronizeUser($user))->onQueue('stuba-synchronization'));
        Notification::info('Your request to synchronize user (' . e($user->email) . ') is pushed on queue.');
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
