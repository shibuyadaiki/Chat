<html>
  <head>
    <title>Chat-History</title>

  </head>
  <body>
	<h1>Chat History</h1>
	<form action="WC301.php">
	<input type="submit" name="name" value="Refresh">
	<br>
	<?php
	$fp = fopen('chat.log','r');
	$count = 0;
	$chatData;
	while(($data = fgets($fp))!==false){
		$chatData[] = explode(',',$data);
		$count++;
	}
	for($a = 0;$a < $count;$a++){
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
	}
	fclose($fp);
	?>
	
	<input type="submit" name="name" value="Refresh">
	<input type="submit" name="name" value="Close" onClick="window.close()">
	</form>
  </body>
</html>

