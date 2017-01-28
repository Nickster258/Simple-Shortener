<?php
require __DIR__ . '/constants.php';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);

mysql_select_db('urls', $conn);

if(! $conn) {
        die(mysql_error());
}

function getUrl($rand) {
        global $conn;
        try {
                $query = "SELECT URL FROM urls WHERE rand = binary \"$rand\"";
                $result = mysql_query($query, $conn);

                if (!$result) {
                        echo 'MySQL Error: ' . mysql_error();
                        exit;
                } elseif (mysql_num_rows($result)==0) {
                        echo "Incorrect redirect code: $rand";
                        exit;
                } else {
                        $resu = mysql_result($result, 0);
                        return urldecode($resu);
                }

        } catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
        }
}

$rand = $_GET["id"];

if (strlen($rand) > 4) {
        echo "Invalid redirect code!";
        mysql_close($conn);
        exit;
} else {
        $url = getUrl($rand);
        mysql_close($conn);
        header ("Location: $url");
}

?>
