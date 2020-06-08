<script type="text/javascript" src="../../pages/report/tableExport/libs/FileSaver/FileSaver.min.js"></script>
<script type="text/javascript" src="../../pages/report/tableExport/tableExport.js"></script>
  <script type="text/javascript" src="../../pages/report/tableExport/libs/jsPDF/jspdf.min.js"></script>
  <script type="text/javascript" src="../../pages/report/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript" src="../../pages/report/tableExport/libs/html2canvas/html2canvas.min.js"></script>
  <script type="text/javaScript">
	
    function doExport(selector, params) {
      
		
		 var options = {
        //ignoreRow: [1,11,12,-2],
        //ignoreColumn: [0,-1],
        tableName: 'Countries',
        worksheetName: 'Countries by population'
      };

      $.extend(true, options, params);

      $(selector).tableExport(options);

			
    }
    
    function DoOnCellHtmlData(cell, row, col, data) {
      var result = "";
      if (data != "") {
        var html = $.parseHTML( data )

        $.each( html, function() {
          if ( typeof $(this).html() === 'undefined' )
            result += $(this).text();
          else if ( $(this).is("input") )
            result += $('#'+$(this).attr('id')).val();
          else if ( ! $(this).hasClass('no_export') )
            result += $(this).html();
        });
      }
      return result;
    }

    function DoOnMsoNumberFormat(cell, row, col) {
      var result = "";
      if (row > 2 && col == 0)
        result = '\\@';
      return result;
    }

  </script>

<script>
$(document).ready
(
	function() 
    {
        $('.input-daterange').datepicker
        (
            {
                format: "dd/mm/yyyy",
                language: "th",
                autoclose: true,
                todayHighlight: true
            }
        );

        $("#start").datepicker("setDate", new Date());
	}
);
</script>
<FORM METHOD="post">
<?php
if ( $_POST['search'] )
{
	$date1 = ( empty($_GET['date1']) ) ? date("Y-m-d",strtotime(str_replace('/','-',$_POST['start']))) : $_GET['date1'];
	$date2 = ( empty($_GET['date2']) ) ? date("Y-m-d",strtotime(str_replace('/','-',$_POST['end']))) : $_GET['date2'];
	$stn = ( empty($_GET['stn']) ) ? $_POST['inp_stn'] : $_GET['stn'];
}
else
{
	$date1 = date('Y-m-d');
	$date2 = date('Y-m-d');
	$stn = "STN16";
}
if ( $date1 == $date2 )
{
	$namedate = " ณ วันที่ ".date_thai($date1);
}
else
{
	$namedate = " ระหว่างวันที่ ".date_thai($date1)." - ".date_thai($date2);
}
?>
<DIV class="well">
	<TABLE CLASS="noborder">
	<TR>
		<TD>
			<LABEL FOR="inp_stn">เลือกสถานี</LABEL>
			<div>
			<SELECT ID="inp_stn" NAME="inp_stn">
			<?php echo getstn($stn ,$connection) ?>
			</SELECT>
			</div>
		</TD>
		<TD>		
			<label for="inp-date-1">เลือกช่วงวันที่</label>
			<div class="input-daterange input-group" id="datepicker">
				<input id="start" type="text" class="input-sm form-control" name="start" value="<?php echo $date1 ?>" />
				<span class="input-group-addon">to</span>
				<input id="end" type="text" class="input-sm form-control" name="end" value="<?php echo $date2 ?>"/>
			</div>
		</TD>
		<TD>
			<BR>
			<INPUT TYPE="submit" NAME="search" CLASS="b_green" VALUE="ค้นหา" />
		</TD>
		<TD>
		<a href="#" class="list-group-item" onClick="doExport('#pvtTable', {type: 'excel', excelstyles: ['background-color', 'color', 
                                                                                      'border-bottom-color', 'border-bottom-style', 'border-bottom-width', 
                                                                                      'border-top-color', 'border-top-style', 'border-top-width', 
                                                                                      'border-left-color', 'border-left-style', 'border-left-width',
                                                                                      'border-right-color', 'border-right-style', 'border-right-width',
                                                                                      'font-family', 'font-size', 'font-weight']
                                                        });"><img src='http://demos.w3lessons.info/assets/images/icons/xls.png' width="24"/> XLS</a>
		</TD>
	</TR>
</TABLE>
</DIV>
<H4><?php echo "ข้อมูลของสถานี".get_name($stn,$connection)."<BR>"?></H4>
<H5><?php echo $namedate ?></H5>
<TABLE class="table table-striped" id="pvtTable"> 
	<THEAD>
		<TR class="info">
			<TH>วัน-เวลา</TH>
			<TH>ปริมาณน้ำฝน</TH>
			<TH>ระดับน้ำหน้าประตู</TH>
			<TH>ระดับน้ำหลังประตู</TH>
		</TR>
	</THEAD>
	<TBODY>
	<?php
	$sql = "SELECT * FROM row_data WHERE STN_ID = '".$stn."' AND DT BETWEEN '".$date1." 00:00' AND '".$date2." 23:45' AND datepart(MINUTE, DT ) %15 =0 ORDER BY DT";
	$res = odbc_exec($connection,$sql);
	$num = odbc_num_rows($res);
	while ( $arr = odbc_fetch_array($res) )
	{		
		$_stn=$arr['STN_ID'];
		$_date=$arr['DT'];

		$_value=get_mm($_stn,$connection);
		$_rfw=$_value[0];
		$_rfd=$_value[1];
		$_wlw=$_value[2];
		$_wld=$_value[3];
		$_wl2w=$_value[4];
		$_wl2d=$_value[5];

		$_rf=check_limit($arr['RF_15MIN'],$_rfw,$_rfd);
		$_wlu=check_limit($arr['WL_UP'],$_wlw,$_wld);
		$_wld=check_limit($arr['WL_DOWN'],$_wl2w,$_wl2d);

		echo "<TR>\n";
		echo "<TD>".date_simple($_date, "f")."</TD>\n";
		echo "<TD><font color='".$_rf."'>".check_value($arr['RF_15MIN'])."</font></TD>\n";
		echo "<TD><font color='".$_wlu."'>".check_value($arr['WL_UP'])."</font></TD>\n";
		echo "<TD><font color='".$_wld."'>".check_value($arr['WL_DOWN'])."</font></TD>\n";
		echo '</TR>';
	}
	?>
	</TBODY>
</TABLE>
<DIV CLASS="box">
	<P>*** เมื่อการตรวจวัดค่าพารามิเตอร์นั้น ถึงเกณฑ์ที่กำหนดไว้ ระบบจะแสดงค่าตัวเลขเป็น <font color="#FFCC33">สีเหลืองเมื่อถึงเกณฑ์เตือนภัย</font> และ <font color="red">สีแดงเมื่อถึงเกณฑ์วิกฤต</font> </P>
<!--
	<P>ขีด (-)						หมายถึง ไม่ได้ติดตั้งอุปกรณ์ตรวจวัด ซึ่งที่หน้าเว็บไซต์หลัก จะแสดงข้อความว่า "n/a"</P>
	<P>0 - 0.25					หมายถึง ค่าที่ตรวจวัดได้ต้องน้อยกว่า 0.25 ซึ่งที่หน้าพิมพ์รายงานตารางข้อมูล จะแสดงข้อความว่า "< 0.25"</P>
	<P>3.00 - 9999				หมายถึง ค่าที่ตรวจวัดได้ต้องมากกว่า 3.00 หรือ > 3.00</P>
	<P>0 - 9999					หมายถึง การไม่จำกัด ค่าต่ำ ค่าสูง, การปล่อยให้ค่าที่ตรวจวัดได้มีอิสระในการแสดงข้อมูล</P>
	<P>ค่าต่ำสุดเท่ากับ 0			หมายถึง การไม่กำหนด เกณฑ์ขั้นต่ำ</P>
	<P>ค่าสูงสุดเท่ากับ 9999		หมายถึง การไม่กำหนด เกณฑ์ขั้นสูง</P>
-->
</DIV>
</FORM>
<?php
function get_mm($stn,$connection)
{    
	$sqlal = "SELECT stn.STN_ID, stn.STN_CODE, stn.STN_NAME_THAI
					,Sum(case when  Sensor_Type='100' and Level_alarm='1' then Value  end) rfw
					,Sum(case when  Sensor_Type='100' and Level_alarm='2' then Value  end) rfd
					,Sum(case when  Sensor_Type='200' and Level_alarm='1' then Value  end) wlw
					,Sum(case when  Sensor_Type='200' and Level_alarm='2' then Value  end) wld
					,Sum(case when  Sensor_Type='201' and Level_alarm='1' then Value  end) wl2w
					,Sum(case when  Sensor_Type='201' and Level_alarm='2' then Value  end) wl2d
					FROM TM_STN stn JOIN TM_Alarm al  
					on stn.STN_ID = al.STN_ID  
					where stn.STN_ID='".$stn."'
					Group by stn.STN_ID, stn.STN_CODE, stn.STN_NAME_THAI";
	$resal = odbc_exec($connection, $sqlal);
	$rowal = odbc_fetch_array($resal); 

	$mm[0]=$rowal['rfw'];
	$mm[1]=$rowal['rfd'];
	$mm[2]=$rowal['wlw'];
	$mm[3]=$rowal['wld'];
	$mm[4]=$rowal['wl2w'];
	$mm[5]=$rowal['wl2d'];

	return $mm;
}

function check_limit($value, $min ,$max)
{

	if ( $value > $min && $value < $max)
	{
		$x = "#FFCC33";
	}
	else if ( $value > $max )
	{
		$x = "red";
	}
	else
	{
		$x = "";
	}


	return $x;
}

function limit_mm($min ,$max)
{    
	$min = ( $min != "0" ) ? $min : '< ';
	$max = ( $max != "9999" ) ? $max : '> ';

	if ( is_numeric($min) AND is_numeric($max) )
	{
		$x = $min.' - '.$max;
	}
	else if ( is_numeric($min) AND !is_numeric($max) )
	{
		$x = $max.$min;
	}
	else if ( !is_numeric($min) AND is_numeric($max) )
	{
		$x = $min.$max;
	}
	else
	{
		$x = '-';
	} 
	
	return $x;
}
?>