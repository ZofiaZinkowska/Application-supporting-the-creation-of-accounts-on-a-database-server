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
?>