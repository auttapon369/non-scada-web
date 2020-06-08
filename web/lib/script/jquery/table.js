var target = 'realtime';

$(document).ready
(
	function() 
    {
    	loadData();
    	update();
    }
);

function loadData() 
{
	var temp = [];
	var html = null,
		rf = '-',
		wl_up = '-',
		wl_down = '-';

	$.each
	(
  		STATION, 
  		function(key, DATA) 
  		{
  			if (DATA.data.rf.enable)
  			{
  				rf = DATA.data.rf.value.now;
  			}
  			if (DATA.data.wl_up.enable)
  			{
  				wl_up = DATA.data.wl_up.value.now;
  			}
  			if (DATA.data.wl_down.enable)
  			{
  				wl_down = DATA.data.wl_down.value.now;
  			}

			html = '<tr>'
				+ '<td class="text-left">' + DATA.code + ' ' + DATA.name + '</td>'
				+ '<td id="date-'+DATA.id+'" class="bd-left">' + DATA.date + '</td>'
				+ '<td id="rf-'+DATA.id+'" class="bd-left">' + rf + '</td>'
				//+ '<td>-</td>'
				//+ '<td>-</td>'
				+ '<td id="wl-up-'+DATA.id+'" class="bd-left">' + wl_up + '</td>'
				+ '<td id="wl-down-'+DATA.id+'">' + wl_down + '</td>'
			+ '</tr>';		

			temp.push(html);
			html = null;
  		}
  	);

	//console.log(temp);
  	$('#'+target+' tbody').append(temp);
}

function update() 
{
	var message = ''; // holds the new message
    var messages = []; // collection of messages coming from server
	var scadaHost = null; // holds the reference to hub
	$.connection.hub.url = "http://182.52.224.70/scadahost/signalr";
	scadaHost = $.connection.scadaHost; // initializes hub
	$.connection.hub.start()
	.done
	(
		function ()
		{
			scadaHost.server.joinGroup("AllStation_RealTime");
			//console.log('ok');
        }
	);

	// register a client method on hub to be invoked by the server
	scadaHost.client.addMessage = function (message) 
	{
		// clear storeage
		// if ( messages.length > 100 ) 
		// {
		// 	messages = [];
		// }

		var msg = JSON.parse(message);
		var time = msg.TimeStamp.substring(16,-3);
		$('#date-' + msg.StationID).html(time);

		if ( msg.TagName == "rf_15m" )
		{
			var point = '#rf-' + msg.StationID;
		}
		if ( msg.TagName == "wl1_real" )
		{
			var point = '#wl-up-' + msg.StationID;
		}
		if ( msg.TagName == "wl2_real" )
		{
			var point = '#wl-down-' + msg.StationID;
		}

		$(point).addClass('text-white');
		$(point).html(msg.TagValue);
		//$(point).delay('500').removeClass('text-white');
		
		setTimeout
		(
			function() 
			{
       			$(point).removeClass("text-white");
   			}, 
   			500
   		);
	};
}