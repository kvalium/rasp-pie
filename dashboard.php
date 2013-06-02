	<?php 
		include('struct/header.html'); 
		include('struct/navbar.html'); 

	?>

	<h1>Raspberry Dashboard</h1>
	
	<table class="table_infos">
		
		<!-- Hostname -->
	
		<!-- CPU Usage -->
		<tr>
			<td>CPU Usage</td>
			<td>
				<br />
				<div class="progress">
				
					<div class="bar" id="cpu"><span id="cputxt"></span></div>
					
				</div>
			</td>
		</tr>		
		
		<!-- RAM Usage 
		<tr>
			<td>CPU Usage</td>
			<td>
				<br />
				<div class="progress">
					<div class="bar" style="width: <?php echo round($real_ram_usage/$total_ram*100); ?>%;">
						<span><?php echo round($real_ram_usage/$total_ram*100); ?> %</span>
					</div>
				</div>
			</td>
		</tr>
		
		-->
	</table>
	
	<!--

		<dt>CPU USAGE</dt>
		<dd>
			<?php echo $cpu_usg. " %"; ?>
			<br />
			<div class="progress">
				<div class="bar" style="width: <?echo $cpu_usg; ?>%;"></div>
			</div>
		<dd>
	</dl>
	<dl>
		<dt>RAM USAGE</dt>
		<dd>
			<?php echo round($real_ram_usage/1000)."Mo // ".round($real_ram_usage/$total_ram*100). " %"; ?>
			<br />
			<div class="progress">
				<div class="bar" style="width: <?echo round($real_ram_usage/$total_ram*100); ?>%;"></div>
			</div>
		<dd>
		<dd>TOTAL RAM : <?php echo round($total_ram/1000);?> Mo</dd>
	</dl>

	-->
<?php
	include('struct/footer.html');
?>