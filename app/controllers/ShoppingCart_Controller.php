<?php
namespace app\controllers;

use app\models\{ShoppingCart,Product};
use app\Redirect;
use app\controllers\{Product_Controller,UserPay_Controller,CreditCard_Controller};
use config\{ServiceSession};
use core\BaseController;

	class ShoppingCart_Controller extends BaseController
	{

		public $productActController;
		public $cart;
		public function __construct()
		{
			parent::__construct();
			$this->productActController= new Product_Controller();
			$this->cart= new ShoppingCart();
		}

		public function index(){
			if (!ServiceSession::read("name")) {
	        Redirect::to("/login")->do();
	    }
      $clasificationStars=[];
			$position;

      $products=ShoppingCart::all();
			$cashCreditController=new CreditCard_Controller();
			$cashCredit=$cashCreditController->getDataCard();
			$cash;
			$card;
			$total=0;
			$totalUps=0;
			if(count($cashCredit)>0)
			{
				$cash=$cashCredit[0]["cash"];
				$card=$cashCredit[0]["card"];
			}

        $sum=0;
        if(count($products)>0){


        $total=0;
         for($i=0;$i<count($products);$i++)
         {
           if($products[$i]["code"]!=0)
           {
             $subtotal=$products[$i]["price"]*$products[$i]["cant"];

                           $maxQuantity=$products[$i]["stock"];
                           if($products[$i]["stock"]<$products[$i]["cant"])
                           {
                             $maxQuantity=$products[$i]["cant"];
                           }


           $total +=$subtotal;
           }
         }
         $totalUps=$total+5;

      }
      $this->view("index",array("file"=>"Cart","products"=>$products,"cash"=>$cash,"total"=>$total,"totalUps"=>$totalUps));
			//require('./app/views/Cart/index.php');
		}

		public function addToCart(){
			$this->view("addToCart",array());
		}

    /**
		*By user add a new product to it shopping cart
		*/
		public function addProductToCartByUser(){
			  $product_code=$_POST['product-code'];
        $shopId="666666";
        $updateIf="yes";
        $stockAct=$_POST['product-stock']-$_POST['quantity'];
			  $this->productActController->updateStock($stockAct,$product_code);
				$new_product=array('user_id'=>$_SESSION["name"],'product_id'=>$product_code,'shop_id'=>$shopId,'cant'=>$_POST['quantity'],'um'=>$_POST['product-um']);
  			$this->cart->insert($new_product);

				//find the new register
				$addedCart=$this->cart->getNameById($product_code,$table_work);
				//ShoppingCart::setTable('product_cart');
				$mensaggeAddedCart="Was an error inserting data";
				Redirect::to("/products")->with([
					'message'=>$addedCart[0]["name"],
				])->do();
		}

		public function updateToCart(){
		  $shopId="666666";
			$stock=$_POST['product-stock'];
			$quantity=$_POST['quantity'];
			$product_cant=$_POST["product-cant"];
			$product_code=$_POST["product-code"];
			$product_name=$_POST["product-name"];
			$product_price=$_POST["product-price"];
			$product_um=$_POST["product-um"];
			$stockAct=$stock-$quantity;
			$updateIf="yes";
			if($product_cant==$quantity)
			{

				Redirect::to("/carts")->do();
			}
			else if($quantity>$product_cant)
			{
				$stockSum=$quantity-$product_cant;
				$stockAct=$stock-$stockSum;
			}
			else
			{
				// code...
				$stockSum=$product_cant-$quantity;
				$stockAct=$stock+$stockSum;
			}
			$productToUpd= array('values_to_update'=>['cant'=>$quantity,'um'=>$product_um],'code_to_update'=>['user_id'=>$_SESSION["name"],'shop_id'=>$shopId,'product_id'=>$product_code,]);//new ShoppingCart($_SESSION["name"],$product_code,$shopId,$quantity,$product_um);
			$this->productActController->updateStock($stockAct,$product_code);
			$this->cart->updateTable($productToUpd);
			$updatedCart=$this->cart->getNameById($product_code);
			Redirect::to("/carts")->with([
				'message'=>$updatedCart[0]["name"],
			])->do();
		}
    public function getByNameID(string $prodId,string $code): string
    {
      $isThereUserbyCode=ShoppingCart::getByNameID($prodId,$code);
      return $isThereUserbyCode;
    }

		public function getCantProductUser(string $user,string $code)
 	 {
 		 $isThereUserbyCode=ShoppingCart::getCantProductUser($user,$code);
 		 return $isThereUserbyCode;
 	 }

	 /**
	 *Delete product of shopping Cart
	 */

		public function delete(){
			$product_to_del=array('shop_id'=>"666666",'user_id'=>$_SESSION['name'],'product_id'=>$_POST['product-code']);
		  $updateIf="yes";
	  	$cantAct=$_POST['product-cant']+$_POST['product-stock'];
	  	$this->productActController->updateStock($cantAct,$_POST['product-code']);
		  $this->cart->deleteBy($product_to_del);
			Redirect::to("/carts")->do();
		}

		/**
 	 *Delete product payed of shopping Cart
 	 */
    public function deleteProductsPayed(string $shopDelete,string $userDelete){
			ShoppingCart::deleteAll($userDelete,$shopDelete);
		}
	}
