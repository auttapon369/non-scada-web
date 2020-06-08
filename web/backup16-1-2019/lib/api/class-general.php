<?php
class general
{	
	private $month = array
	(
		"th" => array
		(
			"f" => array
			(
				"","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"
			),
			"s" => array
			(
				"","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค."
			)
		),
		"en" => array
		(
			"f" => array(),
			"s" => array()
		)
	);


	public function __construct()
	{
		//
	}


	//------------------------------------------------------------------- #DATE
	
	public function date_short($text, $date="-")
	{
		if ($text)
		{
			$x = explode(' ', $text);
			$d = explode('-', $x[0]);
			$t = substr($x[1], 0, -3);
			$date = (int)$d[2]."/".(int)$d[1]."/".$d[0].", ".$t;
		}

		return $date;
	}

	public function date_thai($text)
	{
		$strYear = date("y",strtotime($text))+43;
		$strMonth = date("n",strtotime($text));
		//$strMonth = date("m",strtotime($text));
		//$strDay = date("j",strtotime($text));
		$strDay = date("d",strtotime($text));
		$strHour = date("H",strtotime($text));
		$strMinute = date("i",strtotime($text));
		$strSeconds = date("s",strtotime($text));
		$strMonthThai = $strMonthCut[$strMonth];
		
		if ( count(explode('-', $text)) == 3 )
		{
			$time = explode(' ', $text);
			$t = ( count($time) == 2 ) ? $time[1] : '';

			//return $template = $strDay."/".$strMonth."/".$strYear.' '.$t;
			$date = (int)$strDay." ".$this->month['th']['f'][$strMonth]." ".$strYear;
		}
		else
		{
			$date = '-';
		}

		return $date;
	}


	//------------------------------------------------------------------- #TEXT
	
	public function text_thai($text)
	{
		$text = trim($text);
		$text = iconv('TIS-620', 'UTF-8', $text);

		return $text;
	}

	public function text_html($text)
	{
		$text = trim($text);
		$text = stripslashes($text);
		$text = preg_replace("/\"/", "", $text);
		$text = preg_replace("/[\n\r\f]+/m", '\n', $text);

		return $text;
	}
	
	public function text_clean($text)
	{
		// Replaces all spaces with hyphens.
		$text = trim($text);
		$text = str_replace(' ', '-', $text);

		// Removes special chars.
		$text = preg_replace('/[^A-Za-z0-9\-\*\@\_\.]/', '', $text);
		
		// Replaces multiple hyphens with single one.
		$text = preg_replace('/-+/', '-', $text);

		return $text;
	}

	public function text_check($text, $type=null)
	{
		$text = trim($text);
		$text = str_replace(' ', '', $text);
		
		if ( $type === "email" && !filter_var($text, FILTER_VALIDATE_EMAIL) )
		{
  			$res = false;
		}
		else if ( $type === "phone" && ( !ctype_digit($text) || strlen($text)!=10 ) )
		{
			$res = false;
		}
		else if ( $type === "zip" && ( !ctype_digit($text) || strlen($text)!=5 ) )
		{
			$res = false;
		}		
		else if ( $type === "num" && !ctype_digit($text) )
		{
			$res = false;
		}
		else
		{
			$res = true;
		}

		return $res;
	}


	//----------------------------------------------------------------- #Images

	public function img_exist($dir, $photo)
	{
		$exp = explode('?', $photo);
		$path = $dir.$exp[0];

		if ( empty($photo) || !file_exists($path) )
		{
			$exp = explode('/', $dir);
			$root = ( $exp[0] == ".." ) ? "../" : null;		
			$img = $root."temp/img/no_photo.gif";
		}
		else
		{
			$img = $dir.$photo;
		}

		return $img;
	}


	function __destruct()
	{
		//clearstatcache();	
	}
}
?>