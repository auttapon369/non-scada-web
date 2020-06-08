<ul class="list-inline sub-menu">
    <li id="m-sub-1"><a href="<?php echo$link."&view=alert"; ?>">เกณฑ์เตือนภัย</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
				   if ( $_GET['view'] == "alert" )
					{ 
						if ( $_GET['page'] == "edit" )
						{
							include("alertEdit.php");
						}
						else
						{
							include("alertMain.php"); 
						}
					}
					else{ include("alertMain.php");  }
                ?>
            </div>  
        </div>
    </div>
</div>