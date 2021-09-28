<?php 

	require('connection.php');

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));


	switch ($_POST['status']) {

		case 'loadClients':

			$query="SELECT id_user, phone, name, surname, patronymic from user";			
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);

				for($i = 0; $i < $rows; $i++) {
					$row = mysqli_fetch_row($result);

					echo '<option data-user-id="'.$row[0].'" data-user-phone="'.$row[1].'" data-user-name="'.$row[2].'" data-user-surname="'.$row[3].'" data-user-patronymic="'.$row[4].'" value="('.$row[0].') '.$row[1].' '.$row[2].' '.$row[3].' '.$row[4].'"></option>';
				}
 			}
 			mysqli_free_result($result);

			break;
		
		case 'loadBooks':

			$query="SELECT id_book, title from book";			
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);

				for($i = 0; $i < $rows; $i++) {
					$row = mysqli_fetch_row($result);

					echo '<option data-book-id="'.$row[0].'" data-book-title="'.$row[1].'" value="('.$row[0].') '.$row[1].'"></option>';
				}
 			}
 			mysqli_free_result($result);

			break;

		case 'loadAuthors':

			$query="SELECT * from author";			
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);

				for($i = 0; $i < $rows; $i++) {
					$row = mysqli_fetch_row($result);

					echo '<option data-author-id="'.$row[0].'" data-author-name="'.$row[2].' data-author-surname="'.$row[1].'" data-author-patronymic="'.$row[4].'" value="('.$row[0].') '; if ($row[4]!="") echo $row[4]; else echo $row[2].' '.$row[1];  echo '"></option>';
				}
 			}
 			mysqli_free_result($result);

			break;

		case 'loadGenres':

			$query="SELECT * from genre";			
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);

				for($i = 0; $i < $rows; $i++) {
					$row = mysqli_fetch_row($result);

					echo '<option data-genre-id="'.$row[0].'" data-genre-name="'.$row[1].'" value="('.$row[0].') '.$row[1].'"></option>';
				}
 			}
 			mysqli_free_result($result);

			break;

		case 'bookCount':

			$query="SELECT author.*, bookshelf.total, bookshelf.available from author inner join book on author.id_author = book.id_author inner join bookshelf on book.id_book = bookshelf.id_book WHERE book.title like ('%".$_POST['bookName']."%')";

			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

			if($result)
			{
				$rows = mysqli_num_rows($result);

				for($i = 0; $i < $rows; $i++) {
					$row = mysqli_fetch_row($result);

					echo '<option data-author-id="'.$row[0].'" data-author-name="'.$row[2].' data-author-surname="'.$row[1].'" data-author-patronymic="'.$row[4].'" data-count-total="'.$row[5].'" data-count-available="'.$row[6].'" value="('.$row[0].') '; if ($row[4]!="") echo $row[4]; else echo $row[2].' '.$row[1];  echo '"></option>';
				}
 			}
 			mysqli_free_result($result);

			break;

			case 'holdBook':

			$query="INSERT INTO hold (id_user, id_book, date_hold, date_hypothesis_return) VALUES (".$_POST['userID'].",".$_POST['bookID'].",str_to_date('".$_POST['dateHold']."','%Y-%m-%d'), str_to_date('".$_POST['dateReturn']."','%Y-%m-%d')".");";

			if(mysqli_query($link, $query)) {

				$query="UPDATE bookshelf SET available=(available-1) WHERE id_book=".$_POST['bookID'];
				if(mysqli_query($link, $query)) {
					echo 1;
				}	else {
					echo mysqli_error($link);
				}
					
			}	else {
				echo mysqli_error($link);
			}
			break;

			case 'loadReturnBook':

				$query="SELECT book.id_book, book.title, hold.date_hold, hold.date_hypothesis_return from hold inner join book on hold.id_book = book.id_book WHERE hold.id_user = ".$_POST['userID']." and hold.returned = false";

				$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));

				if($result)
				{
					$rows = mysqli_num_rows($result);

					for($i = 0; $i < $rows; $i++) {
						$row = mysqli_fetch_row($result);

						echo '<option data-book-id="'.$row[0].'" data-book-title="'.$row[1].'" data-date-hold="'.$row[2].'" data-date-return="'.$row[3].'" value="('.$row[0].') '.$row[1].'"></option>';
					}
	 			}
	 			mysqli_free_result($result);

			break;

			case 'returnBook':

				$query='UPDATE hold SET returned=true, date_return="'.date("yy-m-d").'" WHERE id_book='.$_POST['bookID'].' and id_user='.$_POST['userID'];	

				if(mysqli_query($link, $query)) {

					$query="UPDATE bookshelf SET available=(available+1) WHERE id_book=".$_POST['bookID'];
					if(mysqli_query($link, $query)) {
						echo 1;
					}	else {
						echo mysqli_error($link);
					}

				}	else {
					echo mysqli_error($link);
				}

				break;


			case 'addGenre':

				$query='INSERT INTO genre (name) VALUES ("'.$_POST['genreName'].'")';	

				if(mysqli_query($link, $query)) {
					echo 1;		
				}	else {
					echo mysqli_error($link);
				}

				break;

			case 'addAuthor':

				$query='INSERT INTO author (surname, name, patronymic, pseudonym) VALUES ("'.$_POST['authorSurname'].'", "'.$_POST['authorName'].'", "'.$_POST['authorPatronymic'].'", "'.$_POST['pseudonym'].'")';	

				if(mysqli_query($link, $query)) {
					echo 1;		
				}	else {
					echo mysqli_error($link);
				}

				break;

			case 'addBook':

				$query1='INSERT INTO book (title, id_author, date_publishing, page_count, short_descr, image_link) VALUES ("'.$_POST['title'].'", '.$_POST['author'].', str_to_date("'.$_POST['publishing'].'","%Y-%m-%d"), '.$_POST['page'].', "'.$_POST['descr'].'", "'.$_POST['url'].'")';	


				if (mysqli_query($link, $query1)) {

					$query='SELECT id_book FROM book ORDER BY id_book DESC LIMIT 1';	

					$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));;

					if ($result) {
						$row = mysqli_fetch_row($result);

						$genres = $_POST['genres'];

						for ($i = 0; $i < count($genres); $i++) {
							$query='INSERT INTO book_genre (id_book, id_genre) VALUES ('.$row[0].', '.$genres[$i].')';
							mysqli_query($link, $query);
						}

					$query='INSERT INTO bookshelf (id_book, total, available, last_arrival) VALUES ('.$row[0].', '.$_POST['count'].', '.$_POST['count'].', "'.date("yy-m-d").'")';	

						if(mysqli_query($link, $query)) {
							echo 1;
						}	else echo mysqli_error($link);

					} mysqli_free_result($result);



				} else echo mysqli_error($link);

				
				
			
				break;


			
		default:

			break;
	}
	mysqli_close($link);

 ?>

