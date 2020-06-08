<?php
class login extends sql
{			
	private $conn;
	private $filter;

	public function __construct()
	{
		global $cfg;
		$this->conn = $this->connect($cfg['conn'],'odbc');
		$this->filter = new general();
		
	}


	public function login($_id, $_pass, $_dev=null)
	{
		$x = false;

		if ( $_dev )
		{
			$_SESSION['ses_id'] = 9999;
			$_SESSION['ses_name'] = 'dev';
			$_SESSION['ses_type'] = 'S';
			$x = true;
		}
		else
		{
			$id = $this->filter->text_clean($_id);
			$pass = $this->filter->text_clean($_pass);

			if ( $res = $this->check_user($id, md5($pass)) )
			{
				$_SESSION['ses_id'] = $res['id'];
				$_SESSION['ses_name'] = $this->filter->text_thai(iconv('TIS-620', 'UTF-8',$res['name']));
				$_SESSION['ses_type'] = $res['type'];
				$x = true;
			}
		}

		return $x;
	}


	public function check_user($id, $pass)
	{
		$sql =	"SELECT id as 'id'".
					", name as 'name'".
					", email as 'email'".
					", type as 'type'".
				" FROM dbo.users".
				" WHERE email='".$id."' AND password='".$pass."' AND disable=0";
var_dump($this->conn);
		if ( $exec = odbc_exec($this->conn, $sql) )
		{
			$obj = odbc_fetch_array($exec);
		}
		else
		{
			$obj = false;
		}
		
		return $obj;
	}


	// public function get_login_permit($emp)
	// {
	// 	$sql =	"SELECT pd.pmd_date as 'date'".
	// 				", p.pm_code as 'code'".
	// 				", p.pm_name_th as 'name_th'".
	// 				", p.pm_name_en as 'name_en'".
	// 			" FROM permit_detail pd".
	// 			" LEFT JOIN permit p ON p.pm_id = pd.pm_id".
	// 			" WHERE emp_id = ".$emp.
	// 			" ORDER BY pmd_date DESC";

	// 	return $this->res($sql);
	// }


	// public function __destruct()
	// {
	// 	unset($this->db);
	// 	unset($this->table);
	// }
}
?>