<?php
session_start();
//print_r($_POST);
$error = 0;
foreach ($_POST as $key => $value){
    //echo "$key: $value<br>";
    if (empty($value)){
        echo "$key<br>";
        //powrócić do formularza? script w js (history) form ma być wypełniony
        echo "<script>history.back();</script>";
        exit();
    }
}

if (!isset($_POST["terms"])){
    $_SESSION["error"] = "Zatwierdź regulamin!";
    $error = 1;
}

if ($error != 0){
    echo "<script>history.back();</script>";
    exit();
}

require_once "./connect.php";
$sql = "UPDATE `user` SET `city_id`='$_POST[city_id]', `firstName`='$_POST[firstName]', `lastName`='$_POST[lastName]', `birthday`='$_POST[birthday]' WHERE `user`.`id`=$_SESSION[updateUserId];";
$conn->query($sql);
if ($conn->affected_rows != 0){
    $_SESSION["success"] = "Prawidłowo zaktualizowano użytkownika $_POST[firstName] $_POST[lastName]";
}else{
    $_SESSION["error"] = "Nie zaktualizowano użytkownika!";
}

header ("location: ../3_db_table_delete_add.php");
