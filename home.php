<?php
    include('struct/header.html');
    include('struct/navbar.html');
    include('struct/functions.php');


    $host_file = "hosts.json";

    if (!file_exists($host_file)) {
        get_hosts_list($host_file);
    }

    // retrieve hosts list from the json file
    $fp = fopen($host_file, "r");
    $hosts = json_decode(fgets($fp));
    fclose($fp);

    //set_hostname("192.168.1.35", "Raspi");
    $table = "";$alive=0;
    count($hosts);
    foreach ($hosts as $host) {
        if (isup($host)) {
            $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
            $table .= "<td>" . get_hostname($host) . "</td>";
            $table .= "<td>$host</td>";
            $table .= "<td><a href='dashboard.php?host=$host'><span class='fui-search'></span></a></td></tr>";
            $alive++;
        } else {
            $table .= "<tr class='palette palette-pumpkin'><td><span class='fui-cross'></span></img></td>";
            $table .= "<td>-</td>";
            $table .= "<td>$host</td>";
            $table .= "<td>Host seems down</td></tr>";
        }
    }
?>

<h1>Welcome !</h1>
<h2>Alive hosts <small><?php echo "($alive/".count($hosts).")";?></small></h2>
<table class="table">
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

<?php include('struct/footer.html'); ?>