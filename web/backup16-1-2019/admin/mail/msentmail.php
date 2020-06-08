<?php
header("content-type: text/html; charset=utf-8");
//<meta http-equiv="Content-type" content="text/html;charset=utf-8" />
//include "../../class/index.php";
include('../function.php');

include("class.phpmailer.php");
$DTNOW=date('d-m-Y');

$sql="SELECT group_id, group_name, group_massage, parameter, alarm_level FROM group_user_sms";
$result = odbc_exec($connection,$sql);
while($roww=odbc_fetch_array($result))
{
	$rowid = $roww['group_id'];	
	//$group_mail=$roww['group_mail'];
	//$group_detail=$roww['group_detail'];
	$time_mail="09:15";

	$DT=date('H:i');
	$DTsend=strtotime($time_mail);

	//$test=strtotime('09:40');

	$startTime = date("H:i",strtotime('-5 minutes',$DTsend));
	$endTime = date("H:i",strtotime('+5 minutes',$DTsend));

	if($DT > $startTime and $DT < $endTime)
	{
			$sqllog="Select id, email, telnum, group_id, status FROM users_sms where status= 'Y'";
			$resultlog = odbc_exec($connection,$sqllog);
			$arr_name=array();
			while($res=odbc_fetch_array($resultlog))
			{
				//$txt1=iconv('TIS-620', 'UTF-8',$roww['group_alert']);
				$list_name=$res['email'];
				$txt=iconv('TIS-620', 'UTF-8',"สรุปรายงานประจำวัน  วันที่ ");
				sendmail_welcome($list_name,$txt) ;
			}
			//$list_name=implode(",",$arr_name);
			//$txt=iconv('TIS-620', 'UTF-8',"สรุปรายงานการประปานครหลวงประจำวัน  วันที่ ");
			//sendmail_welcome($list_name,$txt) ;
			
	}
	else
	{
		echo "no sendmail";
	}
}

	//***************************

function sendmail_welcome($list_name,$txt)
{
	//echo $list_name;
	$d = date('d');
	$m = date('m');
	$y = date('Y')+543;
	$H = date('H:i');
	$newy = substr($y,2,2);
	$DTname = $d."/".$m."/".$y;

	$mail = new PHPMailer(); 
	$mail->IsSMTP(); 
	$mail->IsHTML(true);
	//$mail->Host = 'ssl://smtp.gmail.com'; 
	$mail->Port = 587; 
	$mail->Host = "smtp.gmail.com"; // GMAIL's SMTP server
	//$mail->SMTPDebug = 2;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true; 
	$mail->Username = 'eexpert.ata@gmail.com'; //อีเมล์ของคุณ (Google App)
	$mail->Password = 'ata+ee&c'; //รหัสผ่านอีเมล์ของคุณ (Google App)
	$mail->From ="eexpert.ata@gmail.com"; // ใครเป็นผู้ส่ง
	$mail->FromName = "webadmin"; // ชื่อผู้ส่งสักนิดครับ
	$mail->Subject  = ''.$txt.$DTname.'';
	$mail->Body     = "</b>"; 
	$mail->AltBody =  $message_body;
	//$mail->AddAddress('"'.$list_name.'"'); // ส่งไปที่ใครดีครับ
	$mail->AddAddress('nuchanad_k@adv-tek.net'); // ส่งไปที่ใครดีครับ
	$mail->AddAttachment("report.pdf");
	
	//$mail->Send(); 
	if(!$mail->Send())
	{
		echo "Mailer Error: " . $mail->ErrorInfo;
	}
	else
	{
		echo "Message has been sent";
	}
}

/*
function para($id)
{
if($id=='1'){return $a="pH";}elseif($id=='2'){return $a="ORP";}elseif($id=='3'){return $a="TU";}
elseif($id=='4'){return $a="DO";}elseif($id=='5'){return $a="TU";}elseif($id=='6'){return $a="Temp";}
elseif($id=='7'){return $a="Water Level";}elseif($id=='8'){return $a="Flow";}elseif($id=='9'){return $a="Salinity";}
elseif($id=='10'){return $a="Pump";}
}

function getSiteNameID($id)
{
	$sql = "select site_ID,site_name from [dbo].[TM_site] where site_ID = '$id'";
	$result = mssql_query($sql);
	$row = mssql_fetch_array($result);
	return iconv('TIS-620', 'UTF-8',$row[site_name]);
}
*/
?>