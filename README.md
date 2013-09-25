Rasp Pie
========

[Project website here !](http://julienmonchany.github.io/rasp-pie)

Rasp Pie is a web interface for monitoring several Raspberry Pi. 
It allows to scan your subnet to detect alive Raspberry then you can see their status (% CPU, % RAM, etc.).
You can also change their hostname, reboot or shutdown them. 



![Rasp Pie screenshot](https://raw.github.com/julienmonchany/rasp-pie/master/images/screenshots/screenshot.png)


Current version can scan your subnet to seek alive hosts, which are added to a list. Down hosts are also identified.

On click on each item, you reach the dashboard page, where system informations are displayed (CPU%, RAM%, total RAM, Used RAM, hostname, uptime and IP Address).
Then it is possible to change the Raspberry hostname, reboot or shutdown it.

## Author

[**Julien Monchany**](mailto:julien.monchany@gmail.com) - French IT student (look at my [resume](https://docs.google.com/file/d/0B3lnw6TpitHKQnlXTmFZcDc0RGc/edit?usp=sharing) !).


## Incoming improvements
+ Activate authentification
+ Reset the hosts list
+ Refresh the host list to check the hosts status

## Installation

### Client side (on the Rpi)

1) Install snmpd : ```apt-get install snmpd```

2) Edit your SNMP conf file : ```nano /etc/snmp/snmpd.conf```

Configuration example :
```
## sec.name source community
com2sec local 127.0.0.1 public
com2sec mynetwork 192.168.0.0/16 public

## group.name sec.model sec.name
group MyROGroup v1 mynetwork
group MyROGroup v2c mynetwork

## incl/excl subtree mask
view all included .1 80

## context sec.model sec.level prefix read write notif
access MyROGroup "" any noauth exact all none none
```

3) Restart SNMP : ```sudo service snmpd restart```

### Server side

1) Web server running with php_snmp extension activated.

2) Unzip the sources in your web server www folder

3) Edit the struct/params.json file to provide valid SNMP community and your subnet address.

Note : 
1) The authentification is not currently activated. 
2) To reanalyse the subnet, delete file hosts.json and refresh the page.
3) Feel free to contribute ;)


## Design 
[Flat UI Free](https://github.com/designmodo/Flat-UI) - licensed under a Creative Commons Attribution 3.0 Unported (CC BY 3.0) (http://creativecommons.org/licenses/by/3.0/) and MIT License - http://opensource.org/licenses/mit-license.html. 

## Licence

![Creative Commons](http://i.creativecommons.org/l/by-sa/3.0/88x31.png)

This work is licensed under a [Creative Commons Attribution 3.0 Unported License](http://creativecommons.org/licenses/by/3.0/).
