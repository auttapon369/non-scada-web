
<ul class="list-inline sub-menu">
    <li id="m-sub-1"><a href="<?php echo$link."&view=user"; ?>">ข้อมูลผู้ใช้งาน</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
				if ( $_GET['view'] == "user" )
				{ 
					if ( $_GET['page'] == "edit" )
					{
						include("user_edit.php");
					}
					else
					{
						include("user_main.php"); 
					}
				}
				else{ include("user_main.php");  }
                ?>
            </div>  
        </div>
    </div>
</div>