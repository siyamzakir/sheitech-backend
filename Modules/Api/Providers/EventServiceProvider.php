<?php

namespace Modules\Api\Providers;

use App\Models\Order\Order;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Api\Http\Events\OrderEvent;
use Modules\Api\Http\Listeners\OrderEventListener;
use Modules\Api\Http\Observers\OrderObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        OrderEvent::class => [
            OrderEventListener::class,
        ],
    ];

    protected $observers = [
        Order::class => [
            OrderObserver::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
