function runGraph(_json_, _data_, _target_, _caption_)
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
    var options = {
        chart: {
            renderTo: _target_,
            zoomType: 'x'
        },
        title: {
            text: _caption_,
            y: 25
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
        series: []
    };             
    
    // create series
    $.each
    (
        _json_[0].stn,
        function(i, s)
        {
            var seriesOptions = {
                name: getObjects(STATION, 'id', s.id)[0].name,
                data: []
            };

            options.series.push(seriesOptions);
        }
    );

    // push point value
    $.each
    (
        _json_,
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

    // build chart
    var chart = new Highcharts.Chart(options);
}