<div class="container">
	<div class="row">
		<div class="title">
			<h1 class="text-black">CCTV<small>ภาพถ่ายจากกล้องวงจรปิด</small></h1>
		</div>
	</div>
	<div id="cctv" class="row"></div>
	<hr>
	<div class="row tab-control">
		<div class="col-sm-8 col-sm-offset-2">
			<!-- <a href="./?page=cctv&view=milestone" class="btn btn-block btn-lg btn-primary">ค้นหาข้อมูลย้อนหลัง</a> -->
			<a href="http://182.52.224.70:8081/index.html" class="btn btn-block btn-lg btn-primary" target="_blank">ค้นหาข้อมูลย้อนหลัง</a>
		</div>
	</div>
</div>

<!-- script -->
<script>
$(document).ready
(
	function() 
    {
        //var img = null;

        $.each
        (
            STATION, 
            function(index, value)
            {
                //var img = "themes/img/no-photo.gif";

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
	}
);
</script>