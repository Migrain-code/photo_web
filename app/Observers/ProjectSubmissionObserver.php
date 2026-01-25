<?php

namespace App\Observers;

use App\Models\ProjectSubmission;
use App\Models\User;
use App\Notifications\ProjectSubmissionNotification;

class ProjectSubmissionObserver
{
    public function created(ProjectSubmission $submission): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $user->notify(new ProjectSubmissionNotification($submission));
        }
    }
}
