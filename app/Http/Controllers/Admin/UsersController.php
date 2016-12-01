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
        $this->authorize($this->getUser());
        $users = $this->user->sortable([ 'updated_at' => 'desc' ])->paginate(10);

        return view('pages.users')->with([ 'users' => $users ]);
    }


    private function getUser($id = null)
    {
        return is_null($id) ? request()->user() : $this->user->findOrFail($id);
    }


    public function synchronize($id = null)
    {
        $user = $this->getUser($id);
        $this->authorize($user);

        dispatch((new SynchronizeUser($user))->onQueue('stuba-synchronization'));
        Notification::info('Your request to synchronize user ('.e($user->email).') is pushed on queue.');

        return redirect()->back();
    }


    public function ban($id)
    {
        $user = $this->user->findOrFail($id);
        $this->authorize($user);

        Notification::info('You gifted ban to '.$user->link($user->user_name).'!');
        $user->setIsBanned(true);

        return redirect()->back();
    }


    public function removeBan($id)
    {
        $user = $this->user->findOrFail($id);
        $this->authorize($user);

        Notification::info('Ban for account with username  "'.$user->link($user->user_name).'" was removed!');
        $user->setIsBanned(false);

        return redirect()->back();
    }


    public function detail($id = null)
    {
        $user = $this->getUser($id);
        $this->authorize($user);

        return view('pages.users-detail')->with('user_detail', $user);
    }


    public function edit($id)
    {
    }


    public function update(Request $request, $id)
    {
    }


    public function destroy($id)
    {
    }
}
