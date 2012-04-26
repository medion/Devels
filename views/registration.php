<?php
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
<div class="allbody">
<div class="header">
	<a href="/"><?=$lang['header_home']?></a>
	<a href="/news"><?=$lang['header_news']?></a>
	<a href="/page/contacts"><?=$lang['header_contacts']?></a>
</div>
<div class="content">
<!-- content -->
<h2><?=$lang['reg_title']?></h2>
<div style="width:350px; text-align: right;">
<?php if (!isset($reg_already_registered)) {?>
<div style="color: red;">
<?php if (isset($error_empty)) {echo $lang['reg_error_empty']; }
      if (isset($error_max_lenght)) {echo $lang['reg_error_max_lenght']; }
      if (isset($error_password_repeat)) {echo $lang['reg_error_password_repeat']; }
      if (isset($error_login_isset)) {echo $lang['reg_error_login_isset']; }
      if (isset($error_email_error)) {echo $lang['error_email_error']; }
      if (isset($error_email_isset)) {echo $lang['reg_error_email_isset']; }
	  if (isset($error_image_type)) {echo $lang['error_image_type']; }
      ?>
</div>
<form action="/user/registration" method="POST" enctype="multipart/form-data">
    <p><?=$lang['reg_username']?>: <input type="text" name="username" maxlength="20" value="<?=$username?>"></p>
    <p><?=$lang['reg_password']?>: <input type="password" name="password"></p>
    <p><?=$lang['reg_password_again']?>: <input type="password" name="password_again"></p>
	<p><?=$lang['reg_email']?>: <input type="text" maxlength="30" name="email" value="<?=$email?>"></p>
    <p><?=$lang['reg_name']?>: <input type="text" maxlength="30" name="name" value="<?=$name?>"></p>
	<p><?=$lang['reg_load_avatar']?>: <input type="file" name="avatar"></p>
    <p><input type="submit" value="<?=$lang['reg_button']?>"></p>
</form>
    <?} else {
      echo $lang['reg_already_registered'];
}?>

</div>
<!-- / content -->
</div>
<div class="sidebar">
	<div class="auth">
	<a href="/ua">UA</a> <a href="/ru">RU</a> <a href="/en">EN</a><br />
	<?php
		if (isset($_SESSION['user_id'])) {
			echo "ID: ".$_SESSION['user_id']."<br />";
		}
	?>

	</div>
</div>
</div>
</body>
</html>