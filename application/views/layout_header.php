<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Network Monitoring System</title>
<meta name="keywords" content="" />
<meta name="Bryce Sunrise" content="" />
<link rel="shortcut icon" href="<?php echo base_url(); ?>favicon.ico">
<link href="<?php echo base_url(); ?>default.css" rel="stylesheet" type="text/css" media="screen" />
<script language="javaScript" type="text/javascript" src="<?php echo base_url(); ?>js/jquery-1.7.2.min.js" > </script>
</head>
<body>
<div id="header" >
  <div id="logo" style="background-image: url('<?php echo base_url(); ?>images/header.png'); background-repeat: no-repeat;">
      <div style="font-size: 1.6em; padding-top: 23px;"><a href="#"><b>Network Monitoring System</b></a></div>
  </div>
  <div id="menu-bg">
  <div id="menu">
    <ul id="main">
      <li <?php echo $current_page_item == 'main' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url();?>" style="font-weight: bold">Main</a></li>
      <li <?php echo $current_page_item == 'smonitor' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('server_monitoring');?>" style="font-weight: bold">Server Monitoring</a></li>
      <li <?php echo $current_page_item == 'dmonitor' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('network_monitoring');?>" style="font-weight: bold">Network Monitoring</a></li>
      <li <?php echo $current_page_item == 'devices' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('devices');?>" style="font-weight: bold">Network Devices</a></li>
      <li <?php echo $current_page_item == 'servers' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('servers');?>" style="font-weight: bold">Server Devices</a></li>
      <li <?php echo $current_page_item == 'realtime' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('real_time');?>" style="font-weight: bold">Real Time</a></li>
      <li <?php echo $current_page_item == 'bandwidth' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('bandwidth');?>" style="font-weight: bold">Bandwidth</a></li>
      <li <?php echo $current_page_item == 'availability' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('availability');?>" style="font-weight: bold">Availability</a></li>
<!--      <li <?php echo $current_page_item == 'settings' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('settings');?>" style="font-weight: bold">Settings</a></li> -->
      <li <?php echo $current_page_item == 'contactus' ?  ' class="current_page_item" ' : ''; ?> ><a href="<?php echo site_url('contactus');?>" style="font-weight: bold">Contact US</a></li>
    </ul>    
  </div>
  </div>
</div>
<div id="wrapper">
  <!-- start page -->
  <div id="page">
    <!-- start content -->
    <div id="content">      
      <div class="post">
        <h1 class="title">&nbsp;&nbsp;<?php echo $title;?></h1><br/>    