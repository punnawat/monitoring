<div align="center" style="padding-bottom: 10px;">
    <table style="border: 1px #734201 dashed;padding: 4px;">
        <tr>
            <td align="left" style="padding: 10px;">
             <b>Server Name:</b> <?php  echo $result_aval["server_name"] ;?> 
             <b>IP Address:</b> <?php echo $result_aval["ip_address"] ;?> <br/>
             <b>Availability:</b> <br/>
             <table class="log">                    
                <?php if ($result_aval['http_yn'] == 'Y') : ?>
                    <tr>                            
                        <td>HTTP:</td>                        
                        <td><?php echo number_format($result_aval['aval_http'], 2, '.', ''); ?>%</td>
                    </tr>                                             
                <?php endif; ?>

                <?php if ($result_aval['https_yn'] == 'Y') : ?>
                    <tr>                            
                        <td>HTTPS:</td>                        
                        <td><?php echo number_format($result_aval['aval_https'], 2, '.', ''); ?>%</td>
                    </tr>                                             
                <?php endif; ?>

                <?php if ($result_aval['ftp20_yn'] == 'Y') : ?>
                    <tr>                            
                        <td>FTP(20)</td>                        
                        <td><?php echo number_format($result_aval['aval_ftp20'], 2, '.', ''); ?>%</td>
                    </tr>                                             
                <?php endif; ?> 
                <?php if ($result_aval['ftp21_yn'] == 'Y') : ?>
                    <tr>                            
                        <td>FTP(21)</td>                        
                        <td><?php echo number_format($result_aval['aval_ftp21'], 2, '.', ''); ?>%</td>                        
                    </tr>                                             
                <?php endif; ?>
                <?php if ($result_aval['smtp_yn'] == 'Y' ) : ?>
                    <tr>                                                    
                        <td>SMTP</td>                        
                        <td><?php echo number_format($result_aval['aval_smtp'], 2, '.', ''); ?>%</td>
                    </tr>                                           
                <?php endif; ?> 
                <?php if ($result_aval['tcp_port'] != NULL && $result_aval['tcp_port'] != '') :
                            $dataArr = explode(",", $result_aval['tcp_port']);
                            foreach ($dataArr as $d) : ?>
                            <tr>                                    
                                <td>TCP(<?php echo trim($d);?>)</td>                        
                                <td><?php echo number_format($result_aval['aval_tcp_'.trim($d)], 2, '.', ''); ?>%</td>
                            </tr>
                            <?php endforeach;
                        endif; ?>                                     
                </table>
            </td>            
        </tr>
    </table>
</div>

<b>Unsuccess Monitor Log</b>
<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 500px;font-size: 12px;">        
        <tr style="font-weight: bold;">
            <th>Date/Time</th> 
            <th>Service Down</th> 
        </tr>
         <?php foreach ($logs->result_array() as $result_aval): ?>
        <tr>
            <td><?php echo $result_aval['updated_date']; ?></td>
            <td><?php echo $result_aval['service']; ?></td>            
        </tr>
        <?php endforeach; ?>
    </table>    
</div>  


