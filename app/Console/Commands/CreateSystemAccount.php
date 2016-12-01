<?php

namespace App\Console\Commands;

use App\User;
use Illuminate\Console\Command;

class CreateSystemAccount extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stuba:system-account';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create system account.';

    /**
     * @var User
     */
    private $user;

    /**
     * Create a new command instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (!$this->user->exists('system')) {
            $this->user->create([
                'user_name' => 'system',
                'email' => 'system@feibox',
                'password' => 'system',
                'is_banned' => true,
                'is_terminated' => true,
            ]);
            $this->info('System user created.');
        } else {
            $this->info('System user already exists.');
        }
    }
}
