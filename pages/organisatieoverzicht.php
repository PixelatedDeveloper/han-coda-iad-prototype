<div class="row">
    <ul class="thumbnails">


<?php
	$orgs = $organisaties->getAll();

//print_r($orgs);

	foreach ($orgs as $org) {
		echo '
		<li class="span4">
	  		<div class="thumbnail" onclick="javascript:navigateToOrganisation('.$org['id'].')">
				<div style="margin: auto; width: 250px; height: 200px; background: url('.$org['logo'].') no-repeat 50% 50%;">&nbsp;</div>
				<h3>'.$org['naam'].'</h3>
	    	</div>
	    </li>
		';
	}
?>
	</ul>
</div>

<script type="text/javascript">
	function navigateToOrganisation(id){
		 window.location.href = "index.php?page=organisatie&id=" + id;
	}
</script>
