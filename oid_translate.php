<?php
    include('struct/functions.php');

    $ipadr = $_GET['ip'];

    $json = array(
        "Uptime" => get_uptime($ipadr),
        "CPU_Heat" => get_cpu_heat($ipadr),
        "CPU" => get_cpu_usg($ipadr),
        "RAM" => get_used_ram($ipadr),
        "Total_RAM" => get_total_ram($ipadr),
        "Used_RAM" => get_real_ram($ipadr)
    );

    echo json_encode($json);

?>