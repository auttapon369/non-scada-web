<div class="title">
	<h1 class="text-black">รายงาน<small>ข้อมูลการตรวจวัดปริมาณน้ำฝนและระดับน้ำ</small></h1>
</div>
<div class="filter bd-fade">
	<form class="row">
		<div class="col-sm-12 br">
			<label for="inp-station">เลือกสถานี <small class="text-danger">[ <a id="clear">clear</a> ]</small></label>
			<!-- <select id="inp-station" name="station" class="form-control input-sm"></select> -->
			<ul id="inp-station" class="list-inline"></ul>
		</div>
		<div class="col-sm-2">
			<label for="inp-2">เลือกข้อมูล</label>
			<div class="radio">
				<label>
					<input type="radio" name="data" value="rf" checked>
					ปริมาณน้ำฝน
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="data" value="wl">
					ระดับน้ำ
				</label>
			</div>
		</div>
		<div class="col-sm-2">
			<label for="inp-2">เลือกประเภทรายงาน</label>
			<div class="radio">
				<label>
					<input type="radio" name="format" value="15m" checked>
					ราย15นาที
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="format" value="1h">
					รายชั่วโมง
				</label>
			</div>
			<div class="radio r-mean">
				<label>
					<input type="radio" name="format" value="mean">
					รายวันเฉลี่ย
				</label>
			</div>
		</div>
		<div class="col-sm-4">
			<label for="inp-date-1">เลือกช่วงวันที่</label>
			<div class="input-daterange input-group" id="datepicker">
				<input id="start" type="text" class="input-sm form-control" name="start" value="" />
				<span class="input-group-addon">to</span>
				<input id="end" type="text" class="input-sm form-control" name="end" />
			</div>
		</div>
		<div class="col-sm-4">
			<label>&nbsp;</label>
			<button type="button" class="btn btn-block btn-sm btn-info" onclick="javascript:showData('table')">แสดงตาราง</button>
			<button type="button" class="btn btn-block btn-sm btn-success" onclick="javascript:showData('graph')">แสดงกราฟ</button>
		</div>
	</form>
</div>
<div id="data" class="text-center">
	<!-- <div class="col-lg-10 col-lg-offset-1 text-center">
		<img src="<?php //echo PATH_IMG; ?>test/chart.jpg" class="img-responsive" />
	</div> -->
</div>

<div class="loader"></div>

<!-- script -->
<link href="<?php echo PATH_SCRIPT; ?>bootstrap/css/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>bootstrap/js/bootstrap-datepicker.th.min.js"></script>
<!--<script src="<?php echo PATH_PLUGIN; ?>highcharts/highcharts.js"></script>-->
<script src="<?php echo PATH_PLUGIN; ?>highcharts/highstock.js"></script>
<script src="<?php echo PATH_PLUGIN; ?>highcharts/modules/exporting.js"></script>
<script src="<?php echo PAGE; ?>report/js/table.js"></script>
<!--<script src="<?php //echo PAGE; ?>report/js/graph.js"></script>-->
<script src="<?php echo PATH_SCRIPT; ?>graph.js"></script>
<script src="<?php echo PATH_SCRIPT; ?>report.js"></script>
<script>
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
</script>










