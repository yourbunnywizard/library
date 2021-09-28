<?php require('fragment-header.php'); 

	if($_SESSION['access'] == 2) {
		echo '<script src="app/views/scripts/admin-scripts.php"></script>';
	};

?>

<script>
		
</script>

<div class="container" style="margin-top: 100px;">
	<h2 style="margin-bottom: 50px;">Добавление жанра</h2>
	<div class="row">
		<div class="col-12">
			<div class="infopanel">

				<p>название жанра</p>
				<input type="text" id="genre-name" list="client-list">
				
			</div>
		</div>

		<div class="col-12">
			<div class="holdbutton" style="margin-top: 25px;">
				<button id="addGenre">Добавить жанр</button>
			</div>
		</div>
		
	</div>
</div>



<?php require('fragment-footer.php'); ?>