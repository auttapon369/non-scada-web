var app = angular.module('myApp', ['ngRoute','luegg.directives','rzModule']);

app.constant
(
	'cons',
	{
		path: {	
			img: 'web/themes/img/',
			plugin: 'web/lib/plugins/',
			signalr: 'http://192.168.99.2/scadahost/signalr',
			json: {
				//station: 'web/json.php',
				station: 'web/json.php?app=station&view=scada',
				search: 'web/json.php?app=search',
				config: 'web/json.php?app=config'
			}
		},
		text: {
			project: "SCADA",
			title: {
				en: "Nonthaburi District",
				th: "เทศบาลนครนนทบุรี"
			},
			error: {
				page: "This page is not ready.",
				conn: "Please check internet connection."
			}
		}	
	}
);

app.config
(
	[
		"$routeProvider",
		function($routeProvider)
		{
			var path = 'scada/view/';
			$routeProvider
			.when
			(
				'/map',
				{
					templateUrl: path + 'map.html',
					controller: 'mapCtrl',
					controllerAs: 'map'
				}
			)
			.when
			(
				'/station/:id',
				{
					templateUrl: path + 'station.html',
					controller: 'stnCtrl',
					controllerAs: 'stn'
	    		}
			)			
			.when
			(
				'/trend',
				{
					templateUrl: path + 'trend.html?v=16.6.16',
					controller: 'trendCtrl',
					controllerAs: 'trend'
	    		}
			)				
			.when
			(
				'/table',
				{
					templateUrl: path + 'table.html?v=16.6.16',
					controller: 'tbCtrl',
					controllerAs: 'tb'
	    		}
			)
			.when
			(
				'/cctv',
				{
					templateUrl: path + 'cctv.html?v=16.6.16',
					controller: 'cctvCtrl',
					controllerAs: 'cctv'
	    		}
			)
			.when
			(
				'/config',
				{
					templateUrl: path + 'config.html',
					controller: 'cfgCtrl',
					controllerAs: 'cfg'
	    		}
			)
			.when
			(
				'/user',
				{
					templateUrl: path + 'user.html',
					controller: 'userCtrl',
					controllerAs: 'user'
	    		}
			)
			.when
			(
				'/help',
				{
					templateUrl: path + 'help.html',
					controller: 'helpCtrl',
					controllerAs: 'help'
	    		}
			)																			
			.otherwise
			(
				{
	      			redirectTo: '/map'
	    		}
	    	);
		}
	]
);

app.factory
(
	'$_global',
	[
		'$http',
		function($http)
		{
			var data = null;

			return {

				request : function(_url, _vars)
				{
                	if ( typeof _vars !== 'undefined' )
                	{
                    	return $http
						(
							{
								headers : { 'Content-Type': 'application/x-www-form-urlencoded' },
								method: "POST",
								url: _url,
								data: $.param(_vars)
							}
						);
                	}
                	else
                	{
						return $http.get(_url);
					}
				},
            	select : function(_obj, _key, _search)
            	{
            		var x = false;
					angular.forEach
					(
						_obj,
						function(value,key)
						{
							if (_search == value[_key])
							{
								x = _obj[key];
							}
						}
					);

					return x;
				},
				stack: function(_obj,_key)
				{
					var x = "";
					angular.forEach
					(
						_obj,
						function(value,i)
						{
							var a = (i) ? "-" : "";
							x += a + value[_key];
						}
					);

					return x;
				},				
				dayDiff : function(first, second)
            	{
					var date1 = new Date(first);
					var date2 = new Date(second);
					var timeDiff = date2.getTime() - date1.getTime();
					var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));

					return diffDays;
				}
			}
		}
	]
);


/* --------------------------------------------------------------- DIRECTIVE */
app.directive
(
	'nav',
	function()
	{
		return {
			restrict: 'E',
			templateUrl: 'scada/component/nav.html'
		};
	}
);
app.directive
(
	'console',
	function()
	{
		return {
			restrict: 'E',
			templateUrl: 'scada/component/console.html'
		};
	}
);
app.directive
(
	'popup',
	function()
	{
		return {
			restrict: 'E',
			link: function(scope, element, attrs) 
			{
				scope.popid = attrs.popid;
				scope.contentUrl = function()
				{
					return "scada/component/popup.html?v=16.6.20";
				};
			},
			controller: 'popCtrl',
			controllerAs: 'pop',
			template: '<div ng-include="contentUrl()"></div>'
		};
	}
);
app.directive
(
	'tbFormat',
	function()
	{
		return {
			restrict: 'E',
			scope: true,
			link: function(scope, element, attributes) {
				scope.title = attributes["tbTitle"];
				scope.zone = attributes["tbZone"];
				scope.contentUrl = function()
				{
					return "scada/component/table.html?v=16.7.5";
				};
			},
			template: '<div class="h-100" ng-include="contentUrl()"></div>'
			//templateUrl: 'scada/component/table.html?v=16.7.5'
		};
	}
);
app.directive
(
	'timer',
	function()
	{
		return {
			restrict: 'E',
			templateUrl: 'web/lib/plugins/timer/angular.html'
		};
	}
);
app.directive
(
	'loader',
	function()
	{
		return {
			restrict: 'E',
			templateUrl: 'web/lib/plugins/loader/angular.html'
		};
	}
);


/* ------------------------------------------------------------------ FILTER */
app.filter
(
	'unsafe',
	function($sce)
	{
		return $sce.trustAsHtml;
	}
);
app.filter
(
	'abs',
	function()
	{
		return function(val)
		{
			return Math.abs(val);
		}
	}
);


/* --------------------------------------------------------------------- RUN */
app.run
(
	function($window, $rootScope) 
	{
		$rootScope.online = navigator.onLine;
		
		$window.addEventListener
		(
			"offline", 
			function () 
			{
        		$rootScope.$apply
        		(
        			function() 
        			{
          				$rootScope.online = false;
        			}
        		);
      		}, 
      		false
      	);
      
      	$window.addEventListener
      	(
      		"online", 
      		function () 
      		{
        		$rootScope.$apply
        		(
        			function() 
        			{
          				$rootScope.online = true;
        			}
        		);
      		}, 
      		false
      	);
	}
);