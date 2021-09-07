<?php
namespace app\controllers;

use app\models\{ShoppingCart,Product,CreditCard};
use app\Redirect;
use config\{ServiceSession};
use app\controllers\{Product_Controller};
use core\BaseController;

	class CreditCard_Controller extends BaseController
	{
		public function __construct(){
			parent::__construct();
		}

		public function index(){
		$this->view("index",array());
    }

    public function getDataCard(){
      $totallyCart=CreditCard::getCashCard();
      return $totallyCart;
		}

    public function updateCashCard(float $updateCash,string $card){
      CreditCard::updateCashCard($updateCash,$card);
		}
  	}
