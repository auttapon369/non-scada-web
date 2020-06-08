var map;

$(document).ready
(
	function() 
    {
    	loadmap('map', 13, 100, 6);
    	initialize();
    }
);

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

	map = new google.maps.Map(document.getElementById(_id_), mapOptions);
}

function initialize() 
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
  		STATION, 
  		function(key, DATA) 
  		{
    		var latLng = new google.maps.LatLng(DATA.location.lat, DATA.location.lng);
			var marker = new google.maps.Marker
			(
				{
					map: map,
					position: latLng,
					icon: 'themes/img/ic-pin-g.png'
					//icon: pin + data.abb + '_' + data.type + '.png'
				}
			);

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
							html += '<li class="line-break">ปริมาณฝน:<span class="pull-right">' + DATA.data.rf.value.now + ' มม.</span></li>'
							+ '<li>เกณฑ์เฝ้าระวัง:<span class="pull-right">' + DATA.data.rf.value.warning + ' มม.</span></li>'
							+ '<li>เกณฑ์เตือนภัย:<span class="pull-right">' + DATA.data.rf.value.danger + ' มม.</span></li>';
						}
						if (DATA.data.wl_up.enable)
						{
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

			google.maps.event.addListener
			(
				marker,
				'click',
				function()
				{
					info.setContent(html);
					info.open(map, marker);
				}
			);

			bounds.extend(latLng);
  		}
  	);

  	map.fitBounds(bounds);
}