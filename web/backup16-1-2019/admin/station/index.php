<?php
/*
// controller here
// coding 
*/
?>
<ul class="list-inline sub-menu">
    <li id="m-sub-1"><a href="<?php echo$link."&view=site"; ?>">สถานีตรวจวัด</a></li>
    <!-- <li id="m-sub-2"><a href="<?php echo$link."&view=2"; ?>">tab 2</a></li>
    <li id="m-sub-3"><a href="<?php echo$link."&view=3"; ?>">tab 3</a></li>
    <li id="m-sub-4"><a href="<?php echo$link."&view=4"; ?>">tab 4</a></li> -->
</ul>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                <?php
                /*
                // controller here
                // coding 
                */
				if ( $_GET['view'] == "site" )
				{ 
					if ( $_GET['page'] == "edit" )
					{
						include("siteEdit.php");
					}
					else
					{
						include("siteMain.php"); 
					}
				}
				else{}
                ?>
            </div>  
        </div>
    </div>
</div>