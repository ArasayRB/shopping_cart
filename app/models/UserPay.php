<?php
namespace app\models;

use core\ModelBase;
use config\Db;

ob_start();
session_start();
$error = ob_get_clean();

class UserPay extends ModelBase
{

	public $user_id;
	public $product_id;
	public $shop_id;
	public $cant;
	public $totall_pay;
	public $send;
	public $code_time;

	//constructor
	public function __construct()
	{
		$table="user_pay";
 	  parent::__construct($table);
	}

	//get product function
	public static function all()
	{
		$productList =[];
		$error="Vacio";
		$db=Db::getConnect();
		$sql=$db->prepare('SELECT * FROM user_pay');
    $sql->execute();
		foreach ($sql->fetchAll() as $product)
		{
			$productList[]= new UserPay($product['userId'],$product['shopId'], $product['productId'],$product['cant'],$product['totallPay'],$product['send'],$product['codeTime']);
		}

		return $productList;

	}

	public function getByKey(string $prodId,string $user,string $shop,string $date){
		$error="Vacio";
		//search
		$db=Db::getConnect();
		$select=$db->prepare('SELECT * FROM user_pay WHERE user_id=:user AND product_id=:product AND shop_id=:shop AND code_time=:data');
		$select->bindValue('user',$user);
		$select->bindValue('product',$prodId);
		$select->bindValue('shop',$shop);
		$select->bindValue('data',$date);
		$select->execute();

	  return "inserted";
	}

	//register product function
	public static function save(array $product)
	{
		$error="true";
		$db=Db::getConnect();
	  $insert=$db->prepare('INSERT INTO user_pay VALUES(:user_id,:product_id,:shop_id,:cant,:totall_pay,:send,:code_time)');
    $insertValue="true";
		$result="true";
		for($i=0;$i<count($product);$i++)
		{
			$up=new UserPay();
    $isInserted=$up->getByKey($product[$i][0],$product[$i][1],$product[$i][2],"".date("m")."".date("d")."".date("y")."".date("H")."".date("i")."".date("s"));

		$dateTime="".date("m")."".date("d")."".date("y")."".date("H")."".date("i")."".date("s");
	  $insert->bindValue('user_id',$product[$i][0]);
		$insert->bindValue('product_id',$product[$i][1]);
		$insert->bindValue('shop_id',$product[$i][2]);
		$insert->bindValue('cant',$product[$i][3]);
		$insert->bindValue('totall_pay',$product[$i][4]);
		$insert->bindValue('send',$product[$i][5]);
		$insert->bindValue('code_time',$dateTime);
		$insertValue=$insert->execute();
		}
  }
  }
