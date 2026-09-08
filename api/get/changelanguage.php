<?php
# overwrite language
if(isset($_GET["hl"]) ) {
    if($_GET["hl"]== "vi") {
        $_SESSION["lang"] = "vi";
    } else {
        $_SESSION["lang"] = $_GET["hl"];
    }
}

$code = 200;
?>