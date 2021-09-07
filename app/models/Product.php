<?php
namespace app\models;

use config\{Common, Db};
use core\ModelBase;

class Product extends ModelBase
{

	public $code; //code
	public $name;//stock
	public $stock;//name
	public $price;//price
	public $um;//price
	public $img;//price

	//constructor
	public function __construct()
	{
		parent::__construct("products");
	}


  /**
	*Return all products in data base
	*/
	public static function allProductsCar(){
		$error="Vacio";
		$productList =[];
			$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT p.code, p.name, p.stock, p.price, p.um, p.img
		        FROM products p
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
        'um'       =>$product['um'],
        'img'      =>$product['img']);
		}
		return $productList;
	}
	}
}
