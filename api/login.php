<?php

$email = $_GET['email'];
$password = $_GET['password'];

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

$con = mysqli_connect('localhost', 'root', '', 'database_comune');

if (mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " : " . mysqli_connect_errno();
    exit($msg);
}

$sql = "SELECT * FROM `utenti` WHERE `email` = '" . $email . "' AND `password` = '" . $password . "'";

$res = mysqli_query($con, $sql);
$array = mysqli_fetch_array($res);
$result = array('id' => $array['id'],
    'nome' => $array['nome'],
    'cognome' => $array['cognome']);
$output = json_encode($result, JSON_PRETTY_PRINT);

echo $output;
mysqli_close($con);
