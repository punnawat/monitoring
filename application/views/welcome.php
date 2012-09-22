<div align="center">
<?php
$sess_array = $this->session->userdata('logged_in');
if ($sess_array != null && $sess_array["username"] != null) {
    echo form_open('welcome/logout');
    ?> 
    <table  style="border: 4px #734201 dashed;padding: 10px;">
        <tr>
            <td>
                <h2>You are log in as <?php echo $sess_array["username"]; ?>.</h2>
                <input type="submit" value="LOGOUT" />
        </tr>
    </table>
    <?php
} else {
    echo form_open('welcome/login');
    ?>
    <table style="border: 4px #734201 dashed;padding: 10px;">   

        <tr>
            <td>&nbsp;</td>
            <td align="right" style="padding-right: 5px;"><b>Username </b></td>
            <td><input type="text" name="txtUsername" style="width: 250px;" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td align="right" style="padding-right: 5px;"><b>Password </b></td>
            <td><input type="password" name="txtPassword" style="width: 250px;" /></td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
            <td><input type="submit" value="LOGIN" /></td>
            <td>&nbsp;</td>
        </tr>
    </table>
    <?php
}
?>

<?php echo form_close(); ?>
<br/><br/><br/><br/><br/>
</div>