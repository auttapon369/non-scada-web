<div class="row">
	<div class="col-lg-12 title">
		<h1 id="title" class="text-black"></h1>
		<small id="date"></small>
	</div>
</div>
<div class="row bd-top stn-block" id="detail">
	<div class="col-sm-8">
		<img id="cctv" width="100%" class="img-responsive" />
		<div id="playback"></div>
	</div>
	<div class="col-sm-4">
		<table class="table table-info">
			<caption class="bg-black"><span class="glyphicon glyphicon-th-list"></span> รายละเอียด</th>
			<tr>
				<th width="125">รหัส</th>
				<td id="stn-id">-</td>
			</tr>
			<tr>
				<th>ชื่อสถานี</th>
				<td id="stn-name">-</td>
			</tr>
			<tr>
				<th>ที่ตั้ง</th>
				<td id="stn-address">-</td>
			</tr>
			<tr>
				<th>รายละเอียด</th>
				<td id="stn-cctv">-</td>
			</tr>
			<tr>
				<th>การตรวจวัด</th>
				<td id="stn-check">-</td>
			</tr>
		</table>
	</div>
</div>

<div class="row bd-top stn-block" id="wl-up">
	<div class="col-sm-8">
		<!-- <iframe src="<?php //echo PAGE.$_GET['page']; ?>/cross.html" height="480" class="bd-"></iframe> -->
		<div id="svgfile" style="width: 100%; height: 480px; border:1px solid black; "></div>

	</div>
	<div class="col-sm-4">
		<table class="table table-info">
			<caption class="bg-black"><span class="glyphicon glyphicon-tint"></span> ระดับน้ำ</th>
			<tr>
				<th width="125">ระดับน้ำ</th>
				<td id="wl-up-now" class="text-right">-</td>
				<td width="75">ม.รทก.</td>
			</tr>
			<tr>
				<th>เกณฑ์เฝ้าระวัง</th>
				<td id="wl-up-warning" class="text-right">-</td>
				<td>ม.รทก.</td>
			</tr>
			<tr>
				<th>เกณฑ์เตือนภัย</th>
				<td id="wl-up-danger" class="text-right">-</td>
				<td>ม.รทก.</td>
			</tr>
			<tr class="bd-top wl-down">
				<th>ระดับน้ำ (ท้าย)</th>
				<td id="wl-down-now" class="text-right">-</td>
				<td>ม.รทก.</td>
			</tr>
			<tr class="wl-down">
				<th>เกณฑ์เฝ้าระวัง</th>
				<td id="wl-down-warning" class="text-right">-</td>
				<td>ม.รทก.</td>
			</tr>
			<tr class="wl-down">
				<th>เกณฑ์เตือนภัย</th>
				<td id="wl-down-danger" class="text-right">-</td>
				<td>ม.รทก.</td>
			</tr>
		</table>
	</div>
</div>

<div class="row bd-top stn-block" id="rf">
	<div class="col-sm-8">
		<!-- <iframe src="<?php //echo PAGE.$_GET['page']; ?>/graph.html" height="400" class="bd-"></iframe> 
		<div id="graphday" style="min-width:310px; width:100%; height:400px"></div>-->
		<div id="graphday" class="text-center"> </div>
	</div>
	<div class="col-sm-4">
		<table class="table table-info">
			<caption class="bg-black"><span class="glyphicon glyphicon-cloud"></span> ปริมาณน้ำฝน</th>
			<tr>
				<th width="125">ปริมาณฝน</th>
				<td id="rf-now" class="text-right">-</td>
				<td width="75">มม.</td>
			</tr>
			<tr>
				<th>เกณฑ์เฝ้าระวัง</th>
				<td id="rf-warning" class="text-right">-</td>
				<td>มม.</td>
			</tr>
			<tr>
				<th>เกณฑ์เตือนภัย</th>
				<td id="rf-danger" class="text-right">-</td>
				<td>มม.</td>
			</tr>
		</table>
	</div>
</div>

<!-- script -->
<link href="<?php echo PATH_PLUGIN; ?>playback/playback.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PATH_PLUGIN; ?>playback/playback.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>highcharts/highcharts.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>highcharts/modules/exporting.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>graph.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>svg-pan-zoom/svg-pan-zoom.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>svg-pan-zoom/hammer.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>snap.svg.0.4.1/snap.svg-min.js"></script>
<script>
$(document).ready
(
	function() 
    {
    	var stn = linkAct("&id=");
		var DATA = getObjects(STATION, 'code', stn)[0];	
    	var chk_rf = chk_wl_up = chk_wl_down = 'unchecked';

		$('#rf').hide();
		$('#wl-up').hide();
		$('.wl-down').hide();

		if (DATA.data.rf.enable)
		{
			chk_rf = 'check';
			$('#rf').show();
			$('#rf-now').html('<span class="text-'+DATA.data.rf.value.status+'">'+DATA.data.rf.value.now+'</span>');
			$('#rf-warning').html(DATA.data.rf.value.warning);
			$('#rf-danger').html(DATA.data.rf.value.danger);	
		}

		if (DATA.data.wl_up.enable)
		{
			chk_wl_up = 'check';
			$('#wl-up').show();
			$('#wl-up-now').html('<span class="text-'+DATA.data.wl_up.value.status+'">'+DATA.data.wl_up.value.now+'</span>');
			$('#wl-up-warning').html(DATA.data.wl_up.value.warning);
			$('#wl-up-danger').html(DATA.data.wl_up.value.danger);
			
			if (DATA.data.wl_down.enable)
			{
				chk_wl_down = 'check';
				$('.wl-down').show();
				$('#wl-down-now').html('<span class="text-'+DATA.data.wl_down.value.status+'">'+DATA.data.wl_down.value.now+'</span>');
				$('#wl-down-warning').html(DATA.data.wl_down.value.warning);
				$('#wl-down-danger').html(DATA.data.wl_down.value.danger);
			}
		}

		var check = '<span class="glyphicon glyphicon-'+chk_rf+'"></span> ปริมาณฝน<br>' +
		 	'<span class="glyphicon glyphicon-'+chk_wl_up+'"></span> ระดับน้ำ<br>' +
		 	'<span class="glyphicon glyphicon-'+chk_wl_down+'"></span> ระดับน้ำ (ท้าย)';

		$('#title').html(DATA.name);
    	$('#cctv').attr('src', DATA.cctv[0]);
    	$('#stn-id').html(DATA.code);
    	$('#stn-name').html(DATA.name);
    	$('#stn-address').html(DATA.address);
    	$('#stn-cctv').html(DATA.detail);
    	$('#stn-check').html(check);
    	$('#date').html('ปรับปรุงข้อมูลล่าสุด: '+dateThai(DATA.date));
		

		// cctv
		var play = new playback({
			img: {
                id: "cctv",
                src: DATA.cctv,
                stack: ['ondate=','&']
            },
            button: {
                swap: ['หน้า','ท้าย'],
                control: "Playback"
            },                
            range: 3600 * 12, 	// 1hr
            speed: 60 * 15,		// sec
			swap: true,
			log: true,
			stn : stn
		});

		var dt = DATA.date.split(' ');
		//console.log(dt[0]);
		// graph

		$.getJSON
	    (
	        "json.php", 
	        { 
	            app: "search",
	            id: [DATA.id],
	            data: 'rf',
	            format: '1h',
				date1: dt[0]+' 00:00',
            	date2: dt[0]+' 23:45'
	        } 
	    )
	    .done
	    (
	        function(json) 
	        {
				console.log(json.search);
				runGraph(json.search, 'rf', 'graphday', 'กราฟปริมาณน้ำฝนวันนี','1h');
	        }
	    );


	    //cross
	    var $iframe = $('#frameCross');
		var cross_src = "";
		if (DATA.zone != 'C')
		{
		    cross_src = '/CrossSectionService/CrossSectionService.svc/SVGService/GetFloodGate?stnCode=' + stn + '&wlUp=' + DATA.data.wl_up.value.now + '&wlDown=' +DATA.data.wl_down.value.now + '&wlUpH=' + DATA.data.wl_up.value.warning + '&wlUpHH=' + DATA.data.wl_up.value.danger + '&wlDownH=' + DATA.data.wl_down.value.warning + '&wlDownHH=' + DATA.data.wl_down.value.danger;
		}
		else
		{
		    cross_src = '/CrossSectionService/CrossSectionService.svc/SVGService/GetPavement?stnCode=' + stn + '&wl=' + DATA.data.wl_up.value.now + '&wlH=' + DATA.data.wl_up.value.warning + '&wlHH=' + DATA.data.wl_up.value.danger;
		}
		//$iframe.attr('src', cross_src);
		$('#svgfile').load(cross_src, function(){
		    console.log($('#cross-svg'));
		    var eventsHandler;
		    eventsHandler = {
		      haltEventListeners: ['touchstart', 'touchend', 'touchmove', 'touchleave', 'touchcancel']
		    , init: function(options) {
		        var instance = options.instance
		          , initialScale = 1
		          , pannedX = 0
		          , pannedY = 0

		        // Init Hammer
		        // Listen only for pointer and touch events
		        this.hammer = Hammer(options.svgElement, {
		          inputClass: Hammer.SUPPORT_POINTER_EVENTS ? Hammer.PointerEventInput : Hammer.TouchInput
		        })

		        // Enable pinch
		        this.hammer.get('pinch').set({enable: true})

		        // Handle double tap
		        this.hammer.on('doubletap', function(ev){
		          instance.zoomIn()
		        })

		        // Handle pan
		        this.hammer.on('pan panstart panend', function(ev){
		          // On pan start reset panned variables
		          if (ev.type === 'panstart') {
		            pannedX = 0
		            pannedY = 0
		          }

		          // Pan only the difference
		          if (ev.type === 'pan' || ev.type === 'panend') {
		            console.log('p')
		            instance.panBy({x: ev.deltaX - pannedX, y: ev.deltaY - pannedY})
		            pannedX = ev.deltaX
		            pannedY = ev.deltaY
		          }
		        })

		        // Handle pinch
		        this.hammer.on('pinch pinchstart pinchend', function(ev){
		          // On pinch start remember initial zoom
		          if (ev.type === 'pinchstart') {
		            initialScale = instance.getZoom()
		            instance.zoom(initialScale * ev.scale)
		          }

		          // On pinch zoom
		          if (ev.type === 'pinch' || ev.type === 'pinchend') {
		            instance.zoom(initialScale * ev.scale)
		          }
		        })

		        // Prevent moving the page on some devices when panning over SVG
		        options.svgElement.addEventListener('touchmove', function(e){ e.preventDefault(); });
		      }

		    , destroy: function(){
		        this.hammer.destroy()
		      }
		    }

		    // Expose to window namespace for testing purposes
		    window.panZoom = svgPanZoom('#cross-svg', {
		      zoomEnabled: true
		    , controlIconsEnabled: true
		    , fit: 1
		    , center: 1
		    , customEventsHandler: eventsHandler
		    });
		});  
    }
);
</script>