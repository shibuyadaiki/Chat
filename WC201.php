<?php
	$dsn = 'mysql:dbname=chat;host=127.0.0.1';
	$user = 'root';
	$pw = 'H@chiouji1';
	$sql = 'SELECT * FROM User';
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();

	$userData = [];
	$selectUserId = 0;
	while(($buff = $sth->fetch())!==false){
		if($buff['loginid'] == $_REQUEST['LoginId']){
			$selectUserId = $buff['id'];
		}
		$userData[$buff['id']] = [$buff['loginid'], $buff['password'],$buff['dispname'],$buff['del_flag'],$buff['lastlogin_date']];
	}	
	if($_REQUEST['mode'] == 'login'){
		if($_REQUEST['LoginId'] =='' || $_REQUEST['Password'] ==''){ 
			header('Location: ER101.php?errorMode=notWrite');
			exit;
  		}
 		 else if($selectUserId == 0){
			header('Location: ER101.php?errorMode=notUserName');
			exit;
	  	}
 	 	else if($_REQUEST['Password'] != $userData[$selectUserId][1]){
			header('Location: ER101.php?errorMode=notPassword');
			exit;
  		}
  	}
?>

<html>
  <head>
    <title>Chat</title>

  </head>
  <body>
<?php
	$sql = 'SELECT * FROM Log';
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();
	$idSize = 0;
	while(($buff = $sth->fetch())!==false){
		$idSize = $buff['id'];
	}
	$idSize++;
  if( $_REQUEST['mode'] == 'write'){
  	try{
		$dbh = new PDO($dsn,$user,$pw);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$userName = $userData[$selectUserId][2];
		$message = $_REQUEST['chatValue'];
		$date = date("Y-m-d H:i:s");
		
		$sth = $dbh->prepare("insert into Log values(
		$idSize,
		'$userName',
		'$message',
		'$date');
		");
		$sth->execute();
		$dbh->commit();
  	}
  	catch(PDOException $e){
  		$dbh->rollback();
	}
  }
  else if($_REQUEST['mode'] == 'login'){
  	try{
		$dbh = new PDO($dsn,$user,$pw);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$userName = "SysOP";
		$message = $userData[$selectUserId][2]." Login";
		$date = date("Y-m-d H:i:s");
		$sth = $dbh->prepare("insert into Log values(
		$idSize,
		'$userName',
		'$message',
		'$date');
		");
		$sth->execute();
		$dbh->commit();
  	}
  	catch(PDOException $e){
  		$dbh->rollback();
	}
	try{
		$dbh = new PDO($dsn,$user,$pw);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$date = date("Y-m-d H:i:s");
		$sth = $dbh->prepare("update User set lastlogin_date = '$date' where id = $selectUserId");
		$sth->execute();
		$dbh->commit();
  	}
  	catch(PDOException $e){
  		$dbh->rollback();
	}
  }
  else if($_REQUEST['mode'] == 'logout'){
	try{
		$dbh = new PDO($dsn,$user,$pw);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$userName = "SysOP";
		$message = $userData[$selectUserId][2]." Logout";
		$date = date("Y-m-d H:i:s");
		$sth = $dbh->prepare("insert into Log values(
		$idSize,
		'$userName',
		'$message',
		'$date');
		");
		$sth->execute();
		$dbh->commit();
  	}
  	catch(PDOException $e){
  		$dbh->rollback();
	}
    ?><meta http-equiv="refresh"content="0;URL=WC101.php"><?php
  }
  else if($_REQUEST['mode'] == 'delete'){
  	try{
		$dbh = new PDO($dsn,$user,$pw);
		$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
		$dbh->beginTransaction();
		$chatId = $_REQUEST['chatId'];
		$sth = $dbh->prepare("delete from Log where id = $chatId;");
		$sth->execute();
		$dbh->commit();
  	}
  	catch(PDOException $e){
  		$dbh->rollback();
  		
	}
  }
  

?>
	<form action = "WC201.php">
	<?php print $userData[$selectUserId][2];?> 
	<input type="text" name="chatValue" value="">
	<input type="hidden" name="LoginId" value="<?php print $_REQUEST['LoginId']?>">
	<input type="submit" name="mode" value="write">
	</form>
	<hr>
	<form action ="WC201.php">
	<input type="hidden" name="LoginId" value="<?php print $_REQUEST['LoginId']?>">
	<input type="submit" name="mode" value="Refresh">
	</form>
	<?php
	$sql = 'SELECT * FROM Log';
	$dbh = new PDO($dsn,$user,$pw);
	$sth = $dbh->prepare($sql);
	$sth->execute();

	$chatData = [];
	while(($buff = $sth->fetch())!==false){
		$chatData[] = [$buff['id'],$buff['userName'], $buff['message'],$buff['date']];
	}
	for($a = count($chatData) - 1,$c = 0;$a >= 0 && $c < 15;$a--,$c++){
		for($b = 1;$b < 4;$b++){
			if($b == 1){
				print $chatData[$a][$b]."\t";
			}
			else if($b == 2){
				?><font size="5"><?php print $chatData[$a][$b]."\t";?></font><?php
			}
			else{
			?><font size="2" color=gray><?php print $chatData[$a][$b]."\t";?></font><?php
			}
		}
		if($chatData[$a][1] == $userData[$selectUserId][2]){
		?>
		<form action ="WC201.php">
		<input type="hidden" name="LoginId" value="<?php print $_REQUEST['LoginId']?>">
		<input type="hidden" name="chatId" value="<?php print $chatData[$a][0]?>">
		<input type="submit" name="mode" value="delete">
		</form>
		<?php
		}?>
		<hr><?php
	}
	?>
    <form action="WC201.php">
	<a href="WC301.php" target="_blank">History</a>
	<input type="hidden" name="LoginId" value="<?php print $_REQUEST['LoginId']?>">
	<input type="submit" name="mode" value="logout">
	</form>
	
  </body>
</html>

