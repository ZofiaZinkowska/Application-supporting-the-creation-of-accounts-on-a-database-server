<?php

	session_start();
	
    include __DIR__ .'/dump.php';
    include __DIR__.'/model/loginAction.php';
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">

    <title>Aplikacja do zakładania kont na serwerze baz danych</title>
</head>
<body>
    <form id="resetPassword" method="POST" action="">
        <article>
            <input 
                name="userPassword" 
                type="password" 
                placeholder="Podaj nowe hasło"
            />
            <input 
                name="repeatedUserPassword" 
                type="password"
                placeholder="Podaj ponownie nowe hasło"
            />
            <button type="submit">Zmień hasło</button>
            <?php 
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $newPassword = $_POST['userPassword'];
                    $newRepeatedPassoword = $_POST['repeatedUserPassword'];

                    if ($newPassword === $newRepeatedPassoword) {

                        $uuid = $_GET['uuid'];
                        $user = new User();
                        $userId = $user->findByUUID($uuid);
                        $isPasswordChanged = $user->resetPassword($newPassword , $userId->id);

                        if ($isPasswordChanged) {
                            header('Location: http://localhost/projektio/app/index.php');
                        } else {
                            echo 'Hasło nie zostało zmienione.';
                        }
                    } else {
                        echo 'Hasła nie są takie same spróbuj jeszcze raz.';
                    }

                }
            ?>
        </article>
    </form>
    </div>
</body>
</html>