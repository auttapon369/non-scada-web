var STATION = [];

$(document).ready
(
	function() 
    {
        $.ajax
        (
            {
                //url: 'json.php',
                url: 'json.php?app=station',
                async: false,
                dataType: 'json',
                success: function (result)
                {
                    STATION = result.station;
                }
            }
        );
        
        // build menu
        listStation();

        // actived
        var active = linkAct("?page=");
        $('#m-'+active).addClass('active');
        //var activesub = linkAct("&view=") || 'inbox';
        //$('#m-sub-'+activesub).addClass('active');
	}
);

function listStation()
{
    $.each
    (
        STATION,
        function(i, value)
        {
            $('#station-list').append
            (
                '<li><a href="./?page=station&id='+value.code+'">'+value.code+' '+value.name+'</a></li>'
            );
        }
    );
}

function getObjects(obj, key, val) 
{
    var objects = [];

    for ( var i in obj ) 
    {
        if ( !obj.hasOwnProperty(i) ) continue;
        if ( typeof obj[i] == 'object' ) 
        {
            objects = objects.concat(getObjects(obj[i], key, val));
        } 
        else if ( i == key && obj[key] == val ) 
        {
            objects.push(obj);
        }
    }

    return objects;
}

function date_ymd (dt) 
{
    now = new Date(dt);
    year = "" + now.getFullYear();
    month = "" + (now.getMonth() + 1); if (month.length == 1) { month = "0" + month; }
    day = "" + now.getDate(); if (day.length == 1) { day = "0" + day; }
    hour = "" + now.getHours(); if (hour.length == 1) { hour = "0" + hour; }
    minute = "" + now.getMinutes(); if (minute.length == 1) { minute = "0" + minute; }
    second = "" + now.getSeconds(); if (second.length == 1) { second = "0" + second; }
    
    return year + "-" + month + "-" + day + " " + hour + ":" + minute;
}

function dateThai(dt)
{
    now = new Date(dt);
    var thday = new Array ("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
    var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    
    return "วัน" + thday[now.getDay()]+ "ที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " " + (now.getFullYear()+543) + " เวลา " + now.getHours()+":"+((now.getMinutes()<10?'0':'')+now.getMinutes())+"น.";
}

function linkAct(c)
{
    var selected = location.href.split(c);

    if ( selected.length > 1 ) 
    {
        return selected[1].split("&")[0];
    }
    else 
    {
        return false;
    }
}

function confBox(txt)
{
    if ( !confirm(txt) )
    {
        return false;
    }
    
    //return confirm(txt);
}