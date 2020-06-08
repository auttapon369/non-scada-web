<ul class="list-inline sub-menu">
    <li id="m-sub-1"><a href="<?php echo$link."&view=filter"; ?>">ค้นหาข้อมูลผิดปกติ</a></li>
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
               if ( $_GET['view'] == "filter" )
				{ 
					include("dataerror.php");
				}
				else
				{
					include("dataerror.php");
				}
                ?>
            </div>  
        </div>
    </div>
</div>