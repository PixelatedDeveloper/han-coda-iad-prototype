<?php
	$dons = $donaties->getByGebruiker($user_id);
?>
<h1>Mijn donaties</h1>
<?php
$tempdata = array('organisatie' => array(), 'goeddoel' => array());
if ($dons) {
	echo '<table id="userAgenda" class="table table-striped table-bordered table-condensed">';
	echo '
		<thead>
			<tr>
				<th>Aan</th>
				<th>Bedrag</th>
				<th>Opmerking</th>
				<th>Datum</th>
			</tr>
		</thead>
		<tbody>
	';
	foreach ($dons as $don) {
		if ($don['goeddoel_id']) {
			if (!isset($tempdata['goeddoel'][$don['goeddoel_id']])) {
				$tempdata['goeddoel'][$don['goeddoel_id']] = $goededoelen->get($don['goeddoel_id']);
			}
			$data = $tempdata['goeddoel'][$don['goeddoel_id']];
			$aan = '<a href="index.php?page=goeddoel&id='.$data['id'].'">'.$data['naam'].'</a>';
		} else {
			if (!isset($tempdata['organisatie'][$don['stichting_id']])) {
				$tempdata['organisatie'][$don['stichting_id']] = $organisaties->get($don['stichting_id']);
			}
			$data = $tempdata['organisatie'][$don['stichting_id']];
			$aan = '<a href="index.php?page=organisatie&id='.$data['id'].'">'.$data['naam'].'</a>';
		}
		echo '
			<tr>
				<td>'.$aan.'</td>
				<td>€ '.number_format($don['bedrag'], 2, ',', '.').'</td>
				<td>'.$don['opmerking'].'</td>
				<td>'.date('d-m-Y, G:i', strtotime($don['datum'])).'</td>
			</tr>
		';
	}
	echo '</tbody></table>';
}
?>