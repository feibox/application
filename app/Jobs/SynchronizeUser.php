<?php

namespace App\Jobs;

use App\Objects\StubaUser;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SynchronizeUser implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(StubaUser $stuba_user)
    {
        $user_name = explode('@', $this->user->email)[0];
        $stuba_user->initialize($user_name);

        if ($stuba_user->isConnectionSuccessful() && $stuba_user->isValid()) {
            $this->user->unguard();
            $this->user->update([
                'ais_id' => $stuba_user->getId(),
                'rank' => $stuba_user->getRank(),
                'study_level' => $stuba_user->getStudyLevel(),
                'user_name' => $user_name,
                'first_name' => $stuba_user->getFirstName(),
                'middle_name' => $stuba_user->getMiddleName(),
                'last_name' => $stuba_user->getLastName(),
                'title_prefix' => $stuba_user->getTitlePrefix(),
                'title_suffix' => $stuba_user->getTitleSuffix(),
                'study_information' => $stuba_user->getStudyInformation(),
                'is_valid' => true
            ]);
            $this->user->reguard();
        } elseif (!$stuba_user->isConnectionSuccessful()) {
            throw new \Exception('StubaUser is unable to connect to stuba.sk');
        } else {
            //terminated
            $this->user->is_terminated = true;
            $this->user->save();
        }
    }
}
