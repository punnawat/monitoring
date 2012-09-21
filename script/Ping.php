<?php
if (!extension_loaded("sockets")) {
  dl("php_sockets.dll");
}

class Ping {
  public $icmp_socket;
  public $request;
  public $request_len;
  public $reply;
  public $errstr;
  public $timer_start_time;
  
  function __construct() {
    $this->icmp_socket = socket_create(AF_INET, SOCK_RAW, 1);
    socket_set_block($this->icmp_socket);
  }
  
  function ip_checksum($data) {
    $sum = 0;
    for($i=0; $i<strlen($data); $i += 2) {
      if ($data[$i+1])
        $bits = unpack('n*',$data[$i].$data[$i+1]);
      else
        $bits = unpack('C*',$data[$i]);
      $sum += $bits[1];
       }
     
    while ($sum>>16) $sum = ($sum & 0xffff) + ($sum >> 16);
    $checksum = pack('n1',~$sum);
    return $checksum;
  }

  function start_time()  {
    $this->timer_start_time = microtime();
  }
  
  function get_time($precission=2) {
    // format start time
    $start_time = explode(" ", $this->timer_start_time);
    $start_time = $start_time[1] + $start_time[0];
    // get and format end time
    $end_time = explode (" ", microtime());
    $end_time = $end_time[1] + $end_time[0];
    return number_format(($end_time - $start_time)*1000, $precission);
  }

  function Build_Packet($request, $size) {
    $type = "\x08";
    $code = "\x00";
    $chksm = "\x00\x00";
    $id = "\x00\x00";
    $sqn = pack("n", $request);
    $data = ""; 
    for ($i = 0; $i < $size; $i++) $data .= chr(mt_rand(0,255));
    $data = "abcd"; 

    // now we need to change the checksum to the real checksum
    $chksm = $this->ip_checksum($type.$code.$chksm.$id.$sqn.$data);

    // now lets build the actual icmp packet
    $this->request = $type.$code.$chksm.$id.$sqn.$data;
    $this->request_len = strlen($this->request);
  }
  
  function Ping($dst_addr, $requests=1, $size=32, $timeout=1, $percision=3) {
    $result = array();

    // set the timeout
    socket_set_option($this->icmp_socket,
      SOL_SOCKET,  // socket level
      SO_RCVTIMEO, // timeout option
      array(
        "sec"=>$timeout,
        "usec"=>0
      )
    );

    if ($dst_addr) {
      for($r = 0; $r < $requests; $r++) {
        $dst_ip = gethostbyname($dst_addr);
        if (!socket_connect($this->icmp_socket, $dst_addr, NULL)) {
          $this->errstr = "Unable to connect to $dst_addr:$port";
          return false;
        }
        $this->Build_Packet($r, $size);
        $this->start_time();
        socket_write($this->icmp_socket, $this->request, $this->request_len);
        if (@socket_recv($this->icmp_socket, $this->reply, 256, 0)) {
          $bytes = strlen($this->reply);
          $time = $this->get_time($percision);
          $ttl = ord($this->reply{7})*256 + ord($this->reply{8});
          $result['desc']['log'] = "Reply from $dst_ip: bytes=$bytes seq=$r time=$time ms ttl=$ttl";
          $result['desc']['ttl'] = $ttl;
          $result['desc']['time'] = $time;
        }
        else {
          $this->errstr = "Request timed out";
        }
      }
    } 
    else {
      $this->errstr = "Destination address not specified";
      return false;
    }
    return $result;
  }
}
?>
