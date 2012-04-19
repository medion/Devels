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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="http://devels.loc/views/style.css" type="text/css" media="all" />
</head>
<body>
<div class="body1">
	<div class="body2">
		<div class="main">
<!-- / header-->
<!-- content -->
<h2><?=$lang['reg_title']?></h2>
<div style="width:350px; text-align: right;">
<?php if (!isset($reg_already_registered)) {?>
<div style="color: red;">
<?php if (isset($error_empty)) {echo $lang['reg_error_empty']; }
      if (isset($error_max_lenght)) {echo $lang['reg_error_max_lenght']; }
      if (isset($error_password_repeat)) {echo $lang['reg_error_password_repeat']; }
      if (isset($error_login_isset)) {echo $lang['reg_error_login_isset']; }
      ?>
</div>
<form action="/user/registration" method="POST">
    <p><?=$lang['reg_username']?>: <input type="text" name="username" maxlength="20" value="<?=$username?>"></p>
    <p><?=$lang['reg_password']?>: <input type="text" name="password"></p>
    <p><?=$lang['reg_password_again']?>: <input type="text" name="password_again"></p>
    <p><?=$lang['reg_firstname']?>: <input type="text" maxlength="30" name="firstname" value="<?=$firstname?>"></p>
    <p><?=$lang['reg_surname']?>: <input type="text" maxlength="30" name="surname" value="<?=$surname?>"></p>
    <p><input type="submit" value="<?=$lang['reg_button']?>"></p>
</form>
    <?} else {
      echo $lang['reg_already_registered'];
}?>

</div>
<!-- / content -->
		</div>
	</div>
</div>
</body>
</html>