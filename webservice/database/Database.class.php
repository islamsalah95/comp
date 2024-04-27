<?php
class Database
{
	public $allowed_html_fields=array("html","code");

    public function Connect($mysql_server, $mysql_user, $mysql_password)
    {
        $this->connection = mysqli_connect($mysql_server, $mysql_user, $mysql_password);
    }

	public function SelectDB($database_name)
    {
        mysqli_select_db($this->connection,$database_name);
    }
	
    public function __destruct()
    {
        mysqli_close($this->connection);
    }

    public function Query($query)
    {
        return mysqli_query($this->connection,$query);
    }
	
	public function fetch_array($result_set)
    {
        return mysqli_fetch_array($result_set, MYSQLI_ASSOC);
    }
	
	public function DataResult($strTable,$sqlClause,$sql='')
	{
		global $DBprefix;		
		$sql_query = "SELECT * FROM ".$DBprefix.$strTable." WHERE ".$sqlClause;
		if(isset($sql) && $sql != ''){
			$sql_query = $sql;
		}
		$data_table = $this->Query($sql_query);		
		if(!$data_table || mysqli_num_rows($data_table) == 0)
		{
			return null;
		}
		else
		{
			while($row = mysqli_fetch_array($data_table,MYSQLI_ASSOC)) {
				$result[] = $row;
			}
			return $result;
		}

	}
	
	function SQLInsert($strTable,$arrNames,$arrValues)
	{
		global $DBprefix;
		$strNames="";
		$strList="";
		$num = count($arrNames);
		for ($i = 0; $i < $num; $i++) 
		{
			$strNames.=$arrNames[$i].",";
		}		
		$num = count($arrValues);

		for ($i = 0; $i < $num; $i++) 
		{		
			if(strpos($arrNames[$i], "html_")!== false){ }
			else if(!in_array($arrNames[$i], $this->allowed_html_fields))
			{
				if(is_array($arrValues[$i]))
				{
					$arrValues[$i]=implode(",",$arrValues[$i]);
				}
				$arrValues[$i]=strip_tags($arrValues[$i]);				
			}			
			$strList.="'".mysqli_real_escape_string($this->connection, $arrValues[$i])."',";			
		}

		$strList=substr($strList,0,(strlen($strList)-1));
		$strNames=substr($strNames,0,(strlen($strNames)-1));

		$strQuery="INSERT INTO ".$DBprefix.$strTable." (".$strNames.") VALUES (".$strList.")";
		$this->Query($strQuery);		
		$iResult=mysqli_insert_id($this->connection);
		return $iResult;
	}	
	
	function SQLDelete($strTable,$Key,$arrIDs)
	{
		global $DBprefix;
		$strList="";
		$num = count ($arrIDs);
		for ($i = 0; $i < $num; $i++) 
		{
			$strList.=$arrIDs[$i].",";
		}
		$strList=substr($strList,0,(strlen($strList)-1));
		$strQuery="DELETE FROM ".$DBprefix.$strTable." WHERE ".$Key." IN ($strList)";
		$this->Query($strQuery);
	}
	
	
	function SQLDeletePlus($auth_column,$auth_value,$strTable,$Key,$arrIDs)
	{
		global $DBprefix;
		$strList="";
		$num = count ($arrIDs);
		for ($i = 0; $i < $num; $i++) 
		{
			$strList.=$arrIDs[$i].",";
		}
		$strList=substr($strList,0,(strlen($strList)-1));
		$strQuery="DELETE FROM ".$DBprefix.$strTable." WHERE ".$Key." IN ($strList) AND ".$auth_column."='".$auth_value."'";
		$this->Query($strQuery);
	}
	
	function SQLUpdate($strTable,$arrNames,$arrValues,$whereClause)
	{
		global $DBprefix;
		$strUpdateList="";
		$num = count($arrNames);
		for ($i = 0; $i < $num; $i++) 
		{
			if(strpos($arrNames[$i], "html_")!== false){}
			else if(!in_array($arrNames[$i], $this->allowed_html_fields))
			{
				if(is_array($arrValues[$i])) $arrValues[$i]=implode(",",$arrValues[$i]);
				$arrValues[$i]=strip_tags($arrValues[$i]);
			}
			$arr_decim=array("experience_level");
			if(in_array($arrNames[$i],$arr_decim))
			{
				$strUpdateList.=$arrNames[$i]."=NULL,";
			}				
			else	
			{
				$strUpdateList.=$arrNames[$i]."='".mysqli_real_escape_string($this->connection, $arrValues[$i])."',";
			}
		}
		$strUpdateList=substr($strUpdateList,0,(strlen($strUpdateList)-1));
		$strQuery="UPDATE ".$DBprefix.$strTable."
		SET ".$strUpdateList."
		WHERE ".$whereClause;
		$strQuery=str_replace("'NULL'","NULL",$strQuery);
		$iResult=$this->Query($strQuery);
		return $iResult;
	}
}
?>