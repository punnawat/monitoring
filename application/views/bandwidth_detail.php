<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>jquery/css/ui-lightness/jquery-ui-1.8.23.custom.css">
<script src="<?php echo base_url(); ?>jquery/js/jquery-1.8.0.min.js"></script>
<script src="<?php echo base_url(); ?>jquery/js/jquery-ui-1.8.23.custom.min.js"></script>
<script>
    $(function() {		
        $( "#txtStartDate" ).datepicker( { dateFormat: 'yy-mm-dd'} );
        $( "#txtEndDate" ).datepicker( { dateFormat: 'yy-mm-dd'} );		
    });
    function setVal($deviceID, $log) {
        $("#txtDeviceID").val($deviceID);
        $("#txtLogID").val($log);
        document.forms[0].submit();
    }
</script>
<h3>Device Name: <?php echo $device['device_name'] . " [" . $device['ip_address'] . "]"; ?></h3>

<?php   echo form_open('bandwidth/view_graph'); ?>
<div align="center" style="padding-bottom: 10px;">
    <table style="border: 1px #734201 dashed;padding: 4px;">
        <tr>
            <td align="right" style="width: 100px; padding-right: 4px;">
             Period Date 
            </td>
            <td align="left" >
                <input type="text" name="txtStartDate" id="txtStartDate" value="<?php echo $this->input->post('txtStartDate') != null ? $this->input->post('txtStartDate') : '' ?>" /> 
                to <input type="text" name="txtEndDate" id="txtEndDate" value="<?php echo $this->input->post('txtEndDate') != null ? $this->input->post('txtEndDate') : '' ?>" />
            </td>
            <td align="left" style="width: 20px;">
                &nbsp;
            </td>
        </tr>
    </table>
</div>
<input type="hidden" name="txtDeviceID" id="txtDeviceID" />
<input type="hidden" name="txtLogID" id="txtLogID" />
<?php echo form_close(); ?>

<?php $log = $log->result_array(); ?>
<div align="center" style="padding-top: 5px;">
    <table class="sample" style="width: 950px;font-size: 12px;">        
        <tr style="font-weight: bold;">
            <th>Interface</th>            
            <th>View</th>                        
            <th>&nbsp;</th>              
        </tr>        
        <?php for($i = 0; $i < count($log); $i++) : ?>
        <tr valign="top">
            <td><?php echo $log[$i]['interface_name']; ?></td>                         
            <td align="center"><a href="javascript:setVal(<?php echo $log[$i]['device_id']; ?>,<?php echo $log[$i]['id']; ?>);"><img src="<?php echo base_url();?>images/view-icon.png" /></a></td>            
            <?php if($i == 0) :?>
            <td align="center" width="750" rowspan="<?php echo count($log);?>" >
               <?php if(isset($interface_bw)): ?>
                        <script type="text/javascript">
                        google.load("visualization", "1", {packages:["corechart"]});
                        google.setOnLoadCallback(drawChart);
                        function drawChart() {
                            var data = google.visualization.arrayToDataTable([
                            ['Date/Time', 'In', 'Out'],
                           <?php $prevIn = 0; $prevOut = 0; $isFirst = true; ?> 
                           <?php foreach ($interface_bw->result_array() as $r): 
                               if($isFirst) {
                                    $prevIn = $r['bandwidth_in'];
                                    $prevOut =$r['bandwidth_out'];
                                    $isFirst = false;
                               }
                               ?>
                            ['<?php echo $r['updated_date']?>',<?php echo ($r['bandwidth_in'] - $prevIn)/1024/1024/300.0?>,<?php echo ($r['bandwidth_out']-$prevOut)/1024/1024/300.0?>],
                            <?php $prevIn = $r['bandwidth_in']; $prevOut = $r['bandwidth_out']; ?>
                            <?php endforeach; ?>
                            ]);

                            var options = {
                            title: '<?php echo $interface_name;?>',                            
                            vAxis:  {title: 'Mbps', titleTextStyle: {color: '#0B3B0B'}, minValue: 0.0, viewWindowMode: 'maximized'},
                            hAxis:  {title: 'Date/Time', titleTextStyle: {color: '#0B3B0B'}}                            
                            };

                            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
                            chart.draw(data, options);
                        }
                        </script>
                        <br/><br/><br/>
                    <div id="chart_div" style="width: 720px;height:500px;"></div>
                <?php endif; ?>                    
            </td>
            <?php endif; ?>
        </tr>
        <?php endfor; ?>
</table>

</div>    

