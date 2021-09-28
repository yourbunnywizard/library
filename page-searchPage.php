<?php require('fragment-header.php'); ?>

<link rel="stylesheet" href="app/views/styles/sliders.css">

<?php 

if ($_GET['searchString']) {
	$searchString = $_GET['searchString'];
}

?>
	<section class="results-container" id="results-container">

		<script>
			$.ajax({
				type: 'POST',
				url: 'app/models/hardQueryHendler.php',
				data: 'searchString=' + <?php echo '"'.$searchString.'"'; ?>,
				success: function(data) {
					$('#template').html(data);
				}
			});
		</script>	

		<div class="container" id="template">
			
		</div>

	</section>


	<section class="sidebar">
		<?php require('search-sidebar.php'); ?>
	</section>


<?php require('fragment-footer.php'); ?>

