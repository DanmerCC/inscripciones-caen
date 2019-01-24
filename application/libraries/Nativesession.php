<?php 

if ( ! defined('BASEPATH') )
    exit( 'No direct script access allowed' );

class Nativesession
{
    public function __construct()
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
    public function destroy(){

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    public function all(){
        return $_SESSION;
    }


    public function reset(){
        $_SESSION = array();
        session_destroy();
        session_start();
    }
}