rasp-pie
========

Web interface for monitoring several Raspberry Pi.

Current version is still an early beta so many features doesn't work. It currently retrieve the CPU usage (%) of only one Rpi with the provided IP address (in oid_translate.php file), with a 3 seconds actualization.

Installation
============

Client side (on the Rpi)
-----------------------

1) Install snmpd : apt-get install snmpd

2) Edit your SNMP conf file : nano /etc/snmp/snmpd.conf 

Configuration example :
```
## sec.name source community
com2sec local 127.0.0.1 public
com2sec mynetwork 192.168.1.0/24 public

## group.name sec.model sec.name
group MyRWGroup v1 local
group MyRWGroup v2c local
group MyROGroup v1 mynetwork
group MyROGroup v2c mynetwork

## incl/excl subtree mask
view all included .1 80

## context sec.model sec.level prefix read write notif
access MyROGroup "" any noauth exact all none none
access MyRWGroup "" any noauth exact all all all
```
Server side
-----------
1) Web server running with php_snmp extension activated.

2) Unzip the sources in your web server www folder

3) Edit the oid_translate.php file in order to provide the Rpi IP address.

Note : the authentification is not currently activated.