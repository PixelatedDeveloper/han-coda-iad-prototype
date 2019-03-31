<?php

class publiekeagenda {
	public function __construct() {
		
	}
	
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM publiekeagenda WHERE id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		return db::fetch($res);
	}
	
	public function getByGoedDoel($id) {
		$sql = sprintf('SELECT * FROM publiekeagenda WHERE goeddoel_id = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getByOrganisatie($id) {
		$sql = sprintf('SELECT * FROM publiekeagenda WHERE stichting_id = %d AND datum_eind >= CURDATE() ORDER BY datum_begin', db::escape($id));
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
	
	public function getAll() {
		$sql = sprintf('SELECT * FROM publiekeagenda WHERE datum_eind >= CURDATE() ORDER BY datum_begin');
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
	
	public function set($goeddoel_id = null, $stichting_id = null, $naam, $beschrijving, $locatie, $entree, $foto, $datum_begin, $datum_eind, $tijd_begin, $tijd_eind, $heledag) {
		$organisator = ($goeddoel_id) ? 'goeddoel_id' : 'stichting_id';
		$organisator_id = ($goeddoel_id) ? $goeddoel_id : $stichting_id;
		$sql = sprintf('INSERT INTO publiekeagenda (%s, naam, beschrijving, locatie, entree, foto, datum_begin, datum_eind, tijd_begin, tijd_eind, heledag) 
			VALUES (%d, "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", %d)',
			$organisator, $organisator_id,
			db::escape($naam), db::escape($beschrijving), db::escape($locatie), db::escape($entree), db::escape($foto), 
			db::escape($datum_begin), db::escape($datum_eind), db::escape($tijd_begin), db::escape($tijd_begin), db::escape($heledag)
		);
		//echo $sql;
		return db::query($sql);
	}
}

?>