<?php
// echo "<pre>";
?>
var i = 0;
i = 4 ;
function timedCount() {
    postMessage(i);
    setTimeout("timedCount()",1000);
}

timedCount();
