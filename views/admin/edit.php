<?
switch($_SESSION['lang']) :
   default: include('./ua.php'); break;
   case 'ru': include('./ru.php'); break;
   case 'en': include('./en.php'); break;
endswitch;

if (isset($error_admin_edit_empty)) {
	echo $error_admin_edit_empty;
}
?>

<form action="/admin/edit/<?=$data['id']?>" method="POST">
    <p><?=$lang['admin_news_title_add_ua']?>:<br><input type="text" name="title_ua" maxlength="255" size="100" value="<?=$data['title_ua']?>"></p>
    <p><?=$lang['admin_news_text_add_ua']?>:<br><textarea name="text_ua" rows="20" cols="100"><?=$data['text_ua']?></textarea></p>
	<p><?=$lang['admin_news_title_add_en']?>:<br><input type="text" name="title_en" maxlength="255" size="100" value="<?=$data['title_en']?>"></p>
    <p><?=$lang['admin_news_text_add_en']?>:<br><textarea name="text_en" rows="20" cols="100"><?=$data['text_en']?></textarea></p>	
	<input type='submit' value='Редагувати новину'>
</form>