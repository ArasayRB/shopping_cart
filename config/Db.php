<?php
namespace config;

use config\Common;

class Db
{
  private static $instance=NULL;

  public function __construct()
  {

  }

  private function __clone(){}

  /**
  *Connect to data base
  */
  public static function getConnect(){
    $host=Common::env('HOST_MYSQL');
    $db_name=Common::env('NAME_BD_MYSQL');
    $username=Common::env('USER_MYSQL');
    $password=Common::env('PASS_MYSQL');
    if (!isset(self::$instance)) {
      $pdo_options[\PDO::ATTR_ERRMODE]=\PDO::ERRMODE_EXCEPTION;
      self::$instance= new \PDO("mysql:host={$host};dbname={$db_name}",$username,$password,$pdo_options);
      self::$instance->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
      self::$instance->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
      self::$instance->query("SET NAMES 'utf8'");
    }
    return self::$instance;
  }
}
