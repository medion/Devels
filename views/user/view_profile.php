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