<?php

namespace Malekk\LaravelAuthLog\Models;

trait AuthenticationLogable
{
    /**
     * Get the entity's authentications.
     */
    public function authentications()
    {
        return $this->hasMany(AuthenticationLog::class)->latest('login_at');
    }

    /**
     * Get the entity's last login at.
     */
    public function lastLoginAt()
    {
        return optional($this->authentications()->first())->login_at;
    }

    /**
     * Get the entity's last login ip address.
     */
    public function lastLoginIp()
    {
        return optional($this->authentications()->first())->ip_address;
    }
}
