<?php

namespace App\Console\Commands;

use App\Objects\StubaUser;
use Illuminate\Console\Command;

class GetStubaUserData extends Command
{

    protected $signature = 'stuba:user {username}';

    protected $description = 'Gets user information from is.stuba.sk';


    public function __construct()
    {
        parent::__construct();
    }


    public function handle(StubaUser $user)
    {
        $user->initialize($this->argument('username'));

        if ($user->isValid()) {
            $this->comment(d($user));
        } else {
            $this->error('Stuba can not be reached or user does not exist.');
        }
    }
}
