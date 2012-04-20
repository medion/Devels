<?if (isset($error_admin_useredit_empty)) {
	echo $error_admin_useredit_empty;
}

//print_r($data);
?>

<a href='/admin/users'>Список користувачів</a>

<form action="/admin/useredit/<?=$data['id']?>" method="POST">
    <p>Логін:<br><input type="text" name="username" maxlength="255" value="<?=$data['username']?>" size="100"></p>
	<p>Пароль:<br><input type="text" name="password" maxlength="255" value="" size="100"></p>
	<p>Хеш пароля: <?=$data['password']?></p>
	<p>E-mail:<br><input type="text" name="email" maxlength="255" value="<?=$data['email']?>" size="100"></p>
	<p>Імя:<br><input type="text" name="name" maxlength="255" value="<?=$data['name']?>" size="100"></p>
	<p><select name="rules">
		<option <? if(isset($s0)) {echo $s0;}?> value="0">Користувач</option>
		<option <? if(isset($s1)) {echo $s1;}?> value="1">Редактор</option>
		<option <? if(isset($s2)) {echo $s2;}?> value="2">Адмін</option>
		<option <? if(isset($s3)) {echo $s3;}?> value="3">Забанний</option>
	</select></p>
	<input type="submit" value="Редагувати">
</form>