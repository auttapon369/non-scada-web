// function getData(type)
// {
//     $.getJSON
//     (
//         "json.php",
//         //"json.php?app=station", 
//         function(result)
//         {
//             $.each
//             (
//                 result.station, 
//                 function(i, value)
//                 {
//                     $('#station-list').append
//                     (
//                         '<li><a href="./?page=station&id='+value.code+'">'+value.code+' '+value.name+'</a></li>'
//                     );
//                 }
//             );
//         }
//     );
// }

var station = [];

$(document).ready
(
	function() 
    {
        $.ajax
        (
            {
                url: 'json.php',
                async: false,
                dataType: 'json',
                success: function (result) 
                {
                    station = result.station;
                }
            }
        );
        
        // build menu
        $.each
        (
            station, 
            function(i, value)
            {
                $('#station-list').append
                (
                    '<li><a href="./?page=station&id='+value.code+'">'+value.code+' '+value.name+'</a></li>'
                );
            }
        );

        //console.log(station);

        var active = linkAct("?page=");
        $('#m-'+active).addClass('active');
        //console.log(active);

        //var activesub = linkAct("&view=") || 'inbox';
        //$('#m-sub-'+activesub).addClass('active');

        // $('#select-item').change
        // (
        //     function() 
        //     {
        //         var idx = this.selectedIndex;
        //         var link = "./?m=" + selected[1] + "&add=" + idx;
        //         $("#select-add").attr("href", link);
        //     }
        // );

        //console.log(active+' // '+activesub);
        //$('#datepicker').datetimepicker();
	}
);
function linkAct(c)
{
    var selected = location.href.split(c);
    if (selected.length > 1) 
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