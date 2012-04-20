<?php

foreach($list as $key => $value)
{
	print_r ($value['username']." <a href='/admin/useredit/".$value['id']."'>Редагувати</a> <a href='/admin/userdel/".$value['id']."'>Видалити</a><br>");
}

?>