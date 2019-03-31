<?php
session_start();

foreach (glob('classes/class.*.php') as $class) {
	include($class);
}

$db = new db; // Initiate database
$organisaties = new organisaties;
$gebruikers = new gebruikers;
$goededoelen = new goededoelen;
$donaties = new donaties;
$publiekeagenda = new publiekeagenda;
$agenda = new agenda;
$reacties = new reacties;


// User session
$user_id = 0;
if (isset($_SESSION['gdp_uid']) && $_SESSION['gdp_uid'] > 0) {
	$user_id = $_SESSION['gdp_uid'];
	$user = $gebruikers->get($user_id);
}

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 0;

switch ($action) {

	case "doneren":
		if ($_REQUEST['type'] == 'organisatie') {
			$goeddoel_id = 0;
			$stichting_id = $_REQUEST['id'];
		} else {
			$goeddoel_id = $_REQUEST['id'];
			$stichting_id = 0;
		}
		echo ($donaties->set($goeddoel_id, $stichting_id, $user_id, str_replace(',', '.', $_REQUEST['bedrag']), $_REQUEST['comment'])) ? 1 : 0;
	break;
	
	case "agenda":
		echo ($agenda->set($user_id, $_REQUEST['agenda_id'])) ? 1 : 0;
	break;
	
	case "deleteagenda":
		echo ($agenda->delete($user_id, $_REQUEST['agenda_id'])) ? 1 : 0;
	break;

}

?>