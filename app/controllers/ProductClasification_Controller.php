<?php
namespace app\controllers;

use app\models\{ShoppingCart,Product,ProductClasification,UserPay,CreditCard};
use app\controllers\{Product_Controller};
use core\BaseController;


	class ProductClasification_Controller extends BaseController
	{
		public function __construct(){}

		public function index()
		{

		}

    /*
    *This method is for clasificate a product by user
    */
    public function putClasification(){
			$column_value=array('user_id'=>$_SESSION['name'],'product_id'=>$_POST['codeProduct'],'clasification'=>$_POST['stairs']);
			$clasification_product=new ProductClasification();

			$clasification_product->insert($column_value);
      $paginado=array("success"=> true, "action"=>"index", "controller"=>"Product", "state"=>"succefully");
      echo json_encode($paginado);
		}


    public function getClasification(string $clasificationModel)
      {
      $class=ProductClasification::getClasification($clasificationModel);
      return $class;
      }

    public function getClasificationUser(string $code,string $user)
      {
      $class=ProductClasification::getClasificationUser($code,$user);
      return $class;
      }
  }

  if (isset($_GET['action']))
 {
   $userLog;
   if(isset($_SESSION["check"]))
   {
     $userLog=$_SESSION["name"];
   }
      //add connection file
      require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/carrito/config/database.php');
      if ($_GET['action']!='addToCart'&$_GET['action']!='index')
      {
        if($_GET['action']=='putClasification')
        {
          $clasificationModel=new ProductClasification($_SESSION["name"],$_GET["codeProduct"],$_GET["stairs"]);
            $userPayController= new ProductClasification_Controller();
              $userPayController->putClasification($clasificationModel);
        }
      }


  }
