<!doctype html>
<html>
<head>
<title>Lab8_1</title>
<meta charset="utf-8">
<style>
table {width: 600px; border: 1px solid #ccc; border-collapse: collapse;
margin: 10px;}
td, th {padding: 5px; border: 1px solid #ccc;}
th {font-weight: bold; background: #e3edf7}
label {display: block; width: 300px; margin: 5px 0}
input[type=text], textarea, select {width: 350px; padding: 5px;}
input[type=submit] {width: 100px; border-radius: 2px; padding: 5px;
border: 1px solid #ffa71c;
background: #ffbe32;
color: #fff}
.main_form {
width: 380px;
padding: 10px;
margin: 10px;
border-radius: 5px;
border: 1px solid #ffa71c;
background: #fff4a1;
}
.tab{ float:right;}
.forms{display:inline-block;}
</style>
</head>
<body>
<?php
$script_name = $_SERVER['PHP_SELF'];
try {
 $db = new PDO("mysql:host=localhost;dbname=ryilov", "ryilov", "xEqUye4a",
array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
 }
catch(PDOException $e)
 {
 echo $e->getMessage();
 die("Ошибка подключения.");
 }
$sections = $db->query("SELECT id, s_name FROM sections ORDER BY s_order")->fetchAll();
?>

<div class = "forms">
<div class="main_form">
<form action="lab8_1_1.php" method="post">
<label>Раздел<br/><select name="sections">
<?php
foreach ($sections as $section) {
echo "<option value=\"$section[id]\">$section[s_name]</section>";
}
?>
</select>
</label>
<label>ФИО<br/><input type="text" name="fio"></label>
<label>Название<br/><input type="text" name="title"></label>
<label>Сообщение<br/><textarea name="t_area"></textarea></label>
<input type="submit" value="Отправить">
</form>
</div>


<div class="main_form">
<form action="lab8_1_2.php" method="post">
<label>Имя раздела<br/><input type="text" name="sections"></label>
<label>Номер для сортировки<br/><input type="text" name="ordernum"></label>
<input type="submit" value="Отправить">
</form>
</div>
</div>


<?php
$sql = "
SELECT s_name, fio, title, message, DATE_FORMAT(m_time,'%d-%m-%Y, %H:%i:%S') AS
format_time
FROM messages
INNER JOIN sections ON messages.section_id = sections.id
ORDER BY m_time DESC";
$result = $db->query($sql);
if ($result && $result->rowCount() > 0) {
?>
<table class ="tab">
<thead>
<tr><th>Время</th><th>Фамилия, имя</th><th>Раздел</th><th>Название</th><th>Текст
сообщения</th></tr>
</thead>
<?php
while ($row = $result->fetch()) {
echo "<tr><td>$row[format_time]</td><td>$row[fio]</td>
<td>$row[s_name]</td><td>$row[title]</td><td>$row[message]</td></tr>";
}
?>
</table>
<?php
} else {
echo "<p>Данных в таблице сообщений нет.</p>";
}
?>
</body>
</html>