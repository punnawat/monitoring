<?php if(isset($status_msg)):  
        if($status_msg == 'success'):  ?>
<div style="padding-left: 20px; background-color: #E1F5A9;">
    <img src="<?php echo base_url(); ?>images/ok-icon.png" /> บันทึกข้อมูลเรียบร้อย
</div>
<?php endif; ?>
<?php endif; ?>
<?php   echo form_open('servers/save');
        if(isset($id))
            echo form_hidden('device_id', $id);
?>

<div align="center">
    <table border="0" style="width: 800px;">
    <tr>
        <td class="col_label"><span class="req">*</span> Device Name:</td>
        <td class="col_detail">
            <input name="server_name" type="input" value="<?php echo set_value('server_name', isset($server_name) ? $server_name: '' ); ?>" maxlength="150" style="width:210px;" />
            <?php echo (form_error('server_name')) ? ' <img src="'. base_url().'images/error-icon.png'.'" />' : '' ; ?>
        </td>
    </tr>
    <tr>
        <td class="col_label"><span class="req">*</span> IP Address: </td>
        <td class="col_detail">
            <input name="ip_address" type="input" value="<?php echo set_value('ip_address', isset($ip_address) ? $ip_address: '' ); ?>" maxlength="15" style="width:210px;" />
            <?php echo (form_error('ip_address')) ? ' <img src="'. base_url().'images/error-icon.png'.'" />' : '' ; ?>
        </td>
    </tr>    
    <tr>
        <td class="col_label">Location: </td>
        <td class="col_detail">
            <table>
                <tr>
                    <td>
                        FL.
                    </td>                
                    <td>
                        <input name="location_floor" type="input" value="<?php echo set_value('location_floor', isset($location_floor) ? $location_floor: '' ); ?>" maxlength="50" /> 
                        
                    </td>
                </tr>
                <tr>
                     <td>
                        Rack.
                    </td>
                    <td>
                        <input name="location_rack" type="input" value="<?php echo set_value('location_rack', isset($location_rack) ? $location_rack: '' ); ?>" maxlength="50" /> 
                    </td>
                </tr>
                <tr>
                     <td>
                        Room.
                    </td>
                    <td>
                        <input name="location_room" type="input" value="<?php echo set_value('location_room', isset($location_room) ? $location_room: '' ); ?>" maxlength="50" />
                    </td>
                </tr>
                <tr>
                     <td>
                        Building.
                    </td>
                    <td>
                        <input name="location_building" type="input" value="<?php echo set_value('location_building', isset($location_building) ? $location_building: '' ); ?>" maxlength="50" />
                    </td>
                </tr>
            </table>   
        </td>
    </tr>
    <tr>
        <td class="col_label">Services: </td>
        <td class="col_detail">    
            <input name="http_yn" type="checkbox" value="Y" <?php if($this->input->post('http_yn') == 'Y' || (isset($http_yn) && $http_yn == 'Y')) echo ' checked="checked" '; ?> /> HTTP <br/>
            <input name="https_yn" type="checkbox" value="Y" <?php if($this->input->post('https_yn') == 'Y' || (isset($https_yn) && $https_yn == 'Y')) echo ' checked="checked" '; ?> /> HTTPS<br/>
            <input name="ftp20_yn" type="checkbox" value="Y" <?php if($this->input->post('ftp20_yn') == 'Y' || (isset($ftp20_yn) && $ftp20_yn == 'Y')) echo ' checked="checked" '; ?> /> FTP 20<br/>
            <input name="ftp21_yn" type="checkbox" value="Y" <?php if($this->input->post('ftp21_yn') == 'Y' || (isset($ftp21_yn) && $ftp21_yn == 'Y')) echo ' checked="checked" '; ?> /> FTP 21<br/>
            <input name="smtp_yn" type="checkbox" value="Y" <?php if($this->input->post('smtp_yn') == 'Y' || (isset($smtp_yn) && $smtp_yn == 'Y')) echo ' checked="checked" '; ?> /> SMTP <br/>
            TCP Port <input name="tcp_port" type="input" value="<?php echo set_value('tcp_port', isset($tcp_port) ? $tcp_port: '' ); ?>" maxlength="50" />            
        </td>
    </tr>
    <tr>
        <td class="col_label">Monitor ?: </td>
        <td class="col_detail">
            <input name="monitor_yn" type="checkbox" value="Y" <?php if($this->input->post('monitor_yn') == 'Y' || (isset($monitor_yn) && $monitor_yn == 'Y')) echo ' checked="checked" '; ?> />
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td class="col_detail">
            <input type="submit" value="SAVE" />
        </td>
    </tr>
</table>
</div>
<?php echo form_close(); ?>
