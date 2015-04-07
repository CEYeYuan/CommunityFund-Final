<!-- The "navigation" section is the header -->

<!--
	PREREQS:
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/navbar.css' />
		<link type='text/css' rel='stylesheet' href='<?php echo base_url()?>assets/stylesheets/catagory.css' />
		<script type="text/javascript" src="assets/js/jquery-2.1.3.js"></script>
		
	**NOTE: These prereqs must be in the <head> element for the header
	to display properly
 -->

<div id="navigation">
	<ul class="links">
		<li>
			<a href=<?php echo base_url() . "home"; ?>>Community Fund</a>
		</li>
		<li class="active">
			<a href=<?php echo base_url() . "welcome"; ?>>Discover</a>
		</li>
		<li>
			<a href=<?php echo base_url() . "projectCreate"; ?>>Create</a>
		</li>
	</ul>
	<a class="rightside" id="farRight" href='<?php echo base_url() . 
		"main/logout"; ?>'>Logout</a>
	<a class="rightside" href='<?php echo base_url() . 
		"profile"; ?>' >Profile</a>
	<a class="rightside" href='<?php echo base_url() . 
		"friends"; ?>' >Friends 
				
		<!--if a user has unread msg, a logo will be displayed next to the "Friends" anchor-->

		<?php 
			$me=$this->session->userdata('uid');
			//$now=date("Y-m-d H:i:s");
			$sql="select * from Chathistory where receiver='$me' and  ifread='-1'";
			$result=$this->db->query($sql);
			if ($result->num_rows()>0)
			echo "&#8864";
		
		?> </a>

	<!-- Admin console code -->
	<?php 
		// add the link to the admin console only if user is admin
		
		// NOTE: To test this, log in as admin@admin.com
		if ($this->session->userdata('admin')) {
			echo "<a class='rightside' href='";
			echo "" . base_url() . "adminConsole";
			echo "'>Admin Console</a>";
		}
	?>
</div>
