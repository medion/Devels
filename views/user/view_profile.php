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

    <p>Профіль користувача</p>
 
 
    Логін: <?=$profile['username']?><br>
    Ваше імя: <?=$profile['name']?><br>

    Аватра: <img src="/uploads/avatar/<?=$profile['avatar']?>"><br>

    Дата реєстрації: <?=$profile['firstlogin']?><br>
    Останній раз Ви відвідали сайт: <?=$profile['lastlogin']?><br>



    <?php
    if (!empty($profile['my_profile'])):?>
    Редагувати профіль: <a href="/user/edit">Редагувати профіль</a>
    <?endif;?>

</div>
<div class="sidebar">
	<div class="auth">
	<a href="/ua">UA</a> <a href="/ru">RU</a> <a href="/en">EN</a><br />
	<?php
		if (isset($_SESSION['user_id'])) {
			echo "ID: ".$_SESSION['user_id']."<br />";
		}
	?>
	
	<a href="/user/profile"><?=$lang['profile']?></a>
	<br>
	<?=$admin?>
	
	<?=$rules_link['rules_link']?>
	
	<?=$_SESSION['rules']?>
				
	<?php
	if ($this->loggedin()) {
		echo "<br /><a href='/user/logout'>".$lang['user_exit']."</a>";
	} else {
		print_r("<h2>".$lang['sidebar_login_title']."</h2>
		<form action='/user/login' method='post'>
			<input type='text' name='username'>
			<input type='text' name='password'>
			<input type='submit' value='".$lang['sidebar_login_button']."'> <a href='/user/registration'>".$lang['sidebar_reg_button']."</a>
		</form>");
	}
	?>
	</div>
</div>
</div>
</body>
</html>