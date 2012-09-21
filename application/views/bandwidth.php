<?php   echo form_open('bandwidth/search'); ?>
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
            <th>View</th>                        
        </tr>
        <?php if(isset($results)): ?>
        <?php foreach ($results->result_array() as $row): ?>
        <tr>
            <td><?php echo $row['device_name']; ?></td>
            <td><?php echo $row['ip_address']; ?></td>                  
            <td align="center"><a href="<?php echo site_url('bandwidth/view/'.$row['id']); ?>"><img src="<?php echo base_url();?>images/view-icon.png" /></a></td>            
        </tr>
        <?php endforeach; ?>
        <?php endif; ?>
</table>

</div>    

