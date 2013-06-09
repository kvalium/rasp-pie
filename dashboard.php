<?php
include('struct/header.html');
include('struct/navbar.html');
include('struct/functions.php');

    $ipadr = "192.168.1.35";
    $snmp_community = "public";
    // static data
    $OID_HOSTNAME = "iso.3.6.1.2.1.1.5.0";
    $hostname = strstr(snmp2_get($ipadr, $snmp_community, $OID_HOSTNAME), ' ');
    
?>

<h1>Raspberry Dashboard</h1>

<?php 
    if(!extension_loaded('snmp')){
        echo "<p class='palette palette-pumpkin'>SNMP extension is not activated ! <br /><small>Raspberry Pi state cannot be checked :(</small></p>";
    }else{
?>

<div class="row">
    <div class="offset2 span8">
        <table class="table_infos">
            <!-- Hostname -->
            <tr>
                <td class="txt_infos"><h4>Hostname</h4></td>
                <td>
                    <p>
                        <span id="hostnametxt"><?php echo $hostname;?></span>
                    </p>
                </td>
            </tr>
            <!-- Uptime -->
            <tr>
                <td class="txt_infos"><h4>Up since</h4></td>
                <td>
                    <p>
                        <span id="uptimetxt">-</span>
                    </p>
                </td>
            </tr>
            <!-- CPU Usage -->
            <tr>
                <td class="txt_infos"><h4>CPU Usage</h4></td>
                <td>
                    <br />
                    <div class="progress">
                        <div class="bar" id="cpu"><span id="cputxt"></span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <p>
                        Heat: <span id="cpuheattxt">-</span>°C
                    </p>
                </td>
            </tr>

            <!-- RAM Usage -->
            <tr>
                <td class="txt_infos"><h4>RAM Usage</h4></td>
                <td>
                    <br />
                    <div class="progress">
                        <div class="bar" id="ram" width="0%"><span id="ramtxt">0 %</span></div>
                    </div>
                </td>

            </tr>
            <tr>
                <td></td>
                <td>
                    <p>
                        Used: <span id="usedramtxt">-</span> Mo
                        Total: <span id="totalramtxt">-</span> Mo
                    </p>
                </td>
            </tr>

        </table>
    </div>
</div>


<script src="js/main.js"></script>
<?php
    }
include('struct/footer.html');
?>
