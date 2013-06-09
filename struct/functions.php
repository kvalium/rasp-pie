<?php
    function get_params(){
        $param_file = "params.json";
        if(!file_exists($param_file)){
            die("<div class='alert alert-error'><h4>Unable to find the params file !</h4><p>Please create file <b>$param_file</b>.</p></div>");
        }else{
            // retrieve hosts list from the json file
            $db = json_decode(file_get_contents($param_file));
            try{
                $community = $db->{'snmp_community'};
                $subnet = $db->{'raspberry_subnet'};
            }catch (Exception $e){
                die("<div class='alert alert-error'><h4>Params file is invalid!</h4><p>Please stop break everything.</p></div>");
            }
        }
    }
    get_params();

    function get_hosts_list($file) {
        $subnet = "192.168.1.";
        $isup = array();
        for ($ip = 30; $ip <= 40; $ip++) {
            $socket = @fsockopen($subnet . $ip, 22, $errno, $errstr, 0.1);
            if ($socket) {
                $isup[] = $subnet . $ip;
                fclose($socket);
            }
        }
        // writing the hosts IP adresses in a json file
        $fp = fopen($file, "w+"); //lecture
        fputs($fp, json_encode($isup));
        fclose($fp);
    }
    
    function get_hostname($ip){
        $snmp_community = "public";
        // static data
        $OID_HOSTNAME = "iso.3.6.1.2.1.1.5.0";
        return $hostname = strstr(snmp2_get($ip, $snmp_community, $OID_HOSTNAME), ' ');
    }
?>
