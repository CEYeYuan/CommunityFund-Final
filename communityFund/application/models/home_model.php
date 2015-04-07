<?php

class home_model extends CI_Model {
	
	public function createViews() {
		// create the query to create the first DB view
		// this uses the $cid variable passed in
		
		// OLD QUERY
		// find the projects in a category
		//$firstQuery = "CREATE VIEW tmpView AS (SELECT Pro.pid AS pid, Pro.pname AS pname, Pro.description AS description, Procat.cid AS cid, Pro.pic AS pic FROM Project Pro JOIN ProjCat Procat ON Pro.pid = Procat.pid WHERE Pro.active=1 AND Procat.cid=" . $cid . ");";
		$firstQuery = "CREATE VIEW projects AS (SELECT pid, pname, description, pic, category AS cid, fundsNeeded FROM Project);";
		
		// create view tmpView
		$query = $this->db->query($firstQuery);
	}
	
	public function removeTempViews() {
		$tmpQuery = $this->db->query("DROP VIEW projects;");
	}
		
	public function getAll() {
		// db is already auto-loaded
		
		// create the necessary views
		$this->createViews();
		
		// run our query
		$query = $this->db->query("SELECT * FROM projects;");
		
		// delete temp views/clean up
		$this->removeTempViews();
		
		// return the result of our query
		return $query->result();
		
	}
	
	
}