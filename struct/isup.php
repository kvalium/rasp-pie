<?php

function isup($ip) {
    $socket = @fsockopen($ip, 22, $errno, $errstr, 0.1);
    if ($socket) {
        fclose($socket);
        return true;
    } else {
        return false;
    }
}

$table = "";

$ip = $_GET['ip'];
$host = "192.168.0." . $ip;
$file = "../hosts";

if (isup($host)) {
    $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
    $table .= "<td><button class='resolve' value='$host'>Resolve</button></td>";
    $table .= "<td>$host</td>";
    $table .= "<td><a href='dashboard.php?host=$host'><span class='fui-search'></span></a></td></tr>";

    if (file_exists($file)) {
        $fp = fopen($file, "a+");
        $all_hosts = fgets($fp);
        $hosts = explode(";", $all_hosts);
        if(!in_array($host, $hosts)){
            fputs($fp, ";".$host);
            echo $table;
        }
        fclose($fp);
    }else{
        $fp = fopen($file, "a+");
        $all_hosts = fgets($fp);
        fputs($fp, $host);
        fclose($fp);
        echo $table;
    }
}

?>