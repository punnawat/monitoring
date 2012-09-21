<?php

require_once 'DBConnection.php';
function walk($host, $community) {
    snmp_set_quick_print(true);
    
    $initOid = "interfaces.ifTable";
    $arr = snmp2_real_walk($host, $community, $initOid);
    $log = array();
    $log['interface_name'] = array();
    $log['bandwidth_in'] = array();
    $log['bandwidth_out'] = array();
    foreach ($arr as $oid => $val) {
        if (strpos($oid, "ifDescr.") != FALSE) {
            $log['interface_name'][] = $val;
        } else if (strpos($oid, "ifInOctets.") != FALSE) {
            $log['bandwidth_in'][] = $val;
        } else if (strpos($oid, "ifOutOctets.") != FALSE) {
            $log['bandwidth_out'][] = $val;
        }
    }
    return $log;
}

//        $host = "192.168.1.101";
//        $community = "cisco";
//        $initOid = "interfaces.ifTable";
//        $arr = snmp2_real_walk($host, $community, $initOid);
//        $result = array();
//        foreach ($arr as $oid => $val) {
//            if (strpos($oid, "ifDescr.") != FALSE) {
//                $result['interface_name'][] = $val;
//            } else if (strpos($oid, "ifInOctets.") != FALSE) {
//                $result['bandwidth_in'][] = $val;
//            } else if (strpos($oid, "ifOutOctets.") != FALSE) {
//                $result['bandwidth_out'][] = $val;
//            }
//        }
//        print_r($result);
connectDB();
$result = mysql_query(" SELECT id, ip_address,snmp_comm_str FROM mon_devices where bandwidth_yn = 'Y' ");
$sql_insert_begin = "INSERT INTO mon_log_check_bandwidth (device_id, interface_name, bandwidth_in, bandwidth_out) VALUES ( ";
$sql_insert_end = " ) ";
//
while ($row = mysql_fetch_array($result)) {
    try {          
        
        $log = walk($row['ip_address'], $row['snmp_comm_str']);        
        
        for($i = 0; $i < count($log['interface_name']); $i++) {
            $sql_insert_content = $row['id'] . ", '" . $log['interface_name'][$i] . "', ". $log['bandwidth_in'][$i] . ", ". $log['bandwidth_out'][$i] . " ";
            mysql_query($sql_insert_begin . $sql_insert_content . $sql_insert_end);
//            echo $sql_insert_begin . $sql_insert_content . $sql_insert_end;
//            echo '<br>';
        }
//        print_r($log);
    } catch (Exception $exc) {
        
    }
}
closeDB();
?>
