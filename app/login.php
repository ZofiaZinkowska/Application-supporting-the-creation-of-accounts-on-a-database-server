<?php

	session_start();
	
	// if (!isset($_SESSION['logged']))
	// {
	// 	header('Location: login.php');
	// 	exit();
	// }
	
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikacja do zakładania kont w bazie danych</title>
</head>
<body>
    <div>
        <form id="login" method="POST" action="">
            <div>
                <h2>Zaloguj się</h2>
                <div>
                    <input name="email" type="email" placeholder="Podaj email" />
                    <input name="password" type="password" placeholder="Podaj haslo" />

                    <button type="submit">Zaloguj się</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>