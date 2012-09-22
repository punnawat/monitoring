<div align="center" style="padding-bottom: 10px;">
    <table style="border: 1px #734201 dashed;padding: 4px;">
        <tr>
            <td align="right" style="padding: 10px;">
             <b>Device Name:</b> <?php  echo $result_aval["device_name"] ;?> 
             <b>IP Address:</b> <?php echo $result_aval["ip_address"] ;?> 
             <b>Availability:</b> <?php echo number_format($result_aval["aval"], 2, '.', '') ;?> 
            </td>            
        </tr>
    </table>
</div>

<b>Unsuccess Monitor Log</b>
<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 500px;font-size: 12px;">        
        <tr style="font-weight: bold;">
            <th>Date/Time</th> 
            <th>Error Message</th> 
        </tr>
         <?php foreach ($logs->result_array() as $row): ?>
        <tr>
            <td><?php echo $row['updated_date']; ?></td>
            <td><?php echo $row['error_msg']; ?></td>            
        </tr>
        <?php endforeach; ?>
    </table>    
</div>  


