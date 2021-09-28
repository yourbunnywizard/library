<?php require('fragment-header.php'); ?>

<?php require('app/models/connection.php') ?>



<section class="popular">
		<div class="container">
			<div class="popularBooks">
				<h1>Закладки</h1>
			</div>

			<div class="row">				
				
<?php 
	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

	$booksID = []; 

	$query ="SELECT id_book FROM favorite where id_user=".$id;

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

	if ($result) {
		$rows = mysqli_num_rows($result); 

	    for ($i = 0 ; $i < $rows ; ++$i)
	    {
	        $row = mysqli_fetch_row($result);
	        $booksID[$i] = $row[0];
	    }

	}

	mysqli_free_result($result);

	$query ="SELECT id_book, title, id_author, series, image_link FROM book WHERE id_book in (".implode(',', $booksID).")";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	
	if($result)
	{
	    $rows = mysqli_num_rows($result); // количество полученных строк					  



	    for ($i = 0; $i < $rows; ++$i)
	    {
	        $row = mysqli_fetch_row($result);

echo '<div class="col-2">
	<a href="http://localhost/library/page-bookInfo.php?bookID='.$row[0].'" class="book-link">
		<div class="book">							
			<img src="'.$row[4].'" alt="">';
echo '<div class="book-prev">
				<h3 class="__name">'.$row[1].'</h3>';	

	        	$query="SELECT name, surname, pseudonym FROM author WHERE id_author = ".$row[2];
	        	$res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

	        	if($res) 
	        	{
	        		$roww = mysqli_fetch_row($res); 
	    echo '<p class="__author">';

	        		if($roww[2] != "") {
						echo $roww[2];					        			
	        		}	else { echo $roww[0]." ".$roww[1]; }					        		
	        	}
	        	mysqli_free_result($res);

	        	echo '</p>';

	    echo '<p class="__genre">';
	        	$query="SELECT genre.name from book_genre INNER join genre on genre.id_genre = book_genre.id_genre where book_genre.id_book = ".$row[0];
	        	$res = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	        	if($res) 
	        	{
	        		$rowss = mysqli_num_rows($res);
	        		for ($j = 0 ; $j < $rowss ; ++$j)
				    {
				        $roww = mysqli_fetch_row($res);
				        echo '<span>'.$roww[0].'</span>, ';
				    }
	        	}
	        	mysqli_free_result($res);
	    echo '</p>				
			</div>
		</div>
	</a>
</div>';
	    }
	  
	    mysqli_free_result($result);
	}					  
	mysqli_close($link);
 ?>


			</div>

		</div>
	</section>



<?php require('fragment-footer.php'); ?>