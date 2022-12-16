<?php
//$con=oci_connect('username', 'password', 'localhost/orcl');
$conn = oci_connect('projektio', 'projektio', 'localhost/XEPDB1');
if($conn) {
    echo "Connection succeded";
}
else 
{
    echo "Connection failed";
    $err = oci_error();
    trigger_error(htmlentities($err['message'], ENT_QUOTES), E_USER_ERROR);
}

$stid = oci_parse($conn, 'SELECT * FROM employees');
oci_execute($stid);

echo "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    echo "<tr>\n";
    foreach ($row as $item) {
        echo "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    echo "</tr>\n";
}
echo "</table>\n";

class Model {

    public static function getOracleDB() {
        static $db = null;

        static $DB_HOST = '127.0.0.1';
        static $DB_NAME = 'projectio';
        static $DB_USER = 'root';
        static $DB_PASSWORD = '';

        if ($db === null) {
            $dsn = 'mysql:host=' . $DB_HOST . ';dbname=' . $DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, $DB_USER, $DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }
}
?>