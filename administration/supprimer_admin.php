<?php
require '../admin/database.php';
if(!empty($_GET['username'])){
    $log = trim($_GET['username']);
    $log = stripslashes($_GET['username']);
    $log = htmlspecialchars($_GET['username']);
}


    $db = database::connect();
    $statement = $db->prepare('DELETE FROM admin WHERE username = ? ');
    $statement ->execute(array($log));
    database::disconnect();
    header("Location: index.php");