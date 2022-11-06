<?php	

include_once("PHPMailer\Exception.php");
include_once("PHPMailer\PHPMailer.php");
include_once("PHPMailer\SMTP.php");
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function jump_main()
{
	header('Location: index.php');
	die();
}
/**
 * @param int $length
 */
function strong_random_bytes($length)
{
    $strong = false; // Flag for whether a strong algorithm was used
    $bytes = openssl_random_pseudo_bytes($length, $strong);

    if ( ! $strong)
    {
        // System did not use a cryptographically strong algorithm 
        throw new Exception('Strong algorithm not available for PRNG.');
    }        

    return bin2hex($bytes);
}


function connect_oracle()
{
$tns = " (DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)
	(HOST=dbserver.mif.pg.gda.pl)(PORT = 1521))
	(CONNECT_DATA = (SERVER=DEDICATED)
	(SERVICE_NAME = ORACLEMIF)
	))
       ";
$db_username = "WEBSYSTEM";
$db_password = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

    return new PDO("oci:dbname=".$tns,$db_username,$db_password);

}


function websystem_log($event)
{	

$ddd = date("Y-m-d H:i:s");

file_put_contents('log\logs.txt', $ddd.";".$event.PHP_EOL , FILE_APPEND | LOCK_EX);
}





function websystem_send_mail($to, $subject, $body)
{
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
	
	// Active condition utf-8
$mail->CharSet = 'UTF-8';
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'mifgate.mif.pg.gda.pl';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'dbserver_noreply';                     //SMTP username
    $mail->Password   = 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXINNNNNNNE';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
	$mail->SMTPSecure = 'ssl';
	//$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    $mail->Port       = 465;//587;   465                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
	
$mail->SMTPDebug = 0;
$mail->AuthType = 'LOGIN';
//$mail->SMTPSecure = false;
//$mail->SMTPAutoTLS = false;
$mail->SMTPOptions = array(
'ssl' => array(
'verify_peer' => false,
'verify_peer_name' => false,
'allow_self_signed' => true
)
);

    //Recipients
    $mail->setFrom('dbserver_noreply@mif.pg.gda.pl', 'DBServer');
    $mail->addAddress($to, $to);     //Add a recipient
    
        //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();
	
    websystem_log("Message has been sent $to");
	return true;
	
} catch (Exception $e) {
    websystem_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
}

return false;
}