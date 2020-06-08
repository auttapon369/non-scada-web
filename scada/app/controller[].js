app.controller
(
	'mainCtrl',
	function($scope, $route, $routeParams, $location, $timeout, $_global, cons)
	{
		$scope.path = cons.path;
		$scope.text = cons.text;
		$scope.dataREAL = [];

		$_global.request('web/json.php').then
		//$_global.request(cons.path.html+'json?app=station&view=scada').then
		(
			function successCallback(response)
			{
      			$scope.dataSTN = response.data.station;
				angular.forEach
				(
					$scope.dataSTN,
					function(value,key)
					{						
						if ( value['data']['rf']['enable'] )
						{
							var rf_value = value['data']['rf']['value']['now'];
							var rf_status = value['data']['rf']['value']['status'];
						}
						if ( value['data']['wl_up']['enable'] )
						{
							var wl_up_value = value['data']['wl_up']['value']['now'];
							var wl_up_status = value['data']['wl_up']['value']['status'];
						}
						if ( value['data']['wl_down']['enable'] )
						{
							var wl_down_value = value['data']['wl_down']['value']['now'];
							var wl_down_status = value['data']['wl_down']['value']['status'];
						}

						$scope.dataREAL.push
						(
							{
								id: value['id'],
								date: value['date'],
								rf: {
									value: rf_value,
									status: rf_status
								},
								wl_up: {
									value: wl_up_value,
									status: wl_up_status
								},
								wl_down:  {
									value: wl_down_value,
									status: wl_down_status
								}
							}
						);
					}
				);
				//console.log($scope.dataREAL);
				//console.log($scope.dataSTN);
  			},
  			function errorCallback(response)
  			{
  				console.log(response);
  			}
  		);

		$scope.message = ''; // holds the new message
        $scope.messages = []; // collection of messages coming from server
		$scope.scadaHost = null; // holds the reference to hub
		$.connection.hub.url = "http://cctvexpert.dyndns.org/scadahost/signalr";
		$scope.scadaHost = $.connection.scadaHost; // initializes hub
		$.connection.hub.start()
		.done
		(
			function ()
			{
				$scope.scadaHost.server.joinGroup("AllStation_RealTime");
				//console.log('ok');
            }
		);

		/*register a client method on hub to be invoked by the server*/
		$scope.scadaHost.client.addMessage = function (message) 
		{
			// clear storeage
			if ( $scope.messages.length > 100 ) 
			{
				$scope.messages = [];
			}

			var msg = JSON.parse(message);
			var selected = $_global.select($scope.dataSTN, 'id', msg.StationID);

			if ( msg.TagName == "rf_15m" )
			{
				var tag = 'ปริมาณฝน';
			}
			if ( msg.TagName == "wl1_real" )
			{
				var tag = 'ระดับน้ำ (หน้า)';
			}
			if ( msg.TagName == "wl2_real" )
			{
				var tag = 'ระดับน้ำ (หลัง)';
			}

            // push the newly coming message
            var obj = {
				id: msg.StationID,
				code: selected.code,
				name: selected.name,
				date: msg.TimeStamp,
				tag: tag,
				param: msg.TagName,
				value: parseFloat(msg.TagValue)
			}

			$scope.messages.push(obj);
			$scope.update(obj);
            $scope.$apply();

			//console.log($scope.messages);
		};

    	$scope.update = function(data)
    	{
    		var keepGoing = true;
			angular.forEach
			(
				$scope.dataREAL,
				function(value,key)
				{
					if (keepGoing) 
					{
						if ( data.id == value['id'] )
						{
							if ( data.param == "rf_15m" )
							{
								$scope.dataREAL[key].rf.value = data.value;
							}
							if ( data.param == "wl1_real" )
							{
								$scope.dataREAL[key].wl_up.value = data.value;
							}
							if ( data.param == "wl2_real" )
							{
								$scope.dataREAL[key].wl_down.value = data.value;
							}
							$scope.dataREAL[key].date = data.date;
							keepGoing = false;
						}
					}
				}
			);
			//console.log($scope.dataREAL);
		};

		$scope.$watch
		(
			'online', 
			function(newStatus) 
			{
				//$scope.loader(newStatus);
				//$scope.txtOnline = cons.text.error.conn;
			}
		);

		$scope.glued = true;






		$scope.encURL = function(text)
	    {
	    	return text.replace(/ /g, '_');
	    };

		$scope.decURL = function(text)
	    {
	    	return text.replace(/_/g, ' ');
	    };

	    $scope.toHTML = function(text)
	    {
	        return text.replace('<br>', '\r\n');
	    };

	    $scope.isActive = function(view)
	    {
	    	if ( view === $location.path() || view === '/' + $location.path().split('/')[1] )
	    	{
				return true;
	    	}
	    };

		$scope.scrollField = function(id)
		{
			var x = ( id ) ? $("#"+id).offset().top - 110 : 0;

			$('html, body').animate
			(
				{
					scrollTop: x
				},
				500
			);
		};

		$scope.loader = function(status)
		{
			$('loader').show();

			if (status)
			{
				$timeout
				(
					function()
					{
						$('loader').fadeOut();
					},
					2000
				);
			}
		};

		$scope.fullscreen = function()
		{
			alert('F');
		};

		$scope.exit = function()
		{
			alert('Do you want to exit?');
		};
    }
);

app.controller
(
	'mapCtrl',
	function($scope, $route, $timeout, $_global)
	{
		//$scope.scrollField();

		var scope = this;
		scope.active = null;
		scope.swap = 0;

		scope.pop = function(id)
		{
			scope.selected = $_global.select($scope.dataSTN,'id',id);
			scope.real = $_global.select($scope.dataREAL,'id',id);
			scope.show = true;
			scope.timeout = scope.check(this.selected.timeout);
			scope.door = scope.check(this.selected.door,'door');
			scope.active = id;
			
			//console.log(this.selected);
		};

		scope.pin = function(type, data)
		{
			var p = s1 = s2 = s3 = null;
			var s = "success";
			p = (type=="A") ? "fa-map-marker" : null;
			p = (type=="B") ? "fa-circle" : p;
			p = (type=="C") ? "fa-car" : p;
			s1 = (data.rf.enable) ? data.rf.value.status : null;
			s2 = (data.wl_up.enable) ? data.wl_up.value.status : null;
			s3 = (data.wl_down.enable) ? data.wl_down.value.status : null;
			s = ( [s1,s2,s3].indexOf("warning") > -1 ) ? "warning" : s;
			s = ( [s1,s2,s3].indexOf("danger") > -1 ) ? "danger" : s;

			return p + " text-" + s + " sd-" + s;
		}

		scope.check = function(bool, type)
		{
			var style = "";

			if (type=="door")
			{
				style = (bool) ? "fa-lock text-success" : "fa-unlock text-fade";
			}
			else
			{
				style = (bool) ? "text-success" : "text-fade";
			}

			return style;
		};
		
		// if ( angular.isDefined($scope.dataProduct) && angular.isDefined($routeParams.product) )
		// {
		// 	var name = $scope.decURL($routeParams.product);
		// 	$scope.dataSelect = $_global.select($scope.dataProduct,'name',name);
		// 	var c = $_global.select($scope.dataBag,'id',$scope.dataSelect.id);
		// 	scope.checkout = function(id)
		// 	{
		// 		return c.id === id;
		// 	};
		// }

		// $timeout
		// (
		// 	function()
		// 	{
		// 		$route.reload();
		// 	},
		// 	2200
		// );

		// scope.add = function()
		// {
		// 	$scope.dataBag.push
		// 	(
		// 		{
		// 			id: $scope.dataSelect.id,
		// 			name: $scope.dataSelect.name,
		// 			sale: $scope.dataSelect.sale,
		// 			num: 1
		// 		}
		// 	);

	 //  		scope.loading = true;

		// 	$timeout
		// 	(
		// 		function()
		// 		{
		// 			$route.reload();
		// 		},
		// 		1600
		// 	);
		// };
	}
);

app.controller
(
	'tbCtrl',
	function($scope, $timeout)
	{
		//$scope.loader();
		//var scope = this;
		//scope.title = 333;
		// var $table = $('table'),
		//     $bodyCells = $table.find('tbody tr:first').children(),
		//     colWidth;

		// // Get the tbody columns width array
		// colWidth = $bodyCells.map(function() {
		//     return $(this).width();
		// }).get();

		// // Set the width of thead columns
		// $table.find('thead tr').children().each(function(i, v) {
		//     $(v).width(colWidth[i]);
		// }); 
	}
);

app.controller
(
	'cctvCtrl',
	function($scope)
	{
		
	}
);

app.controller
(
	'cfgCtrl',
	function($scope)
	{
		var scope = this;
		
		scope.slider = {
		    minValue: 10,
		    maxValue: 90,
		    options: {
		        floor: 0,
		        ceil: 100,
		        step: 1
		    }
		};
		
		scope.update = function()
		{
			alert('x');
		};
	}
);

app.controller
(
	'userCtrl',
	function($scope)
	{
		
	}
);

app.controller
(
	'helpCtrl',
	function($scope)
	{
		
	}
);





