<?php
namespace app;

use app\controllers\{User_Controller,ProductClasification_Controller,Product_Controller,ShoppingCart_Controller,UserPay_Controller,CreditCard_Controller};
use app\models\{User,ProductClasification,Product,ShoppingCart,UserPay,CreditCard};

	//function call to controller and his respective action pass by parameter
	function call($controller, $action)
  {
		//import the controller since file controllers
		require_once('app/controllers/' . $controller . '_Controller.php');
		//crea el controlador
		switch($controller)
    {
			case 'Product':
				$controller= new Product_Controller();
				break;
			case 'ShoppingCart':
					$controller= new ShoppingCart_Controller();
					break;
			case 'UserPay':
					$controller= new UserPay_Controller();
					break;
			case 'CreditCard':
					$controller= new CreditCard_Controller();
					break;
			case 'ProductClasification':
					$controller= new ProductClasification_Controller();
					break;
			case 'User':
					$controller= new User_Controller();
					break;
		}
		//call controller action
		$controller->{$action }();
	}

	//controller array and his respective action
	$controllers= array(
						'Product'             =>['index','register','update', 'delete'],
						'ShoppingCart'        =>['index','addToCart','updateToCart', 'deleteToCart','added','getQuantityCart','deleteProductsPayed','getByNameID'],
						'UserPay'             =>['index','pay'],
						'CreditCard'          =>['index','getDataCard','updateCashCard'],
						'User'                =>['index','login','logoff'],
						'Session'             =>['setSession','getSession'],
						'ProductClasification'=>['index','putClasification','getClasification','getClasificationUser']
						);
	//confirm controller send since index.php be inside array controllers
	if(array_key_exists($controller, $controllers))
  {
		if(in_array($action, $controllers[$controller]))
    {
			call($controller, $action);
		}
    else
    {
			call('product', 'error');
		}
	}
  else
  {
    call('product', 'error');
	}
