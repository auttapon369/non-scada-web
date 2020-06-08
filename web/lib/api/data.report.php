<?php
$datetime = date("Y-m-d H:i");
///////////////////////////////////////////////////////////
//$sql="SELECT * FROM TM_STN WHERE Check_wl_up = 1 AND Check_wl_dw = 0 or Check_rf = 1 order by zone,LOC_ID";
if($_GET['para'] == 'rf'){
$sql="SELECT * FROM TM_STN WHERE Check_rf = 1 order by zone,LOC_ID";
}
else
{
$sql="SELECT * FROM TM_STN WHERE Check_wl_up = 1 AND Check_wl_dw = 0 order by zone,LOC_ID";
}
$result=odbc_exec($conn,$sql);
$list_stn = array();
$datadt = array();
$datavalue = array();
$data = array();
$outp = array();
$sumval= array();

while ( $sys_arr = odbc_fetch_array($result) )
{

					$stn =$sys_arr['STN_ID'];
					$selectdata="SELECT STN_ID,DT,RF_15MIN,WL_UP FROM row_data WHERE STN_ID='".$stn ."' AND DT BETWEEN DATEADD(day,-2,'".$datetime."')AND'".$datetime."' ";
					$selectdata.="ORDER BY DT DESC";
					$read=odbc_exec($conn,$selectdata);
					$numm=odbc_num_rows($read);
					$e=1;
					while($r=odbc_fetch_array($read))
					{
						
										if($_GET['para']=='rf'){$v=$r['RF_15MIN'];}else{$v=$r['WL_UP'];}

										if($v > 0)
											{
											
											array_push($datadt,trim($r['DT']));
											array_push($datavalue,trim($v));
											if($e<$numm)
												{
												$e++;
											continue;
											
												}
													
											}
						
									if(!empty($datadt))
											{
										//var_dump($datavalue);
														if($_GET['para']=='rf' && array_sum($datavalue) <=0.10 )
															{
															unset($datadt);
															unset($datavalue);
															$datadt = array();
															$datavalue = array();
															$e++;
															continue;
															}

											if($_GET['para']=='rf'){$values=array_sum($datavalue);}else{$values=max($datavalue);}
											$t_min = date("d/m/Y H:i",strtotime("-15 minute",strtotime(min($datadt))));
											$t_max = date("d/m/Y H:i",strtotime(max($datadt)));
											$datastn=array("value"=>number_format(((float)$values),2),"min"=>$t_min,"max"=>$t_max);
											array_push($sumval,$values);
											array_push($data,$datastn);
											}	
												unset($datadt);
												unset($datavalue);
												$datadt = array();
												$datavalue = array();
															
										$e++;
								
					}
						
						
					
					if(!empty($data))
					{
					$getdata = array("name"=>iconv('TIS-620', 'UTF-8',$sys_arr["STN_NAME_THAI"]),"sumval"=>array_sum($sumval),"data"=>$data)	;				
					array_push($outp,$getdata);
					unset($data);
					$data = array();
					unset($sumval);
					$sumval = array();
					}
		
}




$_temp['reports'] = $outp;


?>