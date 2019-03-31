<?php
$items = $publiekeagenda->getAll();
$myitems = $agenda->get($user_id);
$myids = array();
if ($myitems) {
	foreach ($myitems as $myitem) {
		$myids[$myitem['agenda_id']] = $myitem['status'];
	}
}


if ($items) {
	echo '
	<div class="row">
		<ul class="thumbnails">
	';
	foreach ($items as $item) {
		$foto = ($item['foto']) ? '<img src="'.$item['foto'].'" width="100"  height="100" alt="'.$item['naam'].'" title="'.$item['naam'].'" style="float: right; margin: 10px; "/>' : '';
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
		echo '
		<li class="span4">
	  		<div class="thumbnail" style="position: relative; height: 200px; overflow: auto;">
				'.$foto.'
				<h3><a href="index.php?page=agenda&id='.$item['id'].'">'.$item['naam'].'</a></h3>
				<p>
					'.$item['beschrijving'].'
				</p>
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
				<p>
			';
				if ($user_id) {
					if (array_key_exists($item['id'], $myids)) {
						echo '<button data-id="'.$item['id'].'" class="ikga btn">Ik ga!</button>';
					} else {
						echo '<button onclick="addAgendaItem(this, '.$item['id'].')" class="btn btn-primary">Voeg toe</button>';
					}
				}
			echo '
				</p>
	    	</div>
	    </li>
		';
	}
	echo '
		</ul>
	</div>
	';
} else {
	echo '
		<p>Geen agenda items</p>
	';
}
?>
<script type="text/javascript">
function addAgendaItem(e, id) {
	$(e).hide();
	$.get('ajax.php', {action: 'agenda', agenda_id: id}, function(data){
		if (data == 1) {
			alert("Toegevoegd!");
		} else {
			alert("Oh jee, er ging iets fout. Probeer het nog eens!");
			$(e).show();
		}
	});
}
$(document).ready(function(){
	$(".ikga").hover(function(){
		$(this).addClass('btn-danger').html("Verwijder");
	}, function(){
		$(this).removeClass('btn-danger').html("Ik ga!");
	});
	
	$(".ikga").click(function(){
		var ikga = $(this);
		if(confirm("Weet je zeker dat je dit item uit je agenda wilt verwijderen?")) {
			$.get('ajax.php', {action: 'deleteagenda', agenda_id: ikga.attr('data-id')}, function(data){
				if (data == 1) {
					ikga.hide();
				}
			});
		}
	});
});
</script>
<?php
/*
echo '<pre>';
print_r($items);
echo '</pre>';
*/
?>