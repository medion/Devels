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

function cutString($string, $maxlen) {
     $len = (mb_strlen($string) > $maxlen)
         ? mb_strripos(mb_substr($string, 0, $maxlen), ' ')
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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
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

<?php
    print_r("<div class='news_block'><h4>".$data['title_'.$lng]."</h4>".$data['text_'.$lng]."</div>");
?>
<?php
    $rules = $_SESSION['rules'];
    if (isset($rules)&&$rules == 1||$rules == 2) {
        print_r("<br><a href='/admin/edit/".$data['id']."'>Редагувати</a> <a href='/admin/delete/".$data['id']."'>Видалити</a>");
    }
?>

    <div>Додати коментар:</div>
    
    <? if (isset($comm_form)):?>
    <? if (isset($error['comm_empty_field'])) {echo $lang['comm_empty_field']; }
        if (isset($error['comm_add'])) {echo $lang['comm_add']; }
    ?>
    <form action='/news/view/<?=$data['id']?>' method='post'>
        <p>Тема: <input type='text' name='title'></p>
        <p>Текст: <input type='text' name='text'></p>
        <input type='hidden' name='user_id' value='1'>
        <input type='submit' value='Додати коментар'>
    </form>
    <?else:?>
    <p>Ви повинні авторизуватися щоб додати коментар.</p>
    <?endif;?>
    
    <div>Коментарі до новин:</div>
    <?php
    if (isset($comments))
    {
        //print_r($comments);
        $rules_comm = $_SESSION['rules_comm'];
        foreach($comments as $comment => $value)
        {
            print_r("<div style=\"border:1px solid gray;\">".'<p>'.'Користувач: '.'<a href=/user/view_profile/'.$value['user_id'].'>'.$value['username'].'</a></p>'.'<p>Тема: '.$value['title'].'</p>'.'<p>Текст: '.$value['text'].'</p>Додано: '.$value['publication'].'</div>');
            if (isset($rules_comm)&&$rules_comm == 2) {
                print_r("<a href='/comment/del/".$value['id']."'>Видалити</a>");
            }
            echo '';
        }
    } else {
        echo 'Ваш коментар буде першим.';
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
		echo "<br /><a href=\"/user/logout\">".$lang['user_exit']."</a>";
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