rasp-pie
========

Web interface for monitoring several Raspberry Pi.

Current version can scan your subnet to seek alive hosts, which are added to a list. On click on each item, you reach the dashboard page, where system informations are displayed (CPU%, RAM%, total RAM, Used RAM, hostname, uptime and IP Address).

Incoming improvements
---------------------
Using SSH connection for interact with the Pi (change hostname, reboot, etc.).

Installation
============

Client side (on the Rpi)
-----------------------

1) Install snmpd : ```apt-get install snmpd```

2) Edit your SNMP conf file : ```nano /etc/snmp/snmpd.conf```

Configuration example :
```
## sec.name source community
com2sec local 127.0.0.1 public
com2sec mynetwork 192.168.0.0/16 public

## group.name sec.model sec.name
group MyRWGroup v1 mynetwork
group MyRWGroup v2c mynetwork
group MyROGroup v1 mynetwork
group MyROGroup v2c mynetwork

## incl/excl subtree mask
view all included .1 80

## context sec.model sec.level prefix read write notif
access MyROGroup "" any noauth exact all none none
access MyRWGroup "" any noauth exact all all all
```

3) Restart SNMP

Server side
-----------
1) Web server running with php_snmp extension activated.

2) Unzip the sources in your web server www folder

3) Edit the struct/params.json file to provide valid SNMP community and your subnet address.

Note : the authentification is not currently activated.