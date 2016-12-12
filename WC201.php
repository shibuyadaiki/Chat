<html>
  <head>
    <title>Chat</title>

  </head>
  <body>
<?php
	if($_REQUEST['inputValue'] ==''){
    ?>
    <meta http-equiv="refresh"content="0;URL=ER101.php">
    <?php
  }
  else{
  
  }
  
  if( $_REQUEST['mode'] == 'write'){
  	$fp = fopen('chat.log','r+');
  	fread($fp,4096);
  	$log = $_REQUEST['inputValue'].",".$_REQUEST['chatValue'].","."(".date("Y-m-d H:i:s").")"."\n";
  	fwrite($fp,$log);
	fclose($fp);
  }
  else if($_REQUEST['mode'] == 'login'){
  	$fp = fopen('chat.log','r+');
  	fread($fp,4096);
  	$log = "SysOP".",".$_REQUEST['inputValue']." Login".","."(".date("Y-m-d H:i:s").")"."\n";
  	fwrite($fp,$log);
	fclose($fp);
  }
  else if($_REQUEST['mode'] == 'logout'){
  	$fp = fopen('chat.log','r+');
  	fread($fp,4096);
  	$log = "SysOP".",".$_REQUEST['inputValue']." Logout".","."(".date("Y-m-d H:i:s").")"."\n";
  	fwrite($fp,$log);
	fclose($fp);
    ?><meta http-equiv="refresh"content="0;URL=WC101.php"><?php
  }
  

?>
	<form action = "WC201.php">
	<?php print $_REQUEST['inputValue'];?> 
	<input type="hidden" name="mode" value="write">
	<input type="text" name="chatValue" value="">
	<input type="hidden" name="inputValue" value="<?php print $_REQUEST['inputValue']?>">
	<input type="submit" name="name" value="Write">
	</form>
	<hr>
	<form action ="WC201.php">
	<input type="hidden" name="mode" value="read">
	<input type="hidden" name="inputValue" value="<?php print $_REQUEST['inputValue']?>">
	<input type="submit" name="name" value="Refresh">
	</form>
	<?php
	$fp = fopen('chat.log','r');
	$count = 0;
	$chatData;
	while(($data = fgets($fp))!==false){
		$chatData[] = explode(',',$data);
		$count++;
	}
	$forCount = 0;
	for($a = ($count - 1);$a >= 0 ;$a--){
		for($b = 0;$b < 3;$b++){
			if($b == 0){
				print $chatData[$a][$b]."\t";
			}
			else if($b == 1){
				?><font size="5"><?php print $chatData[$a][$b]."\t";?></font><?php
			}
			else{
			?><font size="2" color=gray><?php print $chatData[$a][$b]."\t";?></font><?php
			}
		}
		?><hr><?php
		$forCount++;
		if($forCount == 15)break;
	}
	fclose($fp);
	?>
    <form action="WC201.php">
	<a href="WC301.php" target="_blank">History</a>
	<input type="hidden" name="mode" value="logout">
	<input type="hidden" name="inputValue" value="<?php print $_REQUEST['inputValue']?>">
	<input type="submit" name="name" value="Logout">
	</form>
	
  </body>
</html>

