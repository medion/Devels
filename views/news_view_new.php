<?php

switch($_SESSION['lang']) :
   default: include('./ua.php'); break;
   case 'ru': include('./ru.php'); break;
   case 'en': include('./en.php'); break;
endswitch;

   function loggedin() {
    if (isset($_SESSION['user_id'])&&!empty($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

$lng = $_SESSION['lang'];
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Home</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="http://devels.loc/views/style.css" type="text/css" media="all" />
</head>
<body>
<div class="allbody">

<div class="header">
	<a href="/">Home</a>
	<a href="/news">News</a>
	<a href="/page/contacts">Contacts</a>
</div>

<div class="content">

<?php
	print_r("<div class='news_block'><h4>".$data['title_'.$lng]."</h4>".$data['text_'.$lng]."</div>");
?>
													
<?php
	$rules = $_SESSION['rules'];
	if (isset($rules)&&$rules===1) {
		print_r("<br><a href='/admin/edit/".$data['id']."'>Редагувати</a> <a href='/admin/delete/".$data['id']."'>Видалити</a>");
		//print_r($admin);
	}
?>

</div>







<div class="sidebar">
	<div class="auth">
	<a href="/ua">UA</a> <a href="/ru">RU</a> <a href="/en">EN</a><br />
	<?php
		if (isset($_SESSION['user_id'])) {
			echo "ID: ".$_SESSION['user_id']."<br />";
		}
	?>
	
	<?=$profile?>	
	<br>
	<?=$admin?>
	
	<?=$rules_link['rules_link']?>
	
	<?=$_SESSION['rules']?>
	
	<?php
	if ($this->loggedin()) {
		echo "<br /><a href=\"/user/logout\">Log Out</a>";
	} else {
		print_r("<h2>".$lang['sidebar_login_title']."</h2>
		<form action='/user/login' method='post'>
			<input type='text' name='username'>
			<input type='text' name='password'>
			<input type='submit' value='".$lang['sidebar_login_button']."'> <a href='/user/registration'>Реєстрація</a>
		</form>");
	}
	?>
	</div>
</div>

</div>

</body>
</html>