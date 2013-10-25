<?php
    include('functions.php');
    $table = "";
    $ip = $_GET['ip'];
    $host = "192.168.0." . $ip;
    if (isup($host)) {
        database_connection();
        $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
        $table .= "<td><button class='resolve' value='$host'>Resolve</button></td>";
        $table .= "<td>$host</td>";
        $table .= "<td><a href='dashboard.php?host=$host'><span class='fui-search'></span></a></td></tr>";

        // Check if the host is already known
        $st_isknown = mysql_query("select h_id from host where h_ip = '$host';") or die(mysql_error());
        $isknown = mysql_fetch_row($st_isknown);
        if (!$isknown) {
            // host insert
            //$hostname = get_hostname($host);
            $hostname = "Raspi";
            mysql_query("insert into host(h_hostname,h_ip) values('$hostname','$host');") or die(mysql_error());
            echo $table;
        }
        mysql_close();
    }
?>