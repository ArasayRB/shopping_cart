<?php
namespace core;

use core\BaseEntity;
use config\Db;

/*require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/carrito/autoloadCart.php');

//call
\carrito\autoloadCart::init();

ob_start();
session_start();

$error = ob_get_clean();*/

class ModelBase extends BaseEntity
{
  //private $table;

  public function __construct(string $table)
  {
    //$conn=new Db();
    parent::__construct($table);
  }

  /*public function db()
  {
    return $this->db;
  }*/

  public function executeSql($query)
  {
    $query=$this->getDb()->query($query);
    if($query==true)
    {
      if($query->num_rows>1)
      {
        return $query->fetchAll();
      }
      else if($query->num_rows==1)
      {
        if($query->fetchAll())
        {
          return $query->fetchAll();
        }
        else
        {
          return true;
        }
      }
      else
      {
        return false;
      }
    }
  }
}
