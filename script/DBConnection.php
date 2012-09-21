<?php

function connectDB() {
    date_default_timezone_set('Asia/Bangkok');
    $con = mysql_connect("localhost","root","password");
    mysql_select_db("monitor", $con);
    return $con;
}
function closeDB() {
    mysql_close();
}

?>
