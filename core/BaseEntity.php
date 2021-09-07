<?php
namespace core;

use config\Db;

class BaseEntity{
    //protected $table;
    protected $db;
    protected $connection;

    //constructor
   protected function __construct(protected $table)
    {
      $this->connection=new Db();
      $this->db=$this->connection->getConnect();
    }

    public function getTable(){
      return $this->table;
    }

    public function getDb(){
      return $this->db;
    }

    public function getConnection(){
      return $this->connection;
    }

    public function setTable(string $table){
      $this->table=$table;
    }

    public function getAll()
    {
      $query=$this->db->prepare("SELECT * FROM $this->table");
			$query->execute();
      return $query->fetchAll();
    }

    /**
    *Obtain an array of data by id
    *@param string $id
    */

    public function getById($id)
    {
      $query=$this->db->prepare("SELECT * FROM $this->table WHERE id=:id");
      $query->bindValue('id',$id);
      $query->execute();
      return $query->fetchAll();
    }

    /**
    * Update in db values
    * Receive an array with array of colummn=>value to insert
    * AND array key=>value for update nav-linkdisabled
    * array(array('column'=>value),array('key'=>value))
    */
    public function updateTable(array $values){
      $data=$this->prepareData($values, 'update');
      $columns_to_update=$data['column'];
      $column=$data['key_to_update'];
      $value=$data['values_to_update'];
      $sql="UPDATE $this->table SET $value WHERE $column";
      return $this->executeConsult($sql);
    }

    /**
    * Insert in db values
    * Receive colummn=>value to insert
    */
    public function insert(array $values){
        $data=$this->prepareData($values, 'insert');
      $column=$data['column'];
      $value=$data['values'];
      $sql="INSERT INTO $this->table ($column) VALUES ($value)";
      return $this->executeConsult($sql);
    }

    /**
    * Execute a consult receiving an consult string
    * Return a result fetch of values
    */

    public function executeConsult(string $consult): array{
      $query;

      if(!$query=$this->db->prepare($consult)){
        return "Fallo la preparacion: (".$this->db->errno.") ".$this->db->error;
      }
      if (!$query->execute()) {
        return "Fallo la ejecucion: ".$this->db->errno.") ".$this->db->error;
      }
      return $query->fetchAll();
    }

    /**
    *Prepare data in dependence of type consult
    */

    public function prepareData(array $column_value, string $operation): string|array{
        $keys=array_keys($column_value);
        $values=array_values($column_value);
        if ($operation=='insert') {
          return $this->prepareInsertData($column_value, $keys);
        }
        elseif ($operation=='select') {
          return $this->prepareSelectData($column_value, $keys);
        }
        elseif ($operation=='update') {
          return $this->prepareUpdateData($column_value, $keys);
        }
        elseif ($operation=='delete') {
          return $this->prepareDeleteData($column_value, $keys);
        }
      return "Warning: Operation value not valid";
    }

    /**
    * Prepare the data for consult update
    * receive an array of values=>['value_to_update'=>['column'=>$value],'code_to_update=>['column'=>$value]'] and an array of it keys
    */
    public function prepareUpdateData(array $column_value, array $keys):array{
      //string of columns values to update
      $column="";

      //string of columns values for where update
      $where='';

      //values of  columns to update
      $columns_values=$column_value[$keys[0]];

      //keys of columns values to update
      $keys_columns_values=array_keys($columns_values);

      //values of  'where' columns to update
      $columns_where=$column_value[$keys[1]];

      //keys of 'where' columns values to update
      $keys_columns_where=array_keys($columns_where);

      //quantity of values to update and columns 'where' update respective
      $cant_values=count($column_value[$keys[0]]);
      $cant_where=count($column_value[$keys[1]]);

      //column actualice of values to update consult
      $column=$this->makeConsultString($cant_values, $keys_columns_values, $column, $columns_values,',');

      //column actualice of 'where' to update consult
      $where=$this->makeConsultString($cant_where, $keys_columns_where, $where, $columns_where,'AND');
      return array('values_to_update'=>$column,'key_to_update'=>$where);
    }

    /**
    * Prepare the data for delete
    * receive an array of values=>['value_to_update'=>['column'=>$value],'code_to_update=>['column'=>$value]'] and an array of it keys
    */

    public function prepareDeleteData(array $column_data, array $keys):string{
      return $this->makeConsultString(count($column_data), $keys, '', $column_data,'AND');
    }

    /**
    *Write a consult complement to return to prepareData()
    */

    public function makeConsultString(int $cant_values, array $keys_columns, string $string, array $values_array, string $operator):string{
      for ($i=0; $i < $cant_values; $i++) {
        $key=$keys_columns[$i];
        if($i!=($cant_values-1)){
          $string.=" $key='$values_array[$key]' $operator ";
        }
        else{
          $string.=" $key='$values_array[$key]'";
        }
      }
      return $string;
    }

    /**
    * Prepare the data for consult insert
    * receive an array of column=>data and an array of it keys
    */
    public function prepareInsertData(array $column_value, array $keys):array{
      $cant=count($column_value);
      $data='';
      $column='';
      for ($i=0; $i < $cant; $i++) {
        $key=$keys[$i];
        $value;
        if($i==($cant-1)){
            $column.=$key;
            $data.='"'.$column_value[$key].'"';
        }
        else{
            $column.=$key.',';
            $data.='"'.$column_value[$key].'"'.',';
        }
      }
      return array('column'=>$column,'values'=>$data);
    }

    /**
    * Prepare the data for consult select
    * receive an array of column=>data and an array of it keys
    */
    public function prepareSelectData(array $column_value, array $keys): string{
      $consult='';
      for ($i=0; $i < count($column_value); $i++) {
        $key=$keys[$i];
        $value;
        if($i==0){
          if ($key=='password') {
            $pass=md5($column_value[$key]);
            $consult.="$key='$pass'";
          }
          else{
            $consult.="$key='".$column_value[$key]."'";
        }
        }
        else{
          if ($key=='password') {
            $pass=md5($column_value[$key]);
            $consult.=" AND $key='$pass'";
          }
          else{
            $consult.=" AND $key='".$column_value[$key]."'";
        }
        }
      }
      return $consult;
    }

    /**
    * Receive an column=>value array for search by and
    * Obtain an array fetc of values
    */
    public function getBy(array $column_value)
    {
      $compl='';
      $query;
      $consult="SELECT * FROM $this->table WHERE ";

        $select_where=$this->prepareData($column_value,'select');
        $consult.=$select_where;
        return $this->executeConsult($consult);
    }

    public function deleteById($id)
    {
      $query=$this->db->prepare("DELETE * FROM $this->table WHERE id=:id");
      $query->bindValue('id',$id);
      $query->execute();
      return $query;
    }

    /**
    *Delete where array of column and value
    */

    public function deleteBy(array $column_value)
    {
      $sql="DELETE FROM $this->table WHERE ";
      $select_where=$this->prepareData($column_value,'delete');
      $sql.=$select_where;
      return $this->executeConsult($sql);
    }
}
