<?php

namespace Framework;

class Session
{

    /**
     * function use to start session
     *
     * @return void
     */
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * function use to set session
     * 
     * @param string $key
     * @param mixed $value
     * @return void
     */

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * 
     * function use to get session
     * 
     * @param String $key
     * @param mixed $default
     * @return mixed
     */

    public static function get($key, $default = null)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }

    /**
     * function use to check session exist
     *
     * @param String $key
     * @return boolean
     */
    public static function has($key)
    {
        return isset($_SESSION[$key]);
    }

    /**
     * function use to clear session
     * @param String key
     * @return void
     */

    public static function clear($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * function use to clear all session
     * @return void
     */

    public static function clearAll()
    {
        session_unset();
        session_destroy();
    }
}
