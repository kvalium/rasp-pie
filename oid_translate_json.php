<?php 
	// this page contains OID codes corresponding to a defined propertie.

		$ipadr = "192.168.1.36";
		$snmp_community = "public";
	
		$OID_HOSTNAME 	= "iso.3.6.1.2.1.1.5.0";
		$OID_CPU_LOAD	= "iso.3.6.1.4.1.2021.10.1.3.2";
		$OID_CPU_USAGE	= "iso.3.6.1.4.1.2021.11.9.0";
		$OID_TOTAL_RAM	= "iso.3.6.1.4.1.2021.4.5.0";
		$OID_FREE_RAM	= "iso.3.6.1.4.1.2021.4.11.0";
		$OID_USED_RAM	= "iso.3.6.1.4.1.2021.4.6.0";
		$OID_SHARED_RAM = "iso.3.6.1.4.1.2021.4.13.0";
		$OID_BUFF_RAM	= "iso.3.6.1.4.1.2021.4.14.0";
		$OID_CACHED_RAM = "iso.3.6.1.4.1.2021.4.15.0";

		$hostname 	= strstr(snmp2_get($ipadr,$snmp_community,$OID_HOSTNAME),' ');
		$cpu_usg  	= strstr(snmp2_get($ipadr,$snmp_community,$OID_CPU_USAGE),' ');
		
		// MEMORY USAGES
		$total_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_TOTAL_RAM),' ');
		//$free_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_FREE_RAM),' ');
		$used_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_USED_RAM),' ');
		//$shared_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_SHARED_RAM),' ');
		$buff_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_BUFF_RAM),' ');
		$cached_ram	= strstr(snmp2_get($ipadr,$snmp_community,$OID_CACHED_RAM),' ');
		
		$real_ram_usage = $total_ram-$used_ram-$buff_ram-$cached_ram;
		$ram_usg = round($real_ram_usage/$total_ram*100);
		
		//echo $cpu_usg;
		
		$json = array(
		  "CPU Usage" => $cpu_usg,
		  "RAM Usage" => $ram_usg
		);
		
		echo json_encode($json);
	

	
	
/*

CPU Statistics

Load
1 minute Load: .1.3.6.1.4.1.2021.10.1.3.1
5 minute Load: .1.3.6.1.4.1.2021.10.1.3.2
15 minute Load: .1.3.6.1.4.1.2021.10.1.3.3

CPU
percentage of user CPU time: .1.3.6.1.4.1.2021.11.9.0
raw user cpu time: .1.3.6.1.4.1.2021.11.50.0
percentages of system CPU time: .1.3.6.1.4.1.2021.11.10.0
raw system cpu time: .1.3.6.1.4.1.2021.11.52.0
percentages of idle CPU time: .1.3.6.1.4.1.2021.11.11.0
raw idle cpu time: .1.3.6.1.4.1.2021.11.53.0
raw nice cpu time: .1.3.6.1.4.1.2021.11.51.0

Memory Statistics

Total Swap Size: .1.3.6.1.4.1.2021.4.3.0
Available Swap Space: .1.3.6.1.4.1.2021.4.4.0
Total RAM in machine: .1.3.6.1.4.1.2021.4.5.0
Total RAM used: .1.3.6.1.4.1.2021.4.6.0
Total RAM Free: .1.3.6.1.4.1.2021.4.11.0
Total RAM Shared: .1.3.6.1.4.1.2021.4.13.0
Total RAM Buffered: .1.3.6.1.4.1.2021.4.14.0
Total Cached Memory: .1.3.6.1.4.1.2021.4.15.0

Disk Statistics

The snmpd.conf needs to be edited. Add the following (assuming a machine with a single ‘/' partition):

disk / 100000 (or)

includeAllDisks 10% for all partitions and disks

The OIDs are as follows

Path where the disk is mounted: .1.3.6.1.4.1.2021.9.1.2.1
Path of the device for the partition: .1.3.6.1.4.1.2021.9.1.3.1
Total size of the disk/partion (kBytes): .1.3.6.1.4.1.2021.9.1.6.1
Available space on the disk: .1.3.6.1.4.1.2021.9.1.7.1
Used space on the disk: .1.3.6.1.4.1.2021.9.1.8.1
Percentage of space used on disk: .1.3.6.1.4.1.2021.9.1.9.1
Percentage of inodes used on disk: .1.3.6.1.4.1.2021.9.1.10.1

*/
?>