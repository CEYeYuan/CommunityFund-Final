<!DOCTYPE hmtl>
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/navbar.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/createIntro.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/catagory.css' />
		<script type="text/javascript" src="<?php echo base_url()?>assets/js/jquery-2.1.3.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>assets/js/createTransition.js"></script>
		<script type="application/javascript" src="<?php echo base_url()?>assets/js/createProject.js"></script>
		<script type="text/javascript">
    		var BASE_URL = "<?php echo base_url(); ?>";
		</script>
	</head>
	<header>
		<!-- Include the header -->
		<?php $this->load->view('menubar'); ?>
	</header>
	
	<body>
		
		<?php echo validation_errors(); ?>
		
			<div class="create">
				<ul class='project'></ul>
				<div id="first" class="tab active">
					<h1>Start your own adventure!</h1>
					<a class="start">Go!</a>
				</div>
				<div id="second" class="tab">
					<h1>Select Category</h1>
					<ul class="catList">
						<?php
							foreach($categories as $row) {
								echo "<li><a name='category' value='".$row->cid."'>" . $row->name;
								echo "</a></li>";
							}	
						 ?>
					</ul>
				</div>
				<div id="third" class="tab"> 
					<a>
						<lspan>Project name:</lspan>
						<input type='text' name="title">
						<confirm>Confirm?</confirm>
					<a/>
				</div>
				<div id="fourth" class="tab">
					<a>
						<lspan>pick start date</lspan>
						<div class='startDate'>
							<select name="year" size="1">
							<?php
								// create an <option> tag for years between
								// 1850 and 2050
								for ($i = 1850; $i < 2051; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							?>
							</select>
							
							<!-- Month selection -->
							M:
							<select name="month" size="1">
							<?php
								for ($i = 1; $i < 13; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							 ?>
							</select>
							
							<!-- Day selection -->
							D:
							<select name="day" size="1">
							<?php
								for ($i = 1; $i < 32; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							 ?>
							</select>
						</div> </br>
						<lspan>pick end date</lspan>
						<div class='endDate'>
							<select name="endYear" size="1">
							<?php
								// create an <option> tag for years between
								// 1850 and 2050
								for ($i = 1850; $i < 2051; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							?>
							</select>
							
							<!-- Month selection -->
							M:
							<select name="endMonth" size="1">
							<?php
								for ($i = 1; $i < 13; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							 ?>
							</select>
							
							<!-- Day selection -->
							D:
							<select name="endDay" size="1">
							<?php
								for ($i = 1; $i < 32; $i++) {
									echo "<option value='" . $i . "'>" . $i;
									echo "</option>";
								}
							 ?>
							</select>
						</div>
						<confirm>Confirm</confirm>
					</a>
				</div>
				<div id="fifth" class="tab">
					<a>
						<lspan>Fund Amount</lspan></br>
						<input type="text" name="dollars" size="1">
						.
						<input type="text" name="cents" size="1">
						<confirm>Confirm</confirm>
					</a>
				</div>
				<div id="sixth" class="tab">
					<a>
						<lspan>Description</lspan>
						<textarea name='description' rows='10' cols='50' placeholder='Description here'></textarea>
						<button id='submit'>Create</button>
					</a>
				</div>
			</div>
		
	</body>
	
</html>
