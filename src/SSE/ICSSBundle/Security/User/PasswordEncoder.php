<?php
/**
 * This file is part of openvj project.
 *
 * Copyright 2013-2015 openvj dev team.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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