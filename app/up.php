
<!DOCTYPE html>
<html>
<body>
Plik będzie dostępny w katalogu ORACLE o nazwie ORACLETEMP<br>
Pliki się nadpisują (nie należy traktować w kategori ważne dane)<br>
<form action="up.php" method="post" enctype="multipart/form-data">
  Wybierz plik do załadowania (patrz regulamin PG):<br>
  <input type="file" name="fileToUpload" id="fileToUpload"><br>
  <input type="submit" value="Załaduj" name="submit">
</form>

</body>
</html>


<?php

$target_dir = "c:/ORACLESTUDENTTEMP/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "Plik ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " załadowany.";
  } else {
    echo "Błąd.";
  }
}

}
?>
