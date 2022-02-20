<?php

namespace Malekk\LaravelAuthLog\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Malekk\LaravelAuthLog\Models\AuthenticationLog;

class LogFailureLogin
{
    /**
     * The request.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create the event listener.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     *
     * @param \Illuminate\Auth\Events\Failed $event
     * @return void
     */
    public function handle(Failed $event)
    {
        $user              = $event->user;
        $email             = $this->request->email;
        $ip                = $this->request->ip();
        $userAgent         = $this->request->userAgent();
        $authenticationLog = AuthenticationLog::create([
                                                       'username'   => $email,
                                                       'user_id'   => $user ? $user->id : 0,
                                                       'ip_address' => $ip,
                                                       'user_agent' => $userAgent,
                                                       'is_success' => false,
                                                       'login_at'   => Carbon::now(),
                                                   ]);
    }
}
