<?php

namespace App\Observers;

use App\Helpers\HelperModel;
use App\Jobs\CreateCategoriesAfterCreatedNewUser;
use App\Jobs\CreatePaymentsAfterCreatedNewUser;
use App\Mail\SendWelcome;
use App\Models\{User};
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    use HelperModel;
    public function created(User $user)
    {
        if (config('app.events_enabled')) {
            Mail::queue(new SendWelcome($user));
        }
        CreateCategoriesAfterCreatedNewUser::dispatch($user);
        CreatePaymentsAfterCreatedNewUser::dispatch($user);
    }
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
