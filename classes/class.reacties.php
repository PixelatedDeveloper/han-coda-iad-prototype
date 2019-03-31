<?php

class reacties {

	public function __construct() {
		
	}
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM reacties WHERE gebruiker_id = %d', db::escape($id));
		$res = db::query($sql);
		return ($data = @db::fetchAll($res)) ? $data : 0;
	}
	
	public function getByGoedDoel($id) {
		$sql = sprintf('SELECT * FROM reacties WHERE doel_goeddoel_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getByOrganisatie($id) {
		$sql = sprintf('SELECT * FROM reacties WHERE doel_stichting_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getByAgenda($id) {
		$sql = sprintf('SELECT * FROM reacties WHERE doel_agenda_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}

}

?>