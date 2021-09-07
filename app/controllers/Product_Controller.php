<?php
namespace app\controllers;

use app\models\{ShoppingCart,Product,ProductClasification};
use app\Redirect;
use app\controllers\{ShoppingCart_Controller,ProductClasification_Controller};
use config\{ServiceSession};
use core\BaseController;


	/**
	* Description: Controller for product entity
	* @author: Arasay Rodriguez
	* Date: 18-04-2020
	*/
	class Product_Controller extends BaseController
	{
		public function __construct(){}

	  /**
		*If session no exist return to login page,
		*If exist return a data prodcts view
		*/

		public function index(){
			//return !array_key_exists('name', $_SESSION);
			if (!ServiceSession::read("name")) {
	        Redirect::to("/login")->do();
	    }
      $clasificationStars=[];
			$position;
      $productsExists=Product::allProductsCar();
			$products=$productsExists;
        $sum=0;
				$cant=0;
				//echo $_SESSION['name'];
				for($i=0;$i<count($products);$i++)
				{
				  if($products[$i]["code"]!=0)
				  {
						$position=$products[$i]["code"];
				   $shoppingController=new ShoppingCart_Controller();
				   $isThereProductUser=$shoppingController->getByNameID($_SESSION["name"],$products[$i]["code"]);
				   if($isThereProductUser=="true")
				   {
				     $getCantProductUser=$shoppingController->getCantProductUser($_SESSION["name"],$products[$i]["code"]);
				     if($getCantProductUser!="false")
				     {
				       $cant=$getCantProductUser[0]["cant"];
				     }
				   }
				    $classifController=new ProductClasification_Controller();
				    $resultClass=$classifController->getClasification($products[$i]["code"]);
				    $resultUser=$classifController->getClasificationUser($products[$i]["code"],$_SESSION["name"]);
				    //$puntuation=var_dump(intdiv($resultClass[0]["sum"], $resultClass[0]["cant"]));
				    $puntuation=0;
				    if($resultClass[0]["cant"]!=0 && $resultClass[0]["sum"]!=0)
				    {
				    $puntuation=$resultClass[0]["sum"]/$resultClass[0]["cant"];
				    }
				    $checkedClasif=0;
				    if(isset($resultUser[0]["clasif"]))
				    {
				      $checkedClasif=$resultUser[0]["clasif"];
				    }

						$clasificationStars[$position]=array(
							"cantProducts"     =>$cant,
							"puntiationProduct"=>$puntuation,
							"isCheck"          =>$checkedClasif,
							"isThereProduct"   =>$isThereProductUser
						);
				  }
				}
	      $this->view("index",array("file"=>"Product","products"=>$products,"clasificationStars"=>$clasificationStars,"sum"=>$sum,"cant"=>$cant));
		}

		/**
		*Update stock of products
		*/

		public function updateStock(float $stockAct,string $product_code){
      $values=['values_to_update'=>['stock'=>$stockAct],'code_to_update'=>['code'=>$product_code]];
			$product=new Product();
      return $product->updateTable($values);

		}
	}
