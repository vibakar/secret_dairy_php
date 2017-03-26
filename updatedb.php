<?php

session_start();
if (array_key_exists("content", $_POST)) {
    include 'db.php';
    $id = $_SESSION['id'];
    $mydairy = mysqli_real_escape_string($con, $_POST['content']);
    $sql = "UPDATE dairy SET mydairy='$mydairy' WHERE id= $id";
    $result = mysqli_query($con, $sql);
}
?>
 
