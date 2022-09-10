<?php
//подключение к бд
$link = mysqli_connect('localhost','root','','3owls');
//проверка бд,если нет,её создание
if (!$link){
    $conn_str= mysqli_connect('localhost', 'root', '');
    mysqli_query($conn_str, "CREATE DATABASE `3owls` CHARACTER SET utf8 COLLATE utf8_general_ci;");
    if (mysqli_select_db($conn_str,"3owls"))
    {
        mysqli_query($conn_str,"CREATE TABLE  `3owls`.`images` (`id` INT NOT NULL AUTO_INCREMENT ,`imagename` VARCHAR( 250 ),`updatedname` VARCHAR(250) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL , PRIMARY KEY (  `id` ));");
        echo "База данных успешно создана";
        $link = mysqli_connect('localhost','root','','3owls');
    }
    else
    {
        echo "База данных не создана";
    }
    mysqli_close($conn_str);
}
//удаление
if(isset($_GET['del'])){
    $name = $_GET['del'];
    $query = "DELETE FROM `images` WHERE `imagename` = '$name'";
    mysqli_query($link,$query);
    $pathFile = '../uploads';

    $unlink = unlink($pathFile.'/'.$name);

    if($unlink == true){ echo "получилось удалить"; } else{ echo "не получилось удалить";}
}
// Изменение названия
if (isset($_POST['Name'])) {
    if (isset($_GET['red'])) {
        $sql = mysqli_query($link, "UPDATE `images` SET `updatedname` = '{$_POST['Name']}' WHERE `id`='{$_GET['red']}'");
       if ($sql){
           echo 'Название успешно изменено!';
       }
       else{
           echo 'Ошибка!';
       }
    }
}
if (isset($_GET['red'])) {

    $flag = mysqli_query($link, "SELECT * FROM `images` WHERE `id`='{$_GET['red']}'");

}
?>

    <!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Загрузка на сервер</title>
</head>
<body>
<h2>Загрузка</h2>
<form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image">
    <input type="submit">

</form>
<hr>
<?php while ($result = mysqli_fetch_array($flag)){
?>
<form action="" method="post">
    <table>
        <tr>
            <td>Наименование:</td>
            <td><input type="text" name="Name" value="<?php if (isset($_GET['red'])){ if ($result['updatedname']!= null){ echo $result['updatedname'];}else{echo $result['imagename'];}}else{echo'';}?>"></td>
        </tr>

        <tr>
            <td colspan="2"><button type="submit" value="OK">ОК</button></td>
        </tr>
    </table>
</form>
<br>
<?php } ?>
<h3>Изображения</h3>
<hr color="black" size="5">
<div class="container">
    <div class="row">
        <?php
        $flag = mysqli_query($link,"SELECT * FROM `images`");
        while ($result = mysqli_fetch_array($flag)){
            ?>
            <div class="col-md-4">
                <td><img src="../uploads/<?= $result['imagename']; ?>" alt="" width="300" height="300"></td>
                <td><?php if ($result['updatedname']!= null){ echo $result['updatedname'];}else{echo $result['imagename'];}?></td>
                <br>



                <br>
                <button><a href="?del=<?php echo $result['imagename']; ?>">Удалить</a></button>
                <button><a href='?red=<?=$result['id']?>'>Изменить название</a></button>
                <br>
                <hr color="black">
            </div>
        <?php } ?>
    </div>
</div>

</body>
</html>

<?php


?>
