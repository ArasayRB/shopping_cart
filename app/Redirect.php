<?php
namespace app;

use config\ServiceSession;;
use app\models\{Session,SessionUser};

class Redirect
{
    static $path = "";
    static $these;
    static $goBack;

    private static function these()
    {
        if (!self::$these) {
            self::$these = new self();
        }
        return self::$these;
    }

    private static function redirect($path, $absoluta = false)
    {
        $verdaderaRuta = $absoluta ? $path : BASE_URL . $path;
        header("Location: " . $verdaderaRuta);
        exit;
    }

    public function do() {
        if (self::$goBack) {
            if (isset($_SERVER["HTTP_REFERER"])) {
                self::redirect($_SERVER["HTTP_REFERER"], true);
            } else {
                echo '<script type="text/javascript">history.go(-1)</script>';
                exit;
            }
        }
        self::redirect(self::$path);
    }

    public static function to($path)
    {
        self::$path = $path;
        return self::these();
    }

    public static function back()
    {
        self::$goBack = true;
        return self::these();
    }

    /**
    *Create session and sessiona data key
    *If session data is not save on data base
    * This method save it then
    */

    public static function with($datos)
    {
        ServiceSession::flash($datos);
        $session=new Session();
        $data_where=array('id'=>session_id());
        $data_fetch=$session->getBy($data_where);
        if(count($data_fetch)==0 || $data_fetch[0]['id']!=session_id()){
        $data_session=array('id'=>session_id(),'information'=>['name'=>$_SESSION['name'],'check'=>"true"],'last_access'=>time());
        $session->insert($data_session);
        $data_user_session=array('id_session'=>session_id(),'id_user'=>$_SESSION['name']);
        $session_user=new SessionUser();
        $session_user->insert($data_user_session);
        }
        return self::these();
    }
}
