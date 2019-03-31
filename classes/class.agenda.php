<?php

class agenda {
	
	public $statuses = array(
		1 => 'Ik ga',
		2 => 'Ik ga misschien',
		3 => 'Ik ga niet'
	);

	public function __construct() {
		
	}
	
	public function get($id) {
		$sql = sprintf('SELECT * FROM agendas WHERE gebruiker_id = %d', db::escape($id));
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
	
	public function getFull($id) {
		$sql = sprintf('SELECT a.gebruiker_id, a.status, b.* FROM agendas a LEFT JOIN publiekeagenda b ON a.agenda_id = b.id WHERE a.gebruiker_id = %d', db::escape($id));
		$res = db::query($sql);
		return (db::count($res)) ? db::fetchAll($res) : 0;
	}
	
	public function set($user_id, $agenda_id) {
		$sql = sprintf('INSERT INTO agendas (gebruiker_id, agenda_id, status) VALUES (%d, %d, 1)',
			db::escape($user_id),
			db::escape($agenda_id)
		);
		
		return db::query($sql);
	}
	
	public function delete($user_id, $agenda_id) {
		$sql = sprintf('DELETE FROM agendas WHERE gebruiker_id = %d AND agenda_id = %d LIMIT 1',
			db::escape($user_id),
			db::escape($agenda_id)
		);
		
		return db::query($sql);
	}
}

?>