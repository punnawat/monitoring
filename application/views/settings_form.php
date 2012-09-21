<?php if(isset($status_msg)):  
        if($status_msg == 'success'):  ?>
<div style="padding-left: 20px; background-color: #E1F5A9;">
    <img src="<?php echo base_url(); ?>images/ok-icon.png" /> บันทึกข้อมูลเรียบร้อย
</div>
<?php endif; ?>
<?php endif; ?>
<?php   echo form_open('settings/save'); ?>

<div align="center">
    <table border="0" style="width: 800px;">
    <tr>
        <td class="col_label"><span class="req">*</span> Polling Every :</td>
        <td class="col_detail">
            <input type="hidden" name="refresh_key" value="refresh_time" />
            <input name="refresh_time" type="input" value="<?php echo set_value('refresh_time', isset($refresh_time['values']) ? $refresh_time['values'] : '' ); ?>" maxlength="150" style="width:210px;" /> Mins.
            <?php echo (form_error('refresh_time')) ? ' <img src="'. base_url().'images/error-icon.png'.'" />' : '' ; ?>
        </td>
    </tr>
	<tr>
        <td class="col_label"><span class="req">*</span> Polling Alarm :</td>
        <td class="col_detail">
            <input type="hidden" name="alarm_key" value="downtime" />
            <input name="alarm" type="input" value="<?php echo set_value('alarm', isset($alarm['values']) ? $alarm['values']: '' ); ?>" maxlength="150" style="width:210px;" /> Times
            <?php echo (form_error('alarm')) ? ' <img src="'. base_url().'images/error-icon.png'.'" />' : '' ; ?>
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
