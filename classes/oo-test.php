<?php
$categories = array(
	1 => 'Algemeen',
	2 => 'Dierenwelzijn',
	3 => 'Gehandicaptenzorg',
	4 => 'Godsdienst',
	5 => 'Internet',
	6 => 'Inzameling',
	7 => 'Huisvesting',
	8 => 'Kunst & cultuur',
	9 => 'Mensen rechten',
	10 => 'Natuur & milieu',
	11 => 'Onderzoek',
	12 => 'Onderwijs',
	13 => 'Ontwikkelingswerk',
	14 => 'Ouderenhulp',
	15 => 'Slachtofferhulp',
	16 => 'Sport & recreatie',
	17 => 'vluchtelingenhulp',
	18 => 'Volksgezondheid',
	19 => 'Welzijn',
	20 => 'Zinloos geweld'
);

function categoryHtml($categories, $id, $name) {
	asort($categories);
	$html = '<select id="'.$id.'" name="'.$name.'">';
	foreach ($categories as $id => $name) {
		$html .= '<option value="'.$id.'">'.$name.'</option>';
	}
	$html .= '</select>';
	return $html;
}

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


/* Haal alle organisaties op 
$organs = $organisaties->getAll();
*/

/* Haal alle organisaties op, waar de categorie '2' is
$organs = $organisaties->getAllByCategory(2);
*/

/* Haal 1 organisatie op, met id '1'
$organs = $organisaties->get(1);
*/

/* Toont een HTML <select> veld voor alle categorieën 
echo categoryHtml($categories, 'cats', 'category_id');
*/

/* Een gebruiker registreert 
$register = $gebruikers->signup('jaap@aap.nl', 'peren');
*/

/* Een gebruiker logged in 
$user_id = $gebruikers->login('jaap@aap.nl', 'peren');
//$user_id = $gebruikers->login('jaap@aap.nl', 'appels'); // Fout wachtwoord
*/

/* Voeg toe/update extra data voor gebruiker '1' 
$success = $gebruikers->addGebruikerData(1, 1, 'Dhr.', 'Aangepaste', 'Data', 306203734764);
*/

/* Haal gebruiker informatie op + organisatie info als gebruiker een beheerder is 
$user_info = $gebruikers->get(1);
*/

/* Haal info van goed doel op 
$foutedoelen = $goededoelen->get(1);
*/

/* Haal info van goede doelen van een organisatie op 
$foutedoelen = $goededoelen->getByOrganisatie(2);
*/

/* Haal info van goed doel op 
$foutedoelen = $goededoelen->getByCategorie(3);
*/


/* Haal info van een donatie op
$donos = $donaties->get(1);
*/

/* Haal alle donaties van een goed doel op
$donos = $donaties->getByGoedDoel(5);
*/

/* Haal alle donaties van een stichting op (zonder die van de goede doelen)
$donos = $donaties->getByOrganisatie(1);
*/

/* Haal info van een publiekeagenda op
$pubcal = $publiekeagenda->get(1);
*/

/* Haal alle publiekeagenda van een goed doel op
$pubcal = $publiekeagenda->getByGoedDoel(5);
*/

/* Haal alle publiekeagenda van een stichting op (zonder die van de goede doelen)
$pubcal = $publiekeagenda->getByOrganisatie(1);
*/

/* Haal alle agenda items van een gebruiker op 
$cal = $agenda->get(4);
*/

/* Haal alle agenda items van een gebruiker op + de extra info van publiekeagenda (join) 
$cal = $agenda->getFull(4);
*/

/* Haal een reactie op 
$comment = $reacties->get(4);
*/

/* Haal alle reacties van een goed doel op
$comment = $reacties->getByGoedDoel(5);
*/ 

/* Haal alle reacties van een stichting op 
$comment = $reacties->getByOrganisatie(1);
*/

/* Haal alle reacties van een agenda op 
$comment = $reacties->getByAgenda(2);
*/


echo '<pre>';
print_r($comment); 



