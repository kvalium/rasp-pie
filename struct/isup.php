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

$isup = array();

$ip = $_GET['ip'];
$host = "192.168.0." . $ip;
$file = "../hosts.txt";

if (isup($host)) {
    $table .= "<tr><td><span class='fui-check' style='color:#16a085'></span></img></td>";
    $table .= "<td>hostname</td>";
    $table .= "<td><span class='fui-search'></td>";
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