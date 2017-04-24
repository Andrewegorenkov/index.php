<?php
include "./functions.php";
$file_handle = fopen("mates.json", "r");
$line = file_get_contents('mates.json');
$cart = json_decode( $line, true );
//print_r ($cart);
$l = count ($cart);
For($i=0;$i<$l;$i++)
{
echo "Добавлен пользователь";
echo " ИД : ".$cart[$i]['guid'];
echo " Возраст : ".$cart[$i]['age'];
echo " Имя : ".$cart[$i]['name']['first'];
echo " фамилия : ".$cart[$i]['name']['last'];
echo " мыло : ".$cart[$i]['email'];
echo "<br>";
$guid = $cart[$i]['guid'];
$age = $cart[$i]['age'];
$name = $cart[$i]['name']['first'];
$lastname = $cart[$i]['name']['last'];
$email = $cart[$i]['email'];
$link = dbConnect();
queryNoreturn($link, "INSERT INTO `user`(`guid`,`name`, `lastname`, `email`, `age`) VALUES ('$guid','$name','$lastname','$email','$age')");
}
//unlink('mates.json');
?>