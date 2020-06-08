<?php
class sql
{
	// connect
	public function connect($key, $type)
	{
		$host = $key['host'];
		$db = $key['db'];

		if ( $type === "odbc" )
		{
			$dsn = "Driver={SQL Server};Server=192.168.99.2;Database=$db";
			$conn = odbc_connect($dsn, $key['user'], $key['pass']);
		}
		else
		{
			//$conn = mysql_connect($host, $user, $pass) OR trigger_error(mysql_error(), E_USER_ERROR);	
			$conn = mysql_connect($key['host'], $key['user'], $key['pass']);
			
			if ($conn)
			{
				mysql_select_db($key['db']);
				mysql_query(
					"SET character_set_results = 'utf8',
					character_set_client = 'utf8', 
					character_set_connection = 'utf8', 
					character_set_database = 'utf8', 
					character_set_server = 'utf8'", 
					$conn
				);
			}	
		}

		return $conn;
		// if ($con) 
		// {
		// 	return true;
		// }
		// else
		// {
		// 	return false;
		// }
	}


	// result array obj
	public function res($sql)
	{
		$temp = null;

		if ( $res = mysql_query($sql) )
		{
			$temp = array();
			$obj = array();

			while ( $arr = mysql_fetch_assoc($res) )
			{
				$i = 0;

				while ( $i < mysql_num_fields($res) )
				{
					$meta = mysql_fetch_field($res, $i);
					$obj[$meta->name] = $arr[$meta->name];
					$i++;
				}

				array_push($temp, $obj);
			}
		}

		return $temp;
	}


	// insert
	public function insert($tb, $data)
	{
		$sql = null;

		if ( is_array($data) )
		{
			$sql = "INSERT INTO ".$tb." (";

			$k = 0;
			foreach ($data as $key => $value)
			{
				$comma = ( $k > 0 ) ? ", " : null;
				$sql .= $comma.$key;
				$k++;
			}

			$sql .= ")";
			$sql .= " VALUES (";

			$v = 0;
			foreach ($data as $key => $value)
			{
				$comma = ( $v > 0 ) ? ", " : null;
				$sql .= $comma."'".$value."'";
				$v++;
			}

			$sql .= ");";
		}

		return $sql;
	}


	// update
	public function update($tb, $data, $where=null, $q=null)
	{
		$sql = null;

		if ( is_array($data) )
		{
			$sql = "UPDATE ".$tb." SET ";

			$k = 0;
			foreach ($data as $key => $value)
			{
				$val = ($q) ? $value : "'".$value."'";
				$comma = ( $k > 0 ) ? ", " : null;
				$sql .= $comma.$key."=".$val;
				$k++;
			}

			if ( !empty($where) )
			{
				$sql .= " WHERE ".$where;
			}

			//$sql .= ";";
		}		

		return $sql;
	}


	// delete
	public function delete($tb, $where=null)
	{
		$sql = null;

		if ( $where )
		{
			$sql = "DELETE FROM ".$tb;
			$sql .= " WHERE ".$where;
		}		

		return $sql;
	}


	// query
	public function exec($sql, $id=null)
	{
		$query = mysql_query($sql);

		if ($query)
		{
			if ( !empty($id) )
			{
				return mysql_insert_id();
			}
			else
			{
				return true;
			}
		}
		else
		{
			return false;
		}
	}


}
?>