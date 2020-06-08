var PATH_REPORT = 'pages/report/';

$(document).ready
(
	function() 
    {
        $.each
        (
            STATION,
            function(i, value)
            {
                $('#inp-station').append
                (
                    //'<option value="'+value.id+'">'+value.code+' '+value.name+'</option>'
                    '<li><label class="item"><input type="checkbox" name="station[]" value="'+value.id+'" /> '+value.code+' '+value.name+'</label></li>'
                );
            }
        );

        $('.r-mean').hide();
        $('input[name="data"]').change
        (
            function() 
            { 
                if ( $('input[name="data"]:checked').val() == "rf" )
                {
                    $('.r-mean').hide();
                }
                else
                {
                    $('.r-mean').show();
                }

                $('input[value="15m"]').prop('checked', true);
            }
        );

        $('#clear').click
        (
            function() 
            { 
                $('input[name="station[]"]:checked').removeAttr('checked');
            }
        );

        $('.input-daterange').datepicker
        (
            {
                format: "dd/mm/yyyy",
                language: "th",
                autoclose: true,
                todayHighlight: true
            }
        );

        $("#start").datepicker("setDate", new Date());
	}
);

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
            app: "search-test",
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
            //console.log(json.search);
            var c = caption(da, fr);

            if ( style == "table" )
            {
                runTable(json.search, da, c);
            }
            else if ( style == "graph" )
            {
                runGraph(json.search, da, c);
            }
        }
    );
}

function caption(data,format)
{
    var txt = "";
    
    if ( data == "rf" )
    {
        txt += "ตารางปริมาณน้ำฝน";
    }
    else
    {
        txt += "ตารางระดับน้ำ";
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