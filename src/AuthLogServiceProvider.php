<?php

namespace Malekk\LaravelAuthLog;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\ServiceProvider;
use Malekk\LaravelAuthLog\Listeners\LogFailureLogin;
use Malekk\LaravelAuthLog\Listeners\LogSuccessfulLogin;
use Malekk\LaravelAuthLog\Listeners\LogSuccessfulLogout;

class AuthLogServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerEvents();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }

    /**
     * Register the Authentication Log's events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);
        $events->listen(Login::class, LogSuccessfulLogin::class);
        $events->listen(Failed::class, LogFailureLogin::class);
        $events->listen(Logout::class, LogSuccessfulLogout::class);
    }
}
