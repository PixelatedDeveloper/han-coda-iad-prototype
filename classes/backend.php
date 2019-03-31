<?php
include('class.db.php');
include('class.organisaties.php');
include('class.gebruikers.php');
include('class.goededoelen.php');
include('class.donaties.php');
include('class.publiekeagenda.php');
include('class.agenda.php');
include('class.reacties.php');

$db = new db; // Initiate database
$organisaties = new organisaties;
$gebruikers = new gebruikers;
$goededoelen = new goededoelen;
$donaties = new donaties;
$publiekeagenda = new publiekeagenda;
$agenda = new agenda;
$reacties = new reacties;

$action = (isset($_REQUEST['action'])) ? $_REQUEST['action'] : 0;

switch ($action) {

	case 'registreren':
		echo ($gebruikers->signup($_REQUEST['emailadres'], $_REQUEST['wachtwoord'])) ? 1 : 0;
	break;
	
	case 'getUser':
		echo json_encode($gebruikers->get($_REQUEST['id']));
	break;
	
	case 'getGoedeDoelen':
		echo json_encode($goededoelen->getGoedeDoelen());
	break;

	case 'getPubliekeAgendaByGoedDoel':
		echo json_encode($publiekeagenda->getByGoedDoel($_REQUEST['id']));
	break;

	case 'insertAgenda':
		$agenda->set($_REQUEST['gebruiker_id'], $_REQUEST['agenda_id']);
	break;
	
	case 'registerUser':
		//echo json_encode($_REQUEST['data']);
		$user_id = $gebruikers->signup($_REQUEST['data']['email'], $_REQUEST['data']['password']);
		$gebruikers->addGebruikerData($user_id, 0, $_REQUEST['data']['aanhef'], $_REQUEST['data']['voornaam'], $_REQUEST['data']['achternaam'], $_REQUEST['data']['rekening']);
		
		echo $user_id;
	break;
	
	case 'registerOrganisatie':
		//echo json_encode($_REQUEST['data']);
		$user_id = $gebruikers->signup($_REQUEST['data']['email'], $_REQUEST['data']['password']);
		$gebruikers->addGebruikerData($user_id, 1, $_REQUEST['data']['aanhef'], $_REQUEST['data']['voornaam'], $_REQUEST['data']['achternaam'], $_REQUEST['data']['bank']);
		$organisaties->set($user_id, $_REQUEST['data']['naam'], $_REQUEST['data']['beschrijving'], $_REQUEST['data']['cbf'], $_REQUEST['data']['bank'], $_REQUEST['data']['straat'], $_REQUEST['data']['huisnr'], $_REQUEST['data']['postcode'], $_REQUEST['data']['plaats'], $_REQUEST['data']['telefoon']);
		echo $user_id;
	break;
	
	case 'loginUser':
		echo $gebruikers->login($_REQUEST['email'], $_REQUEST['password']);
	break;
	
	case 'loginUserName':
		echo $gebruikers->login($_REQUEST['email'], $_REQUEST['password'], true);
	break;

}

?>