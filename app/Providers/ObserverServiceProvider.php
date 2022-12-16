<?php

namespace App\Providers;

use Xepare\ObservableProvider as ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{

    /**
     * The observer mappings for the application.
     *
     * @var array
     */
    protected array $observables = [
//        User::class => UserObserver::class,
    ];

}
