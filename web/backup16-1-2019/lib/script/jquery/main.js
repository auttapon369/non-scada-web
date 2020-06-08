var STATION = [];

$(document).ready
(
	function() 
    {
        $.ajax
        (
            {
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