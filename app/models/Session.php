<?php
namespace app\models;

use core\ModelBase;
use config\Db;

//require_once(realpath($_SERVER["DOCUMENT_ROOT"]).'/carrito/config/database.php');
class Session extends ModelBase
{

	public $id;
	public $information;
	public $last_access;

	//constructor
	public function __construct()
	{
		parent::__construct("sessions");
	}


  /**
	*Delete Session data by id user
	*/
	public static function deleteSessions($userId)
{
	 $db = Db::getConnect();
	 $sentencia = $db->prepare("DELETE FROM sessions WHERE id IN (SELECT id_session FROM sessions_user WHERE id_user = ?)");
	 $sentencia->execute([$userId]);
	 $sentencia = $db->prepare("DELETE FROM sessions_user WHERE id_user = ?");
	 $sentencia->execute([$userId]);
}


}
