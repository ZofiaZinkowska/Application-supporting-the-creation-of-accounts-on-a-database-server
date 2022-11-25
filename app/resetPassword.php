<?php

	session_start();
	
    include __DIR__ .'/model/loginAction.php';
    include __DIR__ .'/dump.php';
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
    <link rel="stylesheet" href="login.css" />
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">
    <title>Aplikacja do zakładania kont na serwerze baz danych</title>
</head>
<body>
    <div id="container">
        <nav>
            <button><a class="menu" href="index.php">Strona główna</a></button>
            <button><a class="menu" href="register.php">Rejestracja</a></button>
        </nav>
    </div>
    <div>
        <form id="reset" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <article>
                <h2>Zresetuj hasło</h2>
                <div class = "inputs">
                    <input 
                        name="password1" 
                        type="password" 
                        placeholder="Podaj hasło"
                    />
                    <input 
                        name="password2" 
                        type="password"
                        placeholder="Powtórz hasło" 
                    />

                    <button type="submit">
                        Zmień hasło
                    </button>
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $password = $_POST['password1'];
                            $password = $_POST['password2'];
                        }
                    ?>
                </div>
            </article>
            </div>
        </form>
    </div>
</body>
</html>