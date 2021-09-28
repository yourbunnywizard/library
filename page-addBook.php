<?php require('fragment-header.php'); 

	if($_SESSION['access'] == 2) {
		echo '<script src="app/views/scripts/admin-scripts.php"></script>';
	};

?>

<script>
	$.ajax({
		type: 'POST',
		url: 'app/models/admin-handler.php',
		data: 'status=loadAuthors',
		success: function(data) {
			$('#author-list').html(data);		
		}	
	});

	$.ajax({
		type: 'POST',
		url: 'app/models/admin-handler.php',
		data: 'status=loadGenres',
		success: function(data) {
			$('#genre-list').html(data);		
		}	
	});

</script>

<div class="container" style="margin-top: 40px;">
	<h2 style="margin-bottom: 50px;">Добавление книг</h2>
	<div class="row">
		<div class="col-12">
			<div class="infopanel">

				<p>название</p>
				<input type="text" id="book-title">
				<p>автор</p>
				<input type="text" id="book-author" list="author-list">
				<p>жанр</p>
				<input type="text" id="book-genre" list="genre-list">	
				<div class="chosenGenre"></div>			
				<p>дата публикации</p>
				<input type="date" id="book-publishing">
				<p>к-во страниц</p>
				<input type="number" id="book-page">
				<p>краткое описание</p>
				<textarea id="book-descr"></textarea> 
				<p>url - картинки</p>
				<input type="text" id="book-url">
				<p>к-во печатных копий</p>
				<input type="number" id="book-count">

				
			</div>
		</div>

		<div class="col-12">
			<div class="holdbutton" style="margin-top: 25px;">
				<button id="addBook">Добавить книгу</button>
			</div>
		</div>
		
	</div>
</div>

<datalist id="author-list">
</datalist>

<datalist id="genre-list">
</datalist>

<?php require('fragment-footer.php'); ?>