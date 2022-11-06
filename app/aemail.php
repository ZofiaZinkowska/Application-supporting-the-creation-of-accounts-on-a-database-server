<?php	

session_start();

include_once("glob.php");

if (!isset($_POST['login']) || !isset($_POST['email']))
{	
	jump_main();
}

$email = $_POST['email'];
$name = 'P'.strtoupper(preg_replace ('/[^\p{L}\p{N}]/u', '', $_POST['login']));
$user_type = 3;
/*
outside_emails
id
loginemail
date_created
*/

$_SESSION['error'] = "Błąd. Skontaktuj się z barreich@pg.edu.pl";

//websystem_log("User registration start.");
try{
    $conn = connect_oracle();
}catch(PDOException $e){
    websystem_log($e->getMessage());
	jump_main();
}

$sql = 'alter session set "_oracle_script"=true';
try {

  $stmt = $conn->prepare($sql);          
  $stmt->execute();
}
catch(PDOException $e)
{
	websystem_log("Oracle sript set error");
	jump_main();
}
//$stmt = $conn->prepare($sql);
//$stmt->execute();



$sql = "select DBMS_ASSERT.QUALIFIED_SQL_NAME('$name') from dual";//without prepare to check
try {

  $stmt = $conn->prepare($sql);          
  $stmt->execute();
}
catch(PDOException $e)
{
	//var_dump($e);
	/*
	$stmt->errorInfo()[1] == 44004
    echo "Bad name: " .$stmt->errorCode()."       ".$e->getMessage();
	print_r($stmt->errorInfo());
	*/
	websystem_log("Bad login character $name");
	jump_main();
}



/*
CREATE TABLE accounts (
   id NUMBER GENERATED ALWAYS as IDENTITY(START with 1 INCREMENT by 1) PRIMARY KEY,
   login VARCHAR2(30),
   user_type INT,
   registered INT DEFAULT 0 NOT NULL,
   magic VARCHAR2(100),
   date_created date default sysdate not null
);
*/
//printf("uniqid(): %s\r\n", uniqid());


$magic = uniqid().uniqid();

$sql = "SELECT count(*) FROM accounts WHERE login=:name";

 try {

    websystem_log("Check is user already in DB");
    $stmt = $conn->prepare($sql);  
    $stmt->bindParam(':name', $name);       
    $stmt->execute();
    $row = $stmt->fetch();   
	websystem_log("USINDB = {$row[0]}");   


    if ($row[0] == 0)
	{
		$sql = "INSERT INTO accounts (login, user_type, magic, plain_login) VALUES(:name, :user_type, :magic, :plain_login)";		
		$stmt = $conn->prepare($sql);  
        $stmt->bindParam(':name', $name);       
		$stmt->bindParam(':user_type', $user_type);       
		$stmt->bindParam(':magic', $magic);    
		$stmt->bindParam(':plain_login', $email);    
		
        $stmt->execute();
		$_SESSION['info'] = "Konto założone. Sprawdź email.";
	}
    else
	{		
		
		$_SESSION['error'] = "Login już istnieje";
		jump_main();
	}

 }
catch(PDOException $e)
{
    websystem_log( "Error: " . $e->getMessage());	
	jump_main();
}


$mailmessage = "Aby potwierdzić swoje dane wciśnij poniższy link<br> http://dbserver.mif.pg.gda.pl/conf.php?uid=$magic";

//$mailmessage .= "<br>Poprzez tunel (patrz opis w FAQ) \r\n http://localhost/confirmAcc.aspx?uid={1}\r\n";

if ($user_type == 3){
	websystem_send_mail($email, "Założenie konta DBServer", $mailmessage);
} 

unset($_SESSION['error']);
jump_main();