<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<div align="center">
    <table style="width: 800px;">
        <tr>
            <td align="left">
                
            </td>
        </tr>
    </table>

</div>
<h3>Device Name: <?php echo $device['device_name'] . " [" . $device['ip_address'] . "]"; ?></h3>
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
            <td align="center"><a href="<?php echo site_url('real_time/view_graph/'.$log[$i]['device_id'].'/'.$log[$i]['id']); ?>"><img src="<?php echo base_url();?>images/view-icon.png" /></a></td>            
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
                           <?php foreach ($interface_bw->result_array() as $r): ?>
                               <?php if($isFirst) {
                                    $prevIn = $r['bandwidth_in']; 
                                    $prevOut = $r['bandwidth_out'];
                                    $isFirst = FALSE;
                                    continue;
                               } ?>
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
