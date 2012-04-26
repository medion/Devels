<p><a href="/news/view/<?=$news?>">Повернутися до новини</a></p>

<?
//print_r($vote);
if (empty($vote)) {
    echo 'Голосів немає';
} else {
    foreach($vote as $key => $value)
    {
        print_r('Користувач: <strong>'.$value['username']['username'].'</strong> оцінка: '.$value['vote'].' <a href="/vote/del/'.$value['id'].'">Видалити</a><br>');
    }
}

?>