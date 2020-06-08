<div class="row">
	<div class="col-lg-12 title">
		<h1 class="text-black">โครงการติดตั้งระบบศูนย์ป้องกันและแก้ไขปัญหาน้ำท่วม<small>ภายในเขตเทศบาลนครนนทบุรี</small></h1>
	</div>
</div>


<div class="row">


<ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">ระดับน้ำผิวถนน</a></li>
    <li><a data-toggle="tab" href="#rf">ปริมาณน้ำฝน</a></li>
    <li><a data-toggle="tab" href="#wl">ระดับน้ำประตูระบายน้ำ</a></li>
    
  </ul>

<DIV class="tab-content" ng-app="realApp" ng-controller="realtime">

	<div class="col-md-7 tab-pane fade in active" id="home">
		<table id="realtime" class="table table-striped table-condensed table-hover text-center small">
			<thead class="bg-black bd-fade">
				<tr>
					<th rowspan="2">สถานี</th>
					<th width="100" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
					<!-- <th colspan="2" width="150" class="bd-left">ปริมาณฝน <small>(มม.)</small></th> -->
					<th id="wl_header"  colspan="2" class="bd-left">ระดับน้ำ <small>(ม.)</small></th>
					<th colspan="3" class="bd-left">สถานการณ์</th>
				</tr>
				<tr>
					<!-- <th colspan="2" class="bd-left">15 นาที</th> -->
					<th colspan="2" width="100" class="bd-left">ผิวถนน</th>
					<!-- <th colspan="2" width="100">ท้าย</th>-->					
					<!-- <th width="35" class="bd-left"><span class="glyphicon glyphicon-cloud"></span></th> -->
					<th colspan="2" width="35"><span class="glyphicon glyphicon-tint"></span></th>
					<!-- <th width="35"><span class="glyphicon glyphicon-tint"></span></th> -->
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="(key,event) in realtime | orderBy:['-data.wl_up.value.now']">
					<td class="text-left"><a href="./?page=station&id={{event.code}}"> {{event.code}} {{event.name}}</td>
					<td id="date-{{event.id}}" class="bd-left">{{event.date}}</td>
					<td id="wl-up-{{event.id}}" class="bd-left text-right">{{event.data.wl_up.value.now | number:2 }}</td>
					<td width="25">
					<span id="wl-up-arrow-up-{{event.id}}" class="glyphicon glyphicon-arrow-up text-info" ng-style="{'display': (event.data.wl_up.value.now > event.data.wl_up.value.old) ? 'inline' : 'none'}"></span>
					<span id="wl-up-arrow-down-{{event.id}}" class="glyphicon glyphicon-arrow-down text-fade" ng-style="{'display': (event.data.wl_up.value.now < event.data.wl_up.value.old) ? 'inline' : 'none'}"></span>
					</td>
					<td><span id="wl-up-status-{{event.id}}" class="icon wl {{event.data.wl_up.value.status}}"></span></td>
				</tr> 
			</tbody>
		</table>
	</div>

		<div class="col-md-7 tab-pane fade" id="rf">
		<table id="realtimerf" class="table table-striped table-condensed table-hover text-center small">
			<thead class="bg-black bd-fade">
				<tr>
					<th rowspan="2">สถานี</th>
					<th width="100" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
					<th  id="rf_header" colspan="4" width="150" class="bd-left">ปริมาณฝนสะสม <small>(มม.)</small></th>
					<!-- <th colspan="4" class="bd-left">ระดับน้ำ <small>(ม.รทก.)</small></th> -->
					<th colspan="3" class="bd-left">สถานการณ์</th>
				</tr>
				<tr>
					<th colspan="2" class="bd-center">ย้อนหลัง 1 ชั่วโมง</th>
					<th colspan="2" class="bd-center">ย้อนหลัง 1 วัน</th>
					<!-- <th colspan="2" width="100">ท้าย</th> -->
					<th colspan="3" width="35" class="bd-left"><span class="glyphicon glyphicon-cloud"></span></th>
					<!-- <th width="35"><span class="glyphicon glyphicon-tint"></span></th>
					<th width="35"><span class="glyphicon glyphicon-tint"></span></th> -->
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="(key,event) in realtimerf | orderBy:['-data.rf.value.day','-data.rf.value.now']">
					<td class="text-left"><a href="./?page=station&id={{event.code}}">{{event.code}} {{event.name}}</td>
					<td id="date-{{event.id}}" class="bd-left">{{event.date}}</td>
					<td id="rf-{{event.id}}" class="bd-left text-right">{{event.data.rf.value.now | number:2 }}</td>
					<td width="25">
					<span id="rf-arrow-up-{{event.id}}" class="glyphicon glyphicon-arrow-up text-info" ng-style="{'display': (event.data.rf.value.now > event.data.rf.value.old) ? 'inline' : 'none'}"></span>
					<span id="rf-arrow-down-{{event.id}}" class="glyphicon glyphicon-arrow-down text-fade" ng-style="{'display': (event.data.rf.value.now < event.data.rf.value.old) ? 'inline' : 'none'}"></span>
					</td>
					<td id="rfday-{{event.id}}" class="bd-left text-right">{{event.data.rf.value.day | number:2 }}</td>
					<td width="25"></td>
					<td class="bd-left">
					<span id="rf-status-{{event.id}}" class="icon rf {{event.data.rf.value.status}}"></span>
					</td>
				</tr> 
			</tbody>
		</table>
	</div>

		<div class="col-md-7 tab-pane fade" id="wl">
		<table id="realtimewl" class="table table-striped table-condensed table-hover text-center small">
			<thead class="bg-black bd-fade">
				<tr>
					<th rowspan="2">สถานี</th>
					<th width="100" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
					<!-- <th colspan="2" width="150" class="bd-left">ปริมาณฝน <small>(มม.)</small></th> -->
					<th colspan="4" class="bd-left">ระดับน้ำ <small>(ม.รทก.)</small></th>
					<th colspan="3" class="bd-left">สถานการณ์</th>
				</tr>
				<tr>
					<!-- <th colspan="2" class="bd-left">15 นาที</th> -->
					<th colspan="2" width="100" class="bd-left">หน้า</th>
					<th colspan="2" width="100">ท้าย</th>
					<!-- <th width="35" class="bd-left"><span class="glyphicon glyphicon-cloud"></span></th> -->
					<th width="35"><span class="glyphicon glyphicon-tint"></span></th>
					<th width="35"><span class="glyphicon glyphicon-tint"></span></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat="(key,event) in realtimewl">
					<td class="text-left"><a href="./?page=station&id={{event.code}}">{{event.code}} {{event.name}}</td>
					<td id="date-{{event.id}}" class="bd-left">{{event.date}}</td>
					<td id="wl-up-{{event.id}}" class="bd-left text-right">{{event.data.wl_up.value.now}}</td>
					<td width="25">
					<span id="wl-up-arrow-up-{{event.id}}" class="glyphicon glyphicon-arrow-up text-info" ng-style="{'display': (event.data.wl_up.value.now > event.data.wl_up.value.old) ? 'inline' : 'none'}"></span> 
					<span id="wl-up-arrow-down-{{event.id}}" class="glyphicon glyphicon-arrow-down text-fade" ng-style="{'display': (event.data.wl_up.value.now < event.data.wl_up.value.old) ? 'inline' : 'none'}"></span>
					</td>
					<td id="wl-down-{{event.id}}" class="text-right">{{event.data.wl_down.value.now}}</td>
					<td width="25">
					<span id="wl-down-arrow-up-{{event.id}}" class="glyphicon glyphicon-arrow-up text-info" ng-style="{'display': (event.data.wl_down.value.now > event.data.wl_down.value.old) ? 'inline' : 'none'}"></span> 
					<span id="wl-down-arrow-down-{{event.id}}" class="glyphicon glyphicon-arrow-down text-fade" ng-style="{'display': (event.data.wl_down.value.now < event.data.wl_down.value.old) ? 'inline' : 'none'}"></span>
					</td>
					<td><span id="wl-up-status-{{event.id}}" class="icon wl {{event.data.wl_up.value.status}}"></span></td>
					<td><span id="wl-down-status-{{event.id}}" class="icon wl {{event.data.wl_down.value.status}}"></span></td>
				</tr> 
			</tbody>
		</table>
	</div>

</DIV>

	<div class="col-md-5">
		<div id="map" class="map"></div>
		<table class="table text-center">
			<thead class="bg-black">
				<tr>
					<th width="200">ปริมาณน้ำฝน</th>
					<th>สถานการณ์</th>
					<th width="200">ระดับน้ำ</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><span class="icon rf success"></span></td>
					<td>ปกติ</td>
					<td><span class="icon wl success"></span></td>
				</tr>
				<tr>
					<td><span class="icon rf warning"></span></td>
					<td>เฝ้าระวัง</td>
					<td><span class="icon wl warning"></span></td>
				</tr>
				<tr>
					<td><span class="icon rf danger"></span></td>
					<td>เตือนภัย</td>
					<td><span class="icon wl danger"></span></td>
				</tr>
				<tr>
					<td><span class="icon rf black"></span></td>
					<td class="text-nowrap">ขัดข้องไม่เกิน 3 ชม.</td>
					<td><span class="icon wl black"></span></td>
				</tr>
				<tr>
					<td><span class="icon rf gray"></span></td>
					<td class="text-nowrap">ขัดข้องไม่เกิน 3 วัน</td>
					<td><span class="icon wl gray"></span></td>
				</tr>
				<tr>
					<td><span class="icon rf white"></span></td>
					<td class="text-nowrap">ขัดข้องเกิน 3 วัน</td>
					<td><span class="icon wl white"></span></td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!-- script -->
<link href="<?php echo PATH_PLUGIN; ?>googlemap/map.css" rel="stylesheet" type="text/css" />
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCcDHTZyFY_k-Eol3jy12Ei52vbdva04JY"></script>
<script src="<?php echo PATH_PLUGIN; ?>googlemap/markerwithlabel.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>googlemap/map.js?v=16.6.13"></script>
<script src="<?php echo PATH_SCRIPT; ?>jquery/jquery.signalR-2.2.0.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>realangular.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>jquery.sortElements.js"></script>
<script src="<?php echo PATH_SIGNALR; ?>"></script>
<script>
$(document).ready
(
	function() 
    {
    	// map
    	loadmap('map', 13, 100, 6);
    	initialize(STATION, 'lib/plugins/googlemap/');
    }
);



</script>