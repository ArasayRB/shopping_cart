<?php
namespace core;

use app\Redirect;
use config\{ServiceSession};


ob_start();
session_start();

$error = ob_get_clean();

class BaseController
{
  public function __construct()
  {

  }

  /**
  *Return a page view
  *@param string $view
  *@param array $data to view
  */
  public function view(string $view,array $data=[])
  {
    $products;
    $cash;
    $total;
    $totalUps;
    $clasificationStars;
    $sum;
    $cant;
    foreach ($data as $assoc=>$value)
    {
      ${$assoc}=$value;
    }
    if(isset($data["file"]))
    {
      if(isset($data["products"]))
      {
        $products=$data["products"];
      }
      if(isset($data["cash"]))
      {
        $cash=$data["cash"];
      }
      if(isset($data["total"]))
      {
        $total=$data["total"];
      }
      if(isset($data["totalUps"]))
      {
        $totalUps=$data["totalUps"];
      }
      if(isset($data["clasificationStars"]))
      {
        $clasificationStars=$data["clasificationStars"];
      }
      if(isset($data["sum"]))
      {
        $sum=$data["sum"];
      }
      if(isset($data["cant"]))
      {
        $cant=$data["cant"];
      }
      include(VIEW_DIRECTORY.'/head.php');
      include(VIEW_DIRECTORY.'/navigation.php');
      require (VIEW_DIRECTORY.'/'.$data["file"].'/'.$view.'.php');
      include(VIEW_DIRECTORY.'/foot.php');
    }
    else
    {
      require (VIEW_DIRECTORY.'/'.$view.'.php');
    }
  }
}
