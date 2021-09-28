<?php require('connection.php') ?>

<?php 

if($_GET['action'] == "out") out();

if ($_POST) {

	$link = mysqli_connect($host, $user, $password, $database) or die("Ошибка " . mysqli_error($link));

	switch ($_POST['action_type']) {
		case 'log_in':
			
			$query = "SELECT id_user, surname, name, nickname, login, password, id_access FROM user WHERE login='".$_POST['login']."'";
			$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
			if($result) {
				$row = mysqli_fetch_row($result);

				if($row[5] == $_POST['password']) {

					session_start();
					$_SESSION['id'] = $row[0];
					$_SESSION['nickname'] = $row[3];
					$_SESSION['access'] = $row[6];
					
					$query = "SELECT COUNT(id_user) FROM favorite WHERE id_user='".$_SESSION['id']."'";
					$tempRes = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($tempRes) {
						$tempRow = mysqli_fetch_row($tempRes);
						$_SESSION['favorite'] = $tempRow[0];
						mysqli_free_result($tempRes);
					}

					$query = "SELECT COUNT(id_hold) FROM hold WHERE id_user='".$_SESSION['id']."' and returned=0";
					$tempRes = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
					if($tempRes) {
						$tempRow = mysqli_fetch_row($tempRes);
						$_SESSION['hold'] = $tempRow[0];
						mysqli_free_result($tempRes);
					}
			mysqli_free_result($result);

					header("Location: ".$_SERVER['HTTP_REFERER']);

				} else { header('Location: http://localhost/library'); }
			}

			break;

		case 'sign_in':
			
			$query = 'INSERT INTO user (surname, name, patronymic, date_birth, nickname, login, password, phone) values("'.$_POST['surname'].'", "'.$_POST['name'].'", "'.$_POST['patronymic'].'", str_to_date("'.$_POST['birth'].'", "%Y-%m-%d"), "'.$_POST['nickname'].'", "'.$_POST['login'].'", "'.$_POST['password'].'", "'.$_POST['phone'].'")';

			if(mysqli_query($link, $query)) {
				echo 1;
			} else {
				echo mysqli_error($link);
			}

			break;

		
	}
mysqli_close($link);
}	

	function out() {
		session_start();

		unset($_SESSION['id']);
		unset($_SESSION['nickname']);
		unset($_SESSION['access']);
		unset($_SESSION['time']);
		unset($_SESSION['favorite']);
		unset($_SESSION['hold']);

		header('Location: http://localhost/library');
	}

 ?>