<?php

class goededoelen {
	public function __construct() {
		
	}
	
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM goededoelen WHERE id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		return db::fetch($res);
	}
	
	public function getByOrganisatie($id) {
		$sql = sprintf('SELECT * FROM goededoelen WHERE organisatie_id = %d', db::escape($id));
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
	
	public function getByCategorie($id) {
		$sql = sprintf('SELECT * FROM goededoelen WHERE categorie = %d', db::escape($id));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getGoedeDoelen() {
		$sql = sprintf('
			SELECT g.id, g.naam, g.beschrijving, g.logo, g.url_homepage as goededoel, g.categorie, o.naam as organisatie 
	 		FROM goededoelen as g 
	 		INNER JOIN organisaties as o on g.organisatie_id = o.id 
		');
		$res = db::query($sql);
		
		$temp['goededoelen'] = db::fetchAll($res);
		$temp['organisaties'] = organisaties::getAll();
		return $temp;
	}
	
	public function set($organisatie_id, $naam, $beschrijving, $logo, $url_homepage) {
		$sql = sprintf('INSERT INTO goededoelen (organisatie_id, naam, beschrijving, logo, url_homepage) VALUES (
			%d, "%s", "%s", "%s", "%s"
		)',
			db::escape($organisatie_id),
			db::escape($naam),
			db::escape($beschrijving),
			db::escape($logo),
			db::escape($url_homepage)
		);
		
		return db::query($sql);
	}
	
	public function search($q) {
		$sql = sprintf('SELECT id, naam FROM goededoelen WHERE naam LIKE "%1$s"', '%'.db::escape($q).'%');
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
}

?>