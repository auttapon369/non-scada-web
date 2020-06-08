<script type="text/javascript" src="./pages/report/tableExport/libs/FileSaver/FileSaver.min.js"></script>
<script type="text/javascript" src="./pages/report/tableExport/tableExport.js"></script>
  <script type="text/javascript" src="./pages/report/tableExport/libs/jsPDF/jspdf.min.js"></script>
  <script type="text/javascript" src="./pages/report/tableExport/libs/jsPDF-AutoTable/jspdf.plugin.autotable.js"></script>
  <script type="text/javascript" src="./pages/report/tableExport/libs/html2canvas/html2canvas.min.js"></script>
  <script type="text/javaScript">
	
    function doExport(selector, params) {
      
		
		 var options = {
        //ignoreRow: [1,11,12,-2],
        //ignoreColumn: [0,-1],
        tableName: 'Countries',
        worksheetName: 'Countries by population'
      };

      $.extend(true, options, params);

      $(selector).tableExport(options);

			$("#r1").text("ลำดับ");
			 $("#r2").text("จุดวัด");
			 $("#r3").text("ระยะเวลาฝนตก (น.)");
			$("#r4").text("ปริมาณฝน (มม.)");
			$("#w1").text("ลำดับ");
			 $("#w2").text("จุดวัด");
			 $("#w3").text("ระยะเวลาน้ำท่วมขัง (น.)");
			$("#w4").text("ระดับน้ำสูงสุด (ม.)");

	}
    
    function DoOnCellHtmlData(cell, row, col, data) {
      var result = "";
      if (data != "") {
        var html = $.parseHTML( data )

        $.each( html, function() {
          if ( typeof $(this).html() === 'undefined' )
            result += $(this).text();
          else if ( $(this).is("input") )
            result += $('#'+$(this).attr('id')).val();
          else if ( ! $(this).hasClass('no_export') )
            result += $(this).html();
        });
      }
      return result;
    }

    function DoOnMsoNumberFormat(cell, row, col) {
      var result = "";
      if (row > 2 && col == 0)
        result = '\\@';
      return result;
    }

  </script>
    <script type="text/javascript">

$(document).ready(function(){   
    /* TOGGLE FUNCTION */
    $(".toggle").on("click",function(){
        var elm = $("#"+$(this).data("toggle"));
        if(elm.is(":visible"))
            elm.addClass("hidden").removeClass("show");
        else
            elm.addClass("show").removeClass("hidden");
        
        return false;
    });

	 $(".toggle1").on("click",function(){
        var elm = $("#"+$(this).data("toggle"));
        if(elm.is(":visible"))
            elm.addClass("hidden").removeClass("show");
        else
            elm.addClass("show").removeClass("hidden");
        
        return false;
    });
/*click export pdf*/

	

  });  
 </script>
<div class="title">
	<h1 class="text-black">ข้อมูลสถิติ<small>สรุปสถานะการณ์ฝนตกและน้ำท่วมขัง</small></h1>
</div>

<div>

			<div class="panel panel-default">
				<div class="panel-heading"><i class="glyphicon glyphicon-time"></i> <small id="date"></small> ย้อนหลังถึง <small id="date1"></small></div>
			  </div>
					<div class="pull-right">
                                        <button class="btn btn-danger toggle" data-toggle="exportTable"><i class="fa fa-bars"></i> Export Data</button>
                                    </div>
 <div class="panel-body" id="exportTable" style="display:none">
                                    <div class="row">
                                     
                                        <div class="col-md-3">
                                            <div class="list-group border-bottom">
                                                <a href="#" class="list-group-item" onClick="doExport('#pvtTablerf', {type: 'excel'});"><img src='http://demos.w3lessons.info/assets/images/icons/xls.png' width="24"/> XLS</a>
                                       
                                            </div>
                                        </div>
                                        
                                    </div>                               
                                </div>
			<div ng-app="myApp">
						<!-- น้ำฝน -->
						<div  ng-controller="CtrlRF"> 
						<div class="panel panel-default">
						<div class="panel-heading">ปริมาณฝนสูงสุด ช่วงเวลา</div>
						<div class="panel-body">
						<table class="table table-bordered" id="pvtTablerf">	
						
						<thead id="thead" class="bg-black bd-fade">
						<tr>
						<th class="col-sm-1" id="r1">ลำดับ</th>
						<th class="col-sm-3" id="r2">จุดวัด</th>
						<th class="col-sm-5" id="r3">ระยะเวลาฝนตก (น.) </th>
						<th class="col-sm-3" id="r4">ปริมาณฝน (มม.)</th>
						
						</tr>
						</thead>
						  <tr ng-repeat="(key,x) in rf | orderBy:'-sumval'">
							<td>{{ key +1 }}</td>
							<td>{{ x.name }}</td>
							<td>
									<ul><li ng-repeat="d in x.data">{{ d.min +" ถึง "+ d.max }} </li></ul>
							</td>
							<td>
									<ul><li ng-repeat="v in x.data">{{ v.value }} </li></ul>
							</td>
							
						  </tr>
						</table>

						</div>
						</div>

						</div>
				
						<!-- ระดับน้ำผิวถนน -->

					<div class="pull-right">
                                        <button class="btn btn-danger toggle1" data-toggle="exportTable1"><i class="fa fa-bars"></i> Export Data</button>
                                    </div>
 <div class="panel-body" id="exportTable1" style="display:none">
                                    <div class="row">
                                     
                                        <div class="col-md-3">
                                            <div class="list-group border-bottom">
                                                <a href="#" class="list-group-item" onClick="doExport('#pvtTablewl', {type: 'excel'});"><img src='http://demos.w3lessons.info/assets/images/icons/xls.png' width="24"/> XLS</a>
                                       
                                            </div>
                                        </div>
                                        
                                    </div>                               
                                </div>
						<div  ng-controller="CtrlWL"> 
						<div class="panel panel-default">
						<div class="panel-heading">ระดับน้ำผิวถนนสูงสุด ช่วงเวลา</div>
						<div class="panel-body">
				
								<table class="table table-bordered" id="pvtTablewl">

						<thead id="thead" class="bg-black bd-fade">
						<tr>
						 <th class="col-sm-1" id="w1">ลำดับ</th>
						<th class="col-sm-3" id="w2">จุดวัด</th>
						<th class="col-sm-5" id="w3">ระยะเวลาน้ำท่วมขัง (น.)</th>
						<th class="col-sm-3" id="w4">ระดับน้ำสูงสุด (ม.)</th>
						
						</tr>
						</thead>
						
						  <tr ng-repeat="(keyy,xx) in wl | orderBy:'-sumval'">
							<td>{{ keyy +1 }}</td>
							<td>{{ xx.name }}</td>
							<td>
									<ul><li ng-repeat="dd in xx.data">{{ dd.min +" ถึง "+ dd.max }} </li></ul>
							</td>
							<td>
									<ul><li ng-repeat="vv in xx.data">{{ vv.value }} </li></ul>
							</td>
							
						  </tr>
						</table>
						</div>
						</div>

						</div>
			</div><!-- End myApp-->


</div>

<!-- script -->
<script>
$(document).ready
(
	function() 
    {
		var d = new Date();
		var d1 = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate();
		var d2 = d.getFullYear()+'-'+(d.getMonth()+1)+'-'+(d.getDate() - 2);
	
		$('#date').html(dateThai(d1));
		$('#date1').html(dateThai(d2));
		//
	}
);

function dateThai(dt)
{
    now = new Date(dt);
    var thday = new Array ("อาทิตย์","จันทร์","อังคาร","พุธ","พฤหัส","ศุกร์","เสาร์"); 
    var thmonth = new Array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน", "กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
 
    return "วัน" + thday[now.getDay()]+ "ที่ "+ now.getDate()+ " " + thmonth[now.getMonth()]+ " " + (now.getFullYear()+543);
}
</script>

<script>
var app = angular.module('myApp', []);

app.controller('CtrlRF', function($scope, $http) {
    $http.get("./json.php?app=report&para=rf")
    .then(function (response) {$scope.rf = response.data.reports;});
});
app.controller('CtrlWL', function($scope, $http) {
   $http.get("./json.php?app=report&para=wl")
    .then(function (response) {$scope.wl = response.data.reports;});
});
</script>

<script>
//var appwl = angular.module('myApp', []);
//appwl.controller('CtrlWL', function($scope, $http) {
//    $http.get("./json.php?app=report&para=wl")
//    .then(function (response) {$scope.wl = response.data.reports;});
//});
</script>