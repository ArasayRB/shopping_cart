<?php
namespace config;

use app\controllers\Session_Controller;
use app\models\{Session,SessionUser};

class ServiceSession
{

  /**
  *Create session data
  */
    public static function flash($key, $value = null)
    {
        self::init();
        // If is an array of keys and values
        if (is_array($key) && $value === null) {
            foreach ($key as $k => $v) {
                $_SESSION[$k] = $v;
            }
        } else if ($value === null) {
            // if you want get a session var
            if (!isset($_SESSION[$key])) {
                return null;
            }
            $temporal = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $temporal;
        } else {
            // if you want stablish an array var
            $_SESSION[$key] = $value;
        }
    }

    //write or rewrite var in session
    public static function write($key, $data, $overwrite = false)
    {
        self::init();
        if (!isset($_SESSION[$key]) || $overwrite) {
            $_SESSION[$key] = $data;
        }

    }
    /**
     * Read a var saved on session.
     * Return the var content or nuell if no exist
     * @param $key
     * @return mixed|null
     */
    public static function read($key)
    {
        self::init();
        return $_SESSION[$key] ?? null;
    }
    private static function init()
    {
        if (!isset($_SESSION)) {
            session_set_save_handler(new Session_Controller(), true);
        }

        if (!self::startedSession()) {

          //Put limiter cache on 'private'
          session_cache_limiter('private');
          $cache_limiter = session_cache_limiter();

          // Put cache expire on 30 minutes
          session_cache_expire(30);
          $cache_expire = session_cache_expire();
            session_start();
        }
    }

    //Return true if session was start, false if not
    private static function startedSession()
    {
        return session_status() === PHP_SESSION_ACTIVE ? true : false;
    }

    //destroy user session
    public static function destroy()
    {
        self::init();
    		$session=new Session();
    		$session->deleteSessions($_SESSION['name']);
        session_destroy();
    }
}
