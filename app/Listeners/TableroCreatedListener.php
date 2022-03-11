<?php

namespace App\Listeners;

use App\Events\TableroCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class TableroCreatedListener
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
     * @param  TableroCreatedEvent  $event
     * @return void
     */
    public function handle(TableroCreatedEvent $event)
    {
        //
    }
}
