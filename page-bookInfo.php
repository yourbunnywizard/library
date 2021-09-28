<?php require('fragment-header.php'); 

	if($_SESSION['access'] == 2) {
		echo '<script src="app/views/scripts/admin-scripts.php"></script>';
	};

?>

<?php require('app/models/connection.php') ?>

<?php 


	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
	$query = "SELECT * FROM book WHERE id_book=".$_GET['bookID'];

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

	if($result)
	{

		$row = mysqli_fetch_row($result);

?>


<section class="bookInfo-container">
	<input type="hidden" disabled="disabled" name="bookID" id="bookID" value="<?php echo $row[0]; ?>">
	<div class="container">
		<div class="row">
			<div class="col-3">

				<div class="book-preview">
					<img src="<?php echo $row[7]; ?>" alt="" width="100%">
				</div>

<?php 

if ($id) {

	$query="SELECT * FROM favorite WHERE id_user=".$id." and id_book=".$row[0];
	$result_inside = mysqli_query($link, $query) or die("Error ".mysqli_error($link));

	if($result_inside) {
		$rows = mysqli_num_rows($result_inside);

?>

	<div class="like user-btns <?php if($rows > 0) echo 'active'; ?>" id="btn-like"><input id="status" type="checkbox" <?php if($rows > 0) echo 'checked="checked"'; ?> hidden="hidden"><i class="fas fa-heart"></i> Закладки</div>

<?php
		mysqli_free_result($result_inside);
	}
}
 ?>
 				

				<div class="like user-btns"><i class="fas fa-shopping-cart"></i> Арендовать</div>


			</div>

			<div class="col-9">

				<h1><?php echo $row[1]; ?></h1>

				<div class="book-description">
					<h6>Описание</h6>
					<p><?php echo $row[6];?></p>
				</div>

				<div class="book-info">

<?php 

	$query="SELECT * FROM author WHERE id_author=".$row[3];
	$result_inside = mysqli_query($link, $query) or die("Error ".mysqli_error($link));

	if($result_inside) {

	$row_inside = mysqli_fetch_row($result_inside);

?>

					<div class="book_author"><h6>Автор: </h6> <span><?php if($row_inside[4]!="") echo $row_inside[4]; else echo $row_inside[2]." ".$row_inside[1]; ?></span></div>

<?php
		mysqli_free_result($result_inside);
	}

 ?>
						
					<div class="book_series"><h6>Серия: </h6> <span><?php if ($row[2]!="") echo $row[2]; else echo "без серии"; ?></span></div>
<?php 

	$query="SELECT genre.* FROM book_genre inner join genre on book_genre.id_genre = genre.id_genre WHERE book_genre.id_book=".$row[0];
	$result_inside = mysqli_query($link, $query) or die("Error ".mysqli_error($link));
	
	if($result_inside) {
		
	$genres_arr = array();

	$rows_inside = mysqli_num_rows($result_inside);

	for($i = 0; $i < $rows_inside; $i++) {
		$row_inside = mysqli_fetch_row($result_inside);
		$genres_arr[$i] = $row_inside[1];
	}
	

?>

					<div class="book_genre"><h6>Жанр: </h6> <span><?php echo implode(', ', $genres_arr) ?></span></div>

<?php
		mysqli_free_result($result_inside);
	}

 ?>

					<div class="book_year"><h6>Год публикации: </h6> <span><?php echo $row[4];?></span></div>
					<div class="book_page"><h6>К-во страниц: </h6> <span><?php echo $row[5];?>с.</span></div>
				</div>

			</div>


<?php 

$query="SELECT DISTINCT (select count(*) FROM rating where mark=1 and id_book={$row[0]}), (select count(*) from rating where mark=-1 and id_book={$row[0]}) from rating";
$result_inside = mysqli_query($link, $query) or die("Error ".mysqli_error($link));
if($result_inside) {

	$row_inside = mysqli_fetch_row($result_inside);


	$raitMarks = (int)$row_inside[0] + (int)$row_inside[1];
	$likePercent = round( ((int)$row_inside[0] * 1.0 / $raitMarks), 2) * 100;
	$dislikePercent = round( ((int)$row_inside[1] * 1.0 / $raitMarks), 2) * 100;

 ?>
			<div class="col-12">
				<div class="rating-box">
					<div class="rating-slider">
						<p>Оценки читателей</p>
						<div class="rating-bar">
							<div class="rating-p" style="width: <?php echo $likePercent; ?>%"><div class="percent percent-p"><span><?php echo $likePercent; ?>%</span></div></div>
							<div class="rating-n" style="width: <?php echo $dislikePercent; ?>%"><div class="percent percent-n"><span><?php echo $dislikePercent; ?>%</span></div></div>
						</div>
					</div>
					<div class="rating-marks">
						<div class="rating mark-p" id="mark-p"><i class="fas fa-thumbs-up"></i> <span><?php echo $row_inside[0]; ?></span></div>
						<div class="rating mark-n" id="mark-n"><i class="fas fa-thumbs-up"></i> <span><?php echo $row_inside[1]; ?></span></div>
					</div>

				</div>
			</div>

<?php
		mysqli_free_result($result_inside);
	}

 ?>

			<div class="col-12">
				<div class="book-comment-box">
					<div class="book-comment">
						<div class="comment-author">
							<div class="avatar">						
							</div>
							<div class="name">Денис Иванютенко</div>
							<div class="date">12.11.2020</div>
						</div>
						<div class="coment-text"><p>Наш герой - мелкий петербургский чиновник, "Маленький человек". Его жизнь уныла и однообразна, полна мелочных переживаний, которые, по сути дела, и составляют все его жалкое существование. И тут он влюбляется в дочь директора департамента и от этого внезапно накрывшего его чувства, начинает потихоньку сходить с ума. В буквальном смысле этого слова. Ну, а чем дело кончится, узнаете,дочитав до конца.</p></div>
					</div>

					<div class="book-comment">
						<div class="comment-author"></div>
						<div class="coment-text"><p>Наш герой - мелкий петербургский чиновник, "Маленький человек". Его жизнь уныла и однообразна, полна мелочных переживаний, которые, по сути дела, и составляют все его жалкое существование. И тут он влюбляется в дочь директора департамента и от этого внезапно накрывшего его чувства, начинает потихоньку сходить с ума. В буквальном смысле этого слова. Ну, а чем дело кончится, узнаете,дочитав до конца.</p></div>
					</div>
				</div>
			</div>

		</div>
	</div>
</section>

<?php
		mysqli_free_result($result);
	}

	mysqli_close($link);

?>


<?php require('fragment-footer.php'); ?>