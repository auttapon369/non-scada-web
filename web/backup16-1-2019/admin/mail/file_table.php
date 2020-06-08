<?php
include('../function.php');
//$original_mem = ini_get('memory_limit');
 
// then set it to the value you think you need (experiment)
//ini_set('memory_limit','640M');
 
//ini_set('max_execution_time', 900);
// Include the main TCPDF library (search for installation path).
include('tcpdf/tcpdf.php');
include("tcpdf/class/class_curl.php");

$i = 0;
$n = 0;
$page = 0;

$today = date('Y-m-d');
$time = "08:00";

//$aname=$nametype."-".$stationss."-".$name;
$aname="report";
$an=str_replace(" ","",$aname);

$aname=$name;
$an=str_replace(" ","",$aname);

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

//$pdf->setBuffer(128M);
// กำหนดรายละเอียดของไฟล์ pdf
$pdf->SetCreator(PDF_CREATOR);

$pdf->setFooterData(
    array(0,64,0),  // กำหนดสีของข้อความใน footer rgb 
    array(220,44,44)   // กำหนดสีของเส้นคั่นใน footer rgb 
);

// กำหนดฟอนท์ของ header และ footer  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// ำหนดฟอนท์ของ monospaced  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// กำหนดขอบเขตความห่างจากขอบ  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// กำหนดแบ่่งหน้าอัตโนมัติ
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// กำหนดสัดส่วนของรูปภาพ  กำหนดเพิ่มเติมในไฟล์  tcpdf_config.php 
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// อนุญาตให้สามารถกำหนดรุปแบบ ฟอนท์ย่อยเพิมเติมในหน้าใช้งานได้
$pdf->setFontSubsetting(true);

// กำหนด ฟอนท์
$pdf->SetFont('thsarabun', '', 14, '', true);
// เพิ่มหน้า 

$pdf->AddPage('L', 'LETTER');
ob_start();
?>
<HTML xmlns="http://www.w3.org/TR/REC-html40">
<HEAD>
    <meta charset="utf-8">
	<LINK HREF="http://182.52.224.70/admin/css/reset.css" REL="stylesheet" TYPE="text/css" MEDIA="all" />
	<LINK HREF="http://182.52.224.70/admin/css/admin.css" REL="stylesheet" TYPE="text/css" MEDIA="all" />
	<link href="http://182.52.224.70/lib/script/bootstrap/css/bootstrap.min.css" rel="stylesheet"/>
    <script src="http://182.52.224.70/lib/script/jquery/jquery-1.11.2.min.js"></script>
    <script src="http://182.52.224.70/lib/script/bootstrap/js/bootstrap.min.js"></script>
</HEAD>
<BODY>
	<DIV>
		<H3>รายงานสรุปข้อมูลประจำวัน</H3>
	<DIV align="left">ข้อมูลย้อนหลัง 24 ชั่วโมง (ณ เวลา 08:00)</DIV> 
	<DIV align="right"><?php echo date_thai($today) ?></DIV></DIV>
      <table border="1">
			<TR class="active"> 
				<TH rowspan="2">รหัส</TH>
				<TH rowspan="2">ชื่อสถานี</TH>
				<TH colspan="2">ปริมาณน้ำฝน</TH>
				<TH colspan="2">ระดับน้ำหน้าประตู</TH>
				<TH colspan="2">ระดับน้ำหลังประตู</TH>
		    </TR>
			<TR class="active"> 
				<TH>สะสม</TH>
				<TH>สูงสุด</TH>
				<TH>ต่ำสุด</TH>
				<TH>สูงสุด</TH>
				<TH>ต่ำสุด</TH>
				<TH>สูงสุด</TH>
		    </TR>
		<TBODY>
<?php

		$sql_stn = "SELECT * FROM TM_STN ORDER BY LOC_ID ";
		$res_stn = odbc_exec($connection,$sql_stn);

		$wheredt="DT between dateAdd(dd, -1, convert(varchar(16),(convert(varchar(10),(GETDATE()),120)+' 08:01'),120))
			and dateAdd(dd,0,convert(varchar(16),(convert(varchar(10),(GETDATE()),120)+' 08:01'),120)) ";

		while ( $arr_stn = odbc_fetch_array($res_stn) )
		{
			echo "<TR>\n";
			echo "<TH align=\"CENTER\">".$arr_stn['STN_CODE']."</TH>\n";
			echo "<TH align=\"CENTER\">".iconv('TIS-620', 'UTF-8',$arr_stn['STN_NAME_THAI'])."</TH>\n";

			$sum_rf = "SELECT STN_ID,SUM(RF_15MIN) sumrf FROM row_data	where STN_ID='".$arr_stn['STN_ID']."' and ".$wheredt."
			Group by STN_ID ";
			$ress_rf = odbc_exec($connection,$sum_rf);
			$arrs_rf = odbc_fetch_array($ress_rf);

			$max_rf = "select top 1 STN_ID ,RF_15MIN maxrf,DT from row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt."  and RF_15MIN=(SELECT max(RF_15MIN) data FROM row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt." )	order by DT desc ";
			$resm_rf = odbc_exec($connection,$max_rf);
			$arrm_rf = odbc_fetch_array($resm_rf);

			$min_wlu = "select top 1 STN_ID ,WL_UP wlu_min,DT from row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt."  and WL_UP=(SELECT min(WL_UP) wlu_min FROM row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt." )	order by DT desc ";
			$resmin_wlu = odbc_exec($connection,$min_wlu);
			$arrmin_wlu = odbc_fetch_array($resmin_wlu);

			$max_wlu = "select top 1 STN_ID ,WL_UP wlu_max,DT from row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt."  and WL_UP=(SELECT max(WL_UP) wlu_max FROM row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt." )	order by DT desc ";
			$resmax_wlu = odbc_exec($connection,$max_wlu);
			$arrmax_wlu = odbc_fetch_array($resmax_wlu);

			$min_wld = "select top 1 STN_ID ,WL_DOWN wld_min,DT from row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt."  and WL_DOWN=(SELECT min(WL_DOWN) wld_min FROM row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt." )	order by DT desc ";
			$resmin_wld = odbc_exec($connection,$min_wld);
			$arrmin_wld = odbc_fetch_array($resmin_wld);

			$max_wld = "select top 1 STN_ID ,WL_DOWN wld_max,DT from row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt."  and WL_DOWN=(SELECT max(WL_DOWN) wld_max FROM row_data where STN_ID='".$arr_stn['STN_ID']."'  
			and ".$wheredt." )	order by DT desc ";
			$resmax_wld = odbc_exec($connection,$max_wld);
			$arrmax_wld = odbc_fetch_array($resmax_wld);

			
			/*$sumrf = check_value($arrm_rf['sumrf']).' <br>('.date_simple($arrm_rf['DT'],'f').') ';
			$min_wlu = check_value($arrmin_wlu['wlu_min']).' <br>('.date_simple($arrmin_wlu['DT'],'f').') ';
			$max_wlu = check_value($arrmax_wlu['wlu_max']).' <br>('.date_simple($arrmax_wlu['DT'],'f').') ';
			$min_wld = check_value($arrmin_wld['wld_min']).' <br>('.date_simple($arrmin_wld['DT'],'f').') ';
			$max_wld = check_value($arrmax_wld['wld_max']).' <br>('.date_simple($arrmax_wld['DT'],'f').') '; */

			$sumrf=(empty($arrs_rf['sumrf'])) ? "" : check_value($arrs_rf['sumrf']);

			$maxrf=(empty($arrm_rf['maxrf'])) ? "" : check_value($arrm_rf['maxrf']).' <br>('.date_simple($arrm_rf['DT'],'f').') ';

			$min_wlu=(empty($arrmin_wlu['wlu_min'])) ? "" : check_value($arrmin_wlu['wlu_min']).' <br>('.date_simple($arrmin_wlu['DT'],'f').') ';

			$max_wlu=(empty($arrmax_wlu['wlu_max'])) ? "" : check_value($arrmax_wlu['wlu_max']).' <br>('.date_simple($arrmax_wlu['DT'],'f').') ';

			$min_wld=(empty($arrmin_wld['wld_min'])) ? "" : check_value($arrmin_wld['wld_min']).' <br>('.date_simple($arrmin_wld['DT'],'f').') ';

			$max_wld=(empty($arrmax_wld['wld_max'])) ? "" : check_value($arrmax_wld['wld_max']).' <br>('.date_simple($arrmax_wld['DT'],'f').') ';
			
			echo "<TH class=\"active\" align=\"CENTER\">".$sumrf."</TH>\n";
			echo "<TH class=\"active\" align=\"CENTER\">".$maxrf."</TH>\n";
			echo "<TH class=\"active\" align=\"CENTER\">".$min_wlu."</TH>\n";
			echo "<TH class=\"active\" align=\"CENTER\">".$max_wlu."</TH>\n";
			echo "<TH class=\"active\" align=\"CENTER\">".$min_wld."</TH>\n";
			echo "<TH class=\"active\" align=\"CENTER\">".$max_wld."</TH>\n";			

			echo '</TR>';
		}
?>
		</TBODY>
	</TABLE>
</BODY>
</HTML>
<?php

$HTMLoutput = ob_get_contents();

//$pdf->writeHTMLCell(0, 0, '', '', $HTMLoutput, 0, 1, 0, true, '', true);
$pdf->writeHTML($HTMLoutput, true, false, true, false, '');
ob_end_clean();
//ob_clean();
//ob_flush();
//flush(); 
 
// แสดงไฟล์ pdf
$pdf->Output("report.pdf", 'F');
//ini_set('memory_limit',$original_mem);

header( "location: msentmail.php");
?>