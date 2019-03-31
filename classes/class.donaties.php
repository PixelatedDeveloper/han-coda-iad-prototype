<?php

class donaties {
	public function __construct() {
		
	}
	
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM donaties WHERE id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		return db::fetch($res);
	}
	
	public function getByGoedDoel($id) {
		$sql = sprintf('SELECT * FROM donaties WHERE goeddoel_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getByOrganisatie($id) {
		$sql = sprintf('SELECT * FROM donaties WHERE stichting_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getByGebruiker($id) {
		$sql = sprintf('SELECT * FROM donaties WHERE gebruiker_id = %d ORDER BY datum DESC', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getAllByOrganisatie($id) {
		$sql = sprintf('SELECT DISTINCT d.* FROM donaties d LEFT JOIN goededoelen g ON d.goeddoel_id = g.id WHERE d.stichting_id = %1$d OR g.organisatie_id = %1$d ORDER BY d.datum', db::escape($id));
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}

	public function set($goeddoel_id, $stichting_id, $gebruiker_id, $bedrag, $opmerking) {
		$sql = sprintf('INSERT INTO donaties (goeddoel_id, stichting_id, gebruiker_id, duur, bedrag, opmerking, datum) 
			VALUES (%d, %d, %d, 0, %f, "%s", NOW())',
			db::escape($goeddoel_id),
			db::escape($stichting_id),
			db::escape($gebruiker_id),
			db::escape($bedrag),
			db::escape($opmerking)
		);
		return db::query($sql);
	}
}

?>