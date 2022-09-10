<?php
$conn_str= mysqli_connect('localhost', 'root', '');
mysqli_query($conn_str, "CREATE DATABASE `new_db3` CHARACTER SET utf8 COLLATE utf8_general_ci;");
if (mysqli_select_db($conn_str,"new_db3"))
{
    mysqli_query($conn_str,"CREATE TABLE  `new_db3`.`tests` (`id` INT NOT NULL AUTO_INCREMENT ,`test` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (  `id` ));");
    echo "База данных успешно создана";
}
else
{
    echo "База данных не создана";
}
mysqli_close($conn_str);
?>
