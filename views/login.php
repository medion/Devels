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

function cutString($string, $maxlen) {
     $len = (mb_strlen($string) > $maxlen)
         ? mb_strripos(mb_substr($string, 0, $maxlen, 'utf-8'), ' ')
         : $maxlen
     ;
     $cutStr = mb_substr($string, 0, $len);
     return (mb_strlen($string) > $maxlen)
         ? $cutStr . '...'
         : $cutStr 
     ;
 }
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
<div style="color: red;">
<?php if (isset($error_empty_login_pass)) {echo $lang['error_empty_login_pass']; }
      if (isset($error_invalid_login_pass)) {echo $lang['error_invalid_login_pass']; }?>
</div>
<form action='/user/login' method='post'>
    <input type='text' name='username'>
    <input type='text' name='password'><br>
    <input type='submit' value='<?=$lang['sidebar_login_button']?>'>
</form>


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