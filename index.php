

<?php require('fragment-header.php'); ?>

	

	<section class="newest">
		<div class="container">
			<div class="newBooks">
				<h1>Новинки</h1>
			</div>

			<div class="row">
				<?php require('fragment-newest.php') ?>	
			</div>
			 
		</div>
	</section>

	<section class="popular">
		<div class="container">
			<div class="popularBooks">
				<h1>Популярные</h1>
			</div>
			
			<div class="row">
				<?php require('fragment-popular.php') ?>
			</div>

		</div>
	</section>


<?php require('fragment-footer.php'); ?>