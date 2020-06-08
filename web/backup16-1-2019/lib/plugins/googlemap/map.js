var MAP;
// var iconSet = {
// 	rf: {
// 		success: "ic_sq_green.png",
// 		warning: "ic_sq_yellow.png",
// 		danger: "ic_sq_red.png",
// 		black: "ic_sq_black.png",
// 		gray: "ic_sq_gray.png",
// 		white: "ic_sq_white.png"
// 	},
// 	wl: {
// 		success: "ic_cc_green.png",
// 		warning: "ic_cc_yellow.png",
// 		danger: "ic_cc_red.png",
// 		black: "ic_cc_black.png",
// 		gray: "ic_cc_gray.png",
// 		white: "ic_cc_white.png"
// 	}
// };

function loadmap(_id_,_lat_,_lng_,_zoom_)
{
	var mapOptions = 
	{
		center: new google.maps.LatLng(_lat_,_lng_),
		zoom: _zoom_,
		mapTypeId: google.maps.MapTypeId.TERRAIN,
		panControl: false,
		//mapTypeControl: false,
		//scaleControl: false,
		//streetViewControl: false,
		//overviewMapControl: false,
		//rotateControl: false,
		//zoomControl: true,
		zoomControlOptions:
		{
			style: google.maps.ZoomControlStyle.SMALL,
			position: google.maps.ControlPosition.RIGHT
		}
	};	

	MAP = new google.maps.Map(document.getElementById(_id_), mapOptions);
}

function initialize(_json_,_path_) 
{
	var bounds = new google.maps.LatLngBounds();
	var info = new google.maps.InfoWindow
	(
		{
			//content: html,
			maxWidth: 400
		}
	);

	$.each
	(
  		_json_, 
  		function(key, DATA) 
  		{
  			var ic_rf = ic_wl = "";
    		var latLng = new google.maps.LatLng(DATA.location.lat, DATA.location.lng);
			
			// var marker = new google.maps.Marker
			// (
			// 	{
			// 		map: MAP,
			// 		position: latLng,
			// 		icon: 'themes/img/ic-pin.png'
			// 		//icon: pin + data.abb + '_' + data.type + '.png'
			// 	}
			// );

			var html =	'<div class="popup">'
						+ '<h3>' + DATA.code + ' ' + DATA.name + '</h3>'
						+ '<p class="">'
						+ '<span class="glyphicon glyphicon-time"></span> '
						+ DATA.date 
						+ '</p>'
						+ '<ul class="list-unstyled">';
						//+ '<hr>';

						if (DATA.data.rf.enable)
						{
							ic_rf = '<span class="icon rf ' + DATA.data.rf.value.status + '"></span>';
							html += '<li class="line-break">ปริมาณฝน:<span class="pull-right">' + DATA.data.rf.value.now + ' มม.</span></li>'
							+ '<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.rf.value.warning + ' มม.</span></li>'
							+ '<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.rf.value.danger + ' มม.</span></li>';
						}
						if (DATA.data.wl_up.enable)
						{
							ic_wl = '<span class="icon wl ' + DATA.data.wl_up.value.status + '"></span>';
							html += '<li class="line-break">ระดับน้ำ:<span class="pull-right">' + DATA.data.wl_up.value.now + ' ม.รทก.</span></li>'
							+ '<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.wl_up.value.warning + ' ม.รทก.</span></li>'
							+ '<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.wl_up.value.danger + ' ม.รทก.</span></li>';
						}
						if (DATA.data.wl_down.enable)
						{
							html += '<li class="line-break">ระดับน้ำ(ท้าย):<span class="pull-right">' + DATA.data.wl_down.value.now + ' ม.รทก.</span></li>'
							+ '<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.wl_down.value.warning + ' ม.รทก.</span></li>'
							+ '<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.wl_down.value.danger + ' ม.รทก.</span></li>';
						}
						
						html += '</ul>'
						+ '</div>';

			var marker = new MarkerWithLabel
			(
				{
					map: MAP,
					position: latLng,
					icon: _path_+'pin.png',
					labelContent: ic_rf + ic_wl,
					labelAnchor: new google.maps.Point(12, 18),
					labelClass: 'labels'
				}
			);

			google.maps.event.addListener
			(
				marker,
				'click',
				function()
				{
					info.setContent(html);
					info.open(MAP, marker);
				}
			);

			bounds.extend(latLng);
  		}
  	);

  	MAP.fitBounds(bounds);
}