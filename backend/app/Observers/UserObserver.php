<?php

namespace App\Observers;

use App\Helpers\Model;
use App\Mail\SendWelcome;
use App\Models\{User, Payment, Category, Log};
use Illuminate\Support\Facades\Mail;

class UserObserver
{
    use Model;
    public function created(User $user)
    {
        if (config('app.events_enabled')) {
            Mail::queue(new SendWelcome($user));
        }
        Category::createUserCategory($user->id);
        Payment::createUserPayment($user->id);
        self::setData([
            'entity' => 'User',
            'new_values' => json_encode($user),
            'action' => 'create',
            'user_id' => $user->id,
        ],Log::class);
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
