<?php
require __DIR__ . '/constants.php';

$conn = mysql_connect($dbhost, $dbuser, $dbpass);

mysql_select_db('urls', $conn);

if(! $conn) {
        die(mysql_error());
}

function random($length) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charsLength = strlen($chars);
        $rand = '';
        for ($i = 0; $i < $length; $i++) {
                $rand .= $chars[rand(0, $charsLength - 1)];
        }
        return $rand;
}

function addUrl($url) {
        global $conn;
        try {
                // Checks to see if the URL was previously shortened and returns the rand if it was.
                $query = "SELECT rand FROM urls WHERE URL = binary \"$url\"";
                $result = mysql_query($query, $conn);

                if (mysql_num_rows($result)!=0) {
                        $resu = mysql_result($result, 0);
                        return $resu;
                }

                // If the URL hasn't been previously seen, opens a loop, generates rand, and continues loop if the rand already exists.
                $match = true;
                while ($match) {
                        $newRand = random(4);
                        $query = "SELECT * FROM urls WHERE rand = binary \"$newRand\"";
                        $result = mysql_query($query, $conn);

                        if (!$result) {
                                echo 'MySQL Error: ' . mysql_error();
                                exit;
                        } elseif (mysql_num_rows($result)!=0) {
                                $match = true;
                        } else {
                                $match = false;
                                $newQuery = "INSERT INTO urls VALUES(\"$newRand\", \"$url\")";
                                $result = mysql_query($newQuery, $conn);
                                if (!$result) {
                                        echo 'MySQL Error: ' . mysql_error();
                                        exit;
                                } else {
                                        return $newRand;
                                }
                        }
                }
        } catch(Exception $e) {
                echo 'Message: ' .$e->getMessage();
        }
}

$url = $_GET['url'];

$id = '';

// Adds http:// to URLs that don't have it
if (!(substr($url, 0, 6) == 'ftp://') && !(substr($url, 0, 7) == 'http://') && !(substr($url, 0, 8) == 'https://')) {
        $url = substr_replace($url, "http://", 0, 0);
}

// Goes through a preg_match for URL chars, then URL encodes it to protect it.
// Finally returns the index.php for the code.
if (preg_match('_^(?:(?:https?|ftp)://)(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}-\x{ffff}0-9]+-?)*[a-z\x{00a1}-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}-\x{ffff}]{2,})))(?::\d{2,5})?(?:/[^\s]*)?$_iuS',$url)) {
        $encoded = urlencode($url);
        $id = addUrl($encoded);
        mysql_close($conn);
        header("Location: index.php?id=$id");
} else {
        mysql_close($conn);
        header("Location: index.php?invalidChars=true");
}

?>
