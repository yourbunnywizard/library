<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
	
	<title>Document</title>
	<link rel="stylesheet" href="app/views/styles/general.css">	
	<link rel="stylesheet" href="app/views/styles/page-view.css">

	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">

	<!--<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>-->

	<script src="https://kit.fontawesome.com/9ea1653bd2.js" crossorigin="anonymous"></script>
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>


</head>
<body>

<header>
	<?php 
	session_start();

	if(isset($_SESSION['id'])) { 
		$id = $_SESSION['id'];
		$nickname = $_SESSION['nickname'];
		$access = $_SESSION['access'];
	}




	 ?>
		<div class="container">
			<div class="menu">
				<div class="logo"><a href="http://localhost/library"><img src="app/views/images/logoBlack.png" alt="" width="315"></a></div>
				<div class="menuList">
					<div class="catalog"><button id="btn-catalog"><?php require('app/views/images/catalog.svg') ?></button></div>
					<div class="search"><button id="btn-search"><?php require('app/views/images/search.svg') ?></button></div>
					<div class="user-case"><button id="btn-user<?php if( !isset($_SESSION['id']) ) echo '-anonym'; ?>" <?php if( $nickname) echo 'data-nickname="'.$nickname.'"';  ?> ><?php require('app/views/images/user.svg') ?></button></div>
					<div class="authorization-box" <?php if ($id) echo 'style="display : none"';?> >

						<input type="checkbox" id="authorization-active" style="display: none;">

						<form action="http://localhost/library/app/models/authorization.php" class="authorization" name="authorization" method="post">

							<p>Вход</p>

							<input name="action_type" type="hidden" value="log_in">
							<label>Логин<input name="login" type="text"></label>
							<label>Пароль<input name="password" type="password"></label>

							<input type="submit">

							<a href="page-registration.php">Зарегестрироваться</a>

						</form>
					</div>
					<div class="user-menu">
						<input type="checkbox" id="user-menu-active" style="display: none;">
						<ul class="user-menu_list">
							<li><div class="myAcc"><a href="" id="userName" name="<?php echo $id;?>"><?php echo $nickname; ?></a><a href=""><i class="fas fa-cog"></i></a></div></li>
							<li><a href="page-favorite.php">Закладки <span class="favorit"><?php echo $_SESSION['favorite']; ?></span></a></li>
							<li><a href="">Взято в аренду <span class="arenda"><?php echo $_SESSION['hold']; ?></span></a></li>
							<?php 

								if ($access == 2) {
									echo '<hr>
										<li><a href="page-addBook.php">Добавить книгу</a></li>
										<li><a href="page-addAuthor.php">Добавить автора</a></li>
										<li><a href="page-addGenre.php">Добавить жанр</a></li>
										<li><a href="page-bookHold.php">Выдача книги</a></li>
										<li><a href="page-bookReturn.php">Возврат книги</a></li>';
								}

							 ?>
							

							<hr>
							<li><a href="http://localhost/library/app/models/authorization.php?action=out">Выход</a></li>

						</ul>
					</div>
					<style>
						.user-menu {
							position: absolute;
							max-width: 240px;
							right: -240px;
							top: 70px;
							background: #fbfbfb;
							opacity: 0;
							transition: 0.3s;
						}

						.user-menu .user-menu_list li .myAcc {
							display: grid;
							margin-left: 0;
							grid-template-columns: 3fr 1fr;
							font-weight: 700;
						}
						.user-menu ul a {
							display: block;
							padding: 3px 10px;
						}
						ul.user-menu_list li a span {
							padding: 0 7px;
							color: #fff;
						}
						span.favorit {
							background: #0184f8;
						}
						span.arenda {
							background: #f81111;
						}
						ul.user-menu_list li a:hover {
							background: #dadada;
						}

					</style>
				
				</div>
			</div>
		</div>			
	</header>

	<section class="menu-active">
		<input type="checkbox" id="panelActive" style="display: none;">
		<div class="container">
			<div class="search-panel">
				<input type="text" class="inp-search" id="inp-search" placeholder="Название книги или автора">
				<button id="startSearch"><i class="fas fa-search"></i></button>
			</div>
			<div class="catalog-panel">
				<ul class="pop-genre">
					<a href="#"><li>Ужасы</li></a>
					<a href="#"><li>Фантастика</li></a>
					<a href="#"><li>Детективы</li></a>
					<a href="#"><li>Научные</li></a>
					<a href="#"><li>Фентези</li></a>
					<a href="#"><li>Драма</li></a>
					<a href="#"><li>Биоргафия</li></a>
				</ul>
			</div>
		</div>
	</section>