<!DOCTYPE html>
<html>
	<head>
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/navbar.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/catagory.css' />
		<link type="text/css" rel="stylesheet" href='<?php echo base_url()?>assets/stylesheets/project.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/navigation.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/profile.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/projectTab.css' />
		
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-2.1.3.js"></script>
		<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
		<script type='text/javascript' src="<?php echo base_url() ?>assets/js/profileTab.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/backgroundColor.js"></script>
		<script type="text/javascript" src="<?php echo base_url() ?>assets/js/mainContainerFocus.js"></script>
	</head>
	
	<header>
		<!-- Include the header -->
		<?php $this->load->view('menubar'); ?>
	</header>
	
	<body>
		<div class="main-container">
			<div class='left-side'>
			<?php $name=$pTitle[0]->pname;

		if (substr($name, 0,1)<='K' and substr($name, 0,1)>='A')
			$num=1;
		else if (substr($name, 0,1)<='Z' and substr($name, 0,1)>='L')
			$num=2;
		else 
			$num=3;
		$url=base_url()."assets/images/p".$num.".jpg";?>


			
				<img  src='<?php echo $url;?>' alt="project">
				<div class='rating'>
					<!--
						- Added the logos to <a> tags so they can be linked to a function in the controller
						- Added the span tags to keep the styling from the CSS page
						- &#8962; is the code for a little house logo
					 -->
					<span><a href="<?php echo base_url();?>project/rate/<?php echo $pid;?>?rating=5" style="text-decoration:none; color:black">&#8962;</a></span>
					<span><a href="<?php echo base_url();?>project/rate/<?php echo $pid;?>?rating=4" style="text-decoration:none; color:black">&#8962;</a></span>
					<span><a href="<?php echo base_url();?>project/rate/<?php echo $pid;?>?rating=3" style="text-decoration:none; color:black">&#8962;</a></span>
					<span><a href="<?php echo base_url();?>project/rate/<?php echo $pid;?>?rating=2" style="text-decoration:none; color:black">&#8962;</a></span>
					<span><a href="<?php echo base_url();?>project/rate/<?php echo $pid;?>?rating=1" style="text-decoration:none; color:black">&#8962;</a></span>
					: Rate Project
				</div>
			</div>
			<div class='right-side' align="center">
				<a class='title'>
					<?php
							if (count($pTitle) > 0) {
								echo $pTitle[0]->pname;
							} else {
								echo "ERROR";
							}
						?></a></br>
				<a class='Initiator'> 
				
					Initiator:
					<?php
						echo $initiator;
					?></a>		</br>
				<?php
				
				if (!$isInitiator && $isFunder) {
					
					echo "<a class='title'>";
					
					echo "<form method='post' action='".base_url()."project/rateInitiator/".$initiatorUid."'>";
						echo "Rate Initiator:";
						echo "<button type='submit' name='like' value='1'>Like</button>";
						echo "<button type='submit' name='dislike' value='1'>Dislike</button>";
						echo "<input type='hidden' name='pid' value='".$pid."' />";
					echo "</form>";
					
					//echo "<br>";
					echo "</a>";
				}
				
				 ?>
				
				<a class='Initiator'> Initiator Score: 
					<?php
						echo round($initiatorRating, 2)." / 1";
					 ?>
				</a>
				
				<br>
				
				<a class='daystogo'>
					Days To Go:
					<?php
						if (count($daysToGo) > 0) {
							
							if (!$daysToGo[0]->diffDate < 0) {
								echo $daysToGo[0]->diffDate;
							} else {
								echo "Passed End Date";
							}
						} else {
							echo "ERROR";
						}
					?>
				</a></br>
				<a class='daystogo'>
					Current Project Rating: 
					<?php
						$rating = $prating[0]->total;
						
						if (count($prating) > 0) {
							echo round($rating, 2);
							echo " / 5";
						} else {
							echo "ERROR";
						}
					 ?>
				</a>
				<br>
				<a class='curFund'> Funds: 
					$
					<?php
						if (count($cashFunded) > 0) {
							echo $cashFunded[0]->total;
						} else {
							echo "ERROR";
						}
					?>
					/
					<?php
						if (count($cashNeeded) > 0) {
							echo $cashNeeded[0]->needed;
						} else {
							echo "ERROR";
						}
					?>
					
					</a></br>
				<form class='form' action='<?php echo base_url()?>project/fundProject/<?php echo $pid[0] ?>' method="post">
					<a class='fundBtn'>$$ 
					<input type='text' name='dollars'> . <input type='text' name="cents">
					<input type="submit" value="Fund!">
					</a>
				</form>
			</div>
		</div>
		
		<br>
		
		<div class='bottom-container'>
			<div class='tabs'>
				<ul class="tab-links">
					<li class="active"><a href="#description">Description</a></li>
					
					<!--
						- If the user is an initiator, they can rate funders to the project
						- The user cannot rate themself
					 -->
					<li class='rateFunder'><a href='#rateFunder'>Funders</a></li>
					
					<li><a href="#updates">Updates</a></li>
					<li><a href="#comments">Comments</a></li>
				</ul>
				<div class='tab-content'>
					<div id="description" class="tab active" align="center">
						<p>
							<?php 
								if (count($description) > 0) {
									echo $description[0]->description;
								} else {
									echo "ERROR";
								}
							
							?>
						</p>
					</div>
					
					<div id="rateFunder" class="tab" align="center">
						<table cellspacing="20">
							<th>Name</th>
							<th>Amount Funded</th>
							<th>Rating</th>
							<?php 
								if ($isInitiator) {
									echo "<th>Rate</th>";
								}
							 ?>
							 
							 <?php
								
								foreach ($funders as $row) {
									echo "<tr>";
									echo "<td>".$row->username."</td>";
									echo "<td>".$row->total."</td>";
									echo "<td>".round($row->fundRating, 2)." / 1</td>";
									
									// if the user is an initiator, provide buttons to rate funders
									if ($isInitiator && ($row->uid != $uid = $this->session->userdata('uid'))) {
										echo "<td>";
											echo "<form method='post' action='".base_url()."project/rateFunder/".$row->uid."'>";
												echo "<button type='submit' name='like' value='1'>Like</button>";
												echo "<button type='submit' name='dislike' value='1'>Dislike</button>";
												echo "<input type='hidden' name='pid' value='".$pid."' />";
											echo "</form>";
										echo "</td>";
									}
									echo "<tr>";
								}
							 
							  ?>
							 
						</table>
					</div>
					
					<div id="updates" class="tab" align="center">
						
						<?php echo validation_errors(); ?>
						
						<table cellspacing="20">
							<!-- Generate the updates made by Funders and/or Initiators -->
							<?php
								foreach ($updates as $row) {
									echo "<tr valign='top'>";
										echo "<td>".$row->username.":</td>";
										echo "<td>".$row->description;
										echo "<br>";
										echo "<p style='font-size: 10px'>".$row->date."</p></td>";
									echo "</tr>";
								}
							
							 ?>
						</table>
						
						<!-- Check if the current user can update the project -->
						<?php
							if ($canUpdate) {
								
								echo "<form method='post' action=\"".base_url()."project/update/".$pid."\">";
									echo "<textarea name='updateText' rows='3' cols='60'></textarea>";
									echo "<br>";
									echo "<button id='updateButton' type='submit'>Update</button>";
								echo "</form>";
							}
						 ?>
						
					</div>
					<div id="comments" class="tab" align="center">
						
						<?php echo validation_errors(); ?>
						
						<table cellspacing="20">
							<!-- Generate the comments made by any users about the project -->
							<?php
								foreach ($comments as $row) {
									echo "<tr valign='top'>";
										echo "<td>".$row->username.":</td>";
										echo "<td>".$row->description;
										echo "<br>";
										echo "<p style='font-size: 10px'>".$row->date."</p></td>";
									echo "</tr>";
								}
							
							 ?>
						</table>
						
						<form method='post' action="<?php echo base_url();?>project/comment/<?php echo $pid;?>">
							<textarea name='commentText' rows='3' cols='60'></textarea>
							<br>
							<button id='commentButton' type='submit'>Comment</button>
						</form>
						
					</div>
				</div>
			</div>
		</div>
		
	</body>
	

</html>
