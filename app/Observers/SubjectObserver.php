<?php

namespace App\Observers;

use App\Folder;
use App\Subject;

class SubjectObserver
{
    /**
     * @var Folder
     */
    private $folder;

    public function __construct(Folder $folder)
    {
        $this->folder = $folder;
    }

    /**
     * Listen to the User created event.
     *
     * @param Subject $subject
     *
     * @internal param Subject $subject
     */
    public function created(Subject $subject)
    {
        $this->folder->initialize($subject);
    }
}
