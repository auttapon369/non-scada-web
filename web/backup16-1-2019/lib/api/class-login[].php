<?php
class login extends sql
{			
	//private $conf;
	private $filter;

	public function __construct()
	{
		$this->filter = new general();
	}


	public function get_login($_id, $_pass, $_dev=null)
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
			$id = $this->filter->text_clean(trim($_id));
			$pass = $this->filter->text_clean(trim($_pass));
					
			if ( $res = $this->check_user($id, md5($pass)) )
			{
				$_SESSION['ses_id'] = $res[0]['id'];
				$_SESSION['ses_name'] = $res[0]['name'];
				$_SESSION['ses_type'] = $res[0]['type'];
				$x = true;
			}
		}

		return $x;
	}


	public function check_user($id, $pass)
	{
		// $sql =	"SELECT w_id as 'id'".
		// 			", w_name as 'name'".
		// 			", w_email as 'email'".
		// 			", w_type as 'type'".
		// 		" FROM w_user".
		// 		" WHERE w_email='".$id."' AND w_pass='".$pass."' AND w_disable=0";

		return $this->res($sql);
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


	public function logout()
	{
		session_destroy();
		return header(PATH_ROOT);
	}


	// public function __destruct()
	// {
	// 	unset($this->db);
	// 	unset($this->table);
	// }
}
?>