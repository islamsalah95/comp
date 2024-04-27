<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);

require("config.php");
include("Database.class.php");

class db extends Database{
	function __construct(){
		$this->Connect(DBHost, DBUser,DBPass );
		$this->SelectDB(DBName);
        mysqli_set_charset($this->connection,"utf8");
	}

    function get_data($table_name='', $where=1, $sql=''){
    	$data = $this->DataResult($table_name, $where, $sql);
    	if(isset($data) && count($data)){
    		return $data;
    	}
    	else{
    		return false;
    	}
    }

    function insert_data($table_name,$data=array()){
        $id = $this->SQLInsert($table_name, array_keys($data), array_values($data));
        if(isset($id) && $id > 0){
            return $id;
        }
        else{
            return false;
        }
    }

    function update_data($table_name,$data=array(),$where){
        $id = $this->SQLUpdate($table_name, array_keys($data), array_values($data), $where);
        if(isset($id) && $id > 0){
            return $id;
        }
        else{
            return false;
        }
    }
}

$db = new db();

?>