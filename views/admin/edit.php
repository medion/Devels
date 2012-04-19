<?if (isset($error_admin_edit_empty)) {
	echo $error_admin_edit_empty;
}
?>
<form action="/admin/edit/<?=$data['id']?>" method="POST">
    <p>Заголовок:<br><input type="text" name="title" maxlength="255" value="<?=$data['title_ua']?>" size="100"></p>
    <p>Текст:<br><textarea name="text" rows="20" cols="100"><?=$data['text_ua']?></textarea></p>
	<input type='submit' value='Редагувати новину'>
</form>