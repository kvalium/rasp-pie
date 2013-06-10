$(document).ready(function() {
    function getData() {
        $ip = $("#iptxt").text();
        $.getJSON('oid_translate.php?ip='+$ip, function(data) {
            $("#uptimetxt").text(data.Uptime);
            
            $("#cpu").width(data.CPU + '%');
            $("#cputxt").text(data.CPU + '%');
            //$("#cpuheattxt").text(data.CPU_heat);
            
            $("#ram").width(data.RAM + '%');
            $("#ramtxt").text(data.RAM + '%');
            
            $("#usedramtxt").text(data.Used_RAM);
            $("#totalramtxt").text(data.Total_RAM);
            
            if (data.CPU > 75) {
                $("#cpu").css("background-color", "#e74c3c");
            } else {
                if (data.CPU > 50) { $("#cpu").css("background-color", "#f1c40f"); } else { $("#cpu").css("background-color", "#27ae60"); }
            }
            if (data.RAM > 75) {
                $("#ram").css("background-color", "#e74c3c");
            } else {
                if (data.RAM > 50) { $("#ram").css("background-color", "#f1c40f"); } else { $("#ram").css("background-color", "#27ae60"); }
            }
        });
        setTimeout(getData, 3000);
    }
    getData();
});