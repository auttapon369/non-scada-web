<div class="row">
	<div class="col-lg-12 title">
		<h1 id="title" class="text-black"></h1>
	</div>
</div>
<div class="row bd-bottom text-fade" id="detail">
	<div class="col-sm-8">
		<img id="cctv" width="100%" class="img-responsive" />
	</div>
	<div class="col-sm-4">
		<ul class="list-unstyled big">
		</ul>
	</div>
</div>
<div class="row bd-bottom text-fade" id="rf">
	<h2 class="text-center">ปริมาณฝน</h2>
	<div class="col-sm-8">
		<iframe src="<?php echo PATH_PLUGIN; ?>chart/index.html" height="320" class="bd-right -fade"></iframe>
	</div>
	<div class="col-sm-4">
		<ul class="list-unstyled big">
		</ul>
	</div>
</div>
<div class="row bd-bottom text-fade" id="wl-up">
	<h2 class="text-center">ระดับน้ำ</h2>
	<div class="col-sm-8" >
		<!--iframe id="frameCross" src="<?php echo PATH_PLUGIN; ?>cross-section/index.html" height="480" class="bd-right -fade"></iframe-->
		<div id="svgfile" style="width: 100%; height: 480px; border:1px solid black; "></div>
	</div>
	<div class="col-sm-4">
		<ul class="list-unstyled big">
		</ul>
	</div>
</div>
<script src="<?php echo PATH_SCRIPT; ?>svg-pan-zoom/svg-pan-zoom.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>svg-pan-zoom/hammer.js"></script>
<script>
$(document).ready
(
	function() 
    {
    	var stn = linkAct("&id=");
    	var DATA = getObjects(STATION, 'code', stn)[0];
    	var chk_rf = chk_wl_up = chk_wl_down = 'unchecked';
    	//console.log(data);
		
		$('#rf').hide();
		$('#wl-up').hide();
    	$('#cctv').attr('src', DATA.cctv[0]);
    	$('#title').html(DATA.name);

		if (DATA.data.rf.enable)
		{
			chk_rf = 'check';
			var ul_rf = 
			'<li>ปริมาณฝน:<span class="pull-right">' + DATA.data.rf.value.now + ' มม.</span></li>' +
			'<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.rf.value.warning + ' มม.</span></li>' +
			'<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.rf.value.danger + ' มม.</span></li>' +
			'<li class="dividend"></li>' +
			'<li class="small">วันที่:<span class="pull-right">' + DATA.date + '</span></li>';

			$('#rf ul').html(ul_rf);
			$('#rf').show();
		}

		if (DATA.data.wl_up.enable)
		{
			chk_wl_up = 'check';
			var ul_wl_up = 
			'<li>ระดับน้ำ:<span class="pull-right">' + DATA.data.wl_up.value.now + ' ม.รทก.</span></li>' +
			'<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.wl_up.value.warning + ' ม.รทก.</span></li>' +
			'<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.wl_up.value.danger + ' ม.รทก.</span></li>';
			
			if (DATA.data.wl_down.enable)
			{
				chk_wl_down = 'check';
				ul_wl_up += 
				'<li class="dividend"></li>' +
				'<li>ระดับน้ำ(ท้าย):<span class="pull-right">' + DATA.data.wl_down.value.now + ' ม.รทก.</span></li>' +
				'<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.wl_down.value.warning + ' ม.รทก.</span></li>' +
				'<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.wl_down.value.danger + ' ม.รทก.</span></li>';
			}

			ul_wl_up += 
			'<li class="dividend"></li>' +
			'<li class="small">วันที่:<span class="pull-right">' + DATA.date + '</span></li>';

			$('#wl-up ul').html(ul_wl_up);
			$('#wl-up').show();
		}

		var dt = 
			'<li>รหัส: <span class="-right">' + DATA.code + '</span></li>' +
			'<li>ชื่อ: <span class="-right">' + DATA.name + '</span></li>' +
			'<li>ที่ตั้ง: <span class="-right">' + DATA.address + '</span></li>' +
			'<li>จำนวนกล้อง: <span class="-right">' + DATA.cctv.length + ' ตัว</span></li>' +
			'<li class="dividend"></li>' +
			'<li>การตรวจวัด: ' +
				'<p class="-right">' +
					'<span class="glyphicon glyphicon-'+chk_rf+'"></span> ปริมาณฝน<br>' +
					'<span class="glyphicon glyphicon-'+chk_wl_up+'"></span> ระดับน้ำ<br>' +
					'<span class="glyphicon glyphicon-'+chk_wl_down+'"></span> ระดับน้ำ (ท้าย)' +
				'</p>' +
			'</li>';

		$('#detail ul').html(dt);

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
<!-- 
page station
- cross section
- sys Playback ข้อมูลระดับน้ำคู่ภาพตัดขวาง 
-->