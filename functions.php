<?php
//Mysql запрос без возврата данных
function queryNoreturn($link, $query)
{
	//$GLOBALS['global']++;
	global $global;
	$global++;
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
}

//Mysql запрос с возвратом данных
function queryReturn($link, $query)
{
	global $global;
	$global++;
	//$GLOBALS['global']++;
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	return $result;
}
//подключение к бд
function dbConnect()
{
	$mysql_server = "fdb16.atspace.me";
	$mysql_user = "2345958_test";
	$mysql_user_password = "qwerty05411196";

	$link = mysqli_connect($mysql_server, $mysql_user, $mysql_user_password, '2345958_test') or die("Ошибка подключения к БД" . mysqli_error($link));

	mysqli_set_charset($link, 'utf-8' );
	queryNoreturn($link, "SET NAMES utf8");

	return $link;
}

//Рандомный guid
function generate_guid()
{
        if (function_exists('com_create_guid'))
		{
        return com_create_guid();
        }
		else
		{
        mt_srand((double)microtime()*10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);
        $uuid = substr($charid, 0, 8).$hyphen
        .substr($charid, 8, 4).$hyphen
        .substr($charid,12, 4).$hyphen
        .substr($charid,16, 4).$hyphen
        .substr($charid,20,12);
        return $uuid;
        }
}


//Функционал для явы
if(isset($_POST['type']) AND $_POST['type'] == "forjava")
{
//редактирование
if($_POST['action'] == "edit")
	{  	
		$link = dbConnect();
		$name = $_POST['name'];
		$lastname = $_POST['lastname'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$id = $_POST['id'];
		queryNoreturn($link, "UPDATE `user` SET `name`='$name',`lastname`='$lastname',`email`='$email',`age`='$age' WHERE `id`='$id'");
	}	
//Создание
if($_POST['action'] == "create")
	{  	
		$link = dbConnect();
		$name = $_POST['name'];
		$lastname = $_POST['lastname'];
		$age = $_POST['age'];
		$email = $_POST['email'];
		$guid = generate_guid();
		queryNoreturn($link, "INSERT INTO `user`(`guid`,`name`, `lastname`, `email`, `age`) VALUES ('$guid','$name','$lastname','$email','$age')");
	}	
	
//Удаление	
if($_POST['action'] == "del")
	{  	
		$link = dbConnect();
		$id = $_POST['id'];
		queryNoreturn($link, "DELETE FROM `user` WHERE `id`= '$id'");
	}		

}	
	
//Возвращает таблицу 
function listoftable($link)
{
	$query_all = "SELECT * FROM `user`";
	$result_all = queryReturn($link, $query_all); 
	$rows_all = mysqli_num_rows($result_all);
	
	if($rows_all > 0)
	{
		for($i = 0; $i < $rows_all; $i++)
		{ 
		$row = mysqli_fetch_assoc($result_all);
		echo "<tr>";
			echo "
				<td>$row[name]</td>
				<td>$row[lastname]</td>
				<td>$row[age]</td>
				<td>$row[email]</td>
				<td class='center'>
				<i class='edit a_pointer' aria-hidden='true'>Редактировать</i>
				&nbsp;&nbsp;
				<i class='delete a_pointer'>Удалить</i>
				</td>
				<td>$row[id]</td>
				</tr>
			";
		}
	}
}	
?>