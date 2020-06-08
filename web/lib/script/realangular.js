var app = angular.module('realApp', []);

app.directive('scroll', function () {      
 
    return {
    restrict : 'C',
        link: function(scope, element) {
            element.bind("click" , function(e){
                 element.parent().find("a").removeClass('text-white');
                 element.addClass('text-white');
            });     
        }
    }
});

app.controller
(
	'realtime', 
	function ($scope) 
	{
		//alert("OK");
		//console.log(STATION);
		$scope.realtime = [];
		$scope.realtimerf = [];
		$scope.realtimewl = [];
		$scope.list = STATION;
		angular.forEach(STATION, function(DATA, key) {

		if(DATA.zone == "C")
		{
			$scope.realtime.push(DATA);
		}

		if(DATA.data.rf.enable == true)
		{
			$scope.realtimerf.push(DATA);
		}

		if(DATA.data.wl_up.enable == true && DATA.zone != "C")
		{
			$scope.realtimewl.push(DATA);
		}

		});

		
		$scope.message = ''; // holds the new message
        $scope.messages = []; // collection of messages coming from server
		$scope.scadaHost = null; // holds the reference to hub

		$.connection.hub.url = "http://182.52.224.70/scadahost/signalr";

		$scope.scadaHost = $.connection.scadaHost; // initializes hub
		
		$.connection.hub.start().done
		(
			function ()
			{
				//alert('coding start');
				$scope.scadaHost.server.joinGroup("TagChannel");
            }
		).fail(function (err) {
			console.log("Error starting SignalR connection: " + err); // Ends up here.
		  });
		/*$.connection.hub.start({ transport: 'longPolling' }, function() {
			console.log('connection started!');
			$scope.scadaHost.server.joinGroup("TagChannel");
		});*/
		
 
		// register a client method on hub to be invoked by the server
		$scope.scadaHost.client.addMessage = function (message) 
		{
			//alert("OK");
			var msg = JSON.parse(message);
			var time = msg.TimeStamp.substring(16,-3);
			var v = parseFloat(msg.TagValue);

			//console.log(msg);
			if ( msg.TagName == "rf_24H_real")
			{
				var point = '#rfday-' + msg.StationID;
				var stnInfo = getObjects(STATION, 'id', msg.StationID)[0];
				//update realtimerf
				angular.forEach($scope.realtimerf, function(stnData, key) {
					if (stnData.id == msg.StationID)
					{
						stnData.data.rf.value.day = v;
					}
				});
			}
			if ( msg.TagName == "rf_hour_real"|| msg.TagName == "rf_hour_log")
			{
				var point = '#rf-' + msg.StationID;
				var stnInfo = getObjects(STATION, 'id', msg.StationID)[0];
				var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.rf.value.warning) ? "warning" : "success";
				//update realtimerf
				angular.forEach($scope.realtimerf, function(stnData, key) {
					if (stnData.id == msg.StationID)
					{
						stnData.data.rf.value.old = stnData.data.rf.value.now;
						stnData.data.rf.value.now = v;
						stnData.data.rf.value.status = status;
						stnData.date = time;
					}
				});
			}
			if ( msg.TagName == "wl1_log" || msg.TagName == "wl1_real" )
			{
				var point = '#wl-up-' + msg.StationID;
				var stnInfo = getObjects(STATION, 'id', msg.StationID)[0];
				var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_up.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_up.value.warning) ? "warning" : "success";
				if (stnInfo.zone == "C")
				{
					//update realtime
					angular.forEach($scope.realtime, function(stnData, key) {
						if (stnData.id == msg.StationID)
						{
							stnData.data.wl_up.value.old = stnData.data.wl_up.value.now;
							stnData.data.wl_up.value.now = v;
							stnData.data.wl_up.value.status = status;
							stnData.date = time;
						}
					});
				}
				else
				{
					//update realtimewl
					angular.forEach($scope.realtimewl, function(stnData, key) {
						if (stnData.id == msg.StationID)
						{
							stnData.data.wl_up.value.old = stnData.data.wl_up.value.now;
							stnData.data.wl_up.value.now = v;
							stnData.data.wl_up.value.status = status;
							stnData.date = time;
						}
					});
				}
			}
			if ( msg.TagName == "wl2_log" || msg.TagName == "wl2_real" )
			{
				var point = '#wl-down-' + msg.StationID;
				var stnInfo = getObjects(STATION, 'id', msg.StationID)[0];
				var status = (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_down.value.danger) ? "danger" : (v >= getObjects(STATION, 'id', msg.StationID)[0].data.wl_down.value.warning) ? "warning" : "success";
				
				//console.log(status);
				//update realtimewl
				angular.forEach($scope.realtimewl, function(stnData, key) {
					if (stnData.id == msg.StationID)
					{
						stnData.data.wl_down.value.old = stnData.data.wl_down.value.now;
						stnData.data.wl_down.value.now = v;
						stnData.data.wl_down.value.status = status;
						stnData.date = time;
					}
				});
				
			}
			$scope.$apply();
			$(point).addClass('text-white');

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
);