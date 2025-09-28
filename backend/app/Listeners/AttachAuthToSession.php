<?php

namespace App\Listeners;


use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Session as SessionManager;
use App\Models\SessionModel;

class AttachAuthToSession
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        //

        $sessionId = SessionManager::getId();

        SessionModel::where('id', $sessionId)->update([
            'authenticatable_id'   => $event->user->id,
            'authenticatable_type' => get_class($event->user), 
        ]);
    }
}
