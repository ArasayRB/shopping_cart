<?php
namespace app\models;

use core\ModelBase;
use config\Db;

class ProductClasification extends ModelBase
{

	public $user_id;
	public $product_id;
	public $clasification;

	//constructor
	public function __construct()
	{
		parent::__construct('product_clasification');
	}

	//get product function
	public static function all()
	{
		$error="Vacio";
		$productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT * FROM product_clasification'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
    if($sql->execute())
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
			$productList[]= new ProductClasification($product['user_id'], $product['product_id'],$product['clasification']);
		}
		return $productList;
	  }
	}

	public static function getClasification(string $prodId){
		$error="Vacio";
    $productList=[];
		//search
		$db=Db::getConnect();
		if(!$select=$db->prepare('SELECT count(pc.clasification) as cant, sum(pc.clasification) as sum FROM product_clasification pc WHERE pc.product_id=:product_id'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$select->bindValue('product_id',$prodId);
    if(!$select->execute())
		{
			$error= "Fallo la ejecucion: ".$select->errno.") ".$select->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
		else
		{
		foreach ($select->fetchAll() as $product)
		{
			$productList[]= array(
				'cant'     =>$product['cant'],
				'sum'     =>$product['sum']);
		}
		return $productList;
	  }
	}

	public static function getClasificationUser(string $prodId,string $user){
		$error="Vacio";
    $productList=[];
		//search
		$db=Db::getConnect();
		if(!$select=$db->prepare('SELECT pc.clasification FROM product_clasification pc WHERE pc.product_id=:product_id AND pc.user_id=:user_id'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$select->bindValue('product_id',$prodId);
		$select->bindValue('user_id',$user);
    if(!$select->execute())
		{
			$error= "Fallo la ejecucion: ".$select->errno.") ".$select->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
		else
		{

		foreach ($select->fetchAll() as $product)
		{
			$productList[]= array(
				'clasif'     =>$product['clasification']);
		}
		return $productList;
	  }
	}

	//register product function
	public static function save()
	{
		//return $this->insert($product);
		return 'Entre a model ProductClasf';// $this->user_id;
		/*$error="Vacio";
	  $db=Db::getConnect();
	  if(!$insert=$db->prepare('INSERT INTO product_clasification VALUES(:user_id,:product_id,:clasification)'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$insert->bindValue('user_id',$product->user_id);
		$insert->bindValue('product_id',$product->product_id);
		$insert->bindValue('clasification',$product->clasification);
		if(!$insert->execute())
		{
				$error= "Fallo la ejecucion: ".$insert->errno.") ".$insert->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}*/
  }
  }
