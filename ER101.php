<html>
  <head>
    <title>Chat-Error101</title>

  </head>
  <body>
  	<h1>Chat</h1>
  	<font color=red>
  	<h2>Error</h2>
  	<?php
  	if($_REQUEST['errorMode'] == 'notWrite'){
  		?>
  		Please input your id and password.
  		<?php
  	}
	else if($_REQUEST['errorMode'] == 'notUserName'){
  		?>
  		Not found id.
  		<?php
  	}
	else if($_REQUEST['errorMode'] == 'notPassword'){
  		?>
  		Password is incorrect.
  		<?php
  	}
  	?>
  	</font>
  	<form action="WC101.php">
  	<input type="submit" name="back" value="back">
  	</form>
  </body>
</html>

