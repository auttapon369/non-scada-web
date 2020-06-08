var PATH_REPORT = 'pages/report/';

function showData(style)
{
    $(".loader").fadeIn('fast');

    var station = [];
    $('input[name="station[]"]:checked').each
    (
        function() 
        { 
            var v = $(this).val();
            station.push(v);
        }
    );

    var stn = station;
    var da = $('input[name=data]:checked').val();
    var fr = $('input[name=format]:checked').val();
    var d1 = $('#start').val().split('/');
    var d2 = $('#end').val().split('/');
    var c = caption(da, fr);
    //console.log(stn);

    $.getJSON
    (
        "json.php", 
        { 
            app: "search",
            id: stn,
            data: da,
            format: fr,
            date1: d1[2]+'-'+d1[1]+'-'+d1[0],
            date2: d2[2]+'-'+d2[1]+'-'+d2[0] 
        } 
    )
    .done
    (
        function(json) 
        {
            //console.log(stn);
            var c = caption(da, fr);

            if ( style == "table" )
            {
                runTable(json.search, da, c);
            }
            else if ( style == "graph" )
            {
                //runGraph(json.search, da, c);
                runGraph(json.search, da, 'data', c ,fr);
            }

            $(".loader").delay(2000).fadeOut();
        }
    );
}

function caption(data,format)
{
    var txt = "";
    
    if ( data == "rf" )
    {
        txt += "ปริมาณน้ำฝน";
    }
    else
    {
        txt += "ระดับน้ำ";
    }
    if ( format == "15m" )
    {
        txt += " (ราย15นาที)";
    }
    else if ( format == "1h" )
    {
        txt += " (รายชั่วโมง)";
    }
    else if ( format == "mean" )
    {
        txt += " (รายวันเฉลี่ย)";
    }

    return txt;
}