<?php
  namespace app\controllers;

  use config\{Db};

  class Session_Controller implements \SessionHandlerInterface
	{
      /**
       * @var $dataBase \PDO
       */
      private $dataBase; #Save our information db reference
      public function open($savePath, $sessionName)
      {
          $this->dataBase = Db::getConnect();
          return true;
      }
      public function close()
      {
          #Delete reference to information db
          $this->dataBase = null;
          return true;
      }

      public function write($sessionId, $datos_de_sesion)
      {

          $last_access = time();
          $query = $this->dataBase->prepare("REPLACE INTO sessions (id, information, last_access) VALUES (?, ?, ?);");
          $query->execute([$sessionId, $datos_de_sesion, $last_access]);

          /**
           * Watch if session has an user id, to save it
           * in other table and follow a record
           * of sessions by user, and later
           * can delete other sessions
           * or deleted when user be delete
           */
          if (!empty($_SESSION["name"])) {
              $query = $this->dataBase->prepare("REPLACE INTO sessions_user(id_session, id_user) VALUES (?, ?)");
              $query->execute([$sessionId, $_SESSION["name"]]);
          }
          return true;
      }

      public function read($sessionId)
      {
          $query = $this->dataBase->prepare("SELECT information FROM sessions WHERE id = ?;");
          $query->execute([$sessionId]);
          # Obtain an object (with PDO::FETCH_OBJ), to access to $fill->information
          $fill = $query->fetch(\PDO::FETCH_OBJ);
          # if no exist information with that id fetch return false
          if ($fill === false) {
              return ""; # empty string
          } else {
              return $fill->information;
          }
      }
      public function destroy($sessionId)
      {
          $query = $this->dataBase->prepare("DELETE FROM sessions WHERE id = ?;");
          return $query->execute([$sessionId]);
      }
      public function gc($tiempo_de_vida)
      {
          #Calculate actual time - time live.
          $caducidad = time() - $tiempo_de_vida;
          $query = $this->dataBase->prepare("DELETE FROM sessions WHERE last_access < ?;");
          return $query->execute([$caducidad]);
      }
  	}
