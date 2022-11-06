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
    <title>Aplikacja do zakładania kont w bazie danych</title>
</head>
<body>
    <div>
        <form id="register" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <div>
                <h2>Rejestracja</h2>
                <div>
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
                    <input type="submit" />
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