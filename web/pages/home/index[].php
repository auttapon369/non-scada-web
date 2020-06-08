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

<DIV class="tab-content">

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
<script src="<?php echo PATH_SCRIPT; ?>realtime.js?v=16.6.13"></script>
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

    	// table
    	loadData(STATION, 'realtime');
		loadData(STATION, 'realtimerf');
		loadData(STATION, 'realtimewl');
    	update();



		
 var table1 = $('#realtime');
    
    $('#wl_header')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = true;
            
           //th.click(function(){
                
                table1.find('td').filter(function(){
                    
                    return $(this).index() === thIndex;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) >= $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
           // });
                
        });

var table2 = $('#realtimerf');
    
    $('#rf_header')
        .each(function(){
            
            var th = $(this),
                thIndex = th.index(),
                inverse = true;
            
           //th.click(function(){
                
                table2.find('td').filter(function(){
                    
                    return $(this).index() === 4;
                    
                }).sortElements(function(a, b){
                    
                    return $.text([a]) > $.text([b]) ?
                        inverse ? -1 : 1
                        : inverse ? 1 : -1;
                    
                }, function(){
                    
                    // parentNode is the element we want to move
                    return this.parentNode; 
                    
                });
                
                inverse = !inverse;
                    
            //});
                
        });





    }
);



</script>