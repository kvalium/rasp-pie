<?php
include('struct/header.html');
include('struct/navbar.html');
?>

<h1>Raspberry Dashboard</h1>

<div class="row">
    <div class="offset2 span8">
        <table class="table_infos">
            <!-- Hostname -->
            <tr>
                <td class="txt_infos"><h4>Hostname</h4></td>
                <td>
                    <p>
                        <span id="hostnametxt">-</span>
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

<?php
include('struct/footer.html');
?>