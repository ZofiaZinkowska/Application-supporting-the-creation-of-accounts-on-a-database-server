<?php
    session_start();
    include __DIR__ .'/model/uploadAction.php';
    include __DIR__ .'/dump.php';
    
    if (!$_SESSION['user_id']) {
        header('Location: http://localhost/projektio/app/index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="index.css" />
    <link rel="shortcut icon" href="pobrane.png" type="image/x-icon">
    
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
        <form id="uploadFiles" method="POST" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <article>
            <div>
                <h2>Strona do importowania plików .PDF oraz Excel</h2>
        </article>
                <div class = "inputs">
                    Choose Your PDF File 
                    <input type="file" name="PDFFile" accept="application/pdf" />
                    <br />
                    <input type="submit" value="Read File" name="readFile" />
                    <?php
                    if($_SERVER['REQUEST_METHOD'] == 'POST'){
                        if(isset($_FILES['PDFFile']) && $_FILES['PDFFile']['error'] == 0) {
                            $fileName = $_FILES['PDFFile']['name'];
                            
                            $temporaryFile = $_FILES['PDFFile']['tmp_name'];

                            move_uploaded_file($temporaryFile, __DIR__.'/../pdfs/'.$fileName);
                            $addFile = new UploadFileAction();
                            $addFile->addFileToDB($fileName);

                            $result = $addFile->displayFilesRelatedToCurrentUser();

                            if ($result) {
                                foreach($result as $res): ?>
                                <li><a href="display.html.php?id=<?=$res['id']?>&filename=<?=$res['title']?>" target="_blank"><?php echo $res['title'] ?></a></li>
                                <?php endforeach;
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </form>
    </div>
</body>
</html>