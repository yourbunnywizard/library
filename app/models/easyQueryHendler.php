 
<?php require('connection.php') ?>



<?php 
	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
	$query = "SELECT DISTINCT book.id_book, book.title, book.id_author, book.series, book.image_link FROM `book_genre` INNER JOIN book on book_genre.id_book = book.id_book WHERE book_genre.id_genre in (".implode(',', $_POST['genreArr']).") and (book.page_count BETWEEN ".$_POST["pageLim"][0]." and ".$_POST["pageLim"][1].") AND (YEAR(book.date_publishing) BETWEEN ".$_POST["yearLim"][0]." and ".$_POST["yearLim"][1].")";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

echo '<h2>Результаты поиска</h2>';// <span>(1-12 из 20)</span>

echo '<div class="row">';

	if($result)
	{
	    $rows = mysqli_num_rows($result); // количество полученных строк					    	

	    for ($i = 0 ; $i < $rows ; ++$i)
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

echo '</div>';			  
	mysqli_close($link);
 ?>