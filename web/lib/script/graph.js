function runGraph(_json_, _data_, _target_, _caption_,_format_)
{
    if ( _data_ == "rf" )
    {
        var point = 'มม.';
        var yTitle = 'ปริมาณน้ำฝน ('+point+')';
    }
    else
    {
        var point = 'ม.รทก.';
        var yTitle = 'ระดับน้ำ ('+point+')';
    }
            
    // option chart
    var enabletext = (_format_ == "mean" || _format_ == "min" || _format_ == "max") ? true : false
    var options = {
        chart: {
            renderTo: _target_,
            zoomType: 'x',
			type: (_data_ == "rf") ? "column" : (_format_ == "mean" || _format_ == "min" || _format_ == "max") ? "column" : "line"
        },
		credits: {
			enabled: false
		},
        title: {
            text: _caption_,
            y: 25
        },
        tooltip: {
            valueSuffix: ' '+point
        },
        xAxis: {
			type: 'datetime',
			labels: {
                rotation: -45,
                style: {
                    //fontSize: '13px',
                    //fontFamily: 'Verdana, sans-serif'
                }
            },
            //categories: [],
			dateTimeLabelFormats: {
				day: '%e %B %Y',
				week:'%e %B %Y',
				month:'%B %Y',
				year:'%Y'
			}
        },
        yAxis: [{
            title: {
                text: yTitle
            }
		}],
		tooltip: {
			shared: true,
            crosshairs: true,
            followPointer:true,
            useHTML: true,
			/*formatter: function() {
				return  Highcharts.dateFormat('%e. %B %Y %H:%M',this.x) + '<br><b>' + this.series.name + ' ' + this.y +'</b>'+' ' + point;
			}*/
			formatter: function () {
                var s = '<b>' + Highcharts.dateFormat('%e. %B %Y %H:%M',this.x) + '</b>';
				s += '<TABLE>';
                $.each(this.points, function () {
                    s += '<TR><TD style="font-weight:bold;"><span style="color:'+ this.point.color +'">\u25CF</span><span>' + this.series.name + ': </span></TD><TD style="text-align: right">' +
                        this.y.toFixed((_data_ == "rf" ? 1 : 3)) + ' ' + point + '</TD></TR>';
                });
				s += '</TABLE>';
                return s;
            }
		},
		plotOptions: {
			series: {
				marker: {
					enabled: false
				}
				,
				dataLabels: {
                    enabled: enabletext, 
                    rotation: -90,
					color: '#FFFFFF',
					align: 'right',
					format: '{point.y:.2f}', // one decimal
					y: 10, // 10 pixels down from the top
					style: {
						fontSize: '10px'
					}
                }
			}
		},
		scrollbar: {
			 enabled: true
		},
        series: []
		,
		exporting: {
			url: 'http://182.52.224.70/lib/plugins/exporting_server/index.php',
			sourceWidth: 1200,
			sourceHeight: 480,
			width: 2400,
			//scale: 8,
		}
    };             
    var seriesIndex = 0;
	var stationSeries = {};
    // create series
    $.each
    (
        _json_[0].stn,
        function(i, s)
        {
			var stnInfo = getObjects(STATION, 'id', s.id)[0];
			if (_data_ == "rf")
			{
				var seriesOptions = {
					name: stnInfo.name,
					data: [],
					id: s.id + "_rf"
				};
				options.series.push(seriesOptions);
				stationSeries[s.id + "_rf"] = seriesIndex++;
			}
			else if (_data_ == "wl")
			{
				//var yAxis = stnInfo;
				if (stnInfo.data.wl_up.enable)
				{
					var seriesOptions = {
						name: stnInfo.name,
						data: [],
						id: s.id + "_wl_up"
					};
					options.series.push(seriesOptions);
					stationSeries[s.id + "_wl_up"] = seriesIndex++;
				}
				if (stnInfo.data.wl_down.enable)
				{
					var seriesOptions = {
						name: stnInfo.name + '(ท้าย)',
						data: [],
						id: s.id + "_wl_down"
					};
					options.series.push(seriesOptions);
					stationSeries[s.id + "_wl_down"] = seriesIndex++;
				}
			}
        }
    );

    // push point value
    $.each
    (
        _json_,
        function(key, value)
        {
            //options.xAxis.categories.push(value.date);
            
            $.each
            (
                value.stn,
                function(i, v)
                {
                    //options.series[i].data.push((v.value1 == null) ? null : v.value1);
					//var s = '2011-06-21T14:27:28.593Z';
					var a = value.date.split(/[^0-9]/);
					var dateUTC = Date.UTC(a[0],a[1]-1,a[2],a[3],a[4] );
					if (_data_ == "rf")
					{
						options.series[stationSeries[v.id + "_rf"]].data.push([dateUTC, (v.value1 == null) ? null : v.value1]);
					}
					else if (_data_ == "wl")
					{
						if (getObjects(STATION, 'id', v.id)[0].data.wl_up.enable)
							options.series[stationSeries[v.id + "_wl_up"]].data.push([dateUTC, (v.value1 == null) ? null : v.value1]);
						if (getObjects(STATION, 'id', v.id)[0].data.wl_down.enable)
							options.series[stationSeries[v.id + "_wl_down"]].data.push([dateUTC, (v.value2 == null) ? null : v.value2]);
					}
                }
            );
        }
    );

    // build chart
	Highcharts.setOptions({
		lang: {
			months: ['ม.ค.', 'ก.พ.','มี.ค.','เม.ย.','พ.ค.','มิ.ย.','ก.ค.','ส.ค.','ก.ย.','ต.ค.','พ.ย.','ธ.ค.']
		}
	});
    var chart = new Highcharts.Chart(options);
}