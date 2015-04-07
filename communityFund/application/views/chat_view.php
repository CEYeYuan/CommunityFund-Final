<!DOCTYPE html>
<html>
<head>
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/navbar.css' type='text/css' />
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/homeBackground.css' type='text/css' />
	<link rel='stylesheet' href='<?php echo base_url(); ?>assets/stylesheets/chatView.css' type='text/css' />
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.3.js"></script>
	<script type="text/javascript">
    	var BASE_URL = '<?php echo base_url(); ?>';
    	var WHOM = '<?php echo $withWhomuid; ?>';
    	var name = '<?php echo $withWhomfn->row()->firstName; ?>';
	</script>
	<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js" ></script>
	<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/backgroundColor.js'></script>
	<script type="text/javascript" src='<?php echo base_url(); ?>assets/js/updateChat.js'></script>
	
	<title>Chat With <?php echo $withWhomfn->row()->firstName; ?></title>
</head>
<header>
	<?php $this->load->view('menubar'); ?>
</header>
<body>
	<div class='main-container'>
	<h3>Chat With <?php echo $withWhomfn->row()->firstName; ?></h3>
	<h4>
		<?php echo $withWhomfn->row()->firstName."'s Rating as funder: ";
		$result=$this->db->query("select avg(rating) as avrrat from RateF where rated='$withWhomuid'");
		if ($result->row(0)->avrrat==null)
			echo "N/A";
		else
			echo $result->row(0)->avrrat;

		echo "</br>";

		echo $withWhomfn->row()->firstName."'s Rating as Initiator: ";
		$result=$this->db->query("select avg(rating) as avrrate from RateI where rated='$withWhomuid'");
		if ($result->row(0)->avrrate==null)
			echo "N/A";
		else
			echo $result->row(0)->avrrate;

			?>
	</h4>
	<h4>
		
	</h4>
	<div class='chat'>
	<?php 
		if ($history->num_rows()==0){
			$str="<p>You never talk to ".$withWhomfn->row()->firstName.", send a message now!</p>";
			echo $str;
		}else{
			foreach($history->result() as $row){
				$time=substr($row->time, 11,5);
				if ($row->sender==$withWhomuid){
					echo "<span class='left'>$time ".$withWhomfn->row()->firstName.": </span>";
					echo "<span class='right' style='font-family:Arial'>".$row->msg."</span>";
					echo "<br/>";
				}else{
					echo "<span class='left'>".$time." Me: </span>";
					echo "<span  class='right' style='font-family:Arial'>".$row->msg."</span>";
					echo "<br/>";
				}

			}
			
		}
	?>
	</div>
	<textarea name='msg' rows="4" cols='50' > </textarea>	
	<br/>
	<input id='submit' type='submit' value='send'/>
	<div>

</body>
</html>