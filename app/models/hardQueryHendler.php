<?php 

	$searchString = $_POST['searchString'];

	$pieces = explode(" ", $searchString);

	$queryStrTitle = "title like '%".$pieces[0]."%'";
	$queryStrAuthor = "surname like '%".$pieces[0]."%' or name like '%".$pieces[0]."%' or patronymic like '%".$pieces[0]."%' or pseudonym like '%".$pieces[0]."%' ";

	if (count($pieces) > 1) {
		for ($i = 1; $i < count($pieces); $i++) {
			$queryStrTitle = $queryStrTitle.' or ';
			$queryStrTitle = $queryStrTitle."title like '%".$pieces[$i]."%'";


			$queryStrAuthor = $queryStrAuthor.' or ';
			$queryStrAuthor = $queryStrAuthor."surname like '%".$pieces[$i]."%' or name like '%".$pieces[$i]."%' or patronymic like '%".$pieces[$i]."%' or pseudonym like '%".$pieces[$i]."%' ";
		}
	}

//^^^^^^^^ формирую строки услвий для запроса


	$arrID = array();

	require('connection.php');

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));
	$query ="SELECT id_book FROM book WHERE ".$queryStrTitle;

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 	
	if($result)
	{
	    $rows = mysqli_num_rows($result);
	    for ($i = 0 ; $i < $rows ; ++$i)
	    {
	        $row = mysqli_fetch_row($result);
	        $arrID['id_book'][$i] = $row[0];
	    }
	    mysqli_free_result($result);
	}		


	$query ="SELECT id_author FROM author WHERE ".$queryStrAuthor;

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 	
	if($result)
	{
	    $rows = mysqli_num_rows($result);
	    for ($i = 0 ; $i < $rows ; ++$i)
	    {
	        $row = mysqli_fetch_row($result);
	        $arrID['id_author'][$i] = $row[0];
	    }
	    mysqli_free_result($result);
	}	


//^^^^^^^^^^ Выборка id книг и авторов

if ($arrID['id_book']) {

	echo '<h2>Поиск по названию книг</h2>'; //<span>(1-12 из 20)</span>

echo '<div class="row">';
	$query = "SELECT id_book, title, id_author, image_link from book where id_book in(".implode(',', $arrID['id_book']).") ORDER BY title";


	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

	if($result)
	{
	    fragment($result,$link);
	}		
echo '</div>';

}



if ($arrID['id_author']) {


	echo '<h2 style="margin-top: 30px;">Поиск по авторам </h2>'; //<span>(1-12 из 20)</span>

echo '<div class="row">';


	$query ="SELECT id_book, title, id_author, image_link from book where id_author in(".implode(',', $arrID['id_author']).") ORDER BY title";

	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 

	if($result)
	{
		fragment($result,$link);
	}	
echo '</div>';

}
	mysqli_close($link);


 ?>


 <?php 

	function fragment($result, $link) {
		$rows = mysqli_num_rows($result); // количество полученных строк					    	

		    for ($i = 0 ; $i < $rows ; ++$i)
		    {
		        $row = mysqli_fetch_row($result);

			echo '<div class="col-2">
				<a href="http://localhost/library/page-bookInfo.php?bookID='.$row[0].'" class="book-link">
					<div class="book">							
						<img src="'.$row[3].'" alt="">';
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

  ?>