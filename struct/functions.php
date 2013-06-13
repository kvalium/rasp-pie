<?php
    set_include_path(get_include_path() . PATH_SEPARATOR . 'struct/phpseclib');
    include('struct/phpseclib/Net/SSH2.php');
    
    // OID identifiers for SNMP requests
    define("OID_HOSTNAME", "iso.3.6.1.2.1.1.5.0");
    define("OID_CPU_LOAD", "iso.3.6.1.4.1.2021.10.1.3.2");
    define("OID_CPU_USAGE", "iso.3.6.1.4.1.2021.11.9.0");
    define("OID_TOTAL_RAM", "iso.3.6.1.4.1.2021.4.5.0");
    define("OID_FREE_RAM", "iso.3.6.1.4.1.2021.4.11.0");
    define("OID_USED_RAM", "iso.3.6.1.4.1.2021.4.6.0");
    define("OID_SHARED_RAM", "iso.3.6.1.4.1.2021.4.13.0");
    define("OID_BUFF_RAM", "iso.3.6.1.4.1.2021.4.14.0");
    define("OID_CACHED_RAM", "iso.3.6.1.4.1.2021.4.15.0");
    define("OID_UPTIME", "iso.3.6.1.2.1.25.1.1.0");
    define("OID_CPU_IDLE", "iso.3.6.1.4.1.2021.11.11.0");

    // Check if the SNMP extension is activated
    if(!extension_loaded('snmp')){
        die("<p class='palette palette-pumpkin'>SNMP extension is not activated ! <br /><small>Raspberry Pi state cannot be checked :(</small></p>");
    }
    
    // retrieves params from the params.json file
    function get_params() {
        $param_file = "./struct/params.json";
        if (!file_exists($param_file)) {
            die("<div class='alert alert-error'><h4>Unable to find the params file !</h4><p>Please create file <b>$param_file</b>.</p></div>");
        } else {
            // retrieve hosts list from the json file
            $db = json_decode(file_get_contents($param_file));
            try {
                define("PRM_COMMUNITY", $db->{'snmp_community'});
                define("PRM_SUBNET", $db->{'raspberry_subnet'});
            } catch (Exception $e) {
                die("<div class='alert alert-error'><h4>Params file is invalid!</h4><p>Please stop break everything.</p></div>");
            }
        }
    }
    get_params();

    // Scan the subnet in order to retrieve the list of alive hosts
    function get_hosts_list($file) {
        $isup = array();
        for ($ip = 30; $ip <= 40; $ip++) {
            if(isup(PRM_SUBNET . $ip)){
                $isup[] = PRM_SUBNET . $ip;
            }
        }
        // writing the hosts IP adresses in a json file
        $fp = fopen($file, "w+"); //lecture
        fputs($fp, json_encode($isup));
        fclose($fp);
    }

    function isup($ip) {
        $socket = @fsockopen($ip, 22, $errno, $errstr, 0.1);
        if ($socket) {
            fclose($socket);
            return true;
        } else {
            return false;
        }
    }
    
    function reboot($ip){
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'raspberry')) {
            exit();
        }
        return $ssh->exec("sudo reboot &");
    }
    
    function shutdown($ip){
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'raspberry')) {
            exit();
        }
        return $ssh->exec("sudo halt &");
    }
    
    // retrieve hostname for a given IP
    function get_hostname($ip) {
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'raspberry')) {
            exit();
        }
        return $ssh->exec("hostname");
    }
    
    function set_hostname($ip,$new_hostname){
        snmp2_set($ip, PRM_COMMUNITY, OID_HOSTNAME, "s", $new_hostname);
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'raspberry')) {
            exit();
        }
        $ssh->exec("sudo hostname -v $new_hostname");
    }

    function get_uptime($ip) {
        $uptime = explode(" ",snmp2_get($ip, PRM_COMMUNITY, OID_UPTIME));
        if(is_int($uptime[2])){
            $up = $uptime[2]." day(s) ";
            $uptime = explode(":",$uptime[4]);
            $up .= $uptime[0]." hour(s) ".$uptime[1]." min ".floor($uptime[2])." sec.";
        }else{
            $uptime = explode(":",$uptime[2]);
            $up = $uptime[0]." hour(s) ".$uptime[1]." min ".floor($uptime[2])." sec.";
        }
        return $up;
    }
    
    function get_cpu_usg($ip) {
        return 100 - strstr(snmp2_get($ip, PRM_COMMUNITY, OID_CPU_IDLE), ' ');
    }
    
    function get_cpu_heat($ip){
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'raspberry')) {
            exit();
        }
        return round($ssh->exec("cat /sys/class/thermal/thermal_zone0/temp")/1000);
    }
    
    function get_total_ram($ip) {
        return round(strstr(snmp2_get($ip, PRM_COMMUNITY, OID_TOTAL_RAM), ' ')/1000);
    }
    
    function get_real_ram($ip){
        $used_ram = strstr(snmp2_get($ip, PRM_COMMUNITY, OID_USED_RAM), ' ');
        $buff_ram = strstr(snmp2_get($ip, PRM_COMMUNITY, OID_BUFF_RAM), ' ');
        $cached_ram = strstr(snmp2_get($ip, PRM_COMMUNITY, OID_CACHED_RAM), ' ');

        return round((get_total_ram($ip)*1000 - $used_ram - $buff_ram - $cached_ram) / 1000);
    }
    
    function get_used_ram($ip){
        return round((get_real_ram($ip) /get_total_ram($ip)) * 100);
    }

?>
