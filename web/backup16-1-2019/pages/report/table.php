<?php

?>
<table class="table table-striped table-condensed table-hover text-center">
	<thead class="bg-black bd-fade">
		<tr>
			<th rowspan="2">สถานี</th>
			<th width="200" rowspan="2" class="bd-left">วันที่/ เวลา (น.)</th>
			<?php if ( $_GET['data'] == "rf" ){ ?>
			<th colspan="1" class="bd-left">ปริมาณฝน (มม.)</th>
			<?php } else { ?>
			<th colspan="2" class="bd-left">ระดับน้ำ (ม.รทก.)</th>
			<?php } ?>
		</tr>
		<tr>
			<?php if ( $_GET['data'] == "rf" ){ ?>
			<th width="100" class="bd-left"><?php echo $_GET['format'] ?></th>
			<?php } else { ?>
			<th width="100" class="bd-left">หน้า</th>
			<th width="100">หลัง</th>
			<?php } ?>
		</tr>
	</thead>
	<tbody>
		<?php
		for ( $i=0; $i<10; $i++ )
		{
			echo '<tr>
				<td width="200">'.$_GET['id'].'</td>
				<td width="200" class="text-center bd-left date">'.$_GET['date1'].'</td>';

			if ( $_GET['data'] == "rf" )
			{
				echo '<td class="text-center">-</td>';
			}
			else
			{
				echo '<td class="text-center">-</td>
				<td class="text-center">-</td>';
			}

			echo '</tr>';
		}
		?>
	</tbody>
</table>