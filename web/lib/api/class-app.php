<?php
class app extends general 
{			
	// define properties
	private $conf;
	private $sql;


	// constructor
	public function __construct()
	{
		global $cfg;
		$this->conf = $cfg;
	}


	// redirect
	public function page_direct($type, $get1, $get2=null, $act=null, $submit=null)
	{
		if ( $type == 'admin' )
		{
			$arr_file = array
			(
				'not'	=> PATH_PAGE."404.html",
				'ind'	=> $get1."/index.php",
				'view'	=> $get1."/".$get2.".php",
				'act'	=> $get1."/".$act.".php",
				'prc'	=> $get1."/process.php"
			);
		}
		else
		{
			$arr_file = array
			(
				'not'	=> PATH_PAGE."404.html",
				'ind'	=> PAGE."/".$get1."/index.php",
				'view'	=> PAGE."/".$get1."/".$get2.".php"
			);
		}

		$path = $arr_file['not'];

		if ( $get1 )
		{
			if ( $submit && file_exists($arr_file['prc']) )
			{
				$path = $arr_file['prc'];
			}
			else
			{
				if ( $get2 && file_exists($arr_file['view']) )
				{
					$path = $arr_file['view'];
				}
				else
				{
					$path = ( empty($act) && file_exists($arr_file['ind']) ) ? $arr_file['ind'] : $path;

					$path = ( !empty($act) && file_exists($arr_file['act']) ) ? $arr_file['act'] : $path;
				}
			}
		}

		return $path;
	}




	// ---------------------------------------------------------------- station
	public function get_station($id=null)
	{
		$data = array();

		for ($i=0; $i<38; $i++)
		{	
			if ( $i > 25 )
			{
				$z = "C";
				$c = 26;
			}
			else if ( $i > 14 )
			{
				$z = "B";
				$c = 15;
			}
			else
			{
				$z = "A";
				$c = 0;
			}

			$check_rf = rand(0,1) == 1;
			$check_wl_up = ($check_rf) ? rand(0,1) == 1 : true;
			$check_wl_down = ($check_wl_up) ? rand(0,1) == 1 : false;
			$check_cctv = rand(1,2);
			$timeout = rand(0,1) == 1;
			$door = rand(0,1) == 1;

			$data[$i] = array
			(
				"id" => "STN".($i+1),
				"code" => $z.($i+1-$c),
				"zone" => $z,
				"name" => "สถานีสูบน้ำคลองบางบุญนาค",
				"address" => "-",
				"cctv" => $this->gen_cctv($check_cctv),
				"location" => $this->gen_loc(),
				"terrain" => array
				(
					"bottom" => 0,
					"top" => 100
				),
				"data" => array
				(
					"rf" => array
					(
						"enable" => $check_rf,
						"value" => $this->gen_data($check_rf)
					),
					"wl_up" => array
					(
						"enable" => $check_wl_up,
						"value" => $this->gen_data($check_wl_up)
					),
					"wl_down" => array
					(
						"enable" => $check_wl_down,
						"value" => $this->gen_data($check_wl_down)
					)
				),
				"date" => date('Y-m-d H:i'),
				"timeout" => $timeout,
				"door" => $door
			);
		}

		return $data;
	}


	// generate data
	public function gen_data($res)
	{
		$arr = null;

		if ($res) 
		{
			$raw = rand(1,99)/100;
			$value = $raw + rand(0,10);
			$warning = $raw + 8.25;
			$danger = $raw + 9.125;

			if ( $value >= $danger )
			{
				$status = "danger";
			}
			else if ( $value >= $warning )
			{
				$status = "warning";
			}
			else
			{
				$status = "success";
			}

			$arr = array
			(
				"now" => $value,
				"warning" => $warning,
				"danger" => $danger,
				"status" => $status
			);
		}

		return $arr;
	}


	// generate cctv
	public function gen_cctv($res)
	{
		$arr = array();
		$path = "http://61.19.228.10/Process/LoadCCTVMotionImage?cctvId=";

		for ( $i = 0; $i < $res; $i ++ )
		{
			$n = rand(20,40);
			array_push($arr, $path.$n);
		}

		return $arr;
	}


	// generate location
	public function gen_loc()
	{
		$arr = array
		(
			"lat" => 13 + rand(100000,999999)/1000000,
			"lng" => 100 + rand(100000,999999)/1000000
		);

		return $arr;
	}



	public function get_search($id, $data, $format, $d1=null, $d2=null)
	{
		$arr = array();
		$dt = ( !empty($d1) ) ? $d1 : date('Y-m-d H:i');

		for ($i=0; $i<24; $i++)
		{
			$obj = array
			(
				'date' => $dt,
				'stn' => $this->gen_stn($id)
			);

			array_push($arr, $obj);
		}

		// foreach ($id as $v)
		// {	
		// 	$arr = array
		// 	(
		// 		"id" => $v,
		// 		"code" => $v,
		// 		"name" => "สถานีสูบน้ำคลองบางบุญนาค",
		// 		"list" => $this->gen_data_search($d1)
		// 		// "detail" => array
		// 		// (
		// 		// 	"data" => $data,
		// 		// 	"format" => $format,
		// 		// 	"list" => $this->gen_data_search($d1)
		// 		// )
		// 	);

		// 	array_push($obj, $arr);
		// }

		return $arr;
	}

	public function gen_stn($id)
	{
		$arr = array();

		// for ($i=0; $i<10; $i++)
		// {
		// 	$raw = rand(1,99)/100;
		// 	$value = $raw + rand(0,10);
		// 	$obj = array
		// 	(
		// 		'date' => $date,
		// 		'value1' => $value,
		// 		'value2' => $value
		// 	);

		// 	array_push($arr, $obj);
		// }

		foreach ($id as $v)
		{	
			$raw = rand(1,99)/100;
			$value = $raw + rand(0,10);
			$obj = array
			(
				"id" => $v,
				"code" => $v,
				"name" => "สถานีสูบน้ำคลองบางบุญนาค",
				'value1' => $raw,
				'value2' => $value
			);

			array_push($arr, $obj);
		}

		return $arr;
	}


	// destruct
    public function __destruct()
    {
		//unset($this->conf);
		//unset($this->table);
	}
}
?>