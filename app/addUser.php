<?php

	session_start();
	
    include __DIR__ .'/dump.php';
	include __DIR__ .'/model/addUserAction.php';
    

    //    <link rel="stylesheet" href="index.css" />
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
    </div>
    <div>
        <form id="login" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <article>
            <div class = "inputs">
                <input 
                    name="login" 
                    type="email"
                    placeholder="Email"
                />
                <br />
                <br />
                <p>Admin / Student</p>
                <select
                    data-placeholder="User type" 
                    name="userType"
                >
                    <option>0</option>    
                    <option>1</option>
                </select>
                <br />
                <br />
                <p>Czy użytkownik jest zarejestrowany ?</p>
                <select
                    data-placeholder="Registered" 
                    name="registered"
                >
                    <option>0</option>    
                    <option>1</option>
                </select>
                <br />
                <br />
                <input 
                    name="magic" 
                    type="text" 
                    placeholder=""
                />
                <br />
                <br />
                <p>Data dodania użytkownika</p>
                <input 
                    name="date" 
                    type="date"
                />
                <br />
                <br />
            </div>
                <button type="submit">Add User</button>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $login = $_POST['login'];;
                        $userType = $_POST['userType'];;
                        $registered = $_POST['registered'];;
                        $magic = $_POST['magic'];;
                        $date = $_POST['date'];;
                        
                        $addUser = new AddUserModel($login, $userType, $registered, $magic, $date);
                        $addUser->addUserToDatabase();

                    }
                ?>
            </article>
        </form>
    </div>
</body>
</html>