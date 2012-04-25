<?php
session_start();
require 'load.php';
require 'lang.php';
require 'model.php';
require 'connect.inc.php';

// Мова за замовчуванням
$_SESSION['lang'] = isset($_SESSION['lang']) ? $_SESSION['lang'] : 'ua';

// РОУТЕР
$mRequestUri = $_SERVER["REQUEST_URI"];

// Зміна мови
if(($mRequestUri == '/ua')||($mRequestUri == '/ru')||($mRequestUri == '/en'))
{
    switch($mRequestUri) :
    case '/ua':
        unset($_SESSION['lang']);
        $_SESSION['lang'] = 'ua';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        break;
    case '/ru':
        unset($_SESSION['lang']);
        $_SESSION['lang'] = 'ru';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        break;
    case '/en':
        unset($_SESSION['lang']);
        $_SESSION['lang'] = 'en';
        header('Location: '.$_SERVER['HTTP_REFERER']);
        break;
    endswitch;
}
else
{
    // Відкриваємо потрібну сторінку
    if ($mRequestUri == '/') {
        require 'home.php';
        new Home($mRequestUri);
    } else {
        $mRequestUri = substr($mRequestUri, 1);
        $array = explode('/', $mRequestUri);
        if ($array[0] == 'news') {
            require 'news.php';
            new News($array[0],$array[1],$array[2]);
        } else if ($array[0] == 'user') {
            require 'users.php';
            new Users($array[1],$array[2]);
        } else if ($array[0] == 'page') {
            require 'pages.php';
            new Pages($array[1]);
        } else if ($array[0] == 'admin') {
            require 'admin.php';
            new Admin($array[1],$array[2]);
        } else if ($array[0] == 'comment') {
            require 'comment.php';
            new Comment($array[0],$array[1],$array[2]);
        } else if ($array[0] == 'vote') {
            require 'vote.php';
            new Vote($array[0],$array[1],$array[2]);
        } else if ($array[0] == '404') {
            require '404.php';	
        } else {
            header('Location: 404');
        }
    }
	
	
	
	

	
	
	
}