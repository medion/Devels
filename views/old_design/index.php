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
<html>
<head>
<title>Home</title>
<meta charset="utf-8">
<link rel="stylesheet" href="http://devels.loc/css/reset.css" type="text/css" media="all">
<link rel="stylesheet" href="http://devels.loc/css/layout.css" type="text/css" media="all">
<link rel="stylesheet" href="http://devels.loc/css/style.css" type="text/css" media="all">
</head>
<body id="page1">
<div class="main">
<!-- header -->
	<header>
		<nav>
			<ul id="menu">
                            <li id="menu_active"><a href="/"><?=$lang['header_home']?></a></li>
                            <li><a href="news"><?=$lang['header_news']?></a></li>
                            <li class="bg_none"><a href="/page/contacts"><?=$lang['header_contacts']?></a></li>
			</ul>
		</nav>
		<ul id="icon">
			<li><a href="#"><img src="images/icon1.jpg" alt=""></a></li>
			<li><a href="#"><img src="images/icon2.jpg" alt=""></a></li>
			<li><a href="#"><img src="images/icon3.jpg" alt=""></a></li>
			<li><a href="#"><img src="images/icon4.jpg" alt=""></a></li>
			<li><a href="#"><img src="images/icon5.jpg" alt=""></a></li>
		</ul>
	</header>
</div>
<div class="body1">
	<div class="body2">
		<div class="main">
			<h1><a href="index.html" id="logo"></a></h1>
<!-- / header-->
<!-- content -->
			<section id="content">
				<div class="wrapper marg_left1">
					<article class="col1">
						<h2><?=$lang['welcome']?></h2>
						<p><?=$lang['welcome_text']?></p>

<h2><?=$lang['news_main']?></h2>         
<ul>
<?php
//print_r($data);
$lng = $_SESSION['lang'];

foreach($data['news'] as $key => $value)
{
    print_r("<li class='under'>
                <h4><a href='news/view/".$value['id']."'>".$value['title_'.$lng]."</a></h4>"
                .cutString($value['text_'.$lng], 150)."<br><a href='news/view/".$value['id']."'>Читати далі</a>
			</li>");
}
?>
</ul>
                                                
                                                            
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
                                                
					</article>
					<article class="col2 pad_left1">
                                             <a href="/ua">UA</a> <a href="/ru">RU</a> <a href="/en">EN</a>
                                                <br>
                                                <?php
                                                if (isset($_SESSION['user_id'])) {
                                                    echo "ID: ".$_SESSION['user_id'];
                                                }
                                                ?>
												
												<?= $admin ?>
												
                                            
            <?php
            
            if ($this->loggedin()) {
                echo 'Your authorized!';
                echo "<br><a href=\"/user/logout\">Log Out</a>";
            } else {
                print_r("<h2>".$lang['sidebar_login_title']."</h2>
                                                <form action='/user/login' method='post'>
                                                    <input type='text' name='username'>
                                                    <input type='text' name='password'>
                                                    <input type='submit' value='".$lang['sidebar_login_button']."'> <a href='/user/registration'>Реєстрація</a>
                                                </form>");
            }
            ?>
            
            
                                                
                    
                    
                    
					</article>
				</div>
				<div class="wrapper">
					<article class="col1"><a href="http://devels.loc/news" class="button"><?=$lang['news_all']?></a></article>
				</div>
			</section>
<!-- / content -->
		</div>
	</div>
</div>
<div class="body3">
	<div class="main">
<!-- footer -->
		<footer>
			<a rel="nofollow" href="http://www.templatemonster.com/" target="_blank">Website template</a> designed by TemplateMonster.com<br>
			<a href="http://www.templates.com/product/3d-models/" target="_blank">3D Models</a> provided by Templates.com
		</footer>
<!-- / footer -->
	</div>
</div>
</body>
</html>