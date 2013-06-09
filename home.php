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

    //get_hosts_list();
?>

<h1>Welcome !</h1>
<h2>Hosts alive</h2>
<table class="table table-striped">
    <thead>
        <tr>
            <th>IP address</th>
            <th>Hostname</th>
            <th>Details</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach ($hosts as $host) {
                echo "<tr><td>$host</td>";
                echo "<td>".get_hostname($host)."</td>";
                echo "<td><a href='dashboard.php?host=$host'><span class='fui-search'></span></a></td></tr>";
            }
        ?>
    </tbody>
</table>

<?php include('struct/footer.html'); ?>