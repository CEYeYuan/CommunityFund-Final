<!DOCTYPE html>
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/navbar.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/catagory.css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/projectShort.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/progressBar.css' type='text/css' />
		
		<script type="text/javascript">
    		var BASE_URL = "<?php echo base_url(); ?>";
		</script>
		<script type="text/javascript" src="assets/js/jquery-2.1.3.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
		<script type="text/javascript" src="assets/js/loadProjectPreview.js"></script>
		<script type="text/javascript" src="assets/js/backgroundColor.js"></script>
	</head>
	
	<header>
		<!-- Include the header -->
		<?php $this->load->view('menubar'); ?>
	</header>
	
	<body>
	

<!-- This section is the main body -->
<div class="catagory">
	
	<h3>Pioneer a creative project!</h3>
	
	<ul class="catList">
	<?php
	
	foreach($results as $row) {
		echo "<li id='$row->cid'>";
		echo "<a link='discover/index/" . $row->cid . "'>";
		echo $row->name;
		echo "</a>";
		echo "</li>";
	}
	
	?>
	</ul>
</div>
<div class='projectContent'>
</div>
	</body>
</html>