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
    <link rel="stylesheet" href="loginPage.css" />
    <link rel="shortcut icon" href="logo.png" type="image/x-icon">
   
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
        <form id="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <article>
                <h2>Zaloguj się</h2>
                <div class = "inputs">
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

                    <p><a href="resetPassword.php">Zapomniałeś hasła?</a></p>

                    <button type="submit">
                        Zaloguj się
                    </button>
                    <?php 
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $loginDataForm = new User();
                            $user = $loginDataForm->authenticate($email, $password);
                           
                            if ($user) {
                                Login::login($user);
                            }
                        }
                    ?>
                </div>
            </article>
            </div>
        </form>
    </div>
</body>
</html>