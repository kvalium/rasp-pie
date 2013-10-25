<?php
    include('struct/functions.php');

    //$ipadr = $_GET['ip'];
    $ssh = new Net_SSH2("192.168.0.39");
    if (!$ssh->login('pi', 'aaa')) {
        die("cnx fail"); 
    }
    
    $json = array(
        "Uptime" => get_uptime($ssh),
        "CPU_Heat" => get_cpu_heat($ssh),
        "CPU" => "10",/*get_cpu_usg($ipadr),*/
        "RAM" => "10",/*get_used_ram($ipadr),*/
        "Total_RAM" => "10",/*get_total_ram($ipadr),*/
        "Used_RAM" => "10"/*get_real_ram($ipadr)*/
    );

    echo json_encode($json);

?>