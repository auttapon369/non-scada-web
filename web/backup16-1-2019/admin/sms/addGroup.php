<script type="text/javascript">
$('document').ready(function(){
 $('#fok').click(function(e){
        e.preventDefault();
        e.stopPropagation();
if($('#fgroup_name').val()==""){
alert("กรุณากรอกชื่อกลุ่ม");
return false;
} else
{
var fname = $('#fgroup_name').val();
}
if($('#fgroup_content').val()==""){
alert("กรุณากรอกข้อความ");
return false;
}else
{
var massage = $('#fgroup_content').val();
}
if($('#parameter').val()==""){
alert("กรุณากรอกข้อความ");
return false;
}else
{
var parameter = $('#parameter').val();
}

if($('#level').val()==""){
alert("กรุณากรอกข้อความ");
return false;
}else
{
var lv = $('#level').val();
}


jQuery.post('sms/process_addGroup.php', {
fgroup_name:fname,
fgroup_content: massage,
para:parameter,
level:lv,
chk:$('#sta').val()
},  function(data, textStatus){
if(data == 1){

window.location.reload();
}else{

window.location.reload();
}
});
});//fok

var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
var phoneno = /^\d{10}$/; 
$('#insertuser').click(function(e){
        e.preventDefault();
        e.stopPropagation();

if($('#email').val()=="" || !re.test($('#email').val())){
alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
return false;
} else
{
var email = $('#email').val();
}
if($('#tel').val()=="" || !$('#tel').val().match(phoneno)){
alert("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
return false;
}else
{
var tel = $('#tel').val();
}
if($('#groupid').val()==""){
alert("เลือกกลุ่ม");
return false;
}else
{
var groupid = $('#groupid').val();
}

if($('#status').is(':checked')){
var st = $('#status').val();
}else
{

var st = 'N';
}


jQuery.post('sms/process_adduser.php', {
email:email,
tel: tel,
groupid:groupid,
status:st,
chk:'insert'
},  function(data, textStatus){
if(data == 1){

window.location.reload();
}else{

window.location.reload();
}
});
});//fok


});
</script>

<?php
$dsn = "Driver={SQL Server};Server=127.0.0.1;Database=nonburi";
$conn = odbc_connect($dsn, 'sa', 'ata+ee&c');


?>


<div class="text-right">			
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addgroupModal" data-whatever="@mdo">เพิ่มกลุ่ม</button>
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#adduserModal" data-whatever="@mdo">เพิ่มผู้รับ</button>
</div>				

<?php

	$query_g="Select * From dbo.group_user_sms";
	
	$rs_g=odbc_exec($connection,$query_g);
	while($r_g=odbc_fetch_array($rs_g))
	{
	$group_name=iconv('TIS-620', 'UTF-8',$r_g['group_name']);
	$group_content=iconv('TIS-620', 'UTF-8',$r_g['group_massage']);
	?>
		<table class="table table-responsive">
			<!-- <caption class="title"><?php=$ee=iconv('TIS-620', 'UTF-8',$r_g[group_name])?></caption> -->
			<tr class="something info">
				<td class="col-md-2 text-left">กลุ่ม: <?php echo$ee.$group_name?></td>
				<td class="col-md-2 text-left">เตือนภัย: <?php echo ($r_g['parameter']==1)?'น้ำฝน':'ระดับน้ำ';?></td>
				<td class="col-md-1.5 text-left">ระดับ: <?php echo ($r_g['alarm_level']==1)?'เฝ้าระวัง':'วิกฤต';?> </td>				
				<td class="col-md-6 text-left">ข้อความ: <?php echo$group_content;?></td>
				<td class="col-md-0.5 text-left"><button type="button" class="btn btn-default" data-toggle="modal" data-target="#editgroupModal-<?php echo $r_g['group_id'];?>" data-whatever="@mdo"><i class="glyphicon glyphicon-pencil"></i></button>
				</td>
				
			</tr>
			</table>
			<table class="table table-responsive table-bordered">
			<tr>
				<td>#</td>
				<td>อีเมลล์ </td>
				<td>หมายเลขโทรศัพท์มือถือ</td>
				<td>&nbsp;</td>
				<td>&nbsp;</td>
			</tr>
			<?php
            $query_group="Select * From dbo.users_sms Where group_id=$r_g[group_id]";
			$rs_group=odbc_exec($connection,$query_group);
			$rownum=1;
			while($r_group=odbc_fetch_array($rs_group))
			{
			?>
				

				<tr>
					<td><?php echo$rownum;?></td>
					<td><?php echo$r_group['email'];?></td>
					<td><?php echo$r_group['telnum'];?></td>
					<td><a href="./?menu=Setting&view=caution&page=editUserGroup&fuser_id=<?php echo$r_group['id'];?>"></a></td>
					<td><button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#edituserModal-<?php echo$r_group['id'];?>" data-whatever="@mdo"><i class="glyphicon glyphicon-pencil"></i></button></td>
				</tr>
	

<script type="text/javascript">	
		//$(function(){					
$('document').ready(function(){
  
var re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;
var phoneno = /^\d{10}$/; 
$('#edituser<?php echo$r_group[id];?>').click(function(e){
        e.preventDefault();
        e.stopPropagation();

if($('#email<?php echo$r_group[id];?>').val()=="" || !re.test($('#email<?php echo$r_group[id];?>').val())){
alert("กรุณากรอกอีเมล์ให้ถูกต้อง");
return false;
} else
{
var email = $('#email<?php echo$r_group[id];?>').val();
}
if($('#tel<?php echo$r_group[id];?>').val()=="" || !$('#tel<?php echo$r_group[id];?>').val().match(phoneno)){
alert("กรุณากรอกเบอร์โทรศัพท์ให้ถูกต้อง");
return false;
}else
{
var tel = $('#tel<?php echo$r_group[id];?>').val();
}
if($('#groupid<?php echo$r_group[id];?>').val()==""){
alert("เลือกกลุ่ม");
return false;
}else
{
var groupid = $('#groupid<?php echo$r_group[id];?>').val();
}

if($('#status<?php echo$r_group[id];?>').is(':checked')){
var st = $('#status<?php echo$r_group[id];?>').val();
}else
{

var st = 'N';
}


jQuery.post('sms/process_adduser.php', {
email:email,
tel: tel,
groupid:groupid,
status:st,
chk:'edit',
id:'<?php echo$r_group[id];?>'
},  function(data, textStatus){
if(data == 1){

window.location.reload();
}else{

window.location.reload();
}
});
});//


});
</script>


					<!-- MODAL edit USER-->
					<div class="modal fade" id="edituserModal-<?php echo$r_group['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
									  <div class="modal-dialog" role="document">
										<div class="modal-content">
										  <div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											<h4 class="modal-title" id="exampleModalLabel">เพิ่มผู้รับข้อความ</h4>
										  </div>
										  <div class="modal-body">
											<form>
											  <div class="form-group">
												<label for="recipient-name" class="control-label">อีเมล์:</label>
												<input type="text" class="form-control" id="email<?php echo$r_group['id'];?>" value="<?php echo $r_group['email'];?>" >
											  </div>
											   <div class="form-group">
												<label for="recipient-name" class="control-label">เบอร์โทร:</label>
												<input type="text" class="form-control" id="tel<?php echo$r_group['id'];?>" value="<?php echo $r_group['telnum'];?>" >
											  </div>
												<div class="form-group">
											  <label for="recipient-name" class="control-label">กลุ่มแจ้งเตือน:</label>
											  <select id="groupid<?php echo$r_group['id'];?>" class="form-control">
											   <option value="">เลือกกลุ่ม</option>
											  <?php 
													$query = "SELECT group_id,group_name FROM dbo.group_user_sms ORDER BY group_id";
													$result = odbc_exec($connection,$query);

														while ($row = odbc_fetch_array($result))
														{
															if($row['group_id'] ==$r_group['group_id']){$s="selected";}else{$s="";}
															echo "<option value='".$row['group_id']."' ".$s.">".iconv('TIS-620', 'UTF-8',$row['group_name'])."</option>";
														}
												?>
											  </select>
											  </div>
												 <div class="form-group">
												
												<input type="checkbox" id="status<?php echo$r_group['id'];?>" value="Y" <?php echo($r_group['status']=="Y")?'checked':'';?>><label for="recipient-name" class="control-label"> รับข้อความ</label>
											  </div>
												
											  
											</form>
										  </div>
										  <div class="modal-footer">
											<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
											<button type="button" class="btn btn-primary" id="edituser<?php echo$r_group['id'];?>">บันทึก</button>
										  </div>
										</div>
									  </div>
									</div>
					<!-- MODAL edit USER-->


			<?php			
			$rownum++;
			} //end while
			?>
		</table>
		<br>

<script type="text/javascript">	
		//$(function(){					
$('document').ready(function(){
    $('#edit<?php echo$r_g[group_id];?>').click(function(e){
        e.preventDefault();
        e.stopPropagation();

		if($('#recipient-name<?php echo$r_g[group_id];?>').val()==""){
alert("กรุณากรอกชื่อกลุ่ม");
return false;
} else
{
var fname = $('#recipient-name<?php echo$r_g[group_id];?>').val();
}
if($('#message-text<?php echo$r_g[group_id];?>').val()==""){
alert("กรุณากรอกข้อความ");
return false;
}else
{
var massage = $('#message-text<?php echo$r_g[group_id];?>').val();
}
if($('#parameter<?php echo$r_g[group_id];?>').val()==""){
alert("เลือกพารามิเตอร์");
return false;
}else
{
var parameter = $('#parameter<?php echo$r_g[group_id];?>').val();
}

if($('#level<?php echo$r_g[group_id];?>').val()==""){
alert("เลือกระดับเตือนภัย");
return false;
}else
{
var lv = $('#level<?php echo$r_g[group_id];?>').val();
}
console.log($('#id').val());
jQuery.post('sms/process_addGroup.php', {
fgroup_name:fname,
fgroup_content: massage,
para:parameter,
level:lv,
chk:$('#sta1<?php echo$r_g[group_id];?>').val(),
id:$('#idd<?php echo$r_g[group_id];?>').val()
},  function(data, textStatus){
if(data == 1){
window.location.reload();
}else{
window.location.reload();
}
});
 });
});
</script>


			<!-- MODAL edit group-->
				<div class="modal fade" id="editgroupModal-<?php echo $r_g['group_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">แก้ไขกลุ่ม</h4>
					  </div>
					  <div class="modal-body">
						<form>
						  <div class="form-group">
							<label for="recipient-name" class="control-label">ชื่อกลุ่ม:</label>
							<input type="text" class="form-control" id="recipient-name<?php echo$r_g['group_id'];?>" value="<?php echo trim($group_name);?>">
						  </div>
						  <div class="form-group">
						  <label for="recipient-name" class="control-label">เตือนภัย:</label>
						  <select id="parameter<?php echo$r_g['group_id'];?>" class="form-control">
						  <option value="<?php echo$r_g['parameter'];?>"><?php echo ($r_g['parameter']==1)?'น้ำฝน':'ระดับน้ำ'?></option>
						  <option value="1">น้ำฝน</option>
						  <option value="2">ระดับน้ำ</option>
						  </select>
						  </div>

						  	  <div class="form-group">
						  <label for="recipient-name" class="control-label">ระดับ:</label>
						  <select id="level<?php echo$r_g['group_id'];?>" class="form-control">
						  <option value="<?php echo$r_g['alarm_level'];?>"><?php echo ($r_g['alarm_level']==1)?'เฝ้าระวัง':'วิกฤต'?></option>
						  <option value="1">เฝ้าระวัง</option>
						  <option value="2">วิกฤต</option>
						  </select>
						  </div>

						  <div class="form-group">
							<label for="message-text" class="control-label">ข้อความแจ้งเตือน:</label>
							<textarea class="form-control" id="message-text<?php echo$r_g['group_id'];?>" ><?php echo trim($group_content);?></textarea>
							<input  type="hidden" id="sta1<?php echo$r_g['group_id'];?>" value="edit">
						  <input  type="hidden" id="idd<?php echo$r_g['group_id'];?>" value="<?php echo$r_g['group_id'];?>">
						  </div>
						  
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
						<button type="button" class="btn btn-primary" id="edit<?php echo $r_g['group_id'];?>">บันทึก</button>
					  </div>
					</div>
				  </div>
				</div>
					<!-- MODAL edit group-->
	<?php 
	} //end While ms_group
?>





								<!-- MODAL Add group-->
				<div class="modal fade" id="addgroupModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">เพิ่มกลุ่ม</h4>
					  </div>
					  <div class="modal-body">
						<form>
						  <div class="form-group">
							<label for="recipient-name" class="control-label">ชื่อกลุ่ม:</label>
							<input type="text" class="form-control" id="fgroup_name" value="">
						  </div>
						    <div class="form-group">
						  <label for="recipient-name" class="control-label">เตือนภัย:</label>
						  <select id="parameter" class="form-control">
						   <option value="">--</option>
						  <option value="1">น้ำฝน</option>
						  <option value="2">ระดับน้ำ</option>
						  </select>
						  </div>

							<div class="form-group">
						  <label for="recipient-name" class="control-label">ระดับ:</label>
						  <select id="level" class="form-control">
						   <option value="">--</option>
						  <option value="1">เฝ้าระวัง</option>
						  <option value="2">วิกฤต</option>
						  </select>
						  </div>

						  <div class="form-group">
							<label for="message-text" class="control-label">ข้อความแจ้งเตือน:</label>
							<textarea class="form-control" id="fgroup_content" ></textarea>
							<input name="sta" type="hidden" id="sta" value="insert">
						  </div>
						  
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
						<button type="button" class="btn btn-primary" id="fok">บันทึก</button>
					  </div>
					</div>
				  </div>
				</div>
					<!-- MODAL Add group-->





											<!-- MODAL Add USER-->
				<div class="modal fade" id="adduserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
				  <div class="modal-dialog" role="document">
					<div class="modal-content">
					  <div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="exampleModalLabel">เพิ่มผู้รับข้อความ</h4>
					  </div>
					  <div class="modal-body">
						<form>
						  <div class="form-group">
							<label for="recipient-name" class="control-label">อีเมล์:</label>
							<input type="text" class="form-control" id="email" >
						  </div>
						   <div class="form-group">
							<label for="recipient-name" class="control-label">เบอร์โทร:</label>
							<input type="text" class="form-control" id="tel" >
						  </div>
						    <div class="form-group">
						  <label for="recipient-name" class="control-label">กลุ่มแจ้งเตือน:</label>
						  <select id="groupid" class="form-control">
						   <option value="">เลือกกลุ่ม</option>
						  <?php 
								$query = "SELECT group_id,group_name FROM dbo.group_user_sms ORDER BY group_id";
								$result = odbc_exec($connection,$query);

									while ($row = odbc_fetch_array($result))
									{
										if($row['group_id'] ==$id){$s="selected";}else{$s="";}
										echo "<option value='".$row['group_id']."'>".iconv('TIS-620', 'UTF-8',$row['group_name'])."</option>";
									}
							?>
						  </select>
						  </div>
							 <div class="form-group">
							
							<input type="checkbox" id="status" value="Y"><label for="recipient-name" class="control-label"> รับข้อความ</label>
						  </div>
							
						  
						</form>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
						<button type="button" class="btn btn-primary" id="insertuser">บันทึก</button>
					  </div>
					</div>
				  </div>
				</div>
					<!-- MODAL Add USER-->
