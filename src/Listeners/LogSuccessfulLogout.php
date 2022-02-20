<?php

namespace Malekk\LaravelAuthLog\Listeners;

use Illuminate\Auth\Events\Logout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Malekk\LaravelAuthLog\Models\AuthenticationLog;

class LogSuccessfulLogout
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
     * @param \Illuminate\Auth\Events\Logout $event
     * @return void
     */
    public function handle(Logout $event)
    {
        if($event->user)
        {
            $user              = $event->user;
            $ip                = $this->request->ip();
            $userAgent         = $this->request->userAgent();
            $authenticationLog = $user->authentications()->whereIpAddress($ip)->whereUserAgent($userAgent)->first();
            if(!$authenticationLog)
            {
                $authenticationLog = new AuthenticationLog([
                                                               'username'   => $user->email,
                                                               'ip_address' => $ip,
                                                               'user_agent' => $userAgent,
                                                               'is_success' => true,
                                                           ]);
            }

            $authenticationLog->logout_at = Carbon::now();

            $user->authentications()->save($authenticationLog);
        }
    }
}