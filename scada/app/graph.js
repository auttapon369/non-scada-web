app.controller
(
	'trendCtrl',
	function($scope, $timeout, $interval, $_global)
	{
		var ud;
		var dateUTC;
		var scope = this;
		scope.code = "";
		scope.name = "";

		scope.runGraph = function(json,da,tg,wl2)
		{
			var tp = ( da == "rf" ) ? "column" : "line";
		    var options = {
		        chart: {
		        	type: tp,
		        	backgroundColor: "transparent",
		        	zoomType: 'x',
		            renderTo: tg,
		            resetZoomButton: {
				        theme: {
				            display: 'none'
				        }
				    }
		        },
		        title: {
		            text: "xx",
		            y: -100
		        },
		        xAxis: {
					type: 'datetime',
					dateTimeLabelFormats: {
						day: '%e %B %Y',
						week:'%e %B %Y',
						month:'%B %Y',
						year:'%Y'
					},
		            labels: {
		            	style: {
            				color: "#fff"
        				}
		            }
		        },
		        yAxis: {
		            title: {
		                text: ""
		            },
		            labels: {
		            	style: {
            				color: "#fff"
        				}
		            }
		        },
		        legend: {
		        	symbolWidth: 40,
					itemStyle: {
                		color: 'white'
		            }
		        },
		        exporting: {
					enabled: false
				},
				tooltip: {
					shared: true,
		            crosshairs: true,
		            followPointer: true,
		            useHTML: true,
					formatter: function () 
					{
		                var s = '<h6>' + Highcharts.dateFormat('%e/%m/%Y %H:%M',this.x) + '</h6>';
						s += '<ul style="list-style:none;margin:0;padding:0;">';
	                	$.each
	                	(
	                		this.points, 
	                		function () 
	                		{
	                    		s += '<li style="margin:0;text-align:left"><span style="color:'+ this.point.color +'">\u25CF</span> <span>' + this.series.name + ': </span> ' + this.y.toFixed((da == "rf" ? 1 : 3)) + '</li>';
							}
						);
						s += '</ul>';

		                return s;
		            }
				},
				plotOptions: {
					series: {
						color: 'rgb(0,152,213)',
						marker: {
							enabled: false
						}
					}
				},
				scrollbar: {
					enabled: true,
					barBackgroundColor: '#333',
					barBorderColor: '#111',
		            buttonBackgroundColor: '#333',
		            buttonBorderWidth: 0,
		            rifleColor: 'white',
		            trackBackgroundColor: '#222',
		            trackBorderWidth: 0,
		            trackBorderColor: '#111',
				},
		        series: []
		    };

		    if ( da == "rf" )
		    {
		    	options.series.push({name:"ฝน(มม.)", data:[]});
		    }
		    else
		    {
		    	options.series.push({name:"หน้า(ม.รทก.)", data:[], dashStyle: 'solid'});

		    	if (wl2)
		    	{
		    		options.series.push({name:"ท้าย(ม.รทก.)", data:[], dashStyle: 'shortdot'});
		    	}
		    }

		    /* plot value */
		    var dt;
		    $.each
		    (
		        json,
		        function(key, value)
		        {
		        	/*
		        	var time = value.date.split(' ')[1];
		            options.xAxis.categories.push(time);
					options.series[0].data.push(value.stn[0].value1);
		            
		            if (wl2)
		    		{
		    			options.series[1].data.push(value.stn[0].value2);
		    		}
		    		*/

		        	var a = value.date.split(/[^0-9]/);
					var dateUTC = Date.UTC(a[0],a[1]-1,a[2],a[3],a[4] );
					dt = dateUTC;

					if ( da == "rf" )
					{
						options.series[0].data.push([dateUTC, (value.stn[0].value1 == null) ? null : value.stn[0].value1]);
					}
					else
					{
						options.series[0].data.push([dateUTC, (value.stn[0].value1 == null) ? null : value.stn[0].value1]);

						if (wl2)
						{
							options.series[1].data.push([dateUTC, (value.stn[0].value2 == null) ? null : value.stn[0].value2]);
						}
					}
		        }
		    );

			Highcharts.setOptions({
				lang: {
					months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
				}
			});

		    var chart = new Highcharts.Chart(options);
		    /*chart.xAxis[0].setExtremes(dt-720000);*/
		};

		scope.getData = function(stn,da,tg,wl2)
		{
			var dateObj = new Date();
			var month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
			var day = ("0" + dateObj.getDate()).slice(-2);
			var year = dateObj.getFullYear();
			var hour = ("0" + dateObj.getHours()).slice(-2);
			var minute = ("0" + (Math.floor(dateObj.getMinutes() / 15) * 15)).slice(-2);
			var endDate = year + "/" + month + "/" + day + " " + hour + ":" + minute;
			dateObj.setHours(dateObj.getHours() - 24);
			month = ("0" + (dateObj.getMonth() + 1)).slice(-2);
			day = ("0" + dateObj.getDate()).slice(-2);
			year = dateObj.getFullYear();
			hour = ("0" + dateObj.getHours()).slice(-2);
			minute = ("0" + (Math.floor(dateObj.getMinutes() / 15) * 15)).slice(-2);
			startDate = year + "/" + month + "/" + day + " " + hour + ":" + minute;
			var v = "&id[]="+stn+"&data="+da+"&format=15m&date1="+startDate+"&date2="+endDate;

			$_global.request($scope.path.json.search+v).then
			(
				function successCallback(response)
				{
					scope.dataGRAPH = response.data.search;
					scope.runGraph(scope.dataGRAPH,da,tg,wl2);
				},
	  			function errorCallback(response)
	  			{
	  				console.log(response);
	  			}
	  		);
		};

		scope.update = function(id,rf,wl,wl2)
		{
			var now = new Date();
			var utc = Date.UTC(now.getFullYear(), now.getMonth(), now.getDate(), now.getHours(), now.getMinutes(), now.getSeconds());

			if ( dateUTC == null || (Math.floor(dateUTC / 1000 / 60) < Math.floor(utc / 1000/ 60)))
			{
				this.real = $_global.select($scope.dataREAL, 'id', id);
				//dateUTC = $scope.dateUTC(now);
				dateUTC = utc;
				//console.log(dateUTC);
				if (rf)
				{
					var chartRF = $('#graph-rf').highcharts();
					//console.log('rf/ '+this.real.rf.value);
					chartRF.series[0].addPoint([dateUTC,this.real.rf.value],true,false,true);
					if (dateUTC - chartRF.series[0].data[0].x >= (1000 * 60 * 60 * 24))
					{
						chartRF.series[0].removePoint(0, true, true);
					}
					//console.log(dateUTC);
					//console.log(chartRF.series[0].data[0]);
					chartRF.redraw();
				}

				if (wl)
				{
					var chartWL = $('#graph-wl').highcharts();
					//console.log('up/ '+this.real.wl_up.value);
					chartWL.series[0].addPoint([dateUTC,this.real.wl_up.value],true,false,true);
					if (dateUTC - chartWL.series[0].data[0].x >= (1000 * 60 * 60 * 24))
					{
						chartWL.series[0].removePoint(0, true, true);
					}
					if (wl2)
					{
						//console.log('down/ '+this.real.wl_down.value);
						chartWL.series[1].addPoint([dateUTC,this.real.wl_down.value],true,false,true);
						if (dateUTC - chartWL.series[1].data[0].x >= (1000 * 60 * 60 * 24))
						{
							chartWL.series[1].removePoint(0, true, true);
						}
					}
					
					chartWL.redraw();
				}

				/*console.log(dateUTC+' / '+this.real.date);*/
			}
		};
			
		scope.view = function(id)
		{
			scope.selected = $_global.select($scope.dataSTN, 'id', id);
			scope.id = id;
			scope.code = scope.selected.code;
			scope.name = scope.selected.name;

			var rf = scope.selected.data.rf.enable;
			var wl = scope.selected.data.wl_up.enable;
			var wl2 = scope.selected.data.wl_down.enable;

			if ( rf )
			{
				scope.getData(id,'rf','graph-rf',false);
			}
			else
			{
				$('#graph-rf').html("");
			}

			if ( wl )
			{
				scope.getData(id,'wl','graph-wl',wl2);
			}
			else
			{
				$('#graph-wl').html("");
			}

			dateUTC = null;
			$interval.cancel(ud);
			ud = $interval
			(
				function()
				{
					scope.update(id,rf,wl,wl2);
				},
				1000
			);
		};

		/*scope.click = function(id)
		{
			var chart = $('#graph-wl').highcharts();
			var dateUTC = $scope.dateUTC();
			
			chart.series[0].addPoint([dateUTC,10]);
			chart.series[1].addPoint([dateUTC,10]);
			chart.redraw();
		}*/
	}
);