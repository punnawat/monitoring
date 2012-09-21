<div align="center">
    <table style="width: 800px;">
        <tr>
            <td align="left">
                <a href="<?php echo site_url('server_monitoring/clear_log'); ?>"><img src="<?php echo base_url(); ?>images/clear-icon.png" /></a>                                
            </td>
        </tr>
    </table>

</div>

<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 800px;font-size: 12px;">        
        <tr style="font-weight: bold;">
            <th>Device Name</th>
            <th>IP Address</th>
            <th>Status</th>            
            <th>Location</th>                        
        </tr>
        <?php foreach ($servers as $row): ?>
            <tr valign="top">
                <td align="center"><?php echo $row['server_name']; ?></td>
                <td align="center"><?php echo $row['ip_address']; ?></td>
                <td align="left">
                    <?php if ($row['monitor_yn'] == 'Y') : ?>
                        <table class="log">
                            <col width="25px" />
                            <col width="75px" />                    
                            <col width="*" />
                            <?php if ($row['http_yn'] == 'Y') : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                    <td>HTTP</td>                        
                                    <td><?php echo $row['log_http_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_http_date'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            
                            <?php if ($row['https_yn'] == 'Y') : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_https'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                    <td>HTTPS</td>                        
                                    <td><?php echo $row['log_https_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_https_date'])) : ""; ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            
                            <?php if ($row['ftp20_yn'] == 'Y') : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                    <td>FTP(20)</td>                        
                                    <td><?php echo $row['log_ftp20_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_ftp20_date'])) : ""; ?></td>
                                </tr>                                             
                            <?php endif; ?> 
                            <?php if ($row['ftp21_yn'] == 'Y') : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                    <td>FTP(21)</td>                        
                                    <td><?php echo $row['log_ftp21_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_ftp21_date'])) : ""; ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            <?php if ($row['smtp_yn'] == 'Y') : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                    <td>SMTP</td>                        
                                    <td><?php echo $row['log_smtp_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_smtp_date'])) : "";?></td>
                                </tr>                                             
                            <?php endif; ?> 
                            <?php if ($row['tcp_port'] != NULL && $row['tcp_port'] != '') {
                                        $dataArr = explode(",", $row['tcp_port']);
                                        foreach ($dataArr as $d) {?>
                                        <tr>
                                            <td align="center"><img src="<?php
                                                if ($row['status_tcp'. trim($d)] == "UP")
                                                    echo base_url() . "images/green.png";
                                                else
                                                    echo base_url() . "images/red.png";
                                                            ?>" width="15" /></td>
                                            <td>TCP(<?php echo trim($d);?>)</td>                        
                                            <td><?php echo $row['log_tcp_date'. trim($d)] != "" ? date("d/m/y H:i:s", strtotime($row['log_tcp_date'. trim($d)])) : "";?></td>
                                        </tr>
                                        <?php }
                                 } ?>                                     
                         </table> 
                    </td>
                    <td align="left"><?php echo "<b>Floor:</b> " . $row['location_floor'] . ' <b>Rack:</b> ' . $row['location_rack'] . ' <br/><b>Room:</b> ' . $row['location_room'] . ' <b>Building:</b> ' . $row['location_building']; ?></td>            
                </tr>        
            <?php endif; ?>
        
    <?php endforeach; ?>
</table>

</div>    

