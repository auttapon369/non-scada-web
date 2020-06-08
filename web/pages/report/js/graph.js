function runGraph(json, data, caption)
{
    $("#data").load
    (
        PATH_REPORT+"graph.html",
        function() 
        {
            var range = "วันที่ 1 - 10 มิถุนายน 2559";

            if ( data == "rf" )
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
            var options = {
                chart: {
                    renderTo: 'container',
                    zoomType: 'x'
                    //defaultSeriesType: 'column'
                },
                title: {
                    text: caption
                },
                tooltip: {
                    valueSuffix: ' '+point
                },
                xAxis: {
                    categories: []
                },
                yAxis: {
                    title: {
                        text: yTitle
                    }
                },
				plotOptions: {
					series: {
						marker: {
							enabled: false
						}
					}
				},
                series: []
            };             
            
            // create series
            $.each
            (
                json[0].stn,
                function(i, s)
                {
                    var seriesOptions = {
                        name: s.name,
                        data: []
                    };

                    options.series.push(seriesOptions);
                }
            );

            // push point value
            $.each
            (
                json,
                function(key, value)
                {
                    options.xAxis.categories.push(value.date);
                    
                    $.each
                    (
                        value.stn,
                        function(i, v)
                        {
                            options.series[i].data.push(v.value1);
                        }
                    );
                }
            );

            //console.log(options);

            // build chart
            var chart = new Highcharts.Chart(options);
            
            // $('#container').highcharts({
            //     title: {
            //         text: caption,
            //         x: -20 //center
            //     },
            //     subtitle: {
            //         text: range,
            //         x: -20
            //     },
            //     xAxis: {
            //         categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            //             'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            //     },
            //     yAxis: {
            //         title: {
            //             text: yTitle
            //         },
            //         plotLines: [{
            //             value: 0,
            //             width: 1,
            //             color: '#808080'
            //         }]
            //     },
            //     tooltip: {
            //         valueSuffix: ' '+point
            //     },
            //     legend: {
            //         layout: 'vertical',
            //         align: 'right',
            //         verticalAlign: 'middle',
            //         borderWidth: 0
            //     },
            //     series: [{
            //         name: 'Tokyo',
            //         data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
            //     }, {
            //         name: 'New York',
            //         data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
            //     }, {
            //         name: 'Berlin',
            //         data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
            //     }, {
            //         name: 'London',
            //         data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
            //     }]
            // });


            //$('#graph').attr('src','pages/report/asset/graph-'+data+'.jpg');
            $(".loader").delay(2000).fadeOut();
        }
    );
}