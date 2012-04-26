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

    <? if (isset($_SESSION['user_id'])):?>
        <p><?=$lang['profile_title']?></p>
        <?=$lang['profile_login']?>: <?=$profile['username']?><br>
        <?=$lang['profile_name']?>: <?=$profile['name']?><br>
        <?=$lang['profile_avatar']?>: <img src="/uploads/avatar/<?=$profile['avatar']?>"><br>
        <?=$lang['profile_date_reg']?>: <?=$profile['firstlogin']?><br>
        О<?=$lang['profile_last_login']?>: <?=$profile['lastlogin']?><br>
        <p><a href="/user/edit"><?=$lang['profile_edit']?></a></p>
        <p><a href="/user/delprofile"><?=$lang['profile_del']?></a></p>
    <?else:?>
        <p><?=$lang['error_must_reg']?></p>
    <?endif?>

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