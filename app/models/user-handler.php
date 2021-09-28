<?php 
	require('connection.php');

	session_start();

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

	if($_POST) {

		switch ($_POST['status']) {
			case 'false':
				
				$query="INSERT INTO favorite (id_user, id_book) VALUES ({$_POST['userID']}, {$_POST['bookID']})";
				
				if(mysqli_query($link, $query)) {
					echo 'seccess-insert';

					$_SESSION['favorite'] = (int) $_SESSION['favorite'] + 1;

				}	else {
					echo 'false';
				}

				break;

			case 'true':

				$query="DELETE FROM favorite WHERE id_user = {$_POST['userID']} AND id_book = {$_POST['bookID']}";
				
				if(mysqli_query($link, $query)) {
					echo 'seccess-delete';
					$_SESSION['favorite'] = (int) $_SESSION['favorite'] - 1;
				}	else {
					echo 'false';
				}

				break;
			
			case 'like':
				$query="DELETE FROM rating where id_book ={$_POST['bookID']} and id_user = {$_POST['userID']}";
				mysqli_query($link, $query);

				$query="INSERT INTO rating (id_book, id_user, mark) VALUES ({$_POST['bookID']}, {$_POST['userID']}, 1)";

				if(mysqli_query($link, $query)) {
					echo 'seccess-insert';
				}	else {
					echo 'false';
				}
				break;

			case 'dislike':

				$query="DELETE FROM rating where id_book ={$_POST['bookID']} and id_user = {$_POST['userID']}";
				mysqli_query($link, $query);

				$query="INSERT INTO rating (id_book, id_user, mark) VALUES ({$_POST['bookID']}, {$_POST['userID']}, -1)";

				if(mysqli_query($link, $query)) {
					echo 'seccess-insert';
				}	else {
					echo 'false';
				}

				break;

		}

	}

	mysqli_close($link);


 ?>