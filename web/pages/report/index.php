<div class="title">
	<h1 class="text-black">รายงาน<small>ข้อมูลการตรวจวัดปริมาณน้ำฝนและระดับน้ำ</small></h1>
</div>
<div class="filter bd-fade">
	<form class="row">
		<div class="col-sm-12 br">
			<label for="inp-station">เลือกสถานี <small class="text-danger">[ <a id="clear">clear</a> ]</small></label>
			<?php if(!empty($_SESSION['ses_name'])){?><button type="button" class="btn btn-success btn-sm" id="bookmarks">บันทึกการค้นหา</button>
			<select id="favorit" class="selectpicker">
			<option></option>
			</select>
			<?php } ?>
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
					รายวัน
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="format" value="min">
					รายวันต่ำสุด
				</label>
			</div>
			<div class="radio">
				<label>
					<input type="radio" name="format" value="max">
					รายวันสูงสุด
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
<style>
.disabled {
   color: lightgrey;
}
</style>
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

		  var items="";
		  $.getJSON("pages/report/selectBookmarks.php?type=list",function(data){
			items+="<option value=''>เลือกประวัติการค้นหาข้อมูล</option>";
			$.each(data,function(index,item) 
			{
			  items+="<option value='"+item.id+"'>"+item.name+"</option>";
			});
			$("#favorit").html(items); 
		 });


		var dataType = $( "input[name='data']" ).val();

        $.each
        (
            STATION,
            function(i, value)
            {
				var stnInfo = getObjects(STATION, 'id', value.id)[0];
				var strDisable = "disabled";
				var strClass = " disabled";
				if (dataType == 'rf')
				{
					if (stnInfo.data.rf.enable)
					{
						strClass = strDisable = "";
					}
				}
				else
				{
					if (stnInfo.data.wl_up.enable)
					{
						strClass = strDisable = "";
					}
				}
                $('#inp-station').append
                (
                    //'<option value="'+value.id+'">'+value.code+' '+value.name+'</option>'
                    '<li><label class="item'+strClass+'"><input type="checkbox" name="station[]" value="'+value.id+'" '+strDisable+'/> '+value.code+' '+value.name+'</label></li>'
                );
            }
        );

        //$('.r-mean').hide();
        $('input[name="data"]').change
        (
            function() 
            { 
//                if ( $('input[name="data"]:checked').val() == "rf" )
//                {
//                    $('.r-mean').hide();
//                }
//                else
//                {
//                    $('.r-mean').show();
//                }

                $('input[value="15m"]').prop('checked', true);

				dataType = this.value;

				$.each
				(
					STATION,
					function(i, value)
					{
						var stnInfo = getObjects(STATION, 'id', value.id)[0];
						var listItem = $('input[name="station[]"][value="'+value.id+'"]');
						if (dataType == 'rf')
						{
							if (stnInfo.data.rf.enable)
							{
								listItem.removeAttr('disabled');
								listItem.parent().removeClass('disabled');
							}
							else
							{
								listItem.removeAttr('checked');
								listItem.attr("disabled", 'disabled');
								listItem.parent().addClass('disabled');
							}
						}
						else
						{
							if (stnInfo.data.wl_up.enable)
							{
								listItem.removeAttr('disabled');
								listItem.parent().removeClass('disabled');
							}
							else
							{
								listItem.removeAttr('checked');
								listItem.attr("disabled", 'disabled');
								listItem.parent().addClass('disabled');
							}
						}
					}
				);
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



    $('#bookmarks').click
        (
            function() 
            { 
			
				var name_b = prompt("โปรดกรอกชื่อเตือนความจำ");

				if(name_b==null)
				{
					return;
				}
				
                var datas = $('input[name="data"]:checked').val();
				var format = $('input[name="format"]:checked').val();				
				var stn = [];
				$. each($('input[name="station[]"]:checked'), function()
				{
				stn. push($(this). val());
				});
				jQuery.post('pages/report/addBookmarks.php', {
				name:name_b,
				typedata:datas,
				typereport:format,
				station:stn
				},  function(data, textStatus){
					if(data == 1){

						alert("บันทึกเรียบร้อย");
					}
					else
					{
						alert("ไม่สามารถบันทึก");
					}

					}
					);

            }
        );

		$("#favorit").change(
			function(){
			
			var idd= $("#favorit").val();
			 $.getJSON("pages/report/selectBookmarks.php?id="+idd,function(data){
			if(data.typeData=='wl'){$('.r-mean').show();}
			 $('input[name="data"][value="' + data.typeData + '"]').prop('checked', true);
			 $('input[name="format"][value="' + data.typeReport + '"]').prop('checked', true);
			 var stn = data.stn.split(",");
			 $('input[name="station[]"]:checked').removeAttr('checked');
			 $.each(stn,function(number)
			 {
				$('input[name="station[]"][value="' + stn[number] + '"]').prop('checked', true);
			 }
				 );
		 });


		});

</script>










