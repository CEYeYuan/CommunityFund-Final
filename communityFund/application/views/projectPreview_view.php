<div class='project'>
	<?php 
	if (substr($title, 0,1)<='K' and substr($title, 0,1)>='A')
		$num=1;
	else if (substr($title, 0,1)<='Z' and substr($title, 0,1)>='L')
		$num=2;
	else 
		$num=3;

	?>
	<img src='<?php echo base_url()."assets/images/p".$num.".jpg"; ?>'>
	<div class='desc'>
		<h1 class='title'><a href='<?php echo $url;?>'><?php echo $title; ?></a></h1>
		<p><?php echo $desc; ?></p>
		<div id="progress_bar_container">
			<div id="progress_bar">
				<?php 
				$percent=floor(($currentFund/$fundsNeeded)*100); 
				if($percent>100) {
					$percent=100;
				}
				?>
				<div style='width: <?php echo $percent; ?>%;'><?php echo $percent; ?>%</div>
			</div>
		</div>
	</div>
</div>