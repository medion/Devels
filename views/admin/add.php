<?
switch($_SESSION['lang']) :
	case 'ua': include('./ua.php'); break;
	case 'ru': include('./ru.php'); break;
	case 'en': include('./en.php'); break;
endswitch;

if (isset($admin_news_empty_add)) {
	echo $lang['admin_news_empty_add'];
}

?>
<form action="/admin/add" method="POST">
    <p><?=$lang['admin_news_title_add_ua']?>:<br><input type="text" name="title_ua" maxlength="255" size="100"></p>
    <p><?=$lang['admin_news_text_add_ua']?>:<br><textarea name="text_ua" rows="20" cols="100"></textarea></p>
	<p><?=$lang['admin_news_title_add_en']?>:<br><input type="text" name="title_en" maxlength="255" size="100"></p>
    <p><?=$lang['admin_news_text_add_en']?>:<br><textarea name="text_en" rows="20" cols="100"></textarea></p>	
	<input type='submit' value="<?=$lang['admin_news_add_button']?>"
	
</form>