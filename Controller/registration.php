<?php
include '../Connect/db_connect.php';
$error = array();
$message = '';

if(empty($_POST['email'])){
    $error[] = "Empty email";
}else{
    $email = trim(mysqli_real_escape_string($mysqli, $_POST['email']));
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == false){
        $error[] = "Email is not valid";
    }
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
        $message = "No unique email";
        echo '<div class="alert alert-danger" role="alert">'.$message. '</div>';

    }else{
       mysqli_query($mysqli, "INSERT INTO users (`email`, `name`, `password`) VALUES ('{$email}', '{$name}', '{$password}')") or  die("INSERT INTO users (`email`, `name`, `password`) VALUES ('{$email}', '{$name}', '{$password}')");
        $message =  "ВЫ зарегались";
        echo '<div class="alert alert-primary" role="alert">'.$message. '</div>';
    }

}
// Если форма пришла с ошибками
else{
    foreach ($error as $item){
       $message .= $item . '<br>';
    }
    echo '<div class="alert alert-danger" role="alert">'.$message. '</div>';
}

