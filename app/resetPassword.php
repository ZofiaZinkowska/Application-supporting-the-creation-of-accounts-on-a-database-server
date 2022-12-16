<?php
	session_start();
    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'C:/xampp/htdocs/projektIO/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require 'C:/xampp/htdocs/projektIO/vendor/phpmailer/phpmailer/src/SMTP.php';
    require 'C:/xampp/htdocs/projektIO/vendor/phpmailer/phpmailer/src/Exception.php';
    //Create an instance; passing `true` enables exceptions
    include __DIR__ .'/model/loginAction.php';
    include __DIR__ .'/dump.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="resetPassword.css" />
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">
    <title>Aplikacja do zakładania kont na serwerze baz danych</title>
</head>
<body>
    <div>
        <form id="reset" method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
            <article>
                <h2>Zresetuj hasło</h2>
                <div class = "inputs">
                    <input 
                        name="email" 
                        type="email" 
                        placeholder="Podaj email"
                    />
                    <br />
                    <br />
                    <button type="submit">
                        Zresetuj hasło
                    </button>
                    <p><a href="index.php">Przejdź do strony głównej</a></p>
                    <?php 

                        $phpmailer = new PHPMailer();
                        $phpmailer->isSMTP();
                        $phpmailer->Host = 'smtp.mailtrap.io';
                        $phpmailer->SMTPAuth = true;
                        $phpmailer->Port = 2525;
                        $phpmailer->Username = '8f35adc6b99020';
                        $phpmailer->Password = '1228465d4eefe5';
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            
                            $email = $_POST['email'];
                            $user = new User();
                            $isEmailExist = $user->emailExists($email);
                            if ($isEmailExist) {
                                $user->updateUUIDtoResetPassword($email);
                            }
                            $useruuid = $user->getUUID($email);

                            //sender information
                            $phpmailer->setFrom('kmajchrzak1999@gmail.com', 'Karol Majchrzak');

                            //receiver address and name
                            $phpmailer->addAddress('amajchrzak777@gmail.com', 'Adam');

                            $body = "Link do zmiany hasla: <a href='http://localhost/projektio/app/resetPasswordForm.php?uuid=$useruuid->reset_password'>KLIK</a>";
                            $phpmailer->isHTML(true);
                            $phpmailer->Subject = 'PHPMailer SMTP test';
                            $phpmailer->Body = $body;
                            // Send mail   
                            if (!$phpmailer->send()) {
                                echo 'Email not sent an error was encountered: ' . $phpmailer->ErrorInfo;
                            } else {
                                echo 'Email z linkiem do zmiany hasła został wysłany.';
                                // header('Location: http://localhost/projektio/app/index.php');
                            }

                            $phpmailer->smtpClose();

                        } else {
                            
                        }
                    ?>
                </div>
            </article>
            </div>
        </form>
    </div>
</body>
</html>