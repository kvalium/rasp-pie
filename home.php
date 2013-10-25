<?php
include('struct/header.html');
include('struct/navbar.html');
include('struct/functions.php');

database_connection();
$table = "";

$st_hosts = mysql_query("select h_hostname, h_ip from host order by 1;") or die("<div class='alert alert-error'><h4>Unable to retrieve the hosts list. Please check your database.</p></div>");

while ($host = mysql_fetch_assoc($st_hosts)) {
    $host_ip = $host['h_ip'];
    $host_name = $host['h_hostname'];
    if (isup($host_ip)) {
        $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
        $table .= "<td>$host_name</td>";
        $table .= "<td>$host_ip</td>";
        $table .= "<td><a href='dashboard.php?host=$host_ip'><span class='fui-search'></span></a></td></tr>";
    } else {
        $table .= "<tr class='palette palette-pumpkin'><td><span class='fui-cross'></span></img></td>";
        $table .= "<td>-</td>";
        $table .= "<td>$host_ip</td>";
        $table .= "<td>Host seems down</td></tr>";
    }
}
?>

<h1>Welcome !</h1>
<h2>Alive hosts <small></small></h2>
<table id="hosts" class="table">
    <thead>
        <tr>
            <th>Status</th>
            <th>Hostname</th>
            <th>IP address</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php echo $table; ?>
    </tbody>
</table>

<div id="current_scan" class='alert alert-success'>
    <h4><span id="scanned">0</span> hosts scanned, <span id="added">0</span> added</h4>
</div>


<span id="results"></span>

<h2>Subnet Scan</h2>
<p>Scan your subnet to detect and add to the above list the Raspberry Pi(s)</p>
<form method="get" id="scanform" action="javascript:;">
    <input type="text" name="subnet"  placeholder="Subnet mask (xxx.xxx.xxx)" value="192.168.0" pattern="((^|\.)((25[0-5])|(2[0-4]\d)|(1\d\d)|([1-9]?\d))){3}$" required>
    <input type="text" name="startIP" id='scanstart' placeholder="IP range start"  pattern="((25[0-4])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|([1-9]))$" required>
    <input type="text" name="endIP"  id='scanend' placeholder="IP range end"  pattern="((25[0-4])|(2[0-4]\d)|(1\d\d)|([1-9]\d)|([1-9]))$" required>
    <button type="submit" id="btn_submit" class="btn btn-primary">Subnet Scan</button>
</form>

<?php
mysql_close();
include('struct/footer.html');
?>