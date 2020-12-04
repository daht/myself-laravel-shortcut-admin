<?php

namespace App\Listeners;

use App\Events\AdminLogEvent;
use App\Models\AdminLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AdminLogListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(AdminLogEvent $event)
    {
        (new AdminLog())->newQuery()->create($event->param);
    }
}
