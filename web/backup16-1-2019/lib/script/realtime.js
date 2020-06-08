function loadData(_json_,_target_) 
{
	var temp = [];

	$.each
	(
  		_json_,
  		function(key, DATA) 
  		{

			if(_target_ =="realtime" && DATA.zone == "C")
			{
			
  			var html = "",
			rf = '-', rf_icon = "-", rf_arrow_up = "", rf_arrow_down = "",
			wl_up = '-', wl_up_icon = "-", wl_up_arrow_up = "", wl_up_arrow_down = "",
			wl_down = '-', wl_down_icon = "-", wl_down_arrow_up = "", wl_down_arrow_down = "";

  			if (DATA.data.rf.enable)
  			{
  				rf = DATA.data.rf.value.now;
  				rf_icon = '<span id="rf-status-'+DATA.id+'" class="icon rf '+DATA.data.rf.value.status+'"></span>';
  				rf_arrow_up = '<span id="rf-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				rf_arrow_down = '<span id="rf-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';

  			}
  			if (DATA.data.wl_up.enable)
  			{
  				wl_up = DATA.data.wl_up.value.now;
  				wl_up_icon = '<span id="wl-up-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_up.value.status+'"></span>';
  				wl_up_arrow_up = '<span id="wl-up-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_up_arrow_down = '<span id="wl-up-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}
  			if (DATA.data.wl_down.enable)
  			{
  				wl_down = DATA.data.wl_down.value.now;
  				wl_down_icon = '<span id="wl-down-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_down.value.status+'"></span>';
  				wl_down_arrow_up = '<span id="wl-down-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_down_arrow_down = '<span id="wl-down-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}

			html = '<tr>' +
				'<td class="text-left"><a href="./?page=station&id=' + DATA.code + '">' + DATA.code + ' ' + DATA.name + '</td>' +
				'<td id="date-'+DATA.id+'" class="bd-left">' + DATA.date + '</td>' +
				//'<td id="rf-'+DATA.id+'" class="bd-left text-right">' + rf + '</td>' +
				//'<td width="25">' + rf_arrow_up + rf_arrow_down + '</td>' +
				'<td id="wl-up-'+DATA.id+'" class="bd-left text-right">' + wl_up + '</td>' +
				'<td width="25">' + wl_up_arrow_up + wl_up_arrow_down + '</td>' +
				//'<td id="wl-down-'+DATA.id+'" class="text-right">' + wl_down + '</td>' +
				//'<td width="25">' + wl_down_arrow_up + wl_down_arrow_down + '</td>' +
				//'<td class="bd-left">' + rf_icon + '</td>' +
				'<td>' + wl_up_icon + '</td>' +
				//'<td>' + wl_down_icon + '</td>' +
			'</tr>';

			}

			if(_target_ =="realtimerf" && DATA.data.rf.enable == true)
			{
			
  			var html = "",
			rf = '-', rf_icon = "-", rf_arrow_up = "", rf_arrow_down = "",
			wl_up = '-', wl_up_icon = "-", wl_up_arrow_up = "", wl_up_arrow_down = "",
			wl_down = '-', wl_down_icon = "-", wl_down_arrow_up = "", wl_down_arrow_down = "";

  			if (DATA.data.rf.enable)
  			{
  				rf = DATA.data.rf.value.now;
				rfday = DATA.data.rf.value.day;
  				rf_icon = '<span id="rf-status-'+DATA.id+'" class="icon rf '+DATA.data.rf.value.status+'"></span>';
  				rf_arrow_up = '<span id="rf-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				rf_arrow_down = '<span id="rf-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
				rfday_arrow_up = '<span id="rfday-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				rfday_arrow_down = '<span id="rfday-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';

  			}
  			if (DATA.data.wl_up.enable)
  			{
  				wl_up = DATA.data.wl_up.value.now;
  				wl_up_icon = '<span id="wl-up-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_up.value.status+'"></span>';
  				wl_up_arrow_up = '<span id="wl-up-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_up_arrow_down = '<span id="wl-up-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}
  			if (DATA.data.wl_down.enable)
  			{
  				wl_down = DATA.data.wl_down.value.now;
  				wl_down_icon = '<span id="wl-down-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_down.value.status+'"></span>';
  				wl_down_arrow_up = '<span id="wl-down-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_down_arrow_down = '<span id="wl-down-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}

			html = '<tr>' +
				'<td class="text-left"><a href="./?page=station&id=' + DATA.code + '">' + DATA.code + ' ' + DATA.name + '</td>' +
				'<td id="date-'+DATA.id+'" class="bd-left">' + DATA.date + '</td>' +
				'<td id="rf-'+DATA.id+'" class="bd-left text-right">' + rf + '</td>' +
				'<td width="25">' + rf_arrow_up + rf_arrow_down + '</td>' +
				'<td id="rfday-'+DATA.id+'" class="bd-left text-right">' + rfday + '</td>' +
				'<td width="25"></td>' +
				//'<td id="wl-up-'+DATA.id+'" class="bd-left text-right">' + wl_up + '</td>' +
				//'<td width="25">' + wl_up_arrow_up + wl_up_arrow_down + '</td>' +
				//'<td id="wl-down-'+DATA.id+'" class="text-right">' + wl_down + '</td>' +
				//'<td width="25">' + wl_down_arrow_up + wl_down_arrow_down + '</td>' +
				'<td class="bd-left">' + rf_icon + '</td>' +
				//'<td>' + wl_up_icon + '</td>' +
				//'<td>' + wl_down_icon + '</td>' +
			'</tr>';

			}

						if(_target_ =="realtimewl" && DATA.data.wl_up.enable == true && DATA.zone != "C")
			{
			
  			var html = "",
			rf = '-', rf_icon = "-", rf_arrow_up = "", rf_arrow_down = "",
			wl_up = '-', wl_up_icon = "-", wl_up_arrow_up = "", wl_up_arrow_down = "",
			wl_down = '-', wl_down_icon = "-", wl_down_arrow_up = "", wl_down_arrow_down = "";

  			if (DATA.data.rf.enable)
  			{
  				rf = DATA.data.rf.value.now;
  				rf_icon = '<span id="rf-status-'+DATA.id+'" class="icon rf '+DATA.data.rf.value.status+'"></span>';
  				rf_arrow_up = '<span id="rf-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				rf_arrow_down = '<span id="rf-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';

  			}
  			if (DATA.data.wl_up.enable)
  			{
  				wl_up = DATA.data.wl_up.value.now;
  				wl_up_icon = '<span id="wl-up-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_up.value.status+'"></span>';
  				wl_up_arrow_up = '<span id="wl-up-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_up_arrow_down = '<span id="wl-up-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}
  			if (DATA.data.wl_down.enable)
  			{
  				wl_down = DATA.data.wl_down.value.now;
  				wl_down_icon = '<span id="wl-down-status-'+DATA.id+'" class="icon wl '+DATA.data.wl_down.value.status+'"></span>';
  				wl_down_arrow_up = '<span id="wl-down-arrow-up-'+DATA.id+'" class="glyphicon glyphicon-arrow-up text-info"></span>';
  				wl_down_arrow_down = '<span id="wl-down-arrow-down-'+DATA.id+'" class="glyphicon glyphicon-arrow-down text-fade"></span>';
  			}

			html = '<tr>' +
				'<td class="text-left"><a href="./?page=station&id=' + DATA.code + '">' + DATA.code + ' ' + DATA.name + '</td>' +
				'<td id="date-'+DATA.id+'" class="bd-left">' + DATA.date + '</td>' +
				//'<td id="rf-'+DATA.id+'" class="bd-left text-right">' + rf + '</td>' +
				//'<td width="25">' + rf_arrow_up + rf_arrow_down + '</td>' +
				'<td id="wl-up-'+DATA.id+'" class="bd-left text-right">' + wl_up + '</td>' +
				'<td width="25">' + wl_up_arrow_up + wl_up_arrow_down + '</td>' +
				'<td id="wl-down-'+DATA.id+'" class="text-right">' + wl_down + '</td>' +
				'<td width="25">' + wl_down_arrow_up + wl_down_arrow_down + '</td>' +
				//'<td class="bd-left">' + rf_icon + '</td>' +
				'<td>' + wl_up_icon + '</td>' +
				'<td>' + wl_down_icon + '</td>' +
			'</tr>';

			}






			temp.push(html);
  		}
  	);

	//console.log(temp);
  	$('#'+_target_+' tbody').append(temp);
}

function update() 
{
	var scadaHost = null; // holds the reference to hub
	$.connection.hub.url = "http://182.52.224.70/scadahost/signalr";
	scadaHost = $.connection.scadaHost; // initializes hub
	
	$.connection.hub.start().done
	(
		function ()
		{
			//scadaHost.server.joinGroup("AllStation_RealTime");
			scadaHost.server.joinGroup("TagChannel");
			//scadaHost.server.joinGroup("AllStation_Log");
        }
	);
	
	// $.connection.hub.disconnected
	// (
	// 	function() 
	// 	{
	// 		var timestamp = '[' + new Date().toLocaleString() + '] ';
	// 		console.log(timestamp + "hub disconnected");
	// 		setTimeout
	// 		(
	// 			function() 
	// 			{
	// 				var timestamp = '[' + new Date().toLocaleString() + '] ';
	// 				console.log(timestamp + "restart hub connection");
					
	// 				$.connection.hub.start().done
	// 				(
	// 					function() 
	// 					{
	// 						var timestamp = '[' + new Date().toLocaleString() + '] ';
	// 						console.log(timestamp + "reconnect success");
	// 						//hubProxy.server.joinGroup("AllStation_RealTime");
	// 						//hubProxy.server.joinGroup("AllStation_Log");
	// 						scadaHost.server.joinGroup("AllStation_RealTime");
	// 					}
	// 				);
	// 			}, 
	// 			30000
	// 		);
	// 	}
	// );

	// register a client method on hub to be invoked by the server
	scadaHost.client.addMessage = function (message) 
	{
		var msg = JSON.parse(message);
		var time = msg.TimeStamp.substring(16,-3);
		var v = parseFloat(msg.TagValue).toFixed(2);
		$('#date-' + msg.StationID).html(time);
		//console.log(msg);
      
		if ( msg.TagName == "rf_24H_real")
		{
			//console.log('ok');
			var point = '#rfday-' + msg.StationID;
			var cr = $(point).html();
			compare(msg.StationID,cr,v,'rf');
			//var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.warning) ? "warning" : "success";
			//$('#rf-status-' + msg.StationID).attr('class', 'icon rf ' + status);
		}
		if ( msg.TagName == "rf_hour_real"|| msg.TagName == "rf_hour_log")
		{
			var point = '#rf-' + msg.StationID;
			var cr = $(point).html();
			compare(msg.StationID,cr,v,'rf');
			var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.warning) ? "warning" : "success";
			$('#rf-status-' + msg.StationID).attr('class', 'icon rf ' + status);
		}
		if ( msg.TagName == "wl1_log" || msg.TagName == "wl1_real" )
		{
			var point = '#wl-up-' + msg.StationID;
			var cr = $(point).html();
			compare(msg.StationID,cr,v,'wl-up');
			var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_up.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_up.value.warning) ? "warning" : "success";
			$('#wl-up-status-' + msg.StationID).attr('class', 'icon wl ' + status);
		}
		if ( msg.TagName == "wl2_log" || msg.TagName == "wl2_real" )
		{
			var point = '#wl-down-' + msg.StationID;
			var cr = $(point).html();
			compare(msg.StationID,cr,v,'wl-down');
			var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_down.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_down.value.warning) ? "warning" : "success";
			$('#wl-down-status-' + msg.StationID).attr('class', 'icon wl ' + status);
		}

		//console.log(cr);
		$(point).addClass('text-white');
		$(point).html(v);

		
//		 var table1 = $('#realtime');
//    
//    $('#wl_header')
//        .wrapInner('<span title="sort this column"/>')
//        .each(function(){
//            
//            var th = $(this),
//                thIndex = th.index(),
//                inverse = true;          
//                
//                table1.find('td').filter(function(){
//                    
//                    return $(this).index() === thIndex;
//                    
//                }).sortElements(function(a, b){
//                    
//                    return $.text([a]) >= $.text([b]) ?
//                        inverse ? -1 : 1
//                        : inverse ? 1 : -1;
//                    
//                }, function(){
//                    
//                    // parentNode is the element we want to move
//                    return this.parentNode; 
//                    
//                });
//                
//                inverse = !inverse;
//                
//        });
//
//var table2 = $('#realtimerf');
//    
//    $('#rf_header')
//        .wrapInner('<span title="sort this column"/>')
//        .each(function(){
//            
//            var th = $(this),
//                thIndex = th.index(),
//                inverse = true;          
//                
//                table2.find('td').filter(function(){
//                    
//                    return $(this).index() === thIndex;
//                    
//                }).sortElements(function(a, b){
//                    
//                    return $.text([a]) > $.text([b]) ?
//                        inverse ? -1 : 1
//                        : inverse ? 1 : -1;
//                    
//                }, function(){
//                    
//                    // parentNode is the element we want to move
//                    return this.parentNode; 
//                    
//                });
//                
//                inverse = !inverse;
//                                     
//        });

		
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

function compare(_id,_v1,_v2,_target)
{
	if ( _v1 < _v2 )
	{
		$('#'+_target+'-arrow-up-'+_id).show();
		$('#'+_target+'-arrow-down-'+_id).hide();
	}
	else if ( _v1 > _v2 )
	{
		$('#'+_target+'-arrow-up-'+_id).hide();
		$('#'+_target+'-arrow-down-'+_id).show();
	}
	else
	{
		$('#'+_target+'-arrow-up-'+_id).hide();
		$('#'+_target+'-arrow-down-'+_id).hide();
	}
}

