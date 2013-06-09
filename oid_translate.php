<?php

    // this page contains OID codes corresponding to a defined propertie.
    $ipadr = "192.168.1.35";
    $snmp_community = "public";

    $OID_CPU_LOAD = "iso.3.6.1.4.1.2021.10.1.3.2";
    $OID_CPU_USAGE = "iso.3.6.1.4.1.2021.11.9.0";
    $OID_TOTAL_RAM = "iso.3.6.1.4.1.2021.4.5.0";
    $OID_FREE_RAM = "iso.3.6.1.4.1.2021.4.11.0";
    $OID_USED_RAM = "iso.3.6.1.4.1.2021.4.6.0";
    $OID_SHARED_RAM = "iso.3.6.1.4.1.2021.4.13.0";
    $OID_BUFF_RAM = "iso.3.6.1.4.1.2021.4.14.0";
    $OID_CACHED_RAM = "iso.3.6.1.4.1.2021.4.15.0";
    $OID_UPTIME = "iso.3.6.1.2.1.25.1.1.0";
    $OID_CPU_IDLE = "iso.3.6.1.4.1.2021.11.11.0";

    $uptime = explode(" ",snmp2_get($ipadr, $snmp_community, $OID_UPTIME));
    $uptime = explode(":",$uptime[2]);
    $uptime = $uptime[0]." hour ".$uptime[1]." min ".floor($uptime[2])." sec.";

    // CPU
    //$cpu_usg = strstr(snmp2_get($ipadr, $snmp_community, $OID_CPU_USAGE), ' ');
    $cpu_usg = 100 - strstr(snmp2_get($ipadr, $snmp_community, $OID_CPU_IDLE), ' ');

    // MEMORY USAGES
    $total_ram = strstr(snmp2_get($ipadr, $snmp_community, $OID_TOTAL_RAM), ' ');
    //$free_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_FREE_RAM),' ');
    $used_ram = strstr(snmp2_get($ipadr, $snmp_community, $OID_USED_RAM), ' ');
    //$shared_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_SHARED_RAM),' ');
    $buff_ram = strstr(snmp2_get($ipadr, $snmp_community, $OID_BUFF_RAM), ' ');
    $cached_ram = strstr(snmp2_get($ipadr, $snmp_community, $OID_CACHED_RAM), ' ');

    $real_ram_usage = $total_ram - $used_ram - $buff_ram - $cached_ram;
    $ram_usg = round($real_ram_usage / $total_ram * 100);

    //echo $cpu_usg;

    $json = array(
        "Uptime" => $uptime,
        "CPU" => $cpu_usg,
        //"CPU_heat" => $cpu_heat,
        "RAM" => $ram_usg,
        "Total_RAM" => round($total_ram / 1000),
        "Used_RAM" => round($real_ram_usage / 1000)
    );

    echo json_encode($json);

?>