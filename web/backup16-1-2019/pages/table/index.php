<div class="row">
	<div class="col-lg-12 title">
		<h1 class="text-black">ข้อมูลการตรวจวัด<small>Realtime</small></h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<table id="realtime" class="table table-striped table-condensed table-hover text-center">
			<thead class="bg-black bd-fade">
				<tr>
					<th rowspan="2">สถานี</th>
					<th width="150" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
					<th colspan="2" width="150" class="bd-left">ปริมาณฝน (มม.)</th>
					<th colspan="4" class="bd-left">ระดับน้ำ (ม.รทก.)</th>
					<th colspan="3" class="bd-left">สถานการณ์</th>
				</tr>
				<tr>
					<th colspan="2" width="100" class="bd-left">15 นาที</th>
					<th colspan="2" width="100" class="bd-left">หน้า</th>
					<th colspan="2" width="100">ท้าย</th>
					<th width="100" class="bd-left">ปริมาณน้ำฝน</th>
					<th width="100">ระดับน้ำ</th>
					<th width="100">ระดับน้ำ (ท้าย)</th>
				</tr>
			</thead>
			<tbody>
				<!-- 
				<tr>
					<td width="200">{{s.code+' '+s.name}}</td>
					<td width="200" class="text-center bd-left date">{{s.date}}</td>
					<td class="text-center bd-left">{{s.data.rf.value.now}}</td>
					<td class="text-center">-</td>
					<td class="text-center">-</td>
					<td class="text-center bd-left">{{s.data.wl_up.value.now}}</td>
					<td class="text-center">{{s.data.wl_down.value.now}}</td>
				</tr> 
				-->
			</tbody>
		</table>
	</div>
</div>
<!-- 
page home (real-time) 
- show สถานะการเปลี่ยน เพิ่ม ลด
- show สถานะการส่งค่าล่าสุด 
-->
<!-- script -->
<link href="<?php echo PATH_PLUGIN; ?>googlemap/map.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery.signalR-2.2.0.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>realtime.js?v=16.6.13"></script>
<script src="<?php echo PATH_SIGNALR; ?>"></script>
<script>
$(document).ready
(
	function() 
    {
    	loadData(STATION, 'realtime');
    	update();
    }
);
</script>