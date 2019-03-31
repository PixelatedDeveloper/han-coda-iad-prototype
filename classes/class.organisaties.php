<?php

class organisaties {
	public function __construct() {
		
	}
	
	public static function getAll() {
		$sql = sprintf('SELECT * FROM organisaties ORDER BY naam');
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function getAllByCategory($category) {
		$sql = sprintf('SELECT * FROM organisaties WHERE categorie = %d ORDER BY naam', db::escape($category));
		$res = db::query($sql);
		return db::fetchAll($res);
	}
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM organisaties WHERE id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		return db::fetch($res);
	}
	
	public function getByBeheerder($id) {
		$sql = sprintf('SELECT * FROM organisaties WHERE beheerder_id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		return db::fetch($res);
	}
	
	public function set($beheerder, $naam, $beschrijving, $cbf, $bank, $straat, $huisnummer, $postcode, $plaats, $telefoon, $email, $website, $twitter, $facebook, $logo) {
		$sql = sprintf('INSERT INTO organisaties (beheerder_id, naam, beschrijving, cbf, cbf_verified, bank_giro, naw_straat, naw_huisnummer, naw_postcode, naw_plaats, telefoon, emailadres, url_homepage, url_twitter, url_facebook, logo) VALUES (
			%d, "%s", "%s", %d, 0, "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s", "%s"
		)',
			db::escape($beheerder),
			db::escape($naam),
			db::escape($beschrijving),
			db::escape($cbf),
			db::escape($bank),
			db::escape($straat),
			db::escape($huisnummer),
			db::escape($postcode),
			db::escape($plaats),
			db::escape($telefoon),
			db::escape($email),
			db::escape($website),
			db::escape($twitter),
			db::escape($facebook),
			db::escape($logo)
		);
		
		return db::query($sql);
	}
	
		public function search($q) {
		$sql = sprintf('SELECT id, naam FROM organisaties WHERE naam LIKE "%1$s"', '%'.db::escape($q).'%');
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
}

?>