<!DOCTYPE html>
<html>
	<head>
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/navbar.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/homeBackground.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/miniProject.css' type='text/css' />
		
		<script type="text/javascript" src="assets/js/jquery-2.1.3.js"></script>
		<script type="text/javascript" src="assets/js/homeIntro.js"></script>
	</head>
	
	<header>
		<!-- Include the header -->
		<?php $this->load->view('menubar'); ?>
	</header>
	
	<body>
	<div class="background">
		<h1>Welcome to Community Fund</h1>
		<?php
		/*
		// the $picDir is only to be temporarily used
		$picDir = base_url() . "assets/images/";
		foreach($results as $row) {
			echo "<div class='mini' id='" . $row->pid . "' link='" . base_url() . "project/index/" . $row->pid . "'>";
			echo "<div class='left-side'>";
			echo "<img src=" . "'" . $picDir . "wireframe.png' alt='tmpPic'>";
			echo "</div>";
			echo "<div class='right-side'>";
			echo "<h3>";
			echo $row->pname .  "</h3>";
			echo "<h3>";
			echo '$'.$row->fundsNeeded .  "</h3>";
			echo "</div></div>";
		}
		* ***/
	?>
	</div>

	



	</body>
	
</html>