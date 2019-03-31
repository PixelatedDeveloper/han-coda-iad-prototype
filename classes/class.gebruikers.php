<?php

class gebruikers {
	public function __construct() {
		
	}
	
	public function signup($email, $password) {
		$sql = sprintf('INSERT INTO gebruikers (emailadres, wachtwoord) VALUES ("%s", "%s")',
			db::escape($email), hash('sha512', $password)
		);
		db::query($sql);
		return db::lastId();
	}
	
	public function login($email, $password, $name = null) {
		$result = ($name) ? 'emailadres' : 'id';
		$sql = sprintf('SELECT %s FROM gebruikers WHERE emailadres = "%s" AND wachtwoord = "%s" LIMIT 1', 
			$result, db::escape($email), hash('sha512', $password)
		);
		$res = db::query($sql);
		return ($user_id = @db::result($res)) ? $user_id : 0;
	}
	
	public function addGebruikerData($id, $is_organisatie, $aanhef, $voornaam, $achternaam, $rekeningnummer = null) {
		$sql = sprintf('UPDATE gebruikers SET is_organisatie = %d, form_aanhef = "%s", form_voornaam = "%s", form_achternaam = "%s", form_rekeningnummer = "%s" WHERE id = %d LIMIT 1',
			db::escape($is_organisatie), db::escape($aanhef), db::escape($voornaam),
			db::escape($achternaam), db::escape($rekeningnummer), db::escape($id)
		);
		return db::query($sql);
	}
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM gebruikers WHERE id = %d LIMIT 1', db::escape($id));
		$res = db::query($sql);
		$temp = array();
		$temp['gebruiker'] = db::fetch($res);
		if ($temp['gebruiker']['is_organisatie']) {
			$temp['organisatie'] = @organisaties::getByBeheerder($id);
		}
		return $temp;
	}
}

?>