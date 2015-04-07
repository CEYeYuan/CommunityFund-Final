<?php

class Discover_model extends CI_Model {
	
	public function createViews($data) {
		
		// get the $cid value from $data passed in
		$cid = $data['cid'];
		
		// create the query to create the first DB view
		// this uses the $cid variable passed in
		
		// OLD QUERY
		// find the projects in a category
		//$firstQuery = "CREATE VIEW tmpView AS (SELECT Pro.pid AS pid, Pro.pname AS pname, Pro.description AS description, Procat.cid AS cid, Pro.pic AS pic FROM Project Pro JOIN ProjCat Procat ON Pro.pid = Procat.pid WHERE Pro.active=1 AND Procat.cid=" . $cid . ");";
		$firstQuery = "CREATE VIEW tmpView AS (SELECT pid, pname, description, pic, fundsNeeded,category AS cid FROM Project WHERE active=1 AND category=".$cid.");";
		
		// create view tmpView
		$query = $this->db->query($firstQuery);
		
		// create view projectsInCid
		$query = $this->db->query("CREATE VIEW projectsInCid AS (SELECT tmp.pid AS pid, tmp.pname AS pname, tmp.fundsNeeded as fundsNeeded, tmp.description AS description, tmp.pic AS pic, tmp.cid AS cid, cat.name AS cname FROM tmpView tmp JOIN Category cat ON tmp.cid=cat.cid WHERE cat.active=1);");
		
		// creatve view mostPopularInCid
		//change from theta join to  left join
		$query = $this->db->query("CREATE VIEW mostPopularInCid AS (SELECT Pro.pid AS pid, Pro.pname AS pname,fundsNeeded,Pro.description AS description, Pro.pic AS pic, Pro.cname AS cname, AVG(RP.rating) AS netAvg FROM projectsInCid Pro LEFT JOIN RateProj RP ON Pro.pid=RP.pid GROUP BY Pro.pid LIMIT 3);");
	
		$query=$this->db->query("CREATE VIEW currentF as (select pid, sum(amount) as currentFund from Fund group by pid) union (select pid,0 as currentFund from Project where pid not in (select pid from Fund) )");
		$query=$this->db->query("CREATE VIEW everything as select * from mostPopularInCid natural join currentF");
	}
	
	public function removeTempViews() {
		$tmpQuery = $this->db->query("DROP VIEW if exists mostPopularInCid;");
		$tmpQuery = $this->db->query("DROP VIEW if exists projectsInCid;");
		$tmpQuery = $this->db->query("DROP VIEW if exists tmpView;");
		$tmpQuery = $this->db->query("DROP VIEW if exists currentF;");
		$tmpQuery = $this->db->query("DROP VIEW if exists everything;");
	}
	
	public function getCommunity($data) {
		
		// get the $cid value from $data passed in
		$cid = $data['cid'];
		
		// run the query
		$comQuery = $this->db->query("SELECT name FROM Category WHERE cid=" . $cid . ";");
		
		return $comQuery->result();
	}
	
	public function getAll($data) {
		// db is already auto-loaded
		$this->removeTempViews();
		// create the necessary views
		$this->createViews($data);
		
		// run our query
		$query = $this->db->query("SELECT * FROM everything;");
		
		// delete temp views/clean up
		$this->removeTempViews();
		
		// return the result of our query
		return $query->result();
		
	}
	
	
}