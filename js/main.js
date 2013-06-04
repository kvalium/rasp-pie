$(document).ready(function() {
    function getData() {
        $.getJSON('oid_translate.php', function(data) {
            $("#hostnametxt").text(data.Hostname);
            $("#uptimetxt").text(data.Uptime);
            
            $("#cpu").width(data.CPU + '%');
            $("#cputxt").text(data.CPU + '%');
            $("#cpuheattxt").text(data.CPU_heat);
            
            $("#ram").width(data.RAM + '%');
            $("#ramtxt").text(data.RAM + '%');
            
            $("#usedramtxt").text(data.Used_RAM);
            $("#totalramtxt").text(data.Total_RAM);
            
            if (data.CPU > 20) {
                $("#cpu").css("background-color", "#e74c3c");
            } else {
                if (data.CPU > 10) { $("#cpu").css("background-color", "#f1c40f"); } else { $("#cpu").css("background-color", "#27ae60"); }
            }
        });
        setTimeout(getData, 3000);
    }

    getData();
});