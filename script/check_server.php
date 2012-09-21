<?php
require_once 'DBConnection.php';

function checkServer($ip, $port, &$errno) {
    $errstr = "";
    return fsockopen($ip, $port, $errno, $errstr, 1);
}

connectDB();
$result = mysql_query(" SELECT id, server_name, ip_address, location_floor, location_rack, location_room, location_building, http_yn, https_yn, ftp20_yn, ftp21_yn, smtp_yn, tcp_port, monitor_yn, updated_by, updated_date FROM mon_servers where monitor_yn = 'Y' ");
$sql_insert_begin = "INSERT INTO mon_log_check_services (server_id, service, status, error_code) VALUES ( ";
$sql_insert_end = " ) ";

while ($row = mysql_fetch_array($result)) {
    try {
        if ($row['http_yn'] == 'Y') {
            $errno = "";
            $fp = checkServer($row['ip_address'], 80, $errno);
            if ($fp) {
                fclose($fp);
                $sql_insert_content = $row['id'] . ' , "HTTP" , "UP", NULL ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            } else {
                $sql_insert_content = $row['id'] . ' , "HTTP" , "DOWN", "' . $errno . '" ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            }
        }

        if ($row['https_yn'] == 'Y') {
            $errno = "";
            $fp = checkServer($row['ip_address'], 443, $errno);
            if ($fp) {
                fclose($fp);
                $sql_insert_content = $row['id'] . ' , "HTTPS" , "UP", NULL ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            } else {
                $sql_insert_content = $row['id'] . ' , "HTTPS" , "DOWN", "' . $errno . '" ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            }
        }

        if ($row['ftp20_yn'] == 'Y') {
            $errno = "";
            $fp = checkServer($row['ip_address'], 20, $errno);
            if ($fp) {
                fclose($fp);
                $sql_insert_content = $row['id'] . ' , "FTP:20" , "UP", NULL ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            } else {
                $sql_insert_content = $row['id'] . ' , "FTP:20" , "DOWN", "' . $errno . '" ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            }
        }

        if ($row['ftp21_yn'] == 'Y') {
            $errno = "";
            $fp = checkServer($row['ip_address'], 21, $errno);
            if ($fp) {
                fclose($fp);
                $sql_insert_content = $row['id'] . ' , "FTP:21" , "UP", NULL ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            } else {
                $sql_insert_content = $row['id'] . ' , "FTP:21" , "DOWN", "' . $errno . '" ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            }
        }

        if ($row['smtp_yn'] == 'Y') {
            $errno = "";
            $fp = checkServer($row['ip_address'], 25, $errno);
            if ($fp) {
                fclose($fp);
                $sql_insert_content = $row['id'] . ' , "SMTP" , "UP", NULL ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            } else {
                $sql_insert_content = $row['id'] . ' , "SMTP" , "DOWN", "' . $errno . '" ';
                mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
            }
        }

        if ($row['tcp_port'] != NULL && $row['tcp_port'] != '') {
            $dataArr = explode(",", $row['tcp_port']);
            foreach ($dataArr as $d) {
                $errno = "";
                $fp = checkServer($row['ip_address'], trim($d), $errno);
                if ($fp) {
                    fclose($fp);
                    $sql_insert_content = $row['id'] . ' , "TCP:' . trim($d) . '" , "UP", NULL ';
                    mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
                } else {
                    $sql_insert_content = $row['id'] . ' , "TCP:' . trim($d) . '" , "DOWN", "' . $errno . '" ';
                    mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
                }
            }
        }
    } catch (Exception $exc) {
        
    }
}
closeDB();
?>