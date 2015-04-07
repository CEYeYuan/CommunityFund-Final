<?php

class Project_model extends CI_Model {
	
	public function getTitle($data) {
		
		// get the $pid value from $data
		$pid = $data['pid'];
		
		// run the query
		$titleQuery = $this->db->query("SELECT pname FROM Project WHERE pid=" . $pid . ";");
		
		return $titleQuery->result();
		
	}
	
	public function getDescription($data) {
		// get the $pid value from $data
		$pid = $data['pid'];
		
		// run the query
		$descriptionQuery = $this->db->query("SELECT description FROM Project WHERE pid=" . $pid . ";");
		
		return $descriptionQuery->result();
	}
	
	public function getNumFunders($data) {
		
		// get the $pid value from $data
		$pid = $data['pid'];
		
		// run the query
		// find the number of funders for a pid
		//$numFunders = $this->db->query("SELECT DISTINCT COUNT(fid) AS total FROM Fund WHERE pid=" . $pid . ";");
		$queryString = "SELECT DISTINCT COUNT(uid) AS total FROM Fund WHERE pid=1;";
		
		$numFunders = $this->db->query($queryString);
		
		return $numFunders->result();
	}
	
	public function getDaysToGo($data) {
		$pid = $data['pid'];
		
		/*
		 * Example query result for the next query
		 * 
		 * +----------+
		   | diffDate |
		   +----------+
		   |      106 |
		   +----------+
		 * 
		 * */
		
		$daysToGo = $this->db->query("SELECT DATEDIFF((SELECT endDate FROM Project WHERE pid=" . $pid . "), now()) AS diffDate;");
		
		return $daysToGo->result();
	}
	
	public function getProjectRating($data) {
		
		$pid = $data['pid'];
		
		$prating = $this->db->query("SELECT IFNULL(AVG(rating),0) AS total FROM RateProj WHERE pid=" . $pid . ";");
		
		return $prating->result();
		
	}
	
	public function getCashSoFar($data) {
		$pid = $data['pid'];
		
		$cashFunded = $this->db->query("SELECT IFNULL(SUM(amount),0) AS total FROM Fund WHERE pid=" . $pid . ";");
		
		return $cashFunded->result();
	}
	
	public function getCashNeeded($data) {
		$pid = $data['pid'];
		
		$cashNeeded = $this->db->query("SELECT IFNULL(fundsNeeded, 0) AS needed FROM Project WHERE pid=" . $pid . ";");
		
		return $cashNeeded->result();
		
	}
	
	// takes in a uid parameter and returns the fid
	public function getFid($UID) {
		$uid = $UID;
		
		$query = $this->db->query("SELECT fid FROM Funder WHERE active=1 AND uid='" . $uid . "';");
		$row = $query->row();
		$fid = $row->fid;
		
		// this is a variable, not an array
		return $fid;
	}

	public function getInitiator($data) {
		$pid = $data['pid'];
		
		$query = $this->db->query("SELECT username from User join Project on initiator=uid where pid='$pid'");
		
		$row = $query->row();
		$username = $row->username;
		
		// this is a variable, not an array
		return $username;
	}
	
	public function getInitiatorUid($data) {
		$pid = $data['pid'];
		
		$query = $this->db->query("SELECT uid from User join Project on initiator=uid where pid='$pid'");
		
		$row = $query->row();
		$uid = $row->uid;
		
		// this is a variable, not an array
		return $uid;
	}
	
	public function isFunder($data) {
		$pid = $data['pid'];
		$uid = $this->session->userdata('uid');
		
		$queryString = "SELECT uid, pid, date, amount, active FROM Fund WHERE pid=".$pid." AND uid=".$uid.";";
		
		$query = $this->db->query($queryString);
		
		// user is a funder of the project
		if ($query->num_rows() >= 1) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function isInitiator($data) {
		$pid = $data['pid'];
		$uid = $this->session->userdata('uid');
		
		$queryString = "SELECT * FROM Project WHERE pid=".$pid." AND initiator=".$uid.";";
		
		$query = $this->db->query($queryString);
		
		// user is the initiator of the project
		if ($query->num_rows() >= 1) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getInitiatorRating($dataIn) {
		$pid = $dataIn['pid'];
		
		$queryString = "SELECT IFNULL(AVG(rating), -1) AS rating FROM RateI;";
		
		$query = $this->db->query($queryString);
		
		if ($query->num_rows() > 0) {
			$row = $query->row();
			$rating = $row->rating;
			
			// this is a variable, not an array
			return $rating;
		} else {
			return -1;
		}
		
	}
	
	public function getFunders($data) {
		$pid = $data['pid'];
		$uid = $this->session->userdata('uid');
		
		$view1String = "CREATE VIEW tmpView1 AS (SELECT FD.uid, FD.pid, US.username, FD.date, SUM(FD.amount) AS total FROM Fund FD JOIN User US ON FD.uid=US.uid WHERE FD.pid=".$pid." AND FD.active=1 AND US.active=1 GROUP BY uid);";
		
		$view2String = "CREATE VIEW tmpView2 AS (SELECT rated, AVG(rating) as fundRating FROM RateF GROUP BY rated);";
		
		$viewQuery1 = $this->db->query($view1String);
		
		$viewQuery2 = $this->db->query($view2String);
		
		$queryString = "SELECT TP1.uid, TP1.pid, TP1.username, TP1.date, TP1.total, TP2.rated, IFNULL(TP2.fundRating, -1) AS fundRating FROM tmpView1 TP1 LEFT JOIN tmpView2 TP2 ON TP1.uid=TP2.rated;";
		
		$query = $this->db->query($queryString);
		
		$dropString = "DROP VIEW tmpView1;";
		
		$dropQuery = $this->db->query($dropString);
		
		$dropString = "DROP VIEW tmpView2;";
		
		$dropQuery = $this->db->query($dropString);
		
		return $query->result();
	}
	
	public function makeDonation($data) {
		
		// get the uid from the session
		$uid = $this->session->userdata('uid');
		
		$pid = $data['pid'];
		$username = $data['username'];
		
		// get the donation info
		$dollars = $data['dollars'];
		$cents = $data['cents'];
		$amount = $dollars.".".$cents;
		
		// make the donation
		$queryString = "INSERT INTO Fund (uid, pid, date, amount, active) VALUES (".$uid.", ".$pid.", now(), '".$amount."', 1);";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	public function rateProject($dataIn) {
		
		//$data['pid'] = $PID;
		//$data['rating'] = $rating;
		
		$uid = $this->session->userdata('uid');
		$pid = $dataIn['pid'];
		$rating = $dataIn['rating']; // either one of [1, 2, 3, 4, 5]
		
		$queryString = "INSERT INTO RateProj (uid, pid, date, rating) VALUES (".$uid.", ".$pid.", now(), ".$rating.");";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function updateProj($dataIn) {
		
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$description = $dataIn['description'];
		
		$queryString = "INSERT INTO UpdateProj (uid, pid, date, description, active) VALUES (".$uid.", ".$pid.", now(), '".$description."', 1);";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function commentProj($dataIn) {
		
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$description = $dataIn['description'];
		
		$queryString = "INSERT INTO Comment (uid, pid, date, description, active) VALUES (".$uid.", ".$pid.", now(), '".$description."', 1);";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	public function getUpdates($dataIn) {
		$pid = $dataIn['pid'];
		
		$queryString = "SELECT UPR.uid, UPR.date, UPR.description, US.username FROM UpdateProj UPR JOIN User US ON UPR.uid=US.uid WHERE UPR.pid=".$pid." AND UPR.active=1 AND US.active=1;";
		
		$query = $this->db->query($queryString);
		
		return $query->result();
	}
	
	public function canUpdate($dataIn) {
		
		$uid = $this->session->userdata('uid');
		$pid = $dataIn['pid'];
		
		$queryString = "SELECT FD.uid, FD.pid, PR.initiator FROM Fund FD JOIN Project PR ON FD.pid=PR.pid WHERE FD.active=1 AND PR.active=1 AND (FD.uid=".$uid." OR PR.initiator=".$uid.");";
		
		$query = $this->db->query($queryString);
		
		if ($query->num_rows() >= 1) {
			// user can update
			return true;
		} else {
			// user cannot update
			return false;
		}
	}
	
	public function getComments($dataIn) {
		
		$uid = $this->session->userdata('uid');
		$pid = $dataIn['pid'];
		
		$queryString = "SELECT US.username, CM.description, CM.date FROM User US JOIN Comment CM ON US.uid=CM.uid WHERE CM.pid=".$pid." AND CM.active=1 AND US.active=1;";
		
		$query = $this->db->query($queryString);
		
		return $query->result();
	}
	 
	public function rateLikeFunder($dataIn) {
		$curUid = $this->session->userdata('uid');
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$rating = $dataIn['like'];
		
		$queryString = "INSERT INTO RateF (pid, rater, rated, rating, date) VALUES (".$pid.", ".$curUid.", ".$uid.", 1, now());";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
	public function rateDislikeFunder($dataIn) {
		
		$curUid = $this->session->userdata('uid');
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$rating = $dataIn['dislike'];
		
		$queryString = "INSERT INTO RateF (pid, rater, rated, rating, date) VALUES (".$pid.", ".$curUid.", ".$uid.", 0, now());";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function rateLikeInitiator($dataIn) {
		
		$curUid = $this->session->userdata('uid');
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$rating = $dataIn['dislike'];
		
		$queryString = "INSERT INTO RateI (pid, rater, rated, rating, date) VALUES (".$pid.", ".$curUid.", ".$uid.", 1, now());";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
		
	}
	
	public function rateDislikeInitiator($dataIn) {
		$curUid = $this->session->userdata('uid');
		$uid = $dataIn['uid'];
		$pid = $dataIn['pid'];
		$rating = $dataIn['dislike'];
		
		$queryString = "INSERT INTO RateI (pid, rater, rated, rating, date) VALUES (".$pid.", ".$curUid.", ".$uid.", 0, now());";
		
		$query = $this->db->query($queryString);
		
		if ($query) {
			return true;
		} else {
			return false;
		}
	}
	
}