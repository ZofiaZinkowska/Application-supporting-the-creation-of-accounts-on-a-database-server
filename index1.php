 <?php
 session_start();
 include '../projektIO/model/mysqlConnection.php';
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

Podaj login poczty (bez znaku @ np. email S999999@student.pg.edu.pl podajemy S999999) aby założyć konto lub zresetować hasło (w przypadku istniejącego konta):<br>
<form method="post" action="reg.php">
<input type="text" name="name">
<select name="type" >
    <option value="1">student.pg.edu.pl</option>
    <option value="2">pg.edu.pl</option>
</select><br>
<input type="submit" value="Zarejestruj/resetuj hasło">
</form>
<br>
<?php

$r = new Registration('Karol', 'Xxxxxx1', 'karmaj@wp.pl');
dump($r);
$r->addUserToDatabase();

if (isset($_SESSION['info'])){
	echo "<h2 class=\"green\">{$_SESSION['info']}</h2>";
	unset($_SESSION['info']);
}
if (isset($_SESSION['error'])){
	echo "<h2 class=\"red\">{$_SESSION['error']}</h2>";
	unset($_SESSION['error']);
}

?>

<br><br><br>
<a href="http://dbserver.mif.pg.gda.pl/download/dbfaq.pdf">Najczęściej zadawane pytania i odpowiedzi</a>

</body>
</html> 
