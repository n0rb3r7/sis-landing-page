<?php
$servername = "localhost";
$database = "emailslanding";
$username = "root";
$password = "";
$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$error = "";
try {
    $db_connection = new PDO($sql, $username, $password, $dsn_Options);
} catch (PDOException $error) {
    echo 'Connection error: ' . $error->getMessage();
}

if (empty($_POST['thisemail'])) {
    $error = "Ingrese su email";
} else {
    if (!filter_var($_POST['thisemail'], FILTER_VALIDATE_EMAIL)) {
        $error = "Email incorrecto";
    }
    $email = $_POST['thisemail'];
}
$checkEmail = $db_connection->prepare("SELECT * FROM useremails WHERE email=:email");
$checkEmail->bindParam(':email', $email);
$checkEmail->execute();
if ($checkEmail->rowCount() != 0) {
    $error = "Email ya registrado, intente con otro.";
} else {
    $saveEmail = $db_connection->prepare("INSERT INTO useremails (email) VALUES (:email)");
    $saveEmail->bindValue(':email', $email);
    $saveEmail->execute();
}
if (empty($error)) {
    $output = json_encode(array('type' => 'message', 'text' => "¡Muchas gracias! Hemos registrado su email."));
    die($output);
} else {
    $output = json_encode(array('type' => 'error', 'text' =>  $error));
    die($output);
}
