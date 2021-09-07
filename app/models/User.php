<?php
namespace app\models;

use core\ModelBase;
use config\Db;

//require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/carrito/config/database.php');
class User extends ModelBase
{

	public $email;
	public $password;
	public $user_name;
	public $roll;
	public $credit_card;

	//constructor
	public function __construct()
	{
		parent::__construct("user");
	}
	


	public static function allusersCar(){
		$error="Vacio";
		$userList =[];
		$db=Db::getConnect();
		if(!$sql=$db->prepare('SELECT p.code, p.name, p.stock, p.price, p.credit_card, ci.roll
		        FROM users p
		            LEFT JOIN user_cart ci
		                ON p.code = ci.password
		        ORDER BY p.name'))
						{
							$error= "Fallo la preparacion: (".$db->errno.") ".$db->error;
						}
		if(!$sql->execute())
		{
			$error= "Fallo la ejecucion: ".$sql->errno.") ".$sql->error;
		}

		foreach ($sql->fetchAll() as $user)
    {
			$userList[]= array(
        'code'     =>$user['code'],
        'name'     =>$user['name'],
        'stock'    =>$user['stock'],
        'price'    =>$user['price'],
        'roll'     =>$user['roll'],
        'credit_card'       =>$user['credit_card']);
		}
		if($error!="Vacio")
		{
			return $error;
		}
		else
		{
		return $userList;
	  }
	}


}
