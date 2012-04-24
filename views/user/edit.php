<?php
   function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    switch($_SESSION['lang']) :
	   case 'ua': include('./ua.php'); break;
	   case 'ru': include('./ru.php'); break;
	   case 'en': include('./en.php'); break;
	endswitch;
?>

<p><a href='/'>Головна</a></p>

<?if (isset($error_profile_edit_empty)) {
	echo $error_profile_edit_empty;
}

if ($profile_pass_change) {
	echo '<br>Ваш профіль змінено!<br>';
}
?>

<form action="/user/edit" method="POST" enctype="multipart/form-data">
    <p><?=$lang['reg_password']?>: <input type="text" name="password"></p>
    <p><?=$lang['reg_password_again']?>: <input type="text" name="password_again"></p>
    <p><?=$lang['reg_name']?>: <input type="text" maxlength="30" name="name" value="<?=$name?>"></p>
	<p>Виберіть файл для завантаження: <input type="file" name="userfile"></p>
    <p><input type="submit" value="Зберегти"></p>
</form>

<a href="/user/profile">мій профіль</a>