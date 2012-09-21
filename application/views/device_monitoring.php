<div align="center">
    <table style="width: 800px;">
        <tr>
            <td align="left">
                <a href="<?php echo site_url('network_monitoring/clear_log'); ?>"><img src="<?php echo base_url(); ?>images/clear-icon.png" /></a>                                
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
                <td align="center"><?php echo $row['device_name']; ?></td>
                <td align="center"><?php echo $row['ip_address']; ?></td>
                <td align="center">
                    <?php if ($row['monitor_yn'] == 'Y') : ?>
                        <table class="log">
                            <col width="25px" />
                            <col width="*" />                                                
                                <tr>
                                    <td align="center"><img src="<?php
                                        if ($row['status_ping'] == "UP")
                                            echo base_url() . "images/green.png";
                                        else
                                            echo base_url() . "images/red.png";
                                                    ?>" width="15" /></td>
                                                           
                                    <td><?php echo $row['log_ping_date'] != "" ? date("d/m/y H:i:s", strtotime($row['log_ping_date'])) : "";  ?></td>
                                </tr>                                                                                   
                         </table> 
                    </td>
                    <td align="left"><?php echo "<b>Floor:</b> " . $row['location_floor'] . ' <b>Rack:</b> ' . $row['location_rack'] . ' <br/><b>Room:</b> ' . $row['location_room'] . ' <b>Building:</b> ' . $row['location_building']; ?></td>            
                </tr>        
            <?php endif; ?>
        
    <?php endforeach; ?>
</table>

</div>    

