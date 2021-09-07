<?php
namespace app\models;

use core\ModelBase;
use config\Db;

class SessionUser extends ModelBase
{

	public $id_session;
	public $id_user;

	//constructor
	public function __construct()
	{
		parent::__construct("sessions_user");
	}


}
