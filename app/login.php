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
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">
    <link rel="stylesheet" href="index.css" />
    <title>Aplikacja do zakładania kont na serwerze baz danych</title>
</head>
<body>
    <div id="container">
            <nav>
                <button><a class="menu" href="index.php">Strona główna</a></button>
                <button><a class="menu" href="login.php">Login</a></button>
                <button><a class="menu" href="register.php">Rejestracja</a></button>
            </nav>
    </div>
    <div>
        <form id="login" method="POST" action="">
            <article>
                <h2>Zaloguj się</h2>
                <div class = "inputs">
                    <input name="email" type="email" placeholder="Podaj email" />
                    <input name="password" type="password" placeholder="Podaj haslo" />

                    <button type="submit">Zaloguj się</button>
                </div>
            </article>
            </div>
        </form>
    </div>
</body>
</html>