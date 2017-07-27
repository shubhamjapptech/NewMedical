<?php
  date_default_timezone_set('Asia/Kolkata');
  $current_time= date('H:i');  //(14:45)
?>
<?php
	require_once 'include/Md_Functions.php';
	require_once 'include/config.php';
	$db = new Md_Functions();
	$up="UPDATE patatent_tablets SET status='not' where `status`='taken' && `remain_medicine`!=0";
	//echo $up;
	$q=mysql_query($up);
?>