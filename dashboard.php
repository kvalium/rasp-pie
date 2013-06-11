<?php
include('struct/header.html');
include('struct/navbar.html');
include('struct/functions.php');

// Check the presence of host ip, then check if host is alive. Finally, 
// retrieves its hostname.
if (isset($_GET['host'])) {
    $ipadr = $_GET['host'];
    if (!isup($ipadr)) {
        die("<div class='alert alert-error'><h4>Host seems down !</h4><p>Unable to reach $ipadr.</p></div>");
    }
} else {
    die("<div class='alert alert-error'><h4>Invalid host provided !</h4><p>Host $ipadr not found.</p></div>");
}

if(isset($_GET['action'])){
    if($_GET['action']=='reboot'){
        reboot($ipadr);
        $result = "<div id='result-alert' class='alert alert-warning'><h4>This computer will reboot in 30 seconds.</h4></div>";
    }else{
        if($_GET['action']=='shutdown'){
            shutdown($ipadr);
            $result = "<div id='result-alert' class='alert alert-warning'><h4>This computer will shutdown.</h4></div>";
        }
    }
}

// Hostname change
if(isset($_POST['hostname'])){
    $new_hostname = $_POST['hostname'];
    if(!is_null($new_hostname) && !empty($new_hostname)){
        set_hostname($ipadr, $new_hostname);
        $result = "<div id='result-alert' class='alert alert-success'><h4>Hostname successfully updated !</h4></div>";
    }else{
        $result = "<div id='result-alert' class='alert alert-error'>An error occurs during hostname update. No change were done.</div>";
    }
}
?>

<h1>Raspberry Dashboard</h1>
<?php if(isset($result)){ echo $result;} ?>
<h2>Status</h2>
<div class="row">
    <div class="offset2 span8">
        <table class="table_infos">
            <!-- Hostname -->
            <tr>
                <td class="txt_infos"><h4>Hostname</h4></td>
                <td>
                    <p>
                        <span id="hostnametxt"><?php echo get_hostname($ipadr); ?></span>
                    </p>
                </td>
            </tr>
            <!-- IP ADR -->
            <tr>
                <td class="txt_infos"><h4>IP Address</h4></td>
                <td>
                    <p>
                        <span id="iptxt"><?php echo $ipadr; ?></span>
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
                        Heat: <span id="cpuheattxt">-</span> °C
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
<hr />
<h2>Actions</h2>
<br />
<div class="row">
    <div class="span3">
        <a class="btn btn-block btn-large" href="home.php">Back</a>
    </div>
    <div class="span3">
        <a class="btn btn-large btn-block btn-info" href="#HostnameModal" data-toggle="modal">Change Hostname</a>
    </div>
    <div class="span3">
        <a class="btn btn-large btn-block btn-danger" href="dashboard.php?host=<?php echo $ipadr;?>&action=reboot" onclick="return(confirm('sure?'));">Reboot</a>
    </div>
    <div class="span3">
        <a class="btn btn-large btn-block btn-inverse" href="dashboard.php?host=<?php echo $ipadr;?>&action=shutdown" onclick="return(confirm('sure?'));">Shutdown</a>
    </div>
</div>


<!-- Modal -->
<div id="HostnameModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Changing hostname</h3>
    </div>
    <form class="modalform" method="post" action='<?php echo "dashboard.php?host=$ipadr"; ?>' >
        <div class="modal-body">
            <p>Hostname must be at least 5 characters long and is limited to 10 characters. Only letters and numbers are allowed.</p>
            <input type="text" name="hostname" class="span6" placeholder="Enter new hostname"  pattern="[A-Za-z0-9]{5,10}" required>
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </form>
</div>

<script src="js/main.js"></script>
<?php
include('struct/footer.html');
?>
