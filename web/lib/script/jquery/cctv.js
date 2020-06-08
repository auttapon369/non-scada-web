$(document).ready
(
	function() 
    {
        var img = null;

        $.each
        (
            STATION, 
            function(index, value)
            {
                var img = "themes/img/no-photo.gif";

                $.each
                (
                    value.cctv, 
                    function(i, photo)
                    {
                        $('#cctv').append
                        (
                            '<div class="photo col-xs-6 col-sm-3"><a href="javascript:void(0)"><img src="'+photo+'" width="100%"/></a><span class="name">'+value.code+' '+value.name+'</span><span class="date">'+value.date+'</span></div>'
                            //'<div class="photo zoom col-xs-6 col-sm-3"><a href="#" class="fancybox" data-fancybox-type="iframe"><img src="'+photo+'" width="100%" target="_blank"/></a><span class="name">'+value.code+' '+value.name+'</span><span class="date">'+value.date+'</span></div>'
                        );
                    }
                );
            }
        );

        $(".photo").click
        (
            function() 
            {
                $(this).toggleClass('fullscreen');
            }
        );


        // fancy
        $(".fancybox").fancybox
        (
            {
                helpers :
                {
                    title :
                    {
                        type : 'inside'
                    },
                    overlay :
                    {
                        css :
                        {
                            'background' : 'rgba(238,238,238,0.85)'
                        }
                    }
                },
                fitToView   : true,
                maxWidth    : 800,
                maxHeight   : 450,
                // width       : '100%',
                // height      : '100%',
                closeClick  : true,
                autoSize    : true,
                openEffect  : 'none',
                closeEffect : 'none'
            }
        );
	}
);