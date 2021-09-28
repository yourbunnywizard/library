<?php 
	require('fragment-header.php');
 ?>

<div class="container" style="margin-top: 40px;">
	<h2 style="margin-bottom: 40px;">Регистрация</h2>
	<div class="row">
		<div class="col-12">
			<div class="infopanel">
				<p>имя</p>
				<input type="text" id="user-name">
				<p>фамилия</p>
				<input type="text" id="user-surname">
				<p>отчество</p>
				<input type="text" id="user-patronymic">			
				<p>дата рождения</p>
				<input type="date" id="user-birth">
				<p>номер телефона (0939034634)</p>
				<input type="number" max=10 id="user-number">
				<p>никнейм(отображается на сайте)</p>
				<input type="text" id="user-nickname">
				<p>логин</p>
				<input type="text" id="user-login"/>
				<p>пароль</p>
				<input type="text" id="user-password">
			</div>
		</div>

		<div class="col-12">
			<div class="holdbutton" style="margin-top: 25px;">
				<button id="registration">Зарегестрироваться</button>
			</div>
		</div>
		
	</div>
</div>

<script>
	
	$('#registration').click(function() {
		var sendData = {};
		sendData.action_type = 'sign_in';
		sendData.name = $('#user-name').val();
		sendData.surname = $('#user-surname').val();
		sendData.patronymic = $('#user-patronymic').val();
		sendData.birth = $('#user-birth').val();
		sendData.phone = $('#user-number').val();
		sendData.nickname = $('#user-nickname').val();
		sendData.login = $('#user-login').val();
		sendData.password = $('#user-password').val();

		$.ajax({
			type: 'POST',
			url: 'app/models/authorization.php',
			data: sendData,
			success: function(data) {
				if (parseInt(data) === 1) { document.location.reload(); }
					else alert(data);	
			}
		});
	});

</script>


 <?php 
	require('fragment-footer.php');
 ?>