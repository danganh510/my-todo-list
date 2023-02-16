<?php

class Session
{
    public static function init()
    {
        // Start the session if it's not already started
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        // Set a session variable
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        // Get a session variable
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }
    public static function delete($key)
    {
        // Get a session variable
        if (isset($_SESSION[$key])) {
           unset($_SESSION[$key]);
           return true;
        } else {
            return false;
        }
    }

    public static function destroy()
    {
        // Destroy the current session
        session_destroy();
    }

}
