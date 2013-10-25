<?php
    //set_include_path(get_include_path() . PATH_SEPARATOR . '/struct/phpseclib');
    include('phpseclib/Crypt/Random.php');
    include('phpseclib/Crypt/Hash.php');
    include('phpseclib/Crypt/RC4.php');
    include('phpseclib/Math/BigInteger.php');
    include('phpseclib/Net/SSH2.php');
    include('params.php'); // this file contains global params
    
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
    
    // vars
   
    // Check if the SNMP extension is activated
    if(!extension_loaded('snmp')){
        echo "<p class='palette palette-pumpkin'>SNMP extension is not activated! <br /><small>Raspberry Pi state cannot be checked :(</small></p>";
    }
    
    // Database Connection
    function database_connection(){
        $db = mysql_connect(get_params("database_host"), get_params("database_login"), get_params("database_password"));

        // on sélectionne la base
        mysql_select_db(get_params("database_name"),$db)or die("<div class='alert alert-error'><h4>Unable to connect to the MySQL server. Have you check <b>params.php</b> in <b>struct</b> folder?</p></div>"); 
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
        if (!$ssh->login('pi', 'aaa')) {
            exit();
        }
        return $ssh->exec("sudo reboot &");
    }
    
    function shutdown($ip){
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'aaa')) {
            exit();
        }
        return $ssh->exec("sudo halt &");
    }
    
    // retrieve hostname for a given IP
    function get_hostname($ip) {
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'aaa')) {
            return "Erreur de connexion SSH";
        }
        return $ssh->exec("hostname");
    }
    
    function set_hostname($ip,$new_hostname){
        snmp2_set($ip, PRM_COMMUNITY, OID_HOSTNAME, "s", $new_hostname);
        $ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'aaa')) {
            exit();
        }
        $ssh->exec("sudo hostname -v $new_hostname");
    }

    function uptime($ip) {
        $uptime = explode(" ",snmp2_get($ip, get_params("snmp_community"), OID_UPTIME));
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
    
    function get_uptime($ssh){        
        $uptime = $ssh->exec("uptime | cut -d, -f1" );
        preg_match('/up(.*)/', $uptime, $resultat);//met dans $resultat tout ce qui se trouve apres up dans $uptime --> regardez la commande uptime sous linux ce qu'elle donne  
        $resultat=trim($resultat[1]);
        if (preg_match('/day/i', $resultat))
        //uptime supérieur a un jour le 1er cut n'a retourné que le nombre de jours d'uptime  
        //il faut maintenant récupérer le nombre d'heures qui se trouve au champ suivant délimité par la virgule  
        {
        $uptime2=$ssh->exec("uptime | cut -d, -f2" );
        $uptime2=trim($uptime2);
        $uptime=$resultat." ".$uptime2." hour(s)";
        }
        else//uptime inférieur a un jour  
        $uptime=$resultat;
        return $uptime;
    }
    
    function get_cpu_usg($ip) {
        return 100 - strstr(snmp2_get($ip, PRM_COMMUNITY, OID_CPU_IDLE), ' ');
    }
    
    function get_cpu_heat($ssh){
       /*$ssh = new Net_SSH2($ip);
        if (!$ssh->login('pi', 'aaa')) {
            exit();
        }*/
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
