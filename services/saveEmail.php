<?php
$error = "";
$servername = "localhost";
$database = "emailslanding";
$username = "root";
$password = "";
$sql = "mysql:host=$servername;dbname=$database;";
$dsn_Options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
try {
    $my_Db_Connection = new PDO($sql, $username, $password, $dsn_Options);
} catch (PDOException $error) {
    echo 'Connection error: ' . $error->getMessage();
}
$email = $_POST['thisemail'];

if (empty($_POST['thisemail'])) {
    $error = "Ingrese su email";
} else {
    $email = $_POST['thisemail'];
}
$saveEmail = $my_Db_Connection->prepare("INSERT INTO useremails (email) VALUES (:email)");
$saveEmail->bindValue(':email', $email);

if (empty($error)) {
    $saveEmail->execute();
    $output = json_encode(array('type' => 'message', 'text' => "email agregado"));
    die($output);
} else {
    $output = json_encode(array('type' => 'error', 'text' =>  $error));
    die($output);
}
