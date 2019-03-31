<?php
if ($user_id && $user['gebruiker']['is_organisatie']) {
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	
		if ($_POST['organisator'] == 'organisatie') {
			$goeddoel_id = null;
			$stichting_id = $user['organisatie']['id'];
		} else {
			$goeddoel_id = $_POST['organisator'];
			$stichting_id = null;
		}
		
		$heledag = (isset($_POST['heledag'])) ? 1 : 0;
		if (!$heledag) {
			$tijd_begin = $_POST['tijd_begin_u'].':'.$_POST['tijd_begin_m'];
			$tijd_eind = $_POST['tijd_eind_u'].':'.$_POST['tijd_eind_m'];
		} else {
			$tijd_begin = 0;
			$tijd_eind = 0;
		}
		$result = $publiekeagenda->set($goeddoel_id, $stichting_id, $_POST['naam'], $_POST['beschrijving'], $_POST['locatie'], str_replace(',', '.', $_POST['entree']), $_POST['foto'], $_POST['datum_begin'], $_POST['datum_eind'], $tijd_begin, $tijd_eind, $heledag);
		if ($result) {
			echo '
				<p><strong>'.htmlentities($_POST['naam']).'</strong> is succesvol toegevoegd!</p>
			';
		} else {
			echo '
				<p><strong>'.htmlentities($_POST['naam']).'</strong> kon niet opgeslagen worden, probeert u het nog eens.</p>
			';
		}
	}
	$hour_html = '';
	for ($i = 0; $i < 24; $i++) {
		$sel = ($i == 8) ? 'selected="selected"' : '';
		$hour_html .= '<option '.$sel.'>'.$i.'</option>';
	}
	
	$hour_html_end = '';
	for ($i = 0; $i < 24; $i++) {
		$sel = ($i == 12) ? 'selected="selected"' : '';
		$hour_html_end .= '<option '.$sel.'>'.$i.'</option>';
	}
	
	$minute_html = '';
	for ($i = 0; $i < 60; $i++) {
		$minute_html .= '<option>'.sprintf('%02d', $i).'</option>';
	}

	$organisator = '
		<optgroup label="Organisatie">
			<option selected="selected" value="organisatie">'.$user['organisatie']['naam'].'</option>
		</optgroup>
	';
	$doelen = $goededoelen->getByOrganisatie($user['organisatie']['id']);
	if ($doelen) {
		$organisator .= '<optgroup label="Goede doelen">';
		foreach ($doelen as $doel) {
			$organisator .= '<option value="'.$doel['id'].'">'.$doel['naam'].'</option>';
		}
		$organisator .= '</optgroup>';
	}
	
	echo '
		<h1>Agenda beheren '.$user['organisatie']['naam'].'</h1>
		<form method="post" action="index.php?page=agendabeheer">
			<fieldset>
				<legend>Nieuw agenda item toevoegen</legend>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Naam:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="naam">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-beschrijving">Beschrijving:</label>
					<div class="controls">
						<!--<input type="text" class="input-xlarge" name="organisatie-beschrijving">-->
						<textarea rows="5" cols="50" class="input-xlarge" name="beschrijving"></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Organisator:</label>
					<div class="controls">
						<select name="organisator">'.$organisator.'</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Locatie:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="locatie">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Hele dag:</label>
					<div class="controls">
						<input type="checkbox" id="heledag" name="heledag">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Begindatum:</label>
					<div class="controls">
						<input type="text" class="input-medium" id="begin-datepicker" name="datum_begin">
						<select class="tijdveld input-mini" name="tijd_begin_u">'.$hour_html.'</select>
						<select class="tijdveld input-mini" name="tijd_begin_m">'.$minute_html.'</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Einddatum:</label>
					<div class="controls">
						<input type="text" class="input-medium" id="eind-datepicker" name="datum_eind">
						<select class="tijdveld input-mini" name="tijd_eind_u">'.$hour_html_end.'</select>
						<select class="tijdveld input-mini" name="tijd_eind_m">'.$minute_html.'</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Entreeprijs:</label>
					<div class="controls input-prepend">
						 <span class="add-on">&euro;</span><input type="text" value="0.00" class="input-medium" name="entree">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="organisatie-naam">Foto URL:</label>
					<div class="controls">
						<input type="text" class="input-xlarge" name="foto">
					</div>
				</div>
				<div class="control-group">
					<div class="controls">
						<input type="submit" class="btn btn-primary" value="Maak aan" />
					</div>
				</div>
			</fieldset>
		</form>
	';
	
	/*$gdoelen = $goededoelen->getByOrganisatie($user['organisatie']['id']);
	echo '<h3>Overzicht van goede doelen</h3>';
	echo '<ul>';
		foreach ($gdoelen as $gdoel) {
			echo '<li>'.$gdoel['naam'].'</li>';
		}
	echo '</ul>';*/
} else {
	echo '
		<h1>Sorry..</h1>
		<p>
			U heeft geen toegang tot dit gedeelte van de website.
		</p>
	';
}
?>

<script type="text/javascript">
	$(function() {
		$("#heledag").change(function(){
			if ($(this).attr('checked')) {
				$(".tijdveld").hide();
			} else {
				$(".tijdveld").show();
			}
		});
		
		$( "#begin-datepicker" ).datepicker({altField: "#eind-datepicker",}).datepicker( "option", "dateFormat", "yy-mm-dd" );
		$( "#eind-datepicker" ).datepicker().datepicker( "option", "dateFormat", "yy-mm-dd" );
	});
</script>