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

function cutText($string, $maxlen) {
    $len = (mb_strlen($string) > $maxlen)
        ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
        : $maxlen
    ;
    $cutText = mb_substr($string, 0, $len);
    return (mb_strlen($string) > $maxlen)
        ? $cutText . '...'
        : $cutText
    ;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Новости</title>
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

$lng = $_SESSION['lang'];
foreach($data['news'] as $key => $value)
{
    print_r("<div class='news_block'><h4><a href='news/view/".$value['id']."'>".$value['title_'.$lng]."</a></h4>"
                .cutText($value['text_'.$lng], 150)."<br /><a href='news/view/".$value['id']."'>Читати далі</a></div>");
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

	<?=$admin?>
	
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