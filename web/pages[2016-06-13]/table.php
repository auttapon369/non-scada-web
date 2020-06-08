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
					<th width="200" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
					<th colspan="1" class="bd-left">ปริมาณฝน (มม.)</th>
					<th colspan="2" class="bd-left">ระดับน้ำ (ม.รทก.)</th>
				</tr>
				<tr>
					<th width="100" class="bd-left">15 นาที</th>
					<!-- <th width="100" >1 ชม.</th>
					<th width="100">24 ชม.</th> -->
					<th width="100" class="bd-left">หน้า</th>
					<th width="100">หลัง</th>
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

<!-- script -->
<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery.signalR-1.2.2.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>jquery/table.js?v=1"></script>
<script src="<?php echo PATH_SIGNALR; ?>"></script>
<!-- 
page home (real-time) 
- show สถานะการเปลี่ยน เพิ่ม ลด
- show สถานะการส่งค่าล่าสุด 
-->