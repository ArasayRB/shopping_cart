<?php
namespace App\models;

use Core\ModelBase;
use Config\Db;

ob_start();
session_start();
$error = ob_get_clean();

class CreditCard extends ModelBase
{

	public $numberCard; //numberCard
	public $cvv;//cvv
	public $cash;//cash
	public $untilDate;//untilDate

	//constructor
	public function __construct()
	{
		parent::__construct("credit_card");
	}

	//get product function
	public static function all(){
		$error="Vacio";
		$productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT cc.number_card, cc.cvv, cc.cash, cc.until_date FROM credit_card cc LEFT JOIN user u
		                ON cc.number_card = u.credit_card'))
										{
											$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
										}
    if(!$sql->execute())
		{
			$error= "Fallo la ejecucion: ".$sql->errno.") ".$sql->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
		else
		{
		foreach ($sql->fetchAll() as $product)
		{
			$productList[]= new CreditCard($product['numberCard'], $product['cvv'],$product['cash'],$product['untilDate']);
		}
		return $productList;
	  }
	}

  public static function getCashCard(){
		$error="Vacio";
		$productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT cc.cash, cc.number_card FROM credit_card cc LEFT JOIN user u
		                ON cc.number_card = u.credit_card WHERE u.email=:user'))
										{
											$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
										}
		$sql->bindValue('user',$_SESSION["name"]);
		if(!$sql->execute())
		{
				$error= "Fallo la ejecucion: ".$sql->errno.") ".$sql->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
		else
		{

		foreach ($sql->fetchAll() as $product)
    {
			$productList[]= array(
        'cash'     =>$product['cash'],
        'card'     =>$product['number_card']);
		}
		return $productList;
	  }
	}

  public static function updateCashCard(float $updateCash,string $card){
		$error="Vacio";
		$db=Db::getConnect();
		if(!$update=$db->prepare('UPDATE credit_card SET cash=:cash WHERE number_card=:card'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$update->bindValue('cash',$updateCash);
		$update->bindValue('card',$card);
		if(!$update->execute())
		{
			$error= "Fallo la ejecucion: ".$update->errno.") ".$update->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
	}

	//register product function
	public static function save(CreditCard $product){
		$error="Vacio";
			$db=Db::getConnect();
			if(!$insert=$db->prepare('INSERT INTO credit_card VALUES(NULL,:numberCard,:cash,:cvv,:untilDate)'))
			{
				$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
			}
			$insert->bindValue('numberCard',$product->numberCard);
			$insert->bindValue('cash',$product->cash);
			$insert->bindValue('cvv',$product->cvv);
			$insert->bindValue('untilDate',$product->untilDate);
			if(!$insert->execute())
			{
				$error= "Fallo la ejecucion: ".$insert->errno.") ".$insert->error;
			}
			if($error!="Vacio")

			return $error;
		}
  }
