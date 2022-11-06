 <?php
 session_start();
 ?>
 <!DOCTYPE html>
<html>
<head>
  <title>DBServer</title>
  
  <style>
.red{
  background-color: Tomato;
}

.green {
  background-color: SpringGreen;
}

</style>
</head>
<body>


<form method="post" action="aemail.php">
Email:
<input type="text" name="email"><br>
Login:
<input type="text" name="login"><br>
<input type="submit" value="Zarejestruj/resetuj hasło">
</form>
<br>
<?php

if (isset($_SESSION['info'])){
	echo "<h2 class=\"green\">{$_SESSION['info']}</h2>";
	unset($_SESSION['info']);
}
if (isset($_SESSION['error'])){
	echo "<h2 class=\"red\">{$_SESSION['error']}</h2>";
	unset($_SESSION['error']);
}
?>

</body>
</html> 
