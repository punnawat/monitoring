<?php
require_once 'DBConnection.php';
require_once 'Ping.php';

connectDB();
$result = mysql_query(" SELECT id, ip_address FROM mon_devices where monitor_yn = 'Y' ");
$sql_insert_begin = "INSERT INTO mon_log_check_devices (device_id, status, error_msg) VALUES ( ";
$sql_insert_end = " ) ";

while ($row = mysql_fetch_array($result)) {
    try {
        
        $ping = new Ping;
        $response = $ping->ping($row['ip_address']);
    
        if (is_array($response) && isset($response['desc'])) {       
             $sql_insert_content = $row['id'] . ' , "UP", NULL ';        
        }
        else {             
            $sql_insert_content = $row['id'] . ' , "DOWN", "'. $ping->errstr . '" ';        
        }
        
        mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
        
    } catch (Exception $exc) {
        
    }
}
closeDB();
?>