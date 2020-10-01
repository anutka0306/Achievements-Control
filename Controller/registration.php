<?php
include '../Connect/db_connect.php';
$error = array();

if(empty($_POST['email'])){
    $error[] = "Empty email";
}else{
    $email = trim(mysqli_real_escape_string($mysqli, $_POST['email']));
}

if(empty($_POST['name'])){
    $error[] = "Empty name";
}else{
    $name = trim(mysqli_real_escape_string($mysqli, $_POST['name']));
}

if(empty($_POST['password'])){
    $error[] = "Empty password";
}else{
    $password = md5($_POST['password']);
}



// Если форма пришла без ошибок, проверяем уникальность email
if(empty($error)){
    $sql = "SELECT id FROM users WHERE email = '{$email}'";
    if(mysqli_query($mysqli, $sql)->num_rows > 0){
        $error[] = "No unique email";
        var_dump($error);
    }else{
       mysqli_query($mysqli, "INSERT INTO users (`email`, `name`, `password`) VALUES ('{$email}', '{$name}', '{$password}')") or  die("INSERT INTO users (`email`, `name`, `password`) VALUES ('{$email}', '{$name}', '{$password}')");
        echo "ВЫ зарегались";
    }

}
// Если форма пришла с ошибками
else{
    var_dump($error);
}