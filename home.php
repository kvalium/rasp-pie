<?php
include('struct/header.html');
include('struct/navbar.html');
include('struct/functions.php');


$host_file = "hosts";
$table = "";

if (file_exists($host_file)) {
    // retrieve hosts list from the host file
    $fp = fopen($host_file, "r");
    $all_hosts = fgets($fp);
    $hosts = explode(";", $all_hosts);
    fclose($fp);

    foreach ($hosts as $host) {
        if (isup($host)) {
            $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
            $table .= "<td>hostname</td>";
            $table .= "<td>$host</td>";
            $table .= "<td><a href='dashboard.php?host=$host'><span class='fui-search'></span></a></td></tr>";
        } else {
            $table .= "<tr class='palette palette-pumpkin'><td><span class='fui-cross'></span></img></td>";
            $table .= "<td>-</td>";
            $table .= "<td>$host</td>";
            $table .= "<td>Host seems down</td></tr>";
        }
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
    <input type="text" name="subnet"  placeholder="Subnet mask" value="192.168.0." pattern="[0-9.]{8,11}" required>
    <input type="text" name="startIP" id='scanstart' placeholder="IP range start"  pattern="[0-9]{1,3}" required>
    <input type="text" name="endIP"  id='scanend' placeholder="IP range end"  pattern="[0-9]{1,3}" required>
    <button type="submit" id="btn_submit" class="btn btn-primary">Subnet Scan</button>
</form>

<?php include('struct/footer.html'); ?>