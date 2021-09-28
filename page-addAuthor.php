<?php require('fragment-header.php'); 

	if($_SESSION['access'] == 2) {
		echo '<script src="app/views/scripts/admin-scripts.php"></script>';
	};

?>



<div class="container" style="margin-top: 100px;">
	<h2 style="margin-bottom: 50px;">Добавление писателя</h2>
	<div class="row">
		<div class="col-12">
			<div class="infopanel">

				<p>Имя</p>
				<input type="text" id="author-name">
				<p>Фамилия</p>
				<input type="text" id="author-surname">
				<p>Отчество</p>
				<input type="text" id="author-patronymic">
				<p>Псевдоним</p>
				<input type="text" id="author-pseudonym">
				
			</div>
		</div>

		<div class="col-12">
			<div class="holdbutton" style="margin-top: 25px;">
				<button id="addAuthor">Добавить автора</button>
			</div>
		</div>
		
	</div>
</div>



<?php require('fragment-footer.php'); ?>