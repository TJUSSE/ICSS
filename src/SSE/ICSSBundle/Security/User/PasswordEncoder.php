<?php

namespace SSE\ICSSBundle\Security\User;

class PasswordEncoder
{
    /**
     * @param $password
     * @param $salt
     * @return string
     */
    public function encode($password, $salt)
    {
        return hash('sha256', $password . $salt);
    }
}