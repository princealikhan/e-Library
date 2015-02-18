<?php

if(!$_POST['page']) die("0");

$page = (int)$_POST['page'];

if(file_exists('pages/page_'.$page.'.html'))
echo file_get_contents('pages/page_'.$page.'.html');

else echo 'There is no such page!';
?>
