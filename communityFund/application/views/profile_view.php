<!DOCTYPE html>
<html>
	<head>
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/navbar.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/profile.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/navigation.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/projectShort.css' type='text/css' />
		<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/progressBar.css' type='text/css' />

		<script type="text/javascript">
    		var BASE_URL = "<?php echo base_url(); ?>";
		</script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/profileTab.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/profileEdit.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/backgroundColor.js"></script>
	</head>

	<header>
		<!-- Include the header -->
		<?php $this->load->view('menubar'); ?>
	</header>
	<body>
	

<div class="profile">
	<h1><?php echo $firstname."'s" ;?> Profile</h1>

	<form method="post" accept-charset="utf-8" action="<?php echo base_url();?>profile/profile_update_validition" >
	<div class='left-side'>
		<?php 
		if (substr($firstname, 0,1)<='K' and substr($firstname, 0,1)>='A')
			$num=1;
		else if (substr($firstname, 0,1)<='Z' and substr($firstname, 0,1)>='L')
			$num=2;
		else 
			$num=3;
		$url=base_url()."assets/images/u".$num.".jpg";?>
		<img src="<?php echo $url;?>" alt="display picture" height="200" width="200">
		
		<edit>Edit</edit>
		<!--<input type="submit" value="done" />-->
		<button id='done' type="submit">Done</button>

	</div>
	<div class='right-side'>
		<ul class="user">

			<a>My Communities:</a></br>
			<a>
				<?php 
				if ($communities->num_rows()===0){
					echo "You haven't joined any community yet!";
				}else{
					foreach($communities->result() as $row){
					echo $row->name."   ";}
				}
				echo "<br/>";
		?>
			</a>
			<a class='username'>Username: <?php echo $username ;?></a>
			
			<?php 
				//echo form_open('index.php/main/profile_update_validition');
				echo validation_errors();
				//echo "<p>Upload your profile picture: ";
				//echo form_upload('file'); 
			?>
			<li>First name: <a class='fn'><?php echo $firstname ;?></a></li>
			<li>Last name: <a class='ln'><?php echo  $lastname ;?></a></li>
			<li>Date of Birth: <a class='dob'>

				<!--<select disabled name="month"><option value=<?php echo $mm ?>><?php echo $mm ?></option></select>
				<select disabled name="day"><option value=<?php echo $dd ?>><?php echo $dd ?></option></select>
				<select disabled name="year"><option value=<?php echo $yy ?>><?php echo $yy ?></option></select>-->
			
				<?php

				$range = range(1900,2015);

	echo '<select disabled name="year" >';
	//Now we use a foreach loop and build the option tags
	foreach($range as $r)
	{
	if ($r==$yy)
		echo '<option value="'.$r.'"selected="selected">'.$r.'</option>';else
	echo '<option value="'.$r.'">'.$r.'</option>';

	}	
	//Echo the closing select tag
	echo '</select>';
	echo "y";


	$range = range(1,12);

	echo '<select  disabled name="month">';
	//Now we use a foreach loop and build the option tags
	foreach($range as $r)
	{
	if ($r==$mm)
		echo '<option value="'.$r.'"selected="selected">'.$r.'</option>';else
	echo '<option value="'.$r.'">'.$r.'</option>';
	}	
	//Echo the closing select tag
	echo '</select>';
	echo "m";

	$range = range(1,31);

	echo '<select disabled name="day" >';
	//Now we use a foreach loop and build the option tags
	foreach($range as $r)
	{
	if ($r==$dd)
		echo '<option value="'.$r.'"selected="selected">'.$r.'</option>';else
	echo '<option value="'.$r.'">'.$r.'</option>';
	}	
	//Echo the closing select tag
	echo '</select>';
	echo "d";


				?>

			</a></li>
			</form>
		
		</ul>
	</div>
</div>
<div class='tabs'>
	<ul class="tab-links">
		<li class="active"><a href="#funder">Projects Funded</a></li>
		<li><a href="#initator">Projects Initiated</a></li>
	</ul>
	<div class='tab-content'>
		<div id="funder" class="tab active">
			<div class='projectContent'>
				<?php 
					$i=0;
					while ($i<$fund->num_rows()){
						$pid=$fund->row($i)->pid;
						//echo $pid;
						$url=base_url()."project/index/$pid";
					$desc=$this->db->query("select description from Project where pid='$pid'")->row(1)->description;
						$fundsNeeded=$this->db->query("select fundsNeeded from Project where pid='$pid'")->row(1)->fundsNeeded;
						$currentFund=$this->db->query("select sum(amount) as amount from Fund where pid='$pid'")->row(1)->amount;
						if ($currentFund==null)
							$currentFund=0;
						$data = array(	'title' => $fund->row($i)->pname,
											'url' => $url,
											'src' => '',
											'desc' => $desc,
											'fundsNeeded'=>$fundsNeeded,
											'currentFund'=>$currentFund);
						$this->load->view('projectPreview_view.php', $data);
						$i++;
					}

				?>
			</div>
		</div>
		<div id="initator" class="tab">
			<div class='projectContent'>
				<?php 
					$i=0;
					while ($i<$init->num_rows()){
						$pid=$init->row($i)->pid;
						//echo $pid;
						$url=base_url()."project/index/$pid";
						//$str="<h3> <a href='$url'>".$init->row($i)->pname."</a>";
						//echo $str;
						$desc=$this->db->query("select description from Project where pid='$pid'")->row(1)->description;
						$fundsNeeded=$this->db->query("select fundsNeeded from Project where pid='$pid'")->row(1)->fundsNeeded;
						$currentFund=$this->db->query("select sum(amount) as amount from Fund where pid='$pid'")->row(1)->amount;
						if ($currentFund==null)
							$currentFund=0;
						$data = array(	'title' => $init->row($i)->pname,
											'url' => $url,
											'src' => '',
											'desc' => $desc,
											'fundsNeeded'=>$fundsNeeded,
											'currentFund'=>$currentFund);
						$this->load->view('projectPreview_view.php', $data);
						$i++;
					}
				
				?>
			</div>
		</div>
	</div>
	</body>
</html>
