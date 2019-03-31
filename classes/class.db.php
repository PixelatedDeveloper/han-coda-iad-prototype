<?php

class db {
	
	/* Predefined variables*/
	/*private $host = array(
		"host" => "localhost",
		"user" => "root",
		"pass" => "",
		"db" => "goededoelenportal"
	);*/
	
	private $host = array(
		"host" => "mysql.dd",
		"user" => "d10111_gdportal",
		"pass" => "gdp0rt4l",
		"db" => "d10111_gdportal"
	);
	
	protected $link;
	//public $querycount = 0;
	
	/* Methods */
	public function __construct() {
		$this->link = @mysql_connect($this->host["host"], $this->host["user"], $this->host["pass"])
			or die('Kan geen verbinding maken met de database server.<br /><pre>'.mysql_error().'</pre>');
		mysql_select_db($this->host["db"]);
	}
	
	public function __destruct() {
		mysql_close();
	}
	
	public static function escape($var) {
		return mysql_real_escape_string($var);
	}
	
	public static function query($query) {
		//$this->querycount++;
		return mysql_query($query);
	}
	
	public static function result($resource, $index = 0) {
		return mysql_result($resource, $index);
	}
	
	public static function lastId() {
		return mysql_insert_id();
	}
	
	public static function count($resource) {
		return ($return = mysql_num_rows($resource)) ? $return : 0;
	}
	
	public static function fetch($resource) {
		return mysql_fetch_assoc($resource);
	}
	
	public static function fetchAll($resource, $index=NULL) {
		while ($row = mysql_fetch_assoc($resource)) {
			if ($index) {
				$data[$row[$index]] = $row;
			} else {
				$data[] = $row;
			}
		}
		return $data;
	}
}

?>