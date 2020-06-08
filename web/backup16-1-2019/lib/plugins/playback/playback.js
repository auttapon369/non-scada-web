/* 

playback 1.0.0 
licences & developed by Guzmin
- guzmin@gmail.com

*/

var PATH;
var LOOP;
var PLUS = 0;
var N = 0;

var playback = function(obj)
{
    var swap = '<div class="swap btn-group">' +
        '<a title="0" class="btn btn-sm btn-default active">' +
            '<span class="glyphicon glyphicon-facetime-video"></span> ' + obj.button.swap[0] +
        '</a>' +
        '<a title="1" class="btn btn-sm btn-default">' +
            '<span class="glyphicon glyphicon-facetime-video"></span> ' + obj.button.swap[1] +
        '</a>' +
    '</div>';

    var q = (obj.log) ? '<q class="text-fade"></q>' : '';

    var control = '<div class="control">' +
        '<a title="0" class="btn btn-sm btn-default">' +
            '<span class="glyphicon glyphicon-play"></span> ' + obj.button.control +
        '</a>' + q +
    '</div>';
    
    $('#playback').append(control);    
    $('#playback').append(swap);
    $('#playback').addClass('playback');


    // swap
    if ( obj.img.src.length < 2 )
    {
        $('.swap').hide();
    }    
    $('.swap a').click
    (
        function()
        {
            N = $(this).attr('title');
            loopstop(obj.img.id, obj.img.src[N]);
            $('.swap a').removeClass('active');
            $(this).addClass('active');
        }
    );


    // play
    $('.control a').click
    (
        function()
        {
            var atv = $('.control a');
            var icon = $('.control span');
            
            if ( atv.attr('title') == 0 )
            {
                //PATH = "http://182.52.224.70/MilestoneImageService/ImageService.svc/ImageService/GetImage?width=800&height=450&ondate=2016-06-13 01:27&cameraname=A1-คลองท่าทราย Cam2";
                PATH = $('#'+obj.img.id).attr('src');
                LOOP = setInterval
                (
                    function()
                    {
                        var x = loopback(obj.img.stack, obj.speed, obj.range);
                        if ( $.isArray(x) )
                        {
                            $('.control q').html(x[0]);
                            $('#'+obj.img.id).attr('src', x[1]);
							setwaterlevel(obj.stn, x[0]);
                        }
                        else
                        {
                            loopstop(obj.img.id, obj.img.src[N]);
                        }
                    },
                    1000
                );
                
                icon.removeClass('glyphicon-play');
                icon.addClass('glyphicon-pause');
                atv.addClass('active');
                atv.attr('title',1);
            }
            else
            {
                loopstop(obj.img.id, obj.img.src[N]);
            }
        }
    );
};

function loopback(stack, speed, range)
{
    var dt_start, dt_loop, newpath;
    var path_1 = PATH.split(stack[0]);
    var path_2 = path_1[1].split(stack[1]);
    var dt = path_2[0].replace(/-/g, "/");  // replace for Safari & IE

    PLUS = PLUS + speed;
    dt_start = new Date(dt);
    dt_loop = new Date(dt);
    dt_loop.setSeconds(dt_loop.getSeconds() - range);
    dt_loop.setSeconds(dt_loop.getSeconds() + PLUS);
    dt_loop = date_ymd(dt_loop);
    newpath = path_1[0] + stack[0] + dt_loop + stack[1] + path_2[1];
    
    //console.log(dt_start);
    
    if ( date_ymd(dt_start) < dt_loop )
    {
        return false;
    }
    else
    {
        return [dt_loop, newpath];
    }
}

function loopstop(id, src)
{
    PLUS = 0;
    clearInterval(LOOP);
    $('#'+id).attr('src', src);
    $('.control span').removeClass('glyphicon-pause');
    $('.control span').addClass('glyphicon-play');
    $('.control a').removeClass('active');
    $('.control a').attr('title',0);
    $('.control q').html('');
}

function setwaterlevel(stn, onDate)
{
	$.getJSON
	(
		'/CrossSectionService/CrossSectionService.svc/SVGService/GetCrossSectionData', 
		{ 
			stnCode: stn,
			onDate: onDate
		} 
	)
	.done
	(
		function(json) 
		{
			var riverBed = json.riverBed;
			var wlUp = json.wlUp * 100;
			var wlDown = json.wlDown * 100;
			$("#timestampValue").text(json.onDate);
			$("#wlUpValue").text(json.wlUp.toFixed(2));
			var s = Snap("#wlUp");
			s.animate({
				y: -(wlUp),
				height: -(riverBed - wlUp)
			}, 300);
			var s2 = Snap("#wlUpGroup");
			s2.animate({
				transform: 'translate(150, ' + (-(wlUp)) + ')',
				fill: json.wlUpColor
			}, 300);
			$("#wlDownValue").text(json.wlDown.toFixed(2));
			var s = Snap("#wlDown");
			s.animate({
				y: -(wlDown),
				height: -(riverBed - wlDown)
			}, 300);
			var s2 = Snap("#wlDownGroup");
			s2.animate({
				transform: 'translate(450, ' + (-(wlDown)) + ')',
				fill: json.wlDownColor
			}, 300);
		}
	);
}