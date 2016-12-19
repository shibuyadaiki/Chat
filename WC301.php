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
	$dsn = 'mysql:dbname=chat;host=127.0.0.1';
	$user = 'root';
	$pw = 'H@chiouji1';
	$sql = 'SELECT * FROM Log';
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();

	$chatData = [];
	while(($buff = $sth->fetch())!==false){
		$chatData[] = [$buff['userName'], $buff['message'],$buff['date']];
	}
	for($a = 0;$a < count($chatData) ;$a++){
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
	?>
	
	<input type="submit" name="name" value="Refresh">
	<input type="submit" name="name" value="Close" onClick="window.close()">
	</form>
  </body>
</html>

