<?php require('fragment-header.php'); 

	if($_SESSION['access'] == 2) {
		echo '<script src="app/views/scripts/admin-scripts.php"></script>';
	};

?>

<script>
	
	$.ajax({
		type: 'POST',
		url: 'app/models/admin-handler.php',
		data: 'status=loadBooks',
		success: function(data) {
			$('#book-list').html(data);		
		}	
	});


		$.ajax({
			type: 'POST',
			url: 'app/models/admin-handler.php',
			data: 'status=loadAuthors',
			success: function(data) {
				$('#author-list').html(data);		
			}	
		});
		
</script>
<div class="container-fluid" style="margin-top: 40px;">
	<h2 style="margin-bottom: 40px;">Выдача книг</h2>
	<div class="row">
		<div class="col-4">
			<div class="infopanel client-info">
				<h4>Инфомация о читателе</h4>

				<p>id читателя / номер телефона </p>
				<input type="text" id="client-identificator" list="client-list">
				<p>имя</p>
				<input type="text" id="client-name">
				<p>фамилия</p>
				<input type="text" id="client-surname">
				<p>отчество</p>
				<input type="text" id="client-patronymic">				
				<p>номер телефона</p>
				<input type="text" id="client-phone">		
			</div>
		</div>
		<div class="col-4">

			<div class="infopanel book-info">
				<h4>Инфомация о книге</h4>

				<p>id книги / название </p>
				<input type="text" id="book-identificator" list="book-list">
				<p>id автора / фио </p>
				<input type="text" id="author-identificator" list="author-list">
				<div class="book-count">
					<div>
						<p>в наличии</p>
						<input type="text" id="available" disabled="disabled">
					</div>
					<div>
						<p>всего</p>
						<input type="text" id="total" disabled="disabled">
					</div>					
				</div>
			</div>
			
		</div>

		<div class="col-4">
			<div class="infopanel date-info">
				<h4>Уточнение сроков</h4>

				<p>дата выдачи</p>
				<input type="date" id="date-hold">
				<p>предположительная дата возврата</p>
				<input type="date" id="date-hypothesis-return">
			</div>
				
		</div>

	</div>

	<div class="holdbutton">
		<button id="hold-to-client">Выдать книгу</button>
	</div>

</div>


<datalist id="client-list">
</datalist>

<datalist id="book-list">
</datalist>

<datalist id="author-list">
</datalist>

<datalist id="temp-author-list">
</datalist>

<?php require('fragment-footer.php'); ?>