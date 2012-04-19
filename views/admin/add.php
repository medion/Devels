<?if (isset($error_admin_add_empty)) {
	echo $error_admin_add_empty;
}
?>
<form action="/admin/add" method="POST">
    <p>Заголовок:<br><input type="text" name="title" maxlength="255" size="100"></p>
    <p>Текст:<br><textarea name="text" rows="20" cols="100"></textarea></p>
	<input type='submit' value='Додати новину'>
</form>