<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-type: application/json");

if ($_COOKIE['id'] != null) {
    $result = array('id' => $_COOKIE['id'],
        'nome' => $_COOKIE['nome'],
        'cognome' => $_COOKIE['cognome']);
    echo json_encode($result, JSON_PRETTY_PRINT);
}
else {
    $email = $_POST['email'];
    $password = $_POST['password'];

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

    if ($array['id'] != null) {
        setcookie("id", $array['id'], strtotime("+1 year"));
        setcookie("nome", $array['nome'], strtotime("+1 year"));
        setcookie("cognome", $array['cognome'], strtotime("+1 year"));

    } else {
        unset($_COOKIE['id']);
        unset($_COOKIE['nome']);
        unset($_COOKIE['cognome']);
    }

    mysqli_close($con);
    echo json_encode($result, JSON_PRETTY_PRINT);
}