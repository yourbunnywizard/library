<form action="http://localhost/library/app/models/authorization.php" class="authorization" name="authorization" method="post">

	<span>Вход</span>

	<input name="action_type" type="hidden" value="log_in">
	<label>Логин<input name="login" type="text"></label>
	<label>Пароль<input name="password" type="password"></label>

	<input type="submit">

</form>

<form action="http://localhost/library/app/models/authorization.php" class="registration" name="authorization" method="post">

	<span>Регистрация</span>

	<input name="action_type" type="hidden" value="sign_in" disabled="disabled">
	<label>Псевдоним<input name="nickname" type="text"></label>

	<label>Логин<input name="login" type="text"></label>
	<label>Пароль<input name="password" type="password"></label>

	<input type="submit">

</form>