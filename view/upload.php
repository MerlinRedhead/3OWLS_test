<?php
$host='localhost';
$user='root';
$pass='';

$link = mysqli_connect($host, $user, $pass);

mysqli_select_db($link,'3OWLS');
$image = $_FILES['image'];
$imagename=$_FILES["image"]["name"];
$imagetype =  ["image/jpeg", "image/png"];


if (!in_array($image["type"], $imagetype)) {
    die('Incorrect file type');
}
//Вставляем имя изображения в бд
$insert_image="INSERT INTO `images`(`imagename`) VALUE ('{$imagename}')";


if (!mysqli_query($link,$insert_image)){
    echo 'error with db';


}




//Проверка файла на сервере
if (!empty($_FILES['image'])){
    $pathFile = __DIR__.'/uploads'.$imagename;

// создаем папку uploads в корне проекта, если её нет
    if (!is_dir('../uploads')) {
        mkdir('../uploads', 0777, true);
    }


    if (!in_array($image["type"], $imagetype)) {
        die('Incorrect file type');
    }

    if (!move_uploaded_file($image["tmp_name"], "../uploads/" . $imagename)) {
        die('Error upload file');
    }

}
header("location: index.php");
?>
