<script>
    function deleteItem($i) {
       var answer = confirm("Confirm to delete this device?")
        if (answer){
            document.getElementById('device_id').value = $i;
            document.forms["delItemForm"].submit();            
        }    
        return false;    
    }
</script>
<form id="delItemForm" method="POST" action="<?php echo site_url('devices/del'); ?>" >
<input type="hidden" id="device_id" name="device_id" />
</form>       
<div align="center">
    <table style="width: 800px;">
        <tr>
            <td align="left">
                <a href="<?php echo site_url('devices/add'); ?>"><img src="<?php echo base_url(); ?>images/add2-icon.png" /></a>                
            </td>
        </tr>
    </table>
    
</div>

<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 800px;">
        <col width="*" />
        <col width="180px" />
        <col width="100px" />
        <col width="150px" />
        <col width="75px" />
        <col width="75px" />
        <tr style="font-weight: bold;">
            <th>Device Name</th>
            <th>IP Address</th>
            <th>Monitor?</th>
            <th>Bandwidth Report?</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($results->result_array() as $row): ?>
        <tr>
            <td><?php echo $row['device_name']; ?></td>
            <td><?php echo $row['ip_address']; ?></td>
            <td align="center"><a href="">
                    <?php if($row['monitor_yn'] == 'Y'): ?>                                    
                    <img src="<?php echo base_url(); ?>images/ok-icon.png" />
                    <?php else: ?>
                    &nbsp;
                    <?php endif; ?>
                </a></td>
            <td align="center"><a href="">
                    <?php if($row['bandwidth_yn'] == 'Y'): ?>                                    
                    <img src="<?php echo base_url(); ?>images/ok-icon.png" />
                    <?php else: ?>
                    &nbsp;
                    <?php endif; ?>
                </a></td>          
            <td align="center"><a href="<?php echo site_url('devices/edit/'.$row['id']); ?>"><img src="<?php echo base_url();?>images/edit-icon.png" /></a></td>
            <td align="center"><a href="#" onclick="return deleteItem(<?php echo $row['id'];?>)"><img src="<?php echo base_url();?>images/bin-icon.png" /></a></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <div align="center">
        <?php echo $links; ?>
    </div>
</div>    
