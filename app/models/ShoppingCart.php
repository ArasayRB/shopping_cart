<?php
namespace app\models;

use core\ModelBase;
use config\Db;

class ShoppingCart extends ModelBase
{

	public $user_id;
	public $product_id;
	public $shop_id;
	public $cant;
	public $um;

	//constructor
	public function __construct()
	{
		parent::__construct("product_cart");
	}

	//get product function
	public static function all(){
		$error="Vacio";
	  $productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT p.code, p.name,p.stock, p.price, p.um, p.img, ci.cant
		            FROM product_cart ci
		                LEFT JOIN products p
		                    ON ci.product_id = p.code
												WHERE ci.user_id=:user'))
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
        'code'     =>$product['code'],
        'name'     =>$product['name'],
        'stock'    =>$product['stock'],
        'price'    =>$product['price'],
        'um'       =>$product['um'],
        'cant'     =>$product['cant'],
        'img'     =>$product['img']);
		}
		return $productList;
	  }
	}

	public static function countProductInCart(){
		$error="Vacio";
		$productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT count(*) FROM product_cart WHERE user_id=:user'))
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
		return $sql->fetchAll();
	  }
	}

	public static function allProductsCar(){
		$error="Vacio";
		$productList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT p.code, p.name, p.stock, p.price, p.um, ci.cant
		        FROM products p
		            LEFT JOIN product_cart ci
		                ON p.code = ci.product_id
		        ORDER BY p.name'))
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
			$productList[]= array(
        'code'     =>$product['code'],
        'name'     =>$product['name'],
        'stock'    =>$product['stock'],
        'price'    =>$product['price'],
        'cant'     =>$product['cant'],
        'um'       =>$product['um']);
		}
		return $productList;
	  }
	}

	//register product function
	public static function save(ShoppingCart $product){
		$error="Vacio";
		$consultInsert="false";
			$db=Db::getConnect();
			if(!$insert=$db->prepare('INSERT INTO product_cart VALUES(:user_id,:id,:shop_id,:cant,:um)'))
			{
				$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
			}
			$insert->bindValue('user_id',$product->user_id);
			$insert->bindValue('id',$product->product_id);
			$insert->bindValue('shop_id',$product->shop_id);
			$insert->bindValue('cant',$product->cant);
			$insert->bindValue('um',$product->um);
			if(!$valueInsert=$insert->execute())
			{
				$error= "Fallo la ejecucion: ".$insert->errno.") ".$insert->error;
			}
			if($error!="Vacio")
			{
				return $error;
			}

		}

	//act function
	public static function update(ShoppingCart $product){
		$error="Vacio";
		$db=Db::getConnect();
		if(!$update=$db->prepare('UPDATE product_cart SET cant=:cant, um=:um WHERE user_id=:user_id AND  product_id=:id AND shop_id=:shop_id'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$update->bindValue('user_id',$product->user_id);
		$update->bindValue('id',$product->product_id);
		$update->bindValue('shop_id',$product->shop_id);
		$update->bindValue('cant',$product->cant);
		$update->bindValue('um',$product->um);
		if(!$update->execute())
		{
			$error= "Fallo la ejecucion: ".$update->errno.") ".$update->error;
		}
		if($error!="Vacio")
		{
			return $error;
		}
	}

	// delete by user_id
	public static function delete(string $prodId){
		$error="Vacio";
		$db=Db::getConnect();
		$delete=$db->prepare('DELETE FROM product_cart WHERE user_id=:user_id AND  product_id=:id AND shop_id=:shop_id');
		$delete->bindValue('user_id',$_SESSION["name"]);
		$delete->bindValue('id',$prodId);
		$delete->bindValue('shop_id',"666666");
		$delete->execute();
	}

	public static function deleteAll(string $userId,string $shopId){
		$error="Vacio";
		$db=Db::getConnect();
		$delete=$db->prepare('DELETE FROM product_cart WHERE user_id=:user_id AND shop_id=:shop_id');
		$delete->bindValue('user_id',$userId);
		$delete->bindValue('shop_id',$shopId);
		$delete->execute();
	}

	public static function getNameById(string $prodId){
		$error="Vacio";
		$userLog;
		if(isset($_SESSION["check"]))
		{
			$userLog=$_SESSION["name"];
		}
    $productList=[];
		//search
		$db=Db::getConnect();
		if(!$select=$db->prepare('SELECT p.code, p.name, p.stock, p.price, ci.cant
				        FROM product_cart ci
				            LEFT JOIN products p
				                ON p.code = ci.product_id AND ci.product_id=:id AND ci.user_id=:name AND ci.shop_id=:shop
				        ORDER BY p.name'))
								{
									$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
								}
		$select->bindValue('id',$prodId);
    $select->bindValue('name',$userLog);
    $select->bindValue('shop',"666666");
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
			if($product['code']!='' && $product['name']!=''){
			$productList[]= array(
				'code'     =>$product['code'],
				'name'     =>$product['name']);
		  }
		}
		return $productList;
	  }
	}




	public static function getByNameID (string $prodId,string $code): string {
		$error="Vacio";
		//search
		$db=Db::getConnect();
		if(!$select=$db->prepare('SELECT * FROM product_cart WHERE product_id=:id AND user_id=:user_id'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$select->bindValue('id',$code);
		$select->bindValue('user_id',$prodId);
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
		$productDb=$select->fetch();
		if($productDb)
		{
			return "true";
		}
		else
		{
			// code...
			return "false";
		}
	  }
	}

	public static function getCantProductUser(string $prodId,string $code){
		$error="Vacio";
		//search
		$productList=[];
		$consult="false";
		$db=Db::getConnect();
		if(!$select=$db->prepare('SELECT cant FROM product_cart WHERE product_id=:id AND user_id=:user_id'))
		{
			$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
		}
		$select->bindValue('id',$code);
		$select->bindValue('user_id',$prodId);
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
		$productDb=$select->fetchAll();
		if($productDb)
		{
			foreach ($productDb as $product)
			{
				$productList[]= array(
					'cant'     =>$product['cant']);
			}
			return $productList;
		}
		else
		{
			return $consult;
		}
	}
	}
}
