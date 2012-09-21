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
            <?php if ($row['monitor_yn'] == 'Y' && $row['is_show'] == true) : ?>
            <tr valign="top">
                <td align="center"><?php echo $row['server_name']; ?></td>
                <td align="center"><?php echo $row['ip_address']; ?></td>
                <td align="left">                    
                        <table class="log">
                            <col width="25px" />
                            <col width="75px" />                    
                            <col width="*" />
                            <col width="25px" />
                            <col width="*" />
                            <?php if ($row['http_yn'] == 'Y' && ($row['status_http_down'] != null || $row['status_http_up'] != null)) : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http_down'] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                    <td>HTTP</td>                        
                                    <td><?php echo $row['status_http_down'] != "" ? date("d/m/y H:i:s", strtotime($row['status_http_down'])) : "";  ?></td>
                                    <td align="center"><img src="<?php
                                        if ($row['status_http_up'] != "")                                            
                                            echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                    <td><?php echo $row['status_http_up'] != "" ? date("d/m/y H:i:s", strtotime($row['status_http_up'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            
                            <?php if ($row['https_yn'] == 'Y' && ($row['status_https_down'] != null || $row['status_https_up'] != null)) : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_https_down'] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                    <td>HTTPS</td>                        
                                    <td><?php echo $row['status_https_down'] != "" ? date("d/m/y H:i:s", strtotime($row['status_https_down'])) : ""; ?></td>
                                    <td align="center"><img src="<?php
                                        if ($row['status_https_up'] != "")                                            
                                            echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                    <td><?php echo $row['status_https_up'] != "" ? date("d/m/y H:i:s", strtotime($row['status_https_up'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            
                            <?php if ($row['ftp20_yn'] == 'Y' && ($row['status_ftp20_down'] != null || $row['status_ftp20_up'] != null)) : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_ftp20_down'] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                    <td>FTP(20)</td>                        
                                    <td><?php echo $row['status_ftp20_down'] != "" ? date("d/m/y H:i:s", strtotime($row['status_ftp20_down'])) : ""; ?></td>
                                    <td align="center"><img src="<?php
                                        if ($row['status_ftp20_up'] != "")                                            
                                            echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                    <td><?php echo $row['status_ftp20_up'] != "" ? date("d/m/y H:i:s", strtotime($row['status_ftp20_up'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?> 
                            <?php if ($row['ftp21_yn'] == 'Y'  && ($row['status_ftp21_down'] != null || $row['status_ftp21_up'] != null)) : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_ftp21_down'] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                    <td>FTP(21)</td>                        
                                    <td><?php echo $row['status_ftp21_down'] != "" ? date("d/m/y H:i:s", strtotime($row['status_ftp21_down'])) : ""; ?></td>
                                    <td align="center"><img src="<?php
                                        if ($row['status_ftp21_up'] != "")                                            
                                            echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                    <td><?php echo $row['status_ftp21_up'] != "" ? date("d/m/y H:i:s", strtotime($row['status_ftp21_up'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?>
                            <?php if ($row['smtp_yn'] == 'Y' && ($row['status_smtp_down'] != null || $row['status_smtp_up'] != null)) : ?>
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_smtp_down'] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                    <td>SMTP</td>                        
                                    <td><?php echo $row['status_smtp_down'] != "" ? date("d/m/y H:i:s", strtotime($row['status_smtp_down'])) : "";?></td>
                                    <td align="center"><img src="<?php
                                        if ($row['status_smtp_up'] != "")                                            
                                            echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                    <td><?php echo $row['status_smtp_up'] != "" ? date("d/m/y H:i:s", strtotime($row['status_smtp_up'])) : "";  ?></td>
                                </tr>                                             
                            <?php endif; ?> 
                            <?php if ($row['tcp_port'] != NULL && $row['tcp_port'] != '') :
                                        $dataArr = explode(",", $row['tcp_port']);
                                        foreach ($dataArr as $d) :
                                             if ($row['status_tcp_down'. trim($d)] == null && $row['status_tcp_up'. trim($d)] == null)
                                                 continue;
                                            ?>
                                        <tr>
                                            <td align="center"><img src="<?php
                                                if ($row['status_tcp_down'. trim($d)] != "")                                            
                                            echo base_url() . "images/red.png"; ?>" width="15" /></td>
                                            <td>TCP(<?php echo trim($d);?>)</td>                        
                                            <td><?php echo $row['status_tcp_down'. trim($d)] != "" ? date("d/m/y H:i:s", strtotime($row['status_tcp_down'. trim($d)])) : "";?></td>
                                            <td align="center"><img src="<?php
                                                if ($row['status_tcp_up'. trim($d)] != "")                                            
                                                    echo base_url() . "images/green.png"; ?>" width="15" /></td>                                    
                                            <td><?php echo $row['status_tcp_up'. trim($d)] != "" ? date("d/m/y H:i:s", strtotime($row['status_tcp_up'. trim($d)])) : "";  ?></td>
                                        </tr>
                                        <?php endforeach;
                                 endif; ?>                                     
                         </table> 
                    </td>
                    <td align="left"><?php echo "<b>Floor:</b> " . $row['location_floor'] . ' <b>Rack:</b> ' . $row['location_rack'] . ' <br/><b>Room:</b> ' . $row['location_room'] . ' <b>Building:</b> ' . $row['location_building']; ?></td>            
                </tr>        
            <?php endif; ?>
        
    <?php endforeach; ?>
</table>

</div>    

