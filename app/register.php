<?php

	session_start();
	
    include '../projektIO/model/registerAction.php';
    include '../projektIO/dump.php';
	// if (!isset($_SESSION['logged']))
	// {
	// 	header('Location: register.php');
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
        <form id="register" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <article>
            <div>
                <h2>Rejestracja</h2>
                </article>
                <div class = "inputs">
                    <input 
                        name="username" 
                        type="text"
                        placeholder="Podaj nazwe użytkownika" 
                    />
                    <input 
                        name="email" 
                        type="email" 
                        placeholder="Podaj email" 
                    />
                    <input 
                        name="password" 
                        type="password" 
                        placeholder="Podaj hasło" 
                    />
                    <button type="submit">Zarejestruj się</button>
                    <?php
                    
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $username = $_POST['username'];
                            $password = $_POST['password']; 
                            $email = $_POST['email'];
                            $registerDataForm = new Registration($_POST['username'], $_POST['password'], $_POST['email']);
                            $registerDataForm->addUserToDatabase();
                        }
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>