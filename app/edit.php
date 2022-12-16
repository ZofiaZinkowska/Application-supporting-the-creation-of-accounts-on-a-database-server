<?php

	session_start();
    include __DIR__ .'/dump.php';
	include __DIR__.'/model/editAction.php';

    if (!$_SESSION['user_id']) {
        header('Location: http://localhost/projektio/app/index.php');
    }

    $editUser = new EditModel();
    $currentUsername = $editUser->selectUsername();
    $currentEmail = $editUser->selectEmail();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">
    <link rel="stylesheet" href="loginPage.css" />
    <title>Aplikacja do zakładania kont na serwerze baz danych</title>
</head>
<body>
    <div id="container">
        <nav>
            <button><a class="menu" href="index.php">Strona główna</a></button>
            <button><a class="menu" href="addUser.php">Dodaj Użytkownika</a></button>
            <button><a class="menu" href="edit.php">Edycja Profilu</a></button>
            <button><a class="menu" href="upload.php">PDF</a></button>
            <button><a class="menu" href="logout.php">Wyloguj</a></button>
        </nav>
        <section>
		</section>
        <footer>
        </footer>
    </div>
    <div>
        <form id="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <article>
            <div class = "inputs">
                <input 
                    name="username" 
                    type="textarea"
                    value=<?php echo $currentUsername[0]["username"]; ?>
                    placeholder=<?php echo $currentUsername[0]["username"]; ?>
                />
                <input 
                    name="email"
                    type="email"
                    value=<?php echo $currentEmail[0]["email"]; ?>
                    placeholder=<?php echo $currentEmail[0]["email"]; ?>
                />
                <input 
                    name="password" 
                    type="password"
                    placeholder="Podaj aktualne hasło"
                />
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
            </div>
                <button type="submit">Edytuj</button>
                <?php 
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $newUsername = $_POST['username'];
                        $newEmail = $_POST['email'];
                        $oldPassword = $_POST['password'];
                        $newPassword = $_POST['userPassword'];
                        $newRepeatedPassoword = $_POST['repeatedUserPassword'];
                        
                        $editUserAction = new EditAction();
                        $editUserAction->updateUserAccountAction($newUsername, $newEmail);
                        $editUserAction->editPasswordAction($oldPassword, $newPassword, $newRepeatedPassoword);
                    }
                ?>
            </article>
        </form>
    </div>
</body>
</html>