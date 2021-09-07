<?php
namespace app\controllers;

use app\models\{ShoppingCart,Product,UserPay,CreditCard};
use app\Redirect;
use config\{ServiceSession};
use app\controllers\{Product_Controller,ShoppingCart_Controller,CreditCard_Controller};
use core\BaseController;

class UserPay_Controller extends BaseController
	{
		public function __construct(){
			parent::__construct();
		}

		public function index()
		{

		}

    public function save(array $products){
      $resultSave=UserPay::save($products);
			return $resultSave;
		}

		/**
		*Pay products cart
		*/

	  public function pay(){
			  $products=ShoppingCart::all();
        $subtotallPay=0;
        $send=$_POST['radio'];
        $totally=0;
        $values=[];
        $shopDelete;
        $userDelete;
				$addups=0;
				$paginado;
				if($send=="ups")
				{
					$totally=5;
				}
        for($i=0;$i<count($products);$i++)
          {
            $totally+=$products[$i]["cant"]*$products[$i]["price"];
            $subtotallPay=$products[$i]["cant"]*$products[$i]["price"];
            $values[]=array($_SESSION["name"],$products[$i]["code"],"666666",$products[$i]["cant"],$subtotallPay,$send);
            $shopDelete="666666";
            $userDelete=$_SESSION["name"];
          }
        $creditCardController= new CreditCard_Controller();
        $arrayCash=$creditCardController->getDataCard();
        $cash=0;
        $card=0;
        if(count($arrayCash)>0)
        {
          $cash=$arrayCash[0]["cash"];
          $card=$arrayCash[0]["card"];
        }
        if($cash>$totally)
        {
          $resultPay=$this->save($values);

		$productActController= new ShoppingCart_Controller();
		$productActController->deleteProductsPayed($shopDelete,$userDelete);
		$updateCash=$cash-$totally;
    $creditCardController->updateCashCard($updateCash,$card);
    $paginado=array("success"=> true, "cashBefore"=>$cash, "cashAfter"=>$updateCash, "cost"=>$totally, "action"=>"index", "controller"=>"Product", "state"=>"succefully");

}

      else
      {
        $paginado=array("success"=> true, "cashBefore"=>$cash, "action"=>"index", "controller"=>"ShoppingCart", "state"=>"noCredit");
      }
			echo json_encode($paginado);
    }
  	}
