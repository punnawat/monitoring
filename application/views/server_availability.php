<?php   echo form_open('server_availability/search'); ?>
<div align="center" style="padding-bottom: 10px;">
    <table style="border: 1px #734201 dashed;padding: 4px;">
        <tr>
            <td align="right" style="width: 200px; padding-right: 4px;">
             Device Name or IP Address   
            </td>
            <td align="left" >
                <input type="text" name="txtKeyword" />
            </td>
            <td align="left" style="width: 100px;">
                <input type="submit" name="btnSubmit" value="SEARCH" />
            </td>
        </tr>
    </table>
</div>
<?php echo form_close(); ?>

<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 800px;font-size: 12px;">        
        <tr style="font-weight: bold;">
            <th>Device Name</th>
            <th>IP Address</th>
            <th>Availability</th>            
            <th>View</th>                        
        </tr>
         <?php foreach ($result_aval as $row): ?>
        <tr>
            <td><?php echo $row['server_name']; ?></td>
            <td><?php echo $row['ip_address']; ?></td>
            <td align="left">
                <table class="log">                    
                    <?php if ($row['http_yn'] == 'Y') : ?>
                        <tr>                            
                            <td>HTTP:</td>                        
                            <td><?php echo number_format($row['aval_http'], 2, '.', ''); ?>%</td>
                        </tr>                                             
                    <?php endif; ?>

                    <?php if ($row['https_yn'] == 'Y') : ?>
                        <tr>                            
                            <td>HTTPS:</td>                        
                           <td><?php echo number_format($row['aval_https'], 2, '.', ''); ?>%</td>
                        </tr>                                             
                    <?php endif; ?>

                    <?php if ($row['ftp20_yn'] == 'Y') : ?>
                        <tr>                            
                            <td>FTP(20)</td>                        
                            <td><?php echo number_format($row['aval_ftp20'], 2, '.', ''); ?>%</td>
                        </tr>                                             
                    <?php endif; ?> 
                    <?php if ($row['ftp21_yn'] == 'Y') : ?>
                        <tr>                            
                            <td>FTP(21)</td>                        
                            <td><?php echo number_format($row['aval_ftp21'], 2, '.', ''); ?>%</td>                        
                        </tr>                                             
                    <?php endif; ?>
                    <?php if ($row['smtp_yn'] == 'Y' ) : ?>
                        <tr>                                                    
                            <td>SMTP</td>                        
                            <td><?php echo number_format($row['aval_smtp'], 2, '.', ''); ?>%</td>
                        </tr>                                           
                    <?php endif; ?> 
                    <?php if ($row['tcp_port'] != NULL && $row['tcp_port'] != '') :
                                $dataArr = explode(",", $row['tcp_port']);
                                foreach ($dataArr as $d) : ?>
                                <tr>                                    
                                    <td>TCP(<?php echo trim($d);?>)</td>                        
                                    <td><?php echo number_format($row['aval_tcp_'.trim($d)], 2, '.', ''); ?>%</td>
                                </tr>
                                <?php endforeach;
                            endif; ?>                                     
                    </table>
            </td>            
            <td align="center"><a href="<?php echo site_url('server_availability/view/'.$row['id']); ?>"><img src="<?php echo base_url();?>images/view-icon.png" /></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div align="center">
        <?php echo $links; ?>
    </div>
</div>  


