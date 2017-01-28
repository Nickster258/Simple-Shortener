<?php
if(isset($_GET['id'])) {
        $id = $_GET['id'];
        echo "<p>Your shortened URL ID is $id</br></br>
                                <a id=\"link\" href=\"http://stonecipher.org/s/$id\">http://stonecipher.org/s/$id</a>  <button onclick=\"copyToClipboard(link)\">Copy</button>
                        </p>
";
} elseif (isset($_GET['invalidChars'])) {
        echo "<p>Invalid characters! Enter the URL again
                                <form action=\"shorten.php\">
                                URL: <input type=\"text\" name=\"url\"> <input type=\"submit\" value=\"Submit\">
                                </form>
                        </p>
";
} else {
        echo "<p>Enter the URL you would like to shorten
                                <form action=\"shorten.php\">
                                URL: <input type=\"text\" name=\"url\"> <input type=\"submit\" value=\"Submit\">
                                </form>
                        </p>
";
}
?>
