<?php
$id = (isset($_REQUEST['id'])) ? $_REQUEST['id'] : 0;

if ($id) {
	$item = $publiekeagenda->get($id);
	$prijs = ($item['entree'] == 0) ? 'gratis' : '€ '.$item['entree'];
	//$datum = ($item['datum_begin'] == $item['datum_eind']) ? $item['datum_begin'] : $item['datum_begin'].' &mdash; '.$item['datum_eind'];
	// Datum
	if ($item['datum_begin'] == $item['datum_eind']) {
		$datum = date('d-m-Y', strtotime($item['datum_begin']));
	} else {
		$datum = date('d-m', strtotime($item['datum_begin'])).' &mdash; '.date('d-m-Y', strtotime($item['datum_eind']));
	}
	// Tijd
	if ($item['heledag']) {
		$tijd = 'hele dag';
	} else {
		$tijd = $item['tijd_begin'].' &mdash; '.$item['tijd_eind'];
	}
	// Goed doel / stichting
	if ($item['goeddoel_id']) {
		$doel = $goededoelen->get($item['goeddoel_id']);
		$organiser = '<a href="index.php?page=goeddoel&id='.$doel['id'].'">'.$doel['naam'].'</a>';
	} else {
		$doel = $organisaties->get($item['stichting_id']);
		$organiser = '<a href="index.php?page=organisatie&id='.$doel['id'].'">'.$doel['naam'].'</a>';
	}
	if ($item['foto']) {
		$logo = '
				<ul class="thumbnails" style="float: right;">
					<li style="width: 260px;">
						<div class="thumbnail">
							<div style="margin: auto; width: 250px; height: 200px; background: url('.$item['foto'].') no-repeat 50% 50%;">&nbsp;</div>
							<small><a target="_blank" href="'.$item['foto'].'">Vergroot afbeelding</a></small>
						</div>
					</li>
				</ul>
		';
	} else {
		$logo = '';
	}
	echo '
	<div class="row-fluid">
		<h1>'.$item['naam'].'</h1>
		'.$logo.'
		<p>'.$item['beschrijving'].'</p>
		<p>
			<em><strong>Entree</strong>: '.$prijs.'</em>
			<br />
			<em><strong>Datum</strong>: '.$datum.'</em>
			<br />
			<em><strong>Tijd</strong>: '.$tijd.'</em>
			<br />
			<em><strong>Locatie</strong>: '.$item['locatie'].'</em>
		</p>
		</p>
			<strong>Organisator</strong>: '.$organiser.'
		</p>
	</div>
';
}

?>